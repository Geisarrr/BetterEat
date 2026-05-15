<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BetterEat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#FBF9F3] antialiased">

    <div class="flex min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 bg-[#53643A] relative overflow-hidden flex-col items-center justify-center text-white">
            <div class="absolute w-32 h-32 bg-[#C5D8A4] opacity-20 rounded-full -top-10 -right-10"></div>
            <div class="absolute w-24 h-24 bg-[#C5D8A4] opacity-20 rounded-full bottom-20 left-10"></div>
            <div class="absolute w-16 h-16 bg-[#FBF9F3] opacity-20 rounded-full top-1/2 left-5"></div>

            <div class="relative z-10 text-center">
                <h1 class="font-poppins font-bold text-7xl md:text-8xl mb-4 tracking-tighter">BetterEat</h1>
                <p class="text-lg md:text-xl font-light opacity-90">Mulai Hidup Lebih Sehat</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-[#FBF9F3]">
            <div class="w-full max-w-md">
                
                <div class="mb-10">
                    <h2 class="font-poppins font-semibold text-2xl text-[#53643A]">BetterEat</h2>
                    <h1 class="font-poppins font-semibold text-3xl text-[#1B1C18] mt-2">Daftar Akun</h1>
                    <p class="text-sm text-gray-500 mt-1">Buat akun untuk memulai perjalanan hidup sehat Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="full_name" class="block text-sm font-medium text-[#1B1C18] mb-2">Nama Lengkap</label>
                        <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] outline-none transition-all">
                        @error('full_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-[#1B1C18] mb-2">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required
                            placeholder="Buat username unik"
                            class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] outline-none transition-all">
                        @error('username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1B1C18] mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@gmail.com"
                            class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] outline-none transition-all">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-[#1B1C18] mb-2">Password</label>
                            <input id="password" type="password" name="password" required 
                                placeholder="Min. 8 karakter"
                                class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] outline-none transition-all">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-[#1B1C18] mb-2">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required 
                                placeholder="Ulangi password"
                                class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] outline-none transition-all">
                        </div>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                    <button type="submit" 
                        class="w-full bg-[#53643A] text-white font-semibold py-3 rounded-xl hover:bg-[#3d4a2b] transition-colors shadow-lg shadow-[#53643a2e] mt-4">
                        Daftar Sekarang
                    </button>

                   <p class="text-center text-sm text-[#1B1C18]">
                        Sudah ada akun? 
                        <a href="{{ route('login') }}" class="font-semibold text-[#53643A] hover:underline">Masuk</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>