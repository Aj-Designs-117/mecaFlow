<div class="container my-5">
    <div class="position-relative mb-2">
        <input type="text" class="form-control rounded-pill ps-5" wire:model.live="search" placeholder="Buscar por titulo o categoria" />
        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
    </div>
    <p class="text-muted small mb-3">Escriba al menos 3 caracteres</p>

    <div class="overflow-auto scroll-categories">
        <button class="btn btn-primary rounded-pill px-4 py-1 d-inline-block"
            wire:click="selectCategory(null)">All</button>
        @foreach ($categories as $category)
            <button class="btn btn-outline-danger rounded-pill px-4 py-1 d-inline-block"
                wire:click="selectCategory('{{ $category->slug }}')">
                {{ $category->name }}
            </button>
        @endforeach
    </div>
</div>
