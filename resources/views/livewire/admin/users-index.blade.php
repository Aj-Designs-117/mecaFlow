<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            @can('admin.users.create')
                <livewire:admin.users-create/>
            @endcan
            <div class="relative p-6 z-10">
            <flux:input wire:model.live="search" icon="magnifying-glass" :label="__('Buscar')" type="text" autofocus autocomplete="Buscar" placeholder="Ingrese el nombre o correo electronico" />

            </div>
            <div class="relative overflow-x-auto z-10">
                @if ($users->count())
                <table class="w-full table-auto text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                    @foreach($users as $user)
                        <tr class="text-center">
                            <td class="px-4 py-2 font-bold">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2 flex justify-center gap-2">
                            @can('admin.users.edit')
                                <flux:modal.trigger name="editUser">
                                    <flux:button wire:click="edit('{{ $user->id }}')" variant="primary" class="cursor-pointer hover:bg-sky-200" size="sm">✏️</flux:button>
                                </flux:modal.trigger>
                            @endcan
                            @can('admin.users.roles')
                                <flux:modal.trigger name="assig-roles">
                                    <flux:button wire:click="editAssignRole('{{ $user->id }}')" variant="primary" class="cursor-pointer hover:bg-yellow-200" size="sm">🔐</flux:button>
                                </flux:modal.trigger>
                            @endcan
                            @can('admin.users.destroy')
                                <flux:button wire:click="destroy('{{ $user->id }}')" variant="primary" class="cursor-pointer hover:bg-red-200" size="sm">🗑️</flux:button>
                            @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-4 relative z-10">
                    {{ $users->links() }}
                </div>

                @else
                <div class="p-6 border-t">
                    <strong class="font-bold">{{ __('No hay registros') }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
     <!-- Modal - Users -->
     <flux:modal name="editUser" class="md:w-96">
        <form wire:submit.prevent="update('{{ $id }}')">
            <div class="space-y-6">
                <flux:heading size="lg">Actualizar usuario</flux:heading>

                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="Nombre" placeholder="Ingrese el nombre" />
                <flux:input wire:model="email" :label="__('Email')" type="email" required autofocus autocomplete="Email" placeholder="Ingrese el email" />
                <flux:input wire:model="password" :label="__('Password')" type="password" required autofocus autocomplete="password" placeholder="Ingrese el password" />

                <div class="flex">
                    <flux:spacer />
                    @can('admin.users.update')
                        <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Update') }}</flux:button>
                    @endcan
                </div>
            </div>
        </form>
    </flux:modal>
      <!-- Modal - Asignacion de rol -->
    <flux:modal name="assig-roles" class="md:w-96">
        <form wire:submit.prevent="assignArole({{ $id }})">
            <div class="space-y-6">
                <flux:heading size="lg">Asignando un rol</flux:heading>

                <flux:input wire:model="name" :label="__('Name')" required disabled/>
                <flux:checkbox.group label="Roles">
                    @foreach($roles as $role)
                        <flux:checkbox wire:model="selectedRoles" label="{{ $role->name }}" value="{{ $role->name }}" />
                    @endforeach
                </flux:checkbox.group>
               
                <div class="flex">
                    <flux:spacer />
                    @can('admin.users.store')
                        <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Asignar') }}</flux:button>
                    @endcan
                </div>
            </div>
        </form>
    </flux:modal>
</div>
