<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="relative h-full w-full p-6 rounded shadow z-10">
                @can('admin.permissions.create')
                    <form wire:submit.prevent="store()">
                        <div class="mb-4">
                            <flux:input wire:model="name" :label="__('Clave')" type="text" required autofocus
                                autocomplete="clave" placeholder="Ingrese la clave" />
                        </div>
                        <div class="mt-4">
                            <flux:input wire:model="description" :label="__('Descripción')" type="text" required
                                autofocus autocomplete="Descripción" placeholder="Ingrese descripción" />
                        </div>
                        <div class="flex justify-end mt-4">
                            @can('admin.permissions.store')
                                <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾
                                    {{ __('Save') }}</flux:button>
                            @endcan
                        </div>
                    </form>
                @endcan
                <div class="mt-4">
                    <flux:input wire:model.live="search" icon="magnifying-glass" :label="__('Buscar')" type="text"
                        required autofocus autocomplete="Buscar" placeholder="Ingrese clave o slug" />
                </div>
            </div>
            <div class="relative overflow-x-auto">
                @if ($permissions->count())
                    <table class="w-full table-auto text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Clave</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2">Fecha / hora de creación</th>
                                <th class="px-4 py-2">Fecha / hora de actualización</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($permissions as $permission)
                                <tr class="text-center">
                                    <td class="px-4 py-2 font-bold">{{ $permission->id }}</td>
                                    <td class="px-4 py-2">{{ $permission->name }}</td>
                                    <td class="px-4 py-2">{{ $permission->description }}</td>
                                    <td class="px-4 py-2">{{ $permission->guard_name }}</td>
                                    <td class="px-4 py-2">{{ $permission->created_at }}</td>
                                    <td class="px-4 py-2">{{ $permission->updated_at }}</td>
                                    @can('admin.permissions.destroy')
                                        <td class="px-4 py-2">
                                            <flux:button wire:click="destroy('{{ $permission->id }}')" variant="primary"
                                                class="cursor-pointer hover:bg-red-200" size="sm">🗑️</flux:button>
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
            @if ($permissions->hasPages())
                <div class="mt-4 relative z-10">
                    {{ $permissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
