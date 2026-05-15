<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BetterEat</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#EFEEE8] font-sans text-[#1B1C18]"> <!-- Warna background utama -->
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-[#53643A] text-white flex flex-col justify-between shrink-0 sticky top-0 h-screen"> <div class="overflow-y-auto overflow-x-hidden custom-scrollbar"> <div class="p-6 mt-2">
                <h1 class="text-[28px] font-extrabold tracking-tight">BetterEat</h1>
                <p class="text-[11px] text-[#E4E2DC] mt-1 font-medium">Admin Panel</p>
            </div>
        
                <nav class="mt-4 px-4 space-y-2 pb-6">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#596A3F] text-white shadow-sm' : 'text-[#E4E2DC] hover:bg-[#596A3F] hover:text-white' }}">
                        Dashboard
                    </a>    

                    <a href="{{ route('admin.users') }}" 
                        class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users') ? 'bg-[#596A3F] text-white shadow-sm' : 'text-[#E4E2DC] hover:bg-[#596A3F] hover:text-white' }}">
                        Manajemen User
                    </a>

                    <a href="{{ route('admin.recipes') }}" 
                        class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.recipes') ? 'bg-[#596A3F] text-white shadow-sm' : 'text-[#E4E2DC] hover:bg-[#596A3F] hover:text-white' }}">
                        Manajemen Resep
                    </a>

                    <a href="{{ route('admin.community') }}" 
                        class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.community') ? 'bg-[#596A3F] text-white shadow-sm' : 'text-[#E4E2DC] hover:bg-[#596A3F] hover:text-white' }}">
                        Manajemen Community Hub
                    </a>

                    <a href="{{ route('admin.tkpi') }}" 
                        class="block px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.tkpi') ? 'bg-[#596A3F] text-white shadow-sm' : 'text-[#E4E2DC] hover:bg-[#596A3F] hover:text-white' }}">
                        Manajemen TKPI
                    </a>
                </nav>
            </div>
    
                <div class="p-4 mb-4 border-t border-[#596A3F]"> <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Logout</a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>
        
    </div>
</body>
</html>