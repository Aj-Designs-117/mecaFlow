<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            @can('admin.roles.create')
            <div class="relative h-full w-full p-6 rounded shadow z-10">
                <form wire:submit.prevent="store()">
                    <div class="mb-4">
                        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="Nombre" placeholder="Ingrese el nombre" />
                    </div>

                    <div class="flex justify-end">
                        @can('admin.roles.store')
                            <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Save') }}</flux:button>
                        @endcan
                    </div>
                </form>
            </div>
            @endcan
            <div class="relative overflow-x-auto z-10">
                @if ($roles->count())
                <table class="w-full table-auto text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Fecha / hora de creación</th>
                            <th class="px-4 py-2">Fecha / hora de actualización</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($roles as $role)
                        <tr class="text-center">
                            <td class="px-4 py-2 font-bold">{{ $role->id }}</td>
                            <td class="px-4 py-2">{{ $role->name }}</td>
                            <td class="px-4 py-2">{{ $role->guard_name }}</td>
                            <td class="px-4 py-2">{{ $role->created_at }}</td>
                            <td class="px-4 py-2">{{ $role->updated_at }}</td>
                            @can('admin.roles.destroy')
                            <td class="px-4 py-2 flex gap-2">
                                <flux:button wire:click="destroy('{{ $role->id }}')" variant="primary" class="cursor-pointer hover:bg-red-200" size="sm">🗑️</flux:button>
                            </td>
                            @endcan
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
</div>
