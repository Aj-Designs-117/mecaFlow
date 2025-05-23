<div class="relative h-full w-full p-6 rounded shadow z-10">
    <form wire:submit.prevent="store()">
        <div class="mb-4">
            <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="nombre" placeholder="Ingrese el nombre" />
        </div>
        <div class="mt-4">
            <flux:input wire:model="slug" :label="__('Slug')" type="text" required autofocus autocomplete="slug" placeholder="Ingrese el slug" />
        </div>
        <div class="flex justify-end mt-4">
            @can('admin.categories.store')
                <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Save') }}</flux:button>
            @endcan
        </div>
    </form>
</div>