<x-layouts.main>
    <section class="wrapper-main">
        <div class="container">
            <div class="blog-container-title">
                <h1 class="blog-title">{{ trim(setting('site_title')) ?: 'Blog' }}</h1>
                <p class="blog-author">Donde las ideas se convierten en máquinas</p>
            </div>
        </div>
    </section>

    <section class="container wrapper-spacing">
        <livewire:blog.category-filter />
        <livewire:blog.posts-list />
    </section>
</x-layouts.main>
