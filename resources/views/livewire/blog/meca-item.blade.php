<div class="row">
    <div class="col-sm-8">
        <h1 class="my-3">
            {{ $post->title }}
        </h1>
        <div class="d-flex justify-content-between my-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                alt="author" class="rounded-circle me-3" width="40" height="40" />
            <div class="text-end">
                <h6 class="mb-0 fw-semibold">Por: {{ $post->user->name }}</h6>
                <small class="text-muted">Publicado: {{ $post->formatted_date }}</small>
            </div>
        </div>

        <div class="fs-5 ql-editor">
            {!! $post->formatted_body !!}
        </div>

        <div class="d-flex flex-wrap gap-2 mb-3">
            @foreach ($post->categories as $category)
                <h4 class="text-primary fw-semibold">{ {{ $category->name }} }</h4>
            @endforeach
        </div>

    </div>
    <div class="col-md-4">
        <livewire:blog.meca-category />
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
        <livewire:blog.meca-popular />
    </div>
</div>
