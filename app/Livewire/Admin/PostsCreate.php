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
use Livewire\Component;

class PostsCreate extends Component
{
    use WithFileUploads;

    public $title = '', $slug = '', $body = '', $partners = '', $status = '', $images = [], $selectedCategories = [];

    public function render()
    {
        $categories = Category::all();
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
        $this->body = '';
        $this->partners = '';
        $this->images = [];
        $this->selectedCategories = [];
    }

    public function store()
    {
        $slugForValidation = Str::slug($this->slug);

        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'body' => 'required|string',
            'partners' => 'nullable|string|max:1000',
            'status' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png|max:2048',
            'selectedCategories' => 'array|min:1',
            'selectedCategories.*' => 'exists:categories,id',
        ]);

        try {

            DB::beginTransaction();

            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'slug' => $slugForValidation,
                'body' => $this->body,
                'partners' => array_filter(array_map('trim', explode(',', $this->partners))),
                'status' => $this->status,
            ]);

            $post->categories()->sync($this->selectedCategories ?? []);



            if ($post) {
                foreach ($this->images as $index => $image) {
                    $path = $image->store('posts', 'cloudinary');
                    $uploadedFileUrl = Storage::disk('cloudinary')->url($path);

                    PostImage::create([
                        'post_id' => $post->id,
                        'image_path' => $uploadedFileUrl,
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            Log::info('Post creado exitosamente', [
                'id' => $post->id,
                'title' => $post->title,
                'images' => count($this->images ?? []),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('quillClear');
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Exception $e) {
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

            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al crear un nuevo post']);
        }
    }
}
