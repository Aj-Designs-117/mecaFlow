<?php

namespace App\Livewire\Blog;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;

class MecaRecent extends Component
{
    public function render()
    {
        $posts = Post::with(['user', 'categories', 'postImages'])
            ->where('status', 'publicado')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.blog.meca-recent', compact('posts'));
    }
}
