<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsersCreate extends Component
{
    public $id, $name, $email, $password;

    public function render()
    {
        return view('livewire.admin.users-create');
    }

    public function resetFieldsView()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function store()
    {

        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Log::info('Usuario creado exitosamente', [
                'id' => $user->id,
                'name' => $user->name,
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);

            $this->resetFieldsView();
            $this->dispatch('UserCreated');
            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear usuario', [
                'error' => $e->getMessage(),
                'input' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
                'modified_by' => Auth::user()->id,
                'ip' => request()->ip()
            ]);
            $this->resetFieldsView();
            $this->dispatch('error', ['message' => 'Algo va mal al crear un nuevo usuario']);
        }
    }
}
