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
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Lista de auditoria</h1>
                    <button wire:click="confirmClearAudit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 cursor-pointer">
                        🗑️ Borrar
                    </button>
                </div>
                <div
                    class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 z-10">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    <div class="relative overflow-x-auto z-10">
                        @if ($logs->count())
                            <table class="w-full table-auto text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm text-center">
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">ID MOD</th>
                                        <th class="px-4 py-2">Modelo</th>
                                        <th class="px-4 py-2">Acción</th>
                                        <th class="px-4 py-2">Usuarios</th>
                                        <th class="px-4 py-2">Detalles</th>
                                        <th class="px-4 py-2">Ip</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($logs as $log)
                                        <tr class="text-center">
                                            <td class="px-4 py-2 font-bold border">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="px-4 py-2 border">{{ $log->subject_id }}</td>
                                            <td class="px-4 py-2 border">{{ $log->log_name }}</td>
                                            <td class="px-4 py-2 border">{{ ucfirst($log->description) }}</td>
                                            <td class="px-4 py-2 border">{{ $log->causer?->name ?? '—' }}</td>
                                            <td class="px-4 py-2 border">
                                                @if (isset($log->properties['register_id']))
                                                    <div><strong>id_registro:</strong> {{ $log->properties['register_id'] }}</div>
                                                @endif
                                                @if (isset($log->properties['error']))
                                                    <div><strong>Error:</strong> {{ $log->properties['error'] }}</div>
                                                @else
                                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-semibold">Sin detalle</span>
                                                @endif
                                                @if (isset($log->properties['line']))
                                                    <div class="my-1">
                                                        <strong>Ip: </strong>
                                                        <span class="bg-sky-200 text-sky-800 px-2 py-1 rounded text-xs font-semibold">{{ $log->properties['ip'] }}</span>
                                                    </div>
                                                @endif
                                                @if (isset($log->properties['line']))
                                                    <div class="my-1">
                                                        <strong>Linea error: </strong>
                                                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">{{ $log->properties['line'] }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                 @if (isset($log->properties['ip']))
                                                    <div class="my-1">
                                                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">{{ $log->properties['ip'] }}</span>
                                                    </div>
                                                @endif
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
                    @if ($logs->hasPages())
                        <div class="mt-4 w-full">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            @endrole
        @endauth
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.addEventListener('confirm-clear-audit', () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción eliminará todos los registros de auditoría!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroyAudits');
                }
            });
        });
    });
</script>
