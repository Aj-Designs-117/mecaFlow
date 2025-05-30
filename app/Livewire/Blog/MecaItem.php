<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class MecaItem extends Component
{
    public $post = '';

    public function render()
    {
        $categories = Category::select('name', 'slug')->get();
        return view('livewire.blog.meca-item', compact('categories'));
    }

    public function mount($slug)
    {
        $this->post = Post::with([
            'user',
            'categories',
            'postImages' => function ($query) {
                $query->orderBy('order');
            }
        ])->where('slug', $slug)->firstOrFail();

        $sessionKey = 'viewed_post_' . $this->post->id;
        if (!session()->has($sessionKey)) {
            $this->post->increment('views');
            session()->put($sessionKey, true);
        }

        // Formatear fecha
        $this->post->formatted_date = Carbon::parse($this->post->created_at)->format('d.m.Y');

        $formattedBody = $this->post->body;

        foreach ($this->post->postImages as $image) {
            $placeholder = '[image_' . $image->order . ']';
            $imgTag = '<img src="' . e($image->image_path) . '" class="object-fit-cover rounded w-100 mb-3 mt-0" alt="post"  style="height: 500px;">';

            // Reemplazar <p>[image_#]</p> completamente
            $formattedBody = preg_replace(
                '/<p>\s*' . preg_quote($placeholder, '/') . '\s*<\/p>/i',
                $imgTag,
                $formattedBody
            );
        }

        $this->post->formatted_body = $formattedBody;
    }
}
