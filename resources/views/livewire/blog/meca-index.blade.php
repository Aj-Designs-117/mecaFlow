<div class="row g-3 mt-5">
    <div class="col-sm-8">
        @foreach ($posts as $post)
            <h2>Ultimos agregados</h2>
            <div class="card border-0 shadow-sm mb-4 bg-card d-flex flex-row rounded">
                <!-- Imagen a la izquierda -->
                {{-- @if ($post->postImages->first())
                    <img src="{{ $post->postImages->first()->image_path }}"
                        class="card-img card-img-post object-fit-cover border rounded" alt="main"> --}}
                {{-- @else --}}
                    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                        class="card-img card-img-item object-fit-cover border rounded" alt="main">
                {{-- @endif --}}
                <!-- Cuerpo de la card -->
                <div class="card-body d-flex flex-column justify-content-between">
                    <!-- Etiquetas -->
                    @foreach ($post->categories as $category)
                        <p class="mb-2">
                            <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                        </p>
                    @endforeach
                    <!-- Título -->

                    <h3 class="card-title fw-bold mb-3">
                        <a href="{{ route('blog.meca.show', $post->slug) }}"
                            class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <!-- Autor y fecha -->
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                alt="author" class="rounded-circle me-3" width="40" height="40" />
                            <div>
                                <h6 class="mb-0 fw-semibold">
                                    {{ $post->user ? $post->user->name : 'Usuario no disponible' }}</h6>
                                <small class="text-muted">Publicado: {{ $post->created_at->format('d.m.Y') }}</small>
                            </div>
                        </div>
                        <!-- Flecha -->
                        <a href="{{ route('blog.meca.show', $post->slug) }}" class="btn btn-outline-danger rounded-circle">
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
        <div class="card p-3 category-scroll">
            <h5 class="mb-3">Categorías</h5>

            <div class="position-relative mb-2">
                <input type="text" class="form-control rounded-pill ps-5" wire:model.live="search" placeholder="Buscar..." />
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>

            <!-- Botón "Todos" -->
            <a href="#" wire:click.prevent="clearCategory"
                class="category-item rounded text-decoration-none text-dark {{ is_null($selectedCategory) ? 'active' : '' }}">
                <i class="fa-solid fa-tag category-icon"></i>
                <span class="d-flex flex-grow-1 text-primary fw-semibold">{ Todos }</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>

            <!-- Lista de categorías -->
            @foreach ($categories as $category)
                <a wire:click="selectCategory('{{ $category->slug }}')"
                    class="category-item text-decoration-none text-dark rounded {{ $selectedCategory === $category->slug ? 'active' : '' }}">
                    <i class="fa-solid fa-tag category-icon"></i>
                    <span class="d-flex flex-grow-1 text-primary fw-semibold ">{ {{ $category->name }} } </span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @endforeach
        </div>
    </div>
</div>
