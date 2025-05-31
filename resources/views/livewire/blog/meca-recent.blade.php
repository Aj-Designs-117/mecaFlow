@php
    $mainPost = $posts->first();
    $otherPosts = $posts->skip(1);
@endphp

<div class="row g-3">
    @if ($mainPost)
        <!-- Main Card -->
        <div class="col-md-8">
            <div class="card text-white border-0 position-relative">
                @if ($mainPost->postImages->first())
                    <img src="{{ $mainPost->postImages->first()->image_path }}"
                        class="card-img-main object-fit-cover border rounded" alt="main">
                @else
                    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                        class="card-img-main object-fit-cover border rounded" alt="main">
                @endif
                <div class="card-overlay">
                    <div class="position-absolute top-0 start-0 m-3 d-flex flex-wrap gap-2">
                        @foreach ($mainPost->categories as $category)
                            <span class="badge bg-danger">{ {{ $category->name }} }</span>
                        @endforeach
                    </div>
                    <h4 class="card-title fw-bold">
                        <a href="{{ route('blog.meca.show', $mainPost->slug) }}"
                            class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                            {{ $mainPost->title }}
                        </a>
                    </h4>

                    <div class="d-flex align-items-center mt-3 author-info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($mainPost->user->name) }}&background=random&rounded=true&size=32"
                            alt="author">
                        <small> {{ $mainPost->user ? $mainPost->user->name : 'Usuario no disponible' }} •
                            {{ $mainPost->created_at->format('d.m.Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Right Column Cards usando Grid -->
    <div class="col-md-4">
        <div class="row g-3">
            @foreach ($otherPosts as $post)
                <!-- Card 1 -->
                <div class="col-md-12">
                    <div class="card text-white border-0 position-relative">
                        @if ($post->postImages->first())
                            <img src="{{ $post->postImages->first()->image_path }}"
                                class="card-img-item object-fit-cover border rounded" alt="main">
                        @else
                            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwpdirecto.com%2Fwp-content%2Fuploads%2F2017%2F08%2Falt-de-una-imagen.png&f=1&nofb=1&ipt=74c144e403ebed513597b4108410bf4abd0dce8e07265d3d789ae12abb40d4b4"
                                class="card-img card-img-item object-fit-cover border rounded" alt="main">
                        @endif
                        <div class="card-overlay">
                            <div class="position-absolute top-0 start-0 m-3 d-flex flex-wrap gap-2">
                                @foreach ($post->categories as $category)
                                    <span class="badge bg-danger">{ {{ $category->name }} }</span>
                                @endforeach
                            </div>
                            <h6 class="card-title fw-bold">
                                <a href="{{ route('blog.meca.show', $post->slug) }}"
                                    class="card-title link-offset-2 link-underline link-underline-opacity-0 text-custom-underline m-0 p-0">
                                    {{ $post->title }}
                                </a>
                            </h6>
                            <div class="d-flex align-items-center mt-2 author-info">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&rounded=true&size=32"
                                    alt="author">
                                <small> {{ $post->user ? $post->user->name : 'Usuario no disponible' }} •
                                    {{ $post->created_at->format('d.m.Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
