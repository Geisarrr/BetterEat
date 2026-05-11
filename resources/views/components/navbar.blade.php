<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-white transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0 ">
                <span class="font-heading font-bold text-xl text-logo tracking-tight">BetterEat</span>
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-1">
                @php
                    $links = [
                        ['label' => 'Home',            'route' => 'home'],
                        ['label' => 'Resep Sehat',     'route' => 'resep'],
                        ['label' => 'Kalkulator Gizi', 'route' => 'kalkulator'],
                        ['label' => 'Community Hub',   'route' => 'community'],
                    ];
                @endphp
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}"
                       class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }} inline-block px-4 py-2 text-bold font-medium text-be-green transition-colors">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('login') }}"
                   class="px-5 py-2 rounded-full text-sm font-medium text-be-primary border border-be-primary hover:bg-be-light transition-colors duration-200">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-be-button hover:bg-opacity-90 shadow-sm transition-colors duration-200">
                    Register
                </a>
            </div>

            <!-- Hamburger -->
            <button id="menu-btn" class="md:hidden p-2 rounded-lg text-be-dark hover:bg-be-light transition-colors" aria-label="Buka menu">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}"       class="block px-4 py-2.5 rounded-lg text-sm font-medium text-be-dark hover:bg-be-light hover:text-be-primary transition-colors">Home</a>
            <a href="{{ route('resep') }}"      class="block px-4 py-2.5 rounded-lg text-sm font-medium text-be-dark hover:bg-be-light hover:text-be-primary transition-colors">Resep Sehat</a>
            <a href="{{ route('kalkulator') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-be-dark hover:bg-be-light hover:text-be-primary transition-colors">Kalkulator Gizi</a>
            <a href="{{ route('community') }}"  class="block px-4 py-2.5 rounded-lg text-sm font-medium text-be-dark hover:bg-be-light hover:text-be-primary transition-colors">Community Hub</a>
            <div class="flex gap-2 pt-3 pb-1">
                <a href="{{ route('login') }}"    class="flex-1 text-center px-4 py-2 rounded-full text-sm font-medium text-be-primary border border-be-primary hover:bg-be-light transition-colors">Login</a>
                <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 rounded-full text-sm font-semibold text-white bg-be-primary transition-colors">Register</a>
            </div>
        </div>
    </div>
</nav>