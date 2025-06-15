<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class CategoriesCreate extends Component
{
    public $name = '', $slug = '';

    public function render()
    {
        return view('livewire.admin.categories-create');
    }

    public function resetFieldsView()
    {
        $this->name = '';
        $this->slug = '';
    }

    public function store()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|unique:categories',
                'slug' => 'required|string|max:255|unique:categories'
            ]);

            DB::beginTransaction();

            $category = Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->slug)
            ]);

            DB::commit();

            Log::info('Categoria creado exitosamente', [
                'id' => $category->id,
                'title' => $category->name,
                'slug' => $category->slug,
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('categoryCreated');
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error al crear categoria', [
                'error' => $e->getMessage(),
                'inputs' => [
                    'name' => $this->name,
                    'slug' => $this->slug,
                ],
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'inputs' => [
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ],
                    'error' => $e->getMessage(),
                    'modified_by' => Auth::user()->id,
                    'ip' => request()->ip()
                ])
                ->log('Error al crear categoria');

            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al crear un nueva categoria']);
        }
    }
}
