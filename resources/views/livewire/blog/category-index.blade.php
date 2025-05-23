<div class="col-md-4 mb-4 text-center">
    @foreach ($categories as $category)
        <ul class="list-unstyled">
            <li class="mb-2">
                <a href="#" wire:click="selectCategory('{{ $category->slug }}')" class="text-decoration-none text-light pe-auto">{{ $category->name }}</a>
            </li>
        </ul>
    @endforeach
</div>
