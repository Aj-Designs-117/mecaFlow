<?php

namespace App\Livewire\Admin;

use App\Models\Audit;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class Dashboard extends Component
{
    use WithPagination;

    public $totalPosts, $recentViews, $drafts, $public, $categories, $users;

    public function render()
    {
        $audits = Audit::with(['post', 'user'])->latest()->paginate(10);
        return view('livewire.admin.dashboard', compact('audits'));
    }

    public function mount()
    {
        $this->totalPosts = Post::count();
        $this->drafts = Post::where('status', 'Borrador')->count();
        $this->public = Post::where('status', 'Publicado')->count();
        $this->categories = Category::count();
        $this->users = User::count();
        $this->recentViews = Post::sum('views');
    }

    public function confirmClearAudit()
    {
        $this->dispatch('confirm-clear-audit');
    }

    public function destroyAudits()
    {
        Audit::truncate();
        $this->dispatch('success', ['message' => 'La auditoria ha sido eliminada']);
    }
}
