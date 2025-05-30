<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class MecaPopular extends Component
{
    public function render()
    {
        $popularPosts = Post::with(['postImages', 'categories'])->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('livewire.blog.meca-popular', compact('popularPosts'));
    }
}
