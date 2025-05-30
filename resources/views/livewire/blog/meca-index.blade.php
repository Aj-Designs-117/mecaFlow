<div class="row g-3 mt-5">
    <div class="col-sm-8">
        <h2>Ultimos agregados</h2>
        @foreach ($posts as $post)
            <div class="card border-0 shadow-sm mb-4 bg-card d-flex flex-row rounded">
                <!-- Imagen a la izquierda -->
                @if ($post->postImages->first())
                    <img src="{{ $post->postImages->first()->image_path }}"
                        class="card-img card-img-post object-fit-cover border rounded" alt="main">
                @else
                    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                        class="card-img card-img-post object-fit-cover border rounded" alt="main">
                @endif
                <!-- Cuerpo de la card -->
                <div class="card-body d-flex flex-column justify-content-between">
                    <!-- Etiquetas -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach ($post->categories as $category)
                            <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                        @endforeach
                    </div>

                    <!-- Título -->
                    <h4 class="card-title fw-bold mb-3">
                        <a href="{{ route('blog.meca.show', $post->slug) }}"
                            class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                            {{ $post->title }}
                        </a>
                    </h4>

                    @if ($post->excerpt)
                        <p class="card-text text-trucate mb-3">
                            {{ Str::limit($post->excerpt, 50, ' ...') }}
                        </p>
                    @endif

                    <!-- Autor y fecha -->
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                alt="author" class="rounded-circle me-3" width="40" height="40" />
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $post->user ? $post->user->name : 'Usuario no disponible' }}</h6>
                                <small class="text-muted">Publicado: {{ $post->created_at->format('d.m.Y') }}</small>
                            </div>
                        </div>
                        <!-- Flecha -->
                        <a href="{{ route('blog.meca.show', $post->slug) }}"
                            class="btn btn-outline-danger rounded-circle">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>


    <div class="col-md-4">
        <livewire:blog.meca-category/>
        <livewire:blog.meca-popular/>
    </div>
</div>
