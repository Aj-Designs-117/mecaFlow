<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="relative p-6 z-10">
                <flux:input wire:model.live="search" icon="magnifying-glass" :label="__('Buscar')" type="text"
                    autofocus autocomplete="Buscar" placeholder="Ingrese el nombre o correo electronico" />

            </div>
            <div class="relative overflow-x-auto">
                @if ($posts->count())
                    <table class="w-full table-auto text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Titulo</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2">Colaboradores</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($posts as $post)
                                <tr class="text-center">
                                    <td class="px-4 py-2 font-bold">{{ $post->id }}</td>
                                    <td class="px-4 py-2">{{ $post->title }}</td>
                                    <td class="px-4 py-2">{{ $post->slug }}</td>
                                    <td class="px-4 py-2">
                                        @foreach ($post->partners as $partner)
                                            {{ $partner }},
                                        @endforeach
                                    </td>
                                    @if ($post->status == 'Publicado')
                                        <td class="px-4 py-2">
                                            <span
                                                class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-semibold">{{ $post->status }}</span>
                                        </td>
                                    @else
                                        <td class="px-4 py-2">
                                            <span
                                                class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">{{ $post->status }}</span>
                                        </td>
                                    @endif
                                    <td class="px-4 py-2 flex justify-center gap-2">
                                        @can('admin.posts.edit')
                                            <flux:button wire:click="edit('{{ $post->id }}')" variant="primary"
                                                class="cursor-pointer hover:bg-sky-200" size="sm">✏️</flux:button>
                                        @endcan
                                        @can('admin.posts.destroy')
                                            <flux:button wire:click="destroy('{{ $post->id }}')" variant="primary"
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
            @if ($posts->hasPages())
                <div class="mt-4 relative z-10">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
