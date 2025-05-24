<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class MecaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;

    public function render()
    {
        $posts = Post::with(['user', 'categories', 'postImages'])
            ->where('status', 'publicado')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('categories', function ($catQuery) {
                            $catQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->whereHas('categories', function ($catQuery) {
                    $catQuery->where('categories.slug', $this->selectedCategory);
                });
            })
            ->latest()
            ->paginate(15);

        $categories = Category::all();

        return view('livewire.blog.meca-index', compact('posts', 'categories'));
    }

    protected $queryString = ['search', 'selectedCategory'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function selectCategory($slug)
    {
        $this->selectedCategory = $slug;
    }

    public function clearCategory()
    {
        $this->selectedCategory = null;
    }
}
