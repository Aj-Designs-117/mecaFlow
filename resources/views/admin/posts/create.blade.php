<x-layouts.app>
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Creación de posts</h1>
    </div>
    @can('admin.posts.create')
        <livewire:admin.posts-create />
    @endcan
</x-layouts.app>
