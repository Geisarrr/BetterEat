<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BetterEat — Platform gizi dan resep sehat berbasis makanan nusantara Indonesia.">
    <title>@yield('title', 'BetterEat — Hidup Sehat dengan Makanan Nusantara')</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Google Fonts: Poppins (heading) + Inter (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN (swap with compiled build for production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Main Background
                        'be-bg': '#FBF9F3',

                        // Primary Text / Dark Text
                        'be-dark': '#1B1C18',
                            
                        'logo': '#3F6212',

                        // Main Primary Color / Main Button
                        'be-primary': '#3C4C25',

                        // Soft Highlight / Hero Section
                        'be-highlight': '#C5D8A4',

                        // Soft Secondary Background
                        'be-light': '#EDF3E4',

                        // Secondary Text / Muted Text
                        'be-muted': '#6B7558',

                        // Natural Brown Accent
                        'be-earth': '#78716C',

                        // Fresh Green Accent
                        'be-green': '#4D7C0F',

                        // Soft Olive Button
                        'be-button': '#53643A',

                        'white': '#ffffff'

                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body:    ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    {{-- Global styles --}}
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background-color: #FBF9F3; color: #1B1C18; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Poppins', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #FBF9F3; }
        ::-webkit-scrollbar-thumb { background: #C5D8A4; border-radius: 99px; }

        /* Shared card transitions */
        .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(83,100,58,.13); }


        /* Nav link active/hover state */
        .nav-link.active { 
            color: #53643A; 
            border-bottom: 3px solid #4D7C0F;
            border-radius: 0;
            padding-bottom: 4px;
            font-weight: 600; 
        }
        .nav-link:hover  { color: #53643A; }

        /* Mobile menu slide */
        #mobile-menu { transition: max-height .3s ease, opacity .3s ease; }

        /* Nutrition bar animation */
        @keyframes growBar { from { width: 0 } }
        .nutrition-bar { animation: growBar .8s ease forwards; }

        /* Hero image float */
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .float-anim { animation: float 4s ease-in-out infinite; }
    </style>

    @stack('styles')
</head>
<body class="antialiased">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    {{-- Navbar scroll shadow + mobile menu --}}
    <script>
        // Sticky shadow
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('shadow-md', window.scrollY > 10);
        });

        // Mobile toggle
        const menuBtn   = document.getElementById('menu-btn');
        const mobileNav = document.getElementById('mobile-menu');
        if (menuBtn && mobileNav) {
            menuBtn.addEventListener('click', () => mobileNav.classList.toggle('hidden'));
        }
    </script>

    @stack('scripts')
</body>
</html>