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
            document.addEventListener('DOMContentLoaded', function() {
                const quill = new Quill('#editor', {
                    theme: 'snow',
                    placeholder: 'Escribe el contenido aquí...'
                });

                Livewire.on('quillClear', function() {
                    quill.setText('');
                    textarea.value = '';
                    textarea.dispatchEvent(new Event('input'));
                });

                const textarea = document.querySelector('#body');

                quill.on('text-change', function() {
                    let html = quill.root.innerHTML;
                    textarea.value = html;
                    textarea.dispatchEvent(new Event('input'));
                });

                const dropdownButton = document.getElementById("dropdownButton");
                const dropdownMenu = document.getElementById("dropdownMenu");
                const label = document.getElementById("dropdownLabel");

                dropdownButton.addEventListener("click", function() {
                    dropdownMenu.classList.toggle("hidden");
                });

                const checkboxes = document.querySelectorAll(".category-checkbox");
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener("change", updateLabel);
                });

                function updateLabel() {
                    const selected = Array.from(checkboxes)
                        .filter(i => i.checked)
                        .map(i => i.parentNode.textContent.trim());

                    label.textContent = selected.length ?
                        selected.join(', ') :
                        "Seleccione categorías...";
                }

                document.addEventListener("click", function(event) {
                    if (!document.getElementById("multiselect-component").contains(event.target)) {
                        dropdownMenu.classList.add("hidden");
                    }
                });
            });
        </script>
       
    @endpush
</x-layouts.app>
