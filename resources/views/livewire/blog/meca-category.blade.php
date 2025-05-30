  <div class="card p-3 category-scroll">
      <h6 class="card-title fw-semibold text-muted mb-3">Categorias</h6>

      <!-- Botón "Todos" -->
      @unless (Route::is('blog.meca.show'))
          <a href="{{ route('home', ['meca' => null]) }}"
              class="category-item rounded text-decoration-none text-dark {{ request('meca') ? '' : 'active' }}">
              <i class="fa-solid fa-tag category-icon"></i>
              <span class="d-flex flex-grow-1 text-primary fw-semibold">{ Todos }</span>
              <i class="fa-solid fa-chevron-right"></i>
          </a>
      @endunless

      <!-- Lista de categorías -->
      @foreach ($categories as $category)
          <a href="{{ route('home', ['meca' => $category->slug]) }}"
              class="category-item text-decoration-none text-dark rounded {{ request('meca') === $category->slug ? 'active' : '' }}">
              <i class="fa-solid fa-tag category-icon"></i>
              <span class="d-flex flex-grow-1 text-primary fw-semibold ">{ {{ $category->name }} } </span>
              <i class="fa-solid fa-chevron-right"></i>
          </a>
      @endforeach
  </div>
