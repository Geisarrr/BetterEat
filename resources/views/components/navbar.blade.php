<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-white shadow-sm transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                <span class="font-heading font-bold text-xl text-[#53643A] tracking-tight">BetterEat</span>
            </a>

            <div class="hidden md:flex items-center h-16 gap-1">
                @php
                    $links = [
                        ['label' => 'Home',            'route' => 'home'],
                        ['label' => 'Resep Sehat',     'route' => 'resep'],
                        ['label' => 'Kalkulator Gizi', 'route' => 'kalkulator'],
                        ['label' => 'Community Hub',   'route' => 'community'],
                    ];
                @endphp

                @foreach($links as $link)
                    @php
                        $isActive = request()->routeIs($link['route']) || ($link['route'] == 'home' && request()->routeIs('dashboard'));
                    @endphp
                    
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center h-16 px-4 text-sm font-semibold transition-all duration-200 border-b-2 {{ $isActive ? 'border-[#53643A] text-[#53643A]' : 'border-transparent text-gray-500 hover:text-[#53643A] hover:border-[#53643A]/30' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ route('my_profile.edit') }}" class="block transform transition hover:scale-105" title="Edit Profil">
                        <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}" 
                             alt="Profile" 
                             class="w-9 h-9 rounded-full border-2 border-[#D6EAB5] object-cover">
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 rounded-full text-sm font-medium text-[#53643A] border border-[#53643A] hover:bg-gray-50 transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-[#53643A] hover:bg-opacity-90 shadow-sm transition-colors duration-200">
                        Register
                    </a>
                @endauth
            </div>

            <button id="menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-4 py-3 space-y-1">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" 
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-[#FBF9F3] text-[#53643A]' : 'text-gray-600 hover:bg-gray-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            
            <div class="pt-3 pb-1 border-t border-gray-100 mt-2">
                @auth
                    <div class="flex items-center gap-3 px-4 py-2 mb-2">
                        <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}" 
                             alt="Profile" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->full_name }}</p>
                            <a href="{{ route('my_profile.edit') }}" class="text-xs text-[#53643A] font-medium hover:underline">Edit Profil</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-500">
                            Logout
                        </button>
                    </form>
                @else
                    <div class="flex gap-2 px-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2 rounded-full text-sm font-medium text-[#53643A] border border-[#53643A]">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 rounded-full text-sm font-semibold text-white bg-[#53643A]">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>