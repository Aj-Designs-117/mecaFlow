<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PostsEdit extends Component
{
    public $postId, $title = '', $slug = '', $excerpt = '', $body = '', $partners = '', $status, $selectedCategories = [], $images = [], $imageUrlsText = '';

    public function render()
    {
        $categories = Category::select('id', 'name')->get();
        return view('livewire.admin.posts-edit', compact('categories'));
    }

    public function mount($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('categories', 'postImages')
            ->select('id', 'title', 'slug', 'excerpt', 'partners', 'body', 'status')
            ->firstOrFail();

        $user = auth()->user();

        if (! $user->hasAnyRole(['Administrador', 'Editor'])) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt;
        $this->partners = is_array($post->partners) ? implode(', ', $post->partners) : $post->partners;
        $this->body = $post->body;
        $this->status = $post->status;
        $this->selectedCategories = $post->categories->pluck('id')->toArray();
        $this->imageUrlsText = $post->postImages->pluck('image_path')->implode("\n");
    }

    public function clearImages()
    {
        $this->images = [];
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->postId,
            'excerpt' => 'nullable|string|max:255',
            'partners' => 'nullable|string|max:1000',
            'body' => 'required|string',
            'status' => 'required|string',
            'selectedCategories' => 'required|array|min:1|max:3',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'título',
            'slug' => 'URL amigable',
            'excerpt' => 'extracto',
            'partners' => 'socios',
            'body' => 'contenido',
            'status' => 'estado',
            'selectedCategories' => 'categorías seleccionadas',
        ];
    }

    public function update()
    {
        $slugForValidation = Str::slug($this->slug);

        $user = auth()->user();

        if (! $user->hasAnyRole(['Administrador', 'Editor'])) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $this->validate($this->rules(), [], $this->attributes());

        try {

            DB::beginTransaction();

            $post = Post::findOrFail($this->postId);

            $post->update([
                'title' => $this->title,
                'slug' => $slugForValidation,
                'excerpt' => $this->excerpt,
                'partners' => array_filter(array_map('trim', explode(',', $this->partners))),
                'body' => $this->body,
                'status' => $this->status,
            ]);
            $post->categories()->sync($this->selectedCategories);

            if (!empty($this->imageUrlsText)) {
                // Separar y limpiar las URLs
                $urls = preg_split('/[\n,]+/', $this->imageUrlsText); // salto de línea o coma
                $urls = array_filter(array_map('trim', $urls)); // limpia espacios

                // Filtrar solo las URLs válidas
                $validUrls = array_filter($urls, fn($url) => filter_var($url, FILTER_VALIDATE_URL));

                // Solo si hay al menos una URL válida, elimina y vuelve a insertar
                if (!empty($validUrls)) {
                    $post->postImages()->delete(); // elimina las anteriores

                    $order = 1;
                    foreach ($validUrls as $url) {
                        $post->postImages()->create([
                            'image_path' => $url,
                            'order' => $order++,
                        ]);
                    }
                }
            }

            DB::commit();

            Log::info('Post actualizado exitosamente', [
                'id' => $post->id,
                'title' => $post->title,
                'images' => count($this->images ?? []),
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Se ha actualizado correctamente']);
            $this->dispatch('quillClear');
            return redirect()->route('admin.posts.index');
        } catch (AuthorizationException $authEx) {
            DB::rollBack();

            Log::warning('Intento de actualización sin permiso', [
                'error' => $authEx->getMessage(),
                'post_id' => $this->postId,
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Intento actualizar sin permiso']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear post', [
                'error' => $e->getMessage(),
                'inputs' => [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'partners' => $this->partners,
                    'images' => count($this->images ?? []),
                    'status' => $this->status,
                ],
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'Algo va mal al actualizar un nuevo post']);
        }
    }
}
