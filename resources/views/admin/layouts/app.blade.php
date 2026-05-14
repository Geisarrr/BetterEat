<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BetterEat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#EFEEE8] font-sans text-[#1B1C18]"> <!-- Warna background utama -->
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-[#53643A] text-white flex flex-col justify-between shrink-0"> <!-- Warna Sidebar -->
            <div>
                <div class="p-6 mt-2">
                    <h1 class="text-[28px] font-extrabold tracking-tight">BetterEat</h1>
                    <p class="text-[11px] text-[#E4E2DC] mt-1 font-medium">Admin Panel</p> <!-- Warna teks sekunder Sidebar -->
                </div>
                
                <nav class="mt-4 px-4 space-y-2">
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Manajemen User</a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Manajemen Community Hub</a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Manajemen Resep</a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Manajemen TKPI</a>
                    
                    <!-- Menu Aktif -->
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg bg-[#596A3F] text-white shadow-sm">Dashboard</a>
                    
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white mt-6">Laporan</a>
                    <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Pengaturan</a>
                </nav>
            </div>
            
            <div class="p-4 mb-4">
                <a href="#" class="block px-4 py-3 text-sm font-medium rounded-lg hover:bg-[#596A3F] transition-colors text-[#E4E2DC] hover:text-white">Logout</a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>
        
    </div>
</body>
</html>