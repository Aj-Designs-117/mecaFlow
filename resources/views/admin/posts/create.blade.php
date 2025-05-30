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

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script>
            (() => {
                // Guardamos la instancia para poder destruirla y evitar conflictos
                let quillInstance = null;

                function initQuillAndDropdown() {
                    if (quillInstance) {
                        quillInstance = null;
                    }

                    const editor = document.querySelector('#editor');
                    const textarea = document.querySelector('#body');

                    if (!editor || !textarea) return;

                    quillInstance = new Quill(editor, {
                        theme: 'snow',
                        placeholder: 'Escribe el contenido aquí...',
                    });

                    quillInstance.on('text-change', () => {
                        const editor = document.querySelector('.ql-editor');
                        editor.querySelectorAll('p').forEach(p => {
                            if (p.innerHTML.trim() === '<br>' && p !== editor.lastChild) {
                                p.remove(); // evita dejar <p> vacíos en medio del contenido
                            }
                        });

                        const cleanedHtml = quillInstance.root.innerHTML.replace(/<br\s*\/?>/g, '');
                        textarea.value = cleanedHtml;
                        textarea.dispatchEvent(new Event('input'));
                    });

                    Livewire.on('quillClear', () => {
                        if (quillInstance) {
                            quillInstance.setText('');
                            textarea.value = '';
                            textarea.dispatchEvent(new Event('input'));
                        }
                    });

                    const dropdownButton = document.getElementById("dropdownButton");
                    const dropdownMenu = document.getElementById("dropdownMenu");
                    const label = document.getElementById("dropdownLabel");

                    if (!dropdownButton || !dropdownMenu || !label) return;

                    dropdownButton.replaceWith(dropdownButton.cloneNode(true));
                    const newDropdownButton = document.getElementById("dropdownButton");
                    newDropdownButton.addEventListener("click", () => {
                        dropdownMenu.classList.toggle("hidden");
                    });

                    const oldCheckboxes = document.querySelectorAll(".category-checkbox");
                    oldCheckboxes.forEach(cb => {
                        cb.replaceWith(cb.cloneNode(true));
                    });

                    const checkboxes = document.querySelectorAll(".category-checkbox");
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener("change", updateLabel);
                    });

                    function updateLabel() {
                        const selected = Array.from(document.querySelectorAll(".category-checkbox"))
                            .filter(i => i.checked)
                            .map(i => i.parentNode.textContent.trim());

                        label.textContent = selected.length ? selected.join(', ') : "Seleccione categorías...";
                    }

                    document.addEventListener("click", (event) => {
                        const component = document.getElementById("multiselect-component");
                        if (component && !component.contains(event.target)) {
                            dropdownMenu.classList.add("hidden");
                        }
                    });
                }

                document.addEventListener('livewire:initialized', () => {
                    initQuillAndDropdown();

                    Livewire.hook('component.init', () => {
                        initQuillAndDropdown();
                    });
                });
            })();
        </script>
    @endpush
</x-layouts.app>
