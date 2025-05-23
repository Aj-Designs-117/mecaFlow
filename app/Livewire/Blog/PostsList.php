<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Component;

class PostsList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategorySlug = null;

    protected $listeners = ['filterPosts' => 'applyFilters'];

    public function render()
    {

        $posts = Post::with(['user', 'categories', 'postImages'])
            ->where('status', 'publicado')
            ->when($this->search, fn($q) =>
            $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->selectedCategorySlug, fn($q) =>
            $q->whereHas('categories', fn($q) =>
            $q->where('slug', $this->selectedCategorySlug)))
            ->latest()
            ->paginate(10);

        $posts->getCollection()->transform(function ($post) {
            $post->formatted_date = optional($post->updated_at)->format('d.m.Y') ?? 'Fecha no disponible';
            $post->main_image = $post->postImages->sortBy('order')->first();
            return $post;
        });

        $recentPosts = $posts->getCollection()->take(2);

        $groupedPosts = $posts->getCollection()
            ->groupBy(fn($post) => optional($post->categories->first())->name ?? 'Sin categoría')
            ->map(fn($group) => $group->take(3));

        return view('livewire.blog.posts-list', compact('recentPosts', 'groupedPosts'));
    }

    public function applyFilters($search, $selectedCategorySlug)
    {
        $this->search = $search;
        $this->selectedCategorySlug = $selectedCategorySlug;
        $this->resetPage();
    }
}
