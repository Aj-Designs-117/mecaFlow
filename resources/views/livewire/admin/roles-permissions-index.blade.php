<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="relative overflow-x-auto z-10">
                @if ($roles->count())
                    <table class="w-full table-auto text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($roles as $role)
                                <tr class="text-center">
                                    <td class="px-4 py-2 font-bold">{{ $role->id }}</td>
                                    <td class="px-4 py-2">{{ $role->name }}</td>
                                    <td class="px-4 py-2 flex justify-center gap-2">
                                        @can('admin.roles-permissions.permissions')
                                            <flux:modal.trigger name="assig-permissions">
                                                <flux:button wire:click="assingPermissions('{{ $role->id }}')"
                                                    variant="primary" class="cursor-pointer hover:bg-yellow-200"
                                                    size="sm">🗝️</flux:button>
                                            </flux:modal.trigger>
                                        @endcan
                                        @can('admin.roles-permissions.destroy')
                                            <flux:button wire:click="destroy('{{ $role->id }}')" variant="primary"
                                                class="cursor-pointer hover:bg-red-200" size="sm">🗑️</flux:button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <div class="p-6 border-t">
                        <strong class="font-bold">{{ __('No hay registros') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    <flux:modal name="assig-permissions" class="md:w-96">
        <form wire:submit.prevent="update('{{ $id }}')">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Asignando permisos</flux:heading>
                </div>
                <flux:input wire:model="name" :label="__('Name')" required autofocus autocomplete="Nombre"
                    placeholder="Ingrese el nombre" />

                <flux:checkbox.group label="Permisos">
                    @foreach ($permissions as $permission)
                        <flux:checkbox wire:model="selectedPermissions" label="{{ $permission->description }}"
                            value="{{ $permission->name }}" />
                    @endforeach
                </flux:checkbox.group>

                <div class="flex">
                    <flux:spacer />
                    @can('admin.roles-permissions.store')
                        <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾
                            {{ __('Save') }}</flux:button>
                    @endcan
                </div>
            </div>
        </form>
    </flux:modal>
</div>
