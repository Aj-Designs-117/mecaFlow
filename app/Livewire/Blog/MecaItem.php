<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Spatie\Activitylog\Facades\Activity;
use Livewire\Component;

class MecaItem extends Component
{
    public $post, $categories, $formattedDate, $formattedBody;

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
            activity()->disableLogging(); // Desactiva logging temporalmente

            $this->post->increment('views');

            activity()->enableLogging(); // Lo vuelve a activar

            session()->put($sessionKey, true);
        }

        // Formatear fecha
        $this->post->formatted_date = Carbon::parse($this->post->created_at)->format('d.m.Y');

        $formattedBody = $this->post->body;

        foreach ($this->post->postImages as $image) {
            $placeholder = '[image_' . $image->order . ']';

            $imgTag = '
                    <div class="w-100 mb-3 mt-0 text-center" >
                        <img src="' . e($image->image_path) . '" class="object-fit-cover rounded w-100 h-100" alt="post">
                    </div>
                ';

            $formattedBody = preg_replace(
                '/<p>\s*' . preg_quote($placeholder, '/') . '\s*<\/p>/i',
                $imgTag,
                $formattedBody
            );
        }

        $this->post->formatted_body = $formattedBody;
    }
}
