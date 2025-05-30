<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use Livewire\Component;

class MecaCategory extends Component
{
    public function render()
    {
        $categories = Category::take(7)->get();
        return view('livewire.blog.meca-category', compact('categories'));
    }
}
