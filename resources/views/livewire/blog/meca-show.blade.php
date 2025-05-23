<div class="row">
    <div class="col-sm-8">
        <h1 class="my-3">
            {{ $post->title }}
        </h1>
        <div class="d-flex justify-content-between my-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32" alt="author"
                class="rounded-circle me-3" width="40" height="40" />
            <div class="text-end">
                <h6 class="mb-0 fw-semibold">Por: {{ $post->user->name }}</h6>
                <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
            </div>
        </div>

        <div class="fs-5 text-tertiary mt-2 text-justify">
            {!! $post->formatted_body !!}
        </div>

    </div>
    <div class="col-md-4">
        <div class="container mt-4">
            <div class="card p-3">
                <h5 class="mb-3">Categorías</h5>

                @foreach ($post->categories as $category)
                    <a href="#" class="category-item text-decoration-none text-dark">
                        <i class="fa-solid fa-tag category-icon"></i>
                        <span class="d-flex flex-grow-1">{{ $category->name }}</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @endforeach

            </div>
            @if (!empty($post->partners) && is_array($post->partners) && count($post->partners) > 0)
                <div class="card p-3 mt-4">
                    <h5 class="mb-3">Colaboradores</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($post->partners as $partner)
                            <li class="list-group-item d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($partner) }}&background=random&rounded=true&size=32"
                                    alt="{{ $partner }}" class="rounded-circle me-2" width="32" height="32">
                                <span>{{ $partner }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div> 
