<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Flux\Flux;

class CategoriesIndex extends Component
{
    use WithPagination;
    
    public $id, $search = '', $sort = 'id', $direction = 'desc', $name = '', $slug = '';

    public function render()
    {   
        $categories = Category::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(10);

        return view('livewire.admin.categories-index', compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->select('id', 'name', 'slug')->first();
        $this->id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }

    public function update($id){
        try{
            $this->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'slug' => 'required|string|max:255|unique:categories,slug,' . $id
            ]);

            DB::beginTransaction();

            $category = Category::findOrFail($id);

            $category->update([
                'name' => $this->name,
                'slug' => Str::slug($this->slug)
            ]);

            DB::commit();

            Log::info('Categoria actualizado exitosamente', [
                'id' => $category->id,
                'title' => $category->name,
                'slug' => $category->slug,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            Flux::modals()->close();
            $this->dispatch('success', ['message' => 'Se ha actualizado correctamente']);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            DB::rollBack();

            Log::warning('Intento de actualizar un categoria inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'La categoria especificada no existe']);
        }catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar la categoria', [
                'error' => $e->getMessage(),
                'category_id' => $id,
                'inputs' => [
                    'name' => $this->name,
                    'slug' => $this->slug,
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            Flux::modals()->close();
            $this->dispatch('error', ['message' => 'Algo va mal al actualizar la categoria']);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($id);
            $categoryName =  $category->name;
            $category->delete(); 

            DB::commit();

            Log::info('Usuario eliminado exitosamente', [
                'deleted_category_id' => $id,
                'deleted_category_name' => $categoryName,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            
            $this->dispatch('success', ['message' => 'Se ha eliminado correctamente']);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            Log::error('Categoria no encontrada al intentar eliminar', [
                'requested_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'La categoria no existe']);
        }catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al eliminar la categoria', [
                'category_id'  => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Algo va mal al eliminar la categoria']);
        }
    }
}
