<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BetterEat</title>
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

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16">
            <div class="w-full max-w-md">
                
                <div class="mb-10">
                    <h2 class="font-poppins font-semibold text-2xl text-[#53643A]">BetterEat</h2>
                    <h1 class="font-poppins font-semibold text-3xl text-[#1B1C18] mt-2">Masuk ke BetterEat</h1>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1B1C18] mb-2">Email </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="Masukkan email atau username"
                            class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] focus:border-[#53643A] outline-none transition-all">
                        @if($errors->get('email'))
                            <p class="mt-1 text-xs text-red-500">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-[#1B1C18] mb-2">Password</label>
                        <input id="password" type="password" name="password" required 
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-[#D1D5DC] focus:ring-2 focus:ring-[#53643A] focus:border-[#53643A] outline-none transition-all">
                        
                        <div class="flex justify-end mt-2">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-[#53643A] hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        @if($errors->get('password'))
                            <p class="mt-1 text-xs text-red-500">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <button type="submit" 
                        class="w-full bg-[#53643A] text-white font-semibold py-3 rounded-xl hover:bg-[#3d4a2b] transition-colors shadow-lg shadow-[#53643a2e]">
                        Login
                    </button>

                  <p class="text-center text-sm text-[#1B1C18]">
                        Belum ada akun? 
                        <a href="{{ route('register') }}" class="font-semibold text-[#53643A] hover:underline">Daftar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>