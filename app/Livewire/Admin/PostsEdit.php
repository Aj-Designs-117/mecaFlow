<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PostsEdit extends Component
{
    public $postId, $title = '', $slug = '', $body = '', $partners = '', $status, $selectedCategories = [], $images = [];

    public function render()
    {
        $categories = Category::select('id', 'name')->get();
        return view('livewire.admin.posts-edit', compact('categories'));
    }

    public function mount($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('categories', 'postImages')
            ->select('id', 'title', 'slug', 'partners', 'body', 'status')
            ->firstOrFail();

        $user = auth()->user();

        if (! $user->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->partners = is_array($post->partners) ? implode(', ', $post->partners) : $post->partners;
        $this->body = $post->body;
        $this->status = $post->status;
        $this->selectedCategories = $post->categories->pluck('id')->toArray();
        $this->images = $post->postImages->pluck('image_path')->toArray();
    }

    public function clearImages()
    {
        $this->images = [];
    }

    public function update()
    {
        $slugForValidation = Str::slug($this->slug);

        try {

            $user = auth()->user();

            if (! $user->hasRole('Administrador')) {
                abort(403, 'No tienes permiso para actualizar este post.');
            }

            $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:posts,slug,' . $this->postId,
                'partners' => 'nullable|string|max:1000',
                'body' => 'required|string',
                'status' => 'required|string',
                'selectedCategories' => 'required|array|min:1',
            ]);

            DB::beginTransaction();

            $post = Post::findOrFail($this->postId);

            $post->update([
                'title' => $this->title,
                'slug' => $slugForValidation,
                'partners' => array_filter(array_map('trim', explode(',', $this->partners))),
                'body' => $this->body,
                'status' => $this->status,
            ]);
            $post->categories()->sync($this->selectedCategories);

            DB::commit();

            Log::info('Post actualizado exitosamente', [
                'id' => $post->id,
                'title' => $post->title,
                'images' => count($this->images ?? []),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Se ha actualizado correctamente']);
            $this->dispatch('quillClear');
            return redirect()->route('admin.posts.index');
        }catch (AuthorizationException $authEx) {
            DB::rollBack();

            Log::warning('Intento de actualización sin permiso', [
                'error' => $authEx->getMessage(),
                'post_id' => $this->postId,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Intento actualizar sin permiso']);
        }catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear post', [
                'error' => $e->getMessage(),
                'inputs' => [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'partners' => $this->partners,
                    'body' =>  $this->body,
                    'images' => count($this->images ?? []),
                    'status' => $this->status,
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'Algo va mal al actualizar un nuevo post']);
        }
    }
}
