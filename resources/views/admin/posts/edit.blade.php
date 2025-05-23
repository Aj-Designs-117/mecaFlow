<x-layouts.app>
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Editar Post</h1>
    </div>
    <livewire:admin.posts-edit :slug="$slug"/>
    
</x-layouts.app>
