<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            @can('admin.categories.create')
                <livewire:admin.categories-create/>
            @endcan
            <div class="relative p-6 z-10">
            <flux:input wire:model.live="search" icon="magnifying-glass" :label="__('Buscar')" type="text" autofocus autocomplete="Buscar" placeholder="Ingrese el nombre o correo electronico" />

            </div>
            <div class="relative overflow-x-auto z-10">
                @if ($categories->count())
                <table class="w-full table-auto text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">slug</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                    @foreach($categories as $category)
                        <tr class="text-center">
                            <td class="px-4 py-2 font-bold">{{ $category->id }}</td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">{{ $category->slug }}</td>
                            <td class="px-4 py-2 flex justify-center gap-2">
                            @can('admin.categories.edit')
                                <flux:modal.trigger name="editCategory">
                                    <flux:button wire:click="edit('{{ $category->id }}')" variant="primary" class="cursor-pointer hover:bg-sky-200" size="sm">✏️</flux:button>
                                </flux:modal.trigger>
                            @endcan
                            @can('admin.categories.destroy')
                                <flux:button wire:click="destroy('{{ $category->id }}')" variant="primary" class="cursor-pointer hover:bg-red-200" size="sm">🗑️</flux:button>
                            @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-4 relative z-10">
                    {{ $categories->links() }}
                </div>

                @else
                <div class="p-6 border-t">
                    <strong class="font-bold">{{ __('No hay registros') }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
     <!-- Modal - Categories -->
     <flux:modal name="editCategory" class="md:w-96">
        <form wire:submit.prevent="update('{{ $id }}')">
            <div class="space-y-6">
                <flux:heading size="lg">Actualizar categoria</flux:heading>

                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="Nombre" placeholder="Ingrese el nombre" />
                <flux:input wire:model="slug" :label="__('Slug')" type="text" required autofocus autocomplete="slug" placeholder="Ingrese el slug" />

                <div class="flex">
                    <flux:spacer />
                    @can('admin.categories.update')
                        <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Update') }}</flux:button>
                    @endcan
                </div>
            </div>
        </form>
    </flux:modal>
     
</div>
