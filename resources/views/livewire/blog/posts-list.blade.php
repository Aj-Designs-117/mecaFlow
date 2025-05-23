<div>
        <div class="row gy-2">
            <h1>Recientes</h1>
            @foreach ($recentPosts as $post)
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm mb-4 bg-card">
                        @if ($post->main_image)
                            <img src="{{ $post->main_image->image_path }}" class="card-img object-fit-cover" alt=""
                                height="400" />
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img object-fit-cover" alt="" height="400" />
                        @endif
                        <div class="card-body">

                            <p class="mb-2">
                                @foreach ($post->categories as $category)
                                    <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                                @endforeach
                            </p>

                            <h5 class="fw-bold mb-3">
                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline">
                                    {{ $post->title }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                        alt="author" class="rounded-circle me-3" width="40" height="40" />
                                    <div>
                                        <h6 class="mb-0 fw-semibold">
                                            {{ $post->user ? $post->user->name : 'Usuario no disponible' }}
                                        </h6>
                                        <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="btn btn-outline-danger rounded-circle">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    
    @if (isset($groupedPosts['Tareas']))
        <h1>Tareas</h1>
        <div class="row gy-2">
            @foreach ($groupedPosts['Tareas'] as $post)
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm mb-4 bg-card">
                        @if ($post->main_image)
                            <img src="{{ $post->main_image->image_path }}" class="card-img object-fit-cover"
                                alt="" height="300" />
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img object-fit-cover" alt="" height="400" />
                        @endif

                        <div class="card-body">

                            @foreach ($post->categories as $category)
                                <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                            @endforeach

                            <h5 class="card-title fw-bold mt-2">
                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline">
                                    {{ $post->title }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                        alt="author" class="rounded-circle me-3" width="40" height="40" />
                                    <div>
                                        <h6 class="mb-0 fw-semibold">
                                            {{ $post->user ? $post->user->name : 'Usuario no disponible' }}
                                        </h6>
                                        <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="btn btn-outline-danger rounded-circle">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

    @if (isset($groupedPosts['Noticias']))
        <h1>Noticias</h1>
        <div class="row gy-2">
            @foreach ($groupedPosts['Noticias'] as $post)
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm mb-4 bg-card">
                        @if ($post->main_image)
                            <img src="{{ $post->main_image->image_path }}" class="card-img object-fit-cover"
                                alt="" height="400" />
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img object-fit-cover" alt="" height="400" />
                        @endif

                        <div class="card-body">

                            @foreach ($post->categories as $category)
                                <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                            @endforeach

                            <h5 class="card-title fw-bold mt-2">
                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline">
                                    {{ $post->title }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                        alt="author" class="rounded-circle me-3" width="40" height="40" />
                                    <div>
                                        <h6 class="mb-0 fw-semibold">
                                            {{ $post->user ? $post->user->name : 'Usuario no disponible' }}
                                        </h6>
                                        <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('blog.posts.meca', $post->slug) }}" class="btn btn-outline-danger rounded-circle">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (isset($groupedPosts['Practicas']))
        <h1>Practicas</h1>
        <div class="row gy-2">
            @foreach ($groupedPosts['Practicas'] as $post)
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm mb-4 bg-card">
                        @if ($post->main_image)
                            <img src="{{ $post->main_image->image_path }}" class="card-img object-fit-cover"
                                alt="" height="400" />
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img object-fit-cover" alt="" height="400" />
                        @endif

                        <div class="card-body">

                            @foreach ($post->categories as $category)
                                <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                            @endforeach

                            <h5 class="card-title fw-bold mt-2">
                                <a href="{{ route('blog.posts.meca', $post->slug) }}"
                                    class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline">
                                    {{ $post->title }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                        alt="author" class="rounded-circle me-3" width="40" height="40" />
                                    <div>
                                        <h6 class="mb-0 fw-semibold">
                                            {{ $post->user ? $post->user->name : 'Usuario no disponible' }}
                                        </h6>
                                        <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('blog.posts.meca', $post->slug) }}" class="btn btn-outline-danger rounded-circle">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- @if (isset($groupedPosts['CAD']))
        <h1>CAD</h1>
        <div class="row gy-2">
            @foreach ($groupedPosts['CAD'] as $post)
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm mb-4 bg-card">
                        @if ($post->main_image)
                            <img src="{{ $post->main_image->image_path }}" class="card-img object-fit-cover"
                                alt="" height="400" />
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img object-fit-cover" alt="" height="400" />
                        @endif

                        <div class="card-body">

                            @foreach ($post->categories as $category)
                                <span class="text-primary fw-semibold">{ {{ $category->name }} }</span>
                            @endforeach

                            <h5 class="card-title fw-bold mb-3">
                                {{ $post->title }}
                            </h5>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}"
                                        alt="author" class="rounded-circle me-3" width="40" height="40" />
                                    <div>
                                        <h6 class="mb-0 fw-semibold">
                                            {{ $post->user ? $post->user->name : 'Usuario no disponible' }}
                                        </h6>
                                        <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
                                    </div>
                                </div>

                                <a href="#" class="btn btn-outline-secondary rounded-circle">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif --}}
</div>
