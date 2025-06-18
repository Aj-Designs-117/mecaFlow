<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Livewire\Component;

class PostsCreate extends Component
{
    use WithFileUploads;

    public $title = '', $slug = '', $excerpt = '', $body = '', $partners = '', $status = '', $images = [], $imageUrls = [], $imageUrlsText = '', $selectedCategories = [];

    public function render()
    {
        $categories = Category::all();
        $this->dispatch('init-quill');
        return view('livewire.admin.posts-create', compact('categories'));
    }

    public function clearImages()
    {
        $this->images = [];
    }

    public function resetFieldsView()
    {
        $this->title = '';
        $this->slug = '';
        $this->excerpt = '';
        $this->body = '';
        $this->partners = '';
        $this->images = [];
        $this->imageUrlsText = '';
        $this->selectedCategories = [];
    }

    public function updatedImageUrlsText()
    {
        $urls = preg_split('/\r\n|\r|\n|,/', $this->imageUrlsText);
        $this->imageUrls = array_filter(array_map('trim', $urls));
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'required|string',
            'partners' => 'nullable|string|max:1000',
            'status' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png|max:2048',
            'imageUrls' => 'nullable|array',
            'imageUrls.*' => 'string|url',
            'selectedCategories' => 'array|min:1|max:3',
            'selectedCategories.*' => 'exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'título',
            'slug' => 'URL amigable',
            'excerpt' => 'extracto',
            'body' => 'contenido',
            'partners' => 'socios',
            'status' => 'estado',
            'images' => 'imágenes',
            'images.*' => 'archivo de imagen',
            'imageUrls' => 'URLs de imágenes',
            'imageUrls.*' => 'URL de imagen',
            'selectedCategories' => 'categorías seleccionadas',
            'selectedCategories.*' => 'categoría',
        ];
    }

    public function store()
    {
        $slugForValidation = Str::slug($this->slug);

        $this->validate($this->rules(), [], $this->attributes());

        if (is_string($this->imageUrls)) {
            $this->imageUrls = array_filter(array_map('trim', explode(',', $this->imageUrls)));
        }

        try {

            DB::beginTransaction();

            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'slug' => $slugForValidation,
                'excerpt' => $this->excerpt,
                'body' => $this->body,
                'partners' => array_filter(array_map('trim', explode(',', $this->partners))),
                'status' => $this->status,
            ]);

            $post->categories()->sync($this->selectedCategories ?? []);

            foreach ($this->images as $index => $image) {
                try {
                    $path = $image->store('posts', 'cloudinary');
                    $uploadedFileUrl = Storage::disk('cloudinary')->url($path);

                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $uploadedFileUrl,
                        'order' => $index + 1,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error subiendo imagen', ['error' => $e->getMessage()]);
                    $this->dispatch('success', ['message' => 'Error en la subida de imagen']);
                }
            }

            foreach ($this->imageUrls as $index => $url) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $url,
                    'order' => count($this->images) + $index + 1,
                ]);
            }

            DB::commit();

            Log::info('Post creado exitosamente', [
                'id' => $post->id,
                'title' => $post->title,
                'images' => count($this->images ?? []),
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('quillClear');
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Throwable $e) {
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
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            activity('errors')
                ->causedBy(auth()->user())
                ->withProperties([
                    'register_id' => $this->postId,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'ip' => request()->ip(),
                    'inputs' => [
                        'title' => $this->title,
                        'slug' => $this->slug,
                        'partners' => $this->partners,
                        'images' => count($this->images ?? []),
                        'status' => $this->status,
                    ],
                ])
                ->log('Error al crear un post');

            $this->dispatch('error', ['message' => 'Algo va mal al crear un nuevo post']);
        }
    }
}
