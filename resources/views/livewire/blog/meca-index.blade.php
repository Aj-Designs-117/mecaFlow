<div class="row g-3 mt-5">
    <div class="col-sm-8">
        <h2>Ultimos agregados</h2>
        @foreach ($posts as $post)
            <div class="card mb-4 flex-row flex-wrap flex-md-nowrap border-0 shadow-sm">
                <!-- Imagen -->
                @if ($post->postImages->first())
                    <img src="{{ $post->postImages->first()->image_path }}"
                        class="card-img-post img-fluid object-fit-cover border rounded" alt="post">
                @else
                    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                        class="card-img-post img-fluid object-fit-cover border rounded" alt="post">
                @endif

                <!-- Contenido -->
                <div class="card-body d-flex flex-column justify-content-between">
                    <!-- Categoría -->

                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($post->categories as $category)
                            <span class="text-primary small fw-bold mb-1">{ {{ $category->name }} }</span>
                        @endforeach
                    </div>

                    <!-- Título -->
                    <h5
                        class="card-title fw-bold mb-2 link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                        <a href="{{ route('blog.meca.show', $post->slug) }}"
                            class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                            {{ $post->title }}
                        </a>
                    </h5>

                    <!-- Descripción -->
                    @if ($post->excerpt)
                        <p class="card-text text-muted mb-3">
                            {{ Str::limit($post->excerpt, 130, ' ...') }}
                        </p>
                    @endif

                    <!-- Metadata -->
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                            alt="author" class="rounded-circle card-img-avatar" />
                        <span>Publicado: {{ $post->created_at->format('d.m.Y') }}</span>
                        <span>·</span>
                        <span>Por:</span>
                        <span class="text-dark"> {{ $post->user ? $post->user->name : 'Usuario no disponible' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>


    <div class="col-md-4">
        <livewire:blog.meca-category />
        <livewire:blog.meca-popular />
    </div>
</div>
