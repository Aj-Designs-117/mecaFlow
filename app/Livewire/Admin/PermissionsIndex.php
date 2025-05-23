<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $description, $name;

    public function render()
    {
        $permissions = Permission::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);
        return view('livewire.admin.permissions-index', compact('permissions'));
    }

    public function notificacion()
    {
        $this->dispatch('success', ['message' => 'Permiso guardado correctamente.']);
    }

    public function resetFieldsView()
    {
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|max:255',
            'description' => 'required'
        ]);

        try {

            $permission = Permission::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            Log::info('Permiso creado exitosamente', [
                'id' => $permission->id,
                'name' => $permission->name,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear permiso', [
                'error' => $e->getMessage(),
                'inputs' => [
                    'name' => $this->name,
                    'description' => $this->description
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al crear un nuevo permiso']);
        }
    }

    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permissionName = $permission->name;
            $permission->delete();

            Log::info('Permiso eliminado exitosamente', [
                'deleted_permission_id' => $id,
                'deleted_permission_name' => $permissionName,
                'modified_by' => auth()->id(),
                'ip' => request()->ip(),
            ]);

            $this->dispatch('success', ['message' => 'Permiso eliminado correctamente']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar permiso inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip(),
            ]);

            $this->dispatch('error', ['message' => 'El permiso no existe']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar permiso', [
                'permission_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip(),
            ]);

            $this->dispatch('error', ['message' => 'Error al eliminar el permiso']);
        }
    }
}
