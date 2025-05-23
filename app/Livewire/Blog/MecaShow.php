<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class MecaShow extends Component
{
    public $post = '';

    public function render()
    {
        return view('livewire.blog.meca-show');
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

        // Formatear fecha
        $this->post->formatted_date = Carbon::parse($this->post->created_at)->format('d.m.Y');

        $formattedBody = $this->post->body;

        foreach ($this->post->postImages as $image) {
            $placeholder = '[image_' . $image->order . ']';
            $imgTag = '<img src="' . e($image->image_path) . '" class="card-img object-fit-cover rounded mb-3" alt="Imagen del post"  height="500">';
            $formattedBody = str_replace($placeholder, $imgTag, $formattedBody);
        }

        $this->post->formatted_body = nl2br($formattedBody);
    }
}
