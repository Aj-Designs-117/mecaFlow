<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-green-400 dark:hover:border-green-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">📝 Total de publicaciones
                    </h5>
                    <p class="text-5xl font-bold text-red-600 dark:text-red-400">{{ $totalPosts }}</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-yellow-400 dark:hover:border-yellow-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">🗂️ Publicados</h5>
                    <p class="text-5xl font-bold text-red-500 dark:text-red-300">{{ $public }}</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-red-400 dark:hover:border-red-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">🗂️ Borradores</h5>
                    <p class="text-5xl font-bold text-red-500 dark:text-red-300">{{ $drafts }}</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-sky-400 dark:hover:border-sky-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">📂 Categorías</h5>
                    <p class="text-5xl font-bold text-red-500 dark:text-red-300">{{ $categories }}</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-sky-400 dark:hover:border-sky-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">👤 Usuarios registrados</h5>
                    <p class="text-5xl font-bold text-red-500 dark:text-red-300">{{ $users }}</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md hover:border-sky-400 dark:hover:border-sky-300 transition duration-300 transform hover:-translate-y-1">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">📈 Total de visitas</h5>
                    <p class="text-5xl font-bold text-red-500 dark:text-red-300">{{ $recentViews }}</p>
                </div>
            </div>
        </div>
        @auth
            @role('Administrador')
                <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    <div class="relative overflow-x-auto z-10">
                        @if ($audits->count())
                            <table class="w-full table-auto text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">Post</th>
                                        <th class="px-4 py-2">Usuario</th>
                                        <th class="px-4 py-2">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($audits as $audit)
                                        <tr class="text-center">
                                            <td class="px-4 py-2 font-bold">{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2">{{ $audit->post->title }}</td>
                                            <td class="px-4 py-2">{{ $audit->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2">{{ $audit->action }}</td>
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
                    @if ($audits->hasPages())
                        <div class="mt-4 w-full">
                            {{ $audits->links() }}
                        </div>
                    @endif
                </div>
            @endrole
        @endauth
    </div>
</div>
