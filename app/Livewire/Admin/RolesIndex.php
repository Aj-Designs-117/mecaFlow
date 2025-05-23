<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RolesIndex extends Component
{
    public $name;

    public function render()
    {
        $roles = Role::all();
        return view('livewire.admin.roles-index', compact('roles'));
    }

    public function resetFieldsView(){ $this->name = ''; }

    public function store()
    {
        $this->validate(['name' => 'required|max:255']);

        try {
            $role = Role::create(['name' => $this->name]);

            Log::info('Rol creado exitosamente', [
                'id' => $role->id,
                'name' => $role->name,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear un rol', [
                'error' => $e->getMessage(),
                'input' => ['name' => $this->name],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al crear un nuevo rol']);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);

            if ($role->users()->exists()) {
                $this->dispatch('success', ['message' => 'No se puede eliminar el rol porque está asignado a usuarios.']);
            }

            $roleName = $role->name;
            $role->delete();

            Log::info('Rol eliminado exitosamente', [
                'delete_role_id' => $id,
                'delete_role_name' => $roleName,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Rol eliminado correctamente']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar un rol inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'El rol no existe']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el rol', [
                'role_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'Error al eliminar el rol']);
        }
    }
}
