<div class="card mt-5">
    <div class="card-body">
        <h6 class="card-title fw-semibold text-muted mb-3">Populares de la semana</h6>
        <!-- Item -->
        @if($popularPosts->isNotEmpty())
        @foreach ($popularPosts as $post)
            <a href="{{ route('blog.meca.show', $post->slug) }}" class="text-decoration-none text-dark">
                <div class="d-flex mb-3 p-2 rounded align-items-center hover-card">
                    @if ($post->postImages->first())
                        <img src="{{ $post->postImages->first()->image_path }}"
                            class="rounded-circle me-3 card-popular-img object-fit-cover" alt="img">
                    @else
                        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                            class="rounded-circle me-3 card-popular-img" alt="img">
                    @endif
                    <div>
                        <div class="d-flex flex-wrap">
                            @foreach ($post->categories as $category)
                                <div class="text-primary fw-semibold small mb-1 me-1">{ {{ $category->name }} }</div>
                            @endforeach
                        </div>
                        <div class="fw-bold">{{ Str::limit($post->title, 30, '...') }}</div>
                    </div>
                </div>
            </a>
        @endforeach
        @else
         <p class="text-muted text-center">No hay publicaciones populares de la semana.</p>
        @endif
    </div>
</div>
