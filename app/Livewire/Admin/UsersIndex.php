<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Flux\Flux;
use Livewire\WithPagination;

use App\Models\User;

class UsersIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $id, $name, $email, $password,  $selectedRoles = [];

    public function render()
    {
        $users = User::whereNotIn('id', array_merge([1]))
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(10);
        $roles = Role::select('id', 'name')->get();
        return view('livewire.admin.users-index', compact('users','roles'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->select('id', 'name', 'email')->first();
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles()->pluck('name')->toArray();
    }

    public function editAssignRole($id){
        $user = User::where('id', $id)->select('id', 'name')->first();
        $this->id = $user->id;
        $this->name = $user->name;
        $this->selectedRoles = $user->roles()->pluck('name')->toArray();
    }

    public function resetFieldsView(){ $this->password = ''; }

    public function update($id)
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:8'
        ]);

        try {
            $user = User::findOrFail($id);

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Log::info('Usuario actualizado exitosamente', [
                'user_id' => $user->id,
                'name' => $user->name,
                'updated_fields' => ['name', 'email', 'password'],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            Flux::modals()->close();
            $this->resetFieldsView();
            $this->dispatch('success', ['message' => 'Se ha actualizado correctamente']);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de actualizar un usuario inexistente', [
                'requested_by' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'El usuario especificado no existe']);
        }catch (\Exception $e) {
            Log::error('Error al actualizar al usuario', [
                'error' => $e->getMessage(),
                'user_id' => $id,
                'inputs' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            Flux::modals()->close();
            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al actualizar un nuevo usuario']);
        }
    }

    public function assignArole($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->syncRoles($this->selectedRoles);

            Log::info('Se asigno un rol exitosamente', [
                'user_id' => $user->id,
                'name' => $user->name,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            Flux::modals()->close();
            $this->dispatch('success', ['message' => 'Se ha asignado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar al usuario', [
                'error' => $e->getMessage(),
                'inputs' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'Algo va mal al asignar los roles']);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $userName = $user->name;
            $user->delete(); 

            Log::info('Usuario eliminado exitosamente', [
                'deleted_user_id' => $id,
                'deleted_user_name' => $userName,
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('success', ['message' => 'Se ha eliminado correctamente']);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Usuario no encontrado al intentar eliminar', [
                'requested_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'El usuario no existe']);
        }catch (\Exception $e) {
            Log::error('Error al eliminar al usuario', [
                'user_id'  => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);
            $this->dispatch('error', ['message' => 'Algo va mal al eliminar al usuario']);
        }
    }

}
