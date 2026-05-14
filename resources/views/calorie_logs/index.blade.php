@extends('layouts.user')

@section('title', 'Tambah Menu - BetterEat')

@section('content')
<div class="min-h-screen bg-[#F0F4EF] flex items-center justify-center pt-28 pb-10">
    <div class="w-full max-w-lg mx-4">
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl shadow-sm">
                <p class="font-bold">Ups! Ada yang salah:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden relative">
            <div class="h-28 bg-gradient-to-br from-[#4A6741] to-[#6B8F5E] relative text-center">
                <div class="absolute w-16 h-16 bg-white/15 rounded-full top-4 left-8"></div>
                <div class="absolute w-20 h-20 bg-white/10 rounded-full top-4 right-10"></div>
                <h1 class="relative z-10 text-white font-poppins font-bold text-xl pt-6">Catat Menu Makan</h1>
                <p class="relative z-10 text-white/80 text-xs">Isi detail makananmu secara manual</p>
            </div>

            <div class="relative flex flex-col items-center -mt-12 mb-4">
                <div class="w-24 h-24 bg-[#4A6741] border-4 border-white rounded-full shadow-lg flex items-center justify-center">
                    <i class='bx bx-edit-alt text-white text-4xl'></i>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Terpakai Hari Ini</p>
                    <p class="font-bold text-[#4A6741] text-lg">
                        {{ number_format($totalKonsumsi) }} / {{ number_format($target) }} <span class="text-xs font-normal text-gray-400">kkal</span>
                    </p>
                </div>
            </div>

            <form action="{{ route('calorie_logs.store') }}" method="POST" class="px-8 pb-8 space-y-5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Nama Makanan / Menu</label>
                    <input type="text" name="meal_name" value="{{ old('meal_name') }}" required 
                        placeholder="Misal: Nasi Padang Ayam Pop"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Estimasi Kalori (kkal)</label>
                    <input type="number" name="calories" value="{{ old('calories') }}" required 
                        placeholder="Contoh: 450"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Waktu Makan</label>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        @foreach(['Sarapan', 'Makan Siang', 'Makan Malam', 'Camilan'] as $time)
                        <label class="relative flex items-center justify-center p-2.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition group">
                            <input type="radio" name="meal_time" value="{{ $time }}" 
                                class="hidden peer" required {{ old('meal_time') == $time ? 'checked' : '' }}>
                            <span class="text-xs font-medium text-gray-500 peer-checked:text-[#4A6741]">{{ $time }}</span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-[#4A6741] rounded-xl"></div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="h-[1px] bg-gray-100 my-4"></div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('dashboard') }}" 
                        class="flex-1 py-3 border border-gray-300 text-gray-500 rounded-xl text-sm font-semibold text-center hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="flex-[1.2] py-3 bg-[#4A6741] text-white rounded-xl text-sm font-semibold hover:bg-[#3d5435] shadow-lg transition">
                        Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection