<header class="bg-white border-b border-gray-200 shadow-sm">
  <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
    <!-- Logo / Título -->
    <div class="text-center sm:text-left">
      <a href="{{ route('dashboard') }}" class="group inline-block">
        <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight group-hover:text-blue-600 transition-colors duration-200">
          {{ config('app.name', 'FinanzasApp') }}
        </h1>
        <p class="text-sm text-gray-500 hidden sm:block group-hover:text-blue-500 transition-colors duration-200">
          Tu centro de control financiero
        </p>
      </a>
    </div>

    <!-- Navegación -->
    <nav class="relative">
      <!-- Botón hamburguesa (móvil) -->
      <button id="menu-toggle" aria-label="Toggle menu"
        class="sm:hidden flex items-center text-gray-600 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 rounded">
        <svg id="icon-open" class="w-6 h-6 block" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Menú desktop -->
      <ul
        class="hidden sm:flex gap-x-6 text-sm font-medium text-gray-600 items-center">
        <li>
          <a href="{{ route('dashboard') }}"
            class="relative hover:text-blue-600 transition-colors duration-200 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-blue-600 hover:after:w-full after:transition-all after:duration-300">
            Dashboard
          </a>
        </li>

        <li class="relative group">
          <button
            id="dropdown-button"
            aria-haspopup="true"
            aria-expanded="false"
            class="flex items-center gap-1 hover:text-blue-600 transition-colors duration-200 focus:outline-none"
          >
            Menú
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M6 9l6 6 6-6" />
            </svg>
          </button>

          <!-- Dropdown -->
          <ul
            id="dropdown-menu"
            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md opacity-0 pointer-events-none transition-opacity duration-200"
            role="menu"
            aria-labelledby="dropdown-button"
          >
            @php
              $navLinks = [
                ['label' => 'Ingresos', 'route' => 'ingresos.index'],
                ['label' => 'Egresos', 'route' => 'egresos.index'],
                ['label' => 'Ahorros', 'route' => 'ahorros.index'],
                ['label' => 'Periodos', 'route' => 'periodos.index'],
                ['label' => 'Gastos Fijos', 'route' => 'gastos-fijos.index'],
              ];
            @endphp
            @foreach ($navLinks as $link)
              <li role="none">
                <a href="{{ route($link['route']) }}"
                  class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white transition-colors duration-200 rounded"
                  role="menuitem">
                  {{ $link['label'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </li>
      </ul>

      <!-- Menú móvil -->
      <div
        id="mobile-menu"
        class="sm:hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-md opacity-0 pointer-events-none transition-opacity duration-200"
      >
        <ul class="flex flex-col gap-y-1 p-2 text-gray-700 text-sm font-medium">
          <li>
            <a href="{{ route('dashboard') }}"
              class="block px-4 py-2 hover:bg-blue-600 hover:text-white rounded transition-colors duration-200">
              Dashboard
            </a>
          </li>
          @foreach ($navLinks as $link)
            <li>
              <a href="{{ route($link['route']) }}"
                class="block px-4 py-2 hover:bg-blue-600 hover:text-white rounded transition-colors duration-200">
                {{ $link['label'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </nav>
  </div>

  <script>
    // Toggle mobile menu
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    menuToggle.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.contains('opacity-100');
      if (isOpen) {
        mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
      } else {
        mobileMenu.classList.add('opacity-100', 'pointer-events-auto');
        mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
      }
    });

    // Toggle dropdown menu desktop
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    dropdownButton.addEventListener('click', (e) => {
      e.preventDefault();
      const isOpen = dropdownMenu.classList.contains('opacity-100');
      if (isOpen) {
        dropdownMenu.classList.remove('opacity-100', 'pointer-events-auto');
        dropdownMenu.classList.add('opacity-0', 'pointer-events-none');
        dropdownButton.setAttribute('aria-expanded', 'false');
      } else {
        dropdownMenu.classList.add('opacity-100', 'pointer-events-auto');
        dropdownMenu.classList.remove('opacity-0', 'pointer-events-none');
        dropdownButton.setAttribute('aria-expanded', 'true');
      }
    });

    // Close dropdown if click outside
    document.addEventListener('click', (event) => {
      if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.remove('opacity-100', 'pointer-events-auto');
        dropdownMenu.classList.add('opacity-0', 'pointer-events-none');
        dropdownButton.setAttribute('aria-expanded', 'false');
      }
    });

    // Optional: close menus on ESC key
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');

        dropdownMenu.classList.remove('opacity-100', 'pointer-events-auto');
        dropdownMenu.classList.add('opacity-0', 'pointer-events-none');
        dropdownButton.setAttribute('aria-expanded', 'false');
      }
    });
  </script>
</header>
