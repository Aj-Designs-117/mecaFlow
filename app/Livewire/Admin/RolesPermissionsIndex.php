<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Flux\Flux;

class RolesPermissionsIndex extends Component
{
    use WithPagination;

    public $id, $name, $selectedPermissions = [], $rolesPermissionsId;

    public function render()
    {
        $roles = Role::select('id', 'name')->get();
        $permissions = Permission::select('name', 'description')->get();
        return view('livewire.admin.roles-permissions-index', compact('roles', 'permissions'));
    }

    public function assingPermissions($id)
    {
        $role = Role::where('id', $id)->select('id', 'name')->firstOrFail();
        $this->id = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions()->pluck('name')->toArray();
    }

    public function update($id)
    {
        $this->validate(['name' => 'required|max:255']);

        try {
            $role = Role::findOrFail($id);

            // Guardar valores anteriores para auditoría
            $originalData = $role->toArray();
            $originalPermissions = $role->permissions->pluck('id')->toArray();

            $role->name = $this->name;
            $role->save();
            $role->syncPermissions($this->selectedPermissions);

            Log::info('Rol y permisos actualizados correctamente', [
                'role_id' => $role->id,
                'name' => $role->name,
                'permissions_assigned' => $this->selectedPermissions,
                'changes' => [
                    'name' => ['old' => $originalData['name'], 'new' => $this->name],
                    'permissions' => ['old' => $originalPermissions, 'new' => $this->selectedPermissions]
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Se ha actualizado correctamente']);
            Flux::modals()->close();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de actualizar rol inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'El rol especificado no existe']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar rol y permisos', [
                'error' => $e->getMessage(),
                'role_id' => $id,
                'input_data' => [
                    'name' => $this->name,
                    'permissions' => $this->selectedPermissions
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Error al asignar el rol y permisos']);
        }
    }

    public function destroy($id)
    {
        try {
            $rol = Role::findOrFail($id);
            $rol_name = $rol->id;
            $rol->delete();

            Log::info('Rol eliminado exitosamente', [
                'delete_role_id' => $id,
                'deleted_role_name' => $rol_name,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Se ha eliminado correctamente']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar rol inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'El rol especificado no existe']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el rol', [
                'role_id' => $rol->id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Error al eliminar la asignación']);
        }
    }
}
