<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use Livewire\Component;

class CategoryIndex extends Component
{
    public $search = '', $selectedCategorySlug = null;

    public function render()
    {
        $categories = Category::take(7)->get();
        return view('livewire.blog.category-index', compact('categories'));
    }

    public function updatedSearch()
    {
        $this->dispatch('filterPosts', $this->search, $this->selectedCategorySlug);
    }

    public function selectCategory($categorySlug)
    {
        $this->selectedCategorySlug = $categorySlug;
        $this->dispatch('filterPosts', $this->search, $this->selectedCategorySlug);
    }
}
