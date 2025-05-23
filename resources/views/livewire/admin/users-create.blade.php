<div class="relative h-full w-full p-6 rounded shadow z-10">
    <form wire:submit.prevent="store()">
        <div class="mb-4">
            <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="name" placeholder="Ingrese el nombre" />
        </div>
        <div class="mt-4">
            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" placeholder="Ingrese el email" />
        </div>
        <div class="mt-4">
            <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="password" placeholder="Ingrese el password" />
        </div>
        <div class="flex justify-end mt-4">
            @can('admin.users.store')
                <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾 {{ __('Save') }}</flux:button>
            @endcan
        </div>
    </form>
</div>