<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="relative h-full w-full p-6 rounded shadow z-10">
                <form wire:submit.prevent="store()">
                    <div class="mb-4">
                        <flux:input wire:model="settings.site_title" :label="__('Titulo')" type="text" required
                            autofocus autocomplete="off" placeholder="Ingrese el titulo" />
                    </div>
                    <div class="mb-4">
                        <flux:textarea wire:model="settings.site_description" :label="__('Descripción')" required
                            autocomplete="off" placeholder="Ingrese una descripción" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.site_author" :label="__('Autor del sitio')" type="text"
                            required autocomplete="off" placeholder="Ingrese el autor del sitio" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.site_number" :label="__('Numero de telefono')" type="text"
                            required autocomplete="off" placeholder="Ingrese el numero de telefono" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.site_email" :label="__('Correo del sitio')" type="email"
                            required autocomplete="off" placeholder="Ingrese el correo del sitio" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.facebook_url" :label="__('Facebook')" type="text"
                            autocomplete="off" placeholder="Ingrese el facebook" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.instagram_url" :label="__('Instagram')" type="text"
                            autocomplete="off" placeholder="Ingrese el instagram" />
                    </div>
                    <div class="mb-4">
                        <flux:input wire:model="settings.web_url" :label="__('web')" type="text"
                            autocomplete="off" placeholder="Ingrese una web" />
                    </div>

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾
                            {{ __('Save') }}</flux:button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
