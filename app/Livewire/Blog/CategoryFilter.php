<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use Livewire\Component;

class CategoryFilter extends Component
{
    public $search = '', $selectedCategorySlug = null;

    public function render()
    {
        $categories = Category::all();
        return view('livewire.blog.category-filter', compact('categories'));
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
