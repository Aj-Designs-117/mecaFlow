<div class="relative h-full w-full p-2 rounded shadow z-10">
    <form wire:submit.prevent="update()" enctype="multipart/form-data">
        <div class="grid md:grid-cols-2 gap-4 justify-center">
            <div class="mt-4">
                <div class="mb-4">
                    <flux:input wire:model="title" :label="__('Titulo')" type="text" required autofocus
                        autocomplete="off" placeholder="Ingrese el titulo" />
                </div>
                <div class="mt-4">
                    <flux:input wire:model="slug" :label="__('Slug')" type="text" required autocomplete="off"
                        placeholder="Ingrese el slug" />
                </div>
                <div class="mt-4">
                    <flux:textarea wire:model="excerpt" :label="__('Extracto')"
                        placeholder="Escriba un pequeño fragmeto del contenido" />
                </div>
                <div class="mt-4">
                    <flux:input wire:model.defer="partners" :label="__('Colaboradores')" type="text"
                        autocomplete="off" placeholder="Ingrese los colaboradores" />
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Categorías
                    </label>
                    @error('')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="relative w-full" id="multiselect-component">
                        <button type="button" id="dropdownButton"
                            class="w-full bg-white text-black dark:bg-neutral-700 dark:text-white px-4 py-2 rounded-md shadow flex justify-between items-center">
                            <span id="dropdownLabel">Seleccione categorías...</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="dropdownMenu"
                            class="absolute mt-2 w-full bg-white text-black dark:bg-neutral-700 dark:text-white rounded-md shadow-lg z-10 max-h-60 overflow-y-auto hidden">

                            @foreach ($categories as $category)
                                <label
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                    <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}"
                                        class="form-checkbox mr-2 category-checkbox">
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('selectedCategories')
                        <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                            <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4">
                    <flux:radio.group wire:model="status" label="Estatus">
                        <flux:radio value="Borrador" label="Borrador" checked />
                        <flux:radio value="Publicado" label="Publicado" />
                    </flux:radio.group>
                </div>
            </div>
            <div class="mb-2">
                <flux:textarea wire:model="imageUrlsText"
                    :label="__('Agregar URLs de imágenes (separadas por coma o salto de línea)')" autocomplete="off"
                    placeholder="https://ejemplo.com/imagen1.jpg, https://ejemplo.com/imagen2.png" />
            </div>

            {{-- <div class="relative mt-4">

                <!-- Subida de archivos -->
                <div
                    class="relative bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 min-h-64 flex items-center justify-center">

                    <!-- Imagen principal -->
                    @if ($images && count($images) > 0)
                        <img class="w-full aspect-video object-cover object-center" src="{{ $images[0] }}"
                            alt="Imagen seleccionada">
                    @else
                        <img class="w-full aspect-video object-cover object-center"
                            src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" alt="img">
                    @endif

                    <!-- Botón para seleccionar imágenes -->
                    <div class="absolute top-4 right-4">
                        <label
                            class="bg-white px-4 py-2 rounded-lg cursor-pointer shadow-md hover:bg-gray-50 transition">
                            📎
                            <input wire:model="images" class="hidden" type="file" accept="image/*" multiple>
                        </label>
                    </div>

                    <!-- Vista previa -->
                    @if ($images && count($images) > 0)
                        <div
                            class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-md p-3 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ count($images) }} imagen(es) seleccionada(s)
                                </span>
                                <button type="button" wire:click="clearImages"
                                    class="text-red-500 hover:text-red-700 text-sm cursor-pointer">
                                    Limpiar todas
                                </button>
                            </div>

                            <div class="grid grid-cols-4 gap-2 max-h-40 overflow-y-auto">
                                @foreach ($images as $img)
                                    <img class="w-full h-20 object-cover rounded" src="{{ $img }}"
                                        alt="preview">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div> --}}

        </div>

        <div class="mt-3">
            <span class="bg-sky-200 text-sky-800 px-2 py-1 rounded text-xs font-semibold">
                Guia: Para insertar imagenes agregue [image_X] y elija el orden en donde se va a visualizar
            </span>
        </div>

        <div wire:ignore class="mt-4">
            <flux:label>Contenido</flux:label>
            <div id="editor" class="h-40 border rounded"></div>
        </div>
        <flux:textarea wire:model="body" id="body" class="hidden" />

        @can('admin.posts.update')
            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary" class="cursor-pointer hover:bg-green-200">💾
                    {{ __('Update') }}</flux:button>
            </div>
        @endcan
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const label = document.getElementById("dropdownLabel");

        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Escribe el contenido aquí...',
            modules: {
                toolbar: [
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'align': [] }],
                    ['code-block', 'blockquote'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
        });

        // Cargar el contenido inicial de body directamente desde la propiedad Livewire
        quill.root.innerHTML = @json($body);

        quill.on('text-change', function() {
            const editor = document.querySelector('.ql-editor');
            editor.querySelectorAll('p').forEach(p => {
                if (p.innerHTML.trim() === '<br>' && p !== editor.lastChild) {
                    p.remove(); // evita dejar <p> vacíos en medio del contenido
                }
            });

            const cleanedHtml = quill.root.innerHTML.replace(/<br\s*\/?>/g, '');
            document.querySelector('#body').value = cleanedHtml;
            @this.set('body', cleanedHtml);
        });

        dropdownButton.addEventListener("click", function() {
            dropdownMenu.classList.toggle("hidden");
        });

        function updateLabel() {
            const checkboxes = document.querySelectorAll(".category-checkbox");
            const selected = Array.from(checkboxes)
                .filter(i => i.checked)
                .map(i => i.parentNode.textContent.trim());

            label.textContent = selected.length ?
                selected.join(', ') :
                "Seleccione categorías...";
        }

        // Escuchar cambios desde Livewire (si se actualizan las categorías)
        window.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', () => {
                updateLabel();
            });
        });

        // Detectar clics fuera del menú para cerrarlo
        document.addEventListener("click", function(event) {
            if (!document.getElementById("multiselect-component").contains(event.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });

        // Inicializar la etiqueta al cargar
        updateLabel();
    });
</script>
