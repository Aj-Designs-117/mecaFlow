<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class MecaIndex extends Component
{
    use WithPagination;

    public $meca;
    protected $queryString = ['meca'];

    public function render()
    {
        $categories = Category::all();

        $posts = Post::with(['user', 'categories', 'postImages'])
            ->where('status', 'Publicado')
            ->when($this->meca, function ($query) {
                $query->whereHas('categories', function ($catQuery) {
                    $catQuery->where('slug', $this->meca);
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.blog.meca-index', compact('posts', 'categories'));
    }
}
