@extends('layouts.user')

@section('title', 'Edit Profile - BetterEat')

@section('content')
<div class="min-h-screen bg-[#F0F4EF] flex items-center justify-center pt-28 pb-10">
    <div class="w-full max-w-lg mx-4">
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden relative">
            
            <div class="h-28 bg-gradient-to-br from-[#4A6741] to-[#6B8F5E] relative">
                <div class="absolute w-16 h-16 bg-white/15 rounded-full top-4 left-8"></div>
                <div class="absolute w-20 h-20 bg-white/10 rounded-full top-4 right-10"></div>
            </div>

            <div class="relative flex flex-col items-center -mt-12 mb-4">
                <div class="relative">
                    <div class="w-24 h-24 bg-[#4A6741] border-4 border-white rounded-full shadow-lg flex items-center justify-center overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            @php
                                $names = explode(' ', Auth::user()->full_name);
                                $initials = collect($names)->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('');
                            @endphp
                            <span class="text-white font-bold text-3xl tracking-wider">{{ $initials }}</span>
                        @endif
                    </div>
                    
                    <button type="button" class="absolute bottom-0 right-0 bg-[#4A6741] border-2 border-white rounded-full p-2 text-white shadow-md hover:bg-[#3d5435] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-3 italic">Ketuk ikon kamera untuk ganti foto</p>
            </div>

            <form action="{{ route('my_profile.update') }}" method="POST" class="px-8 pb-8 space-y-5">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ Auth::user()->full_name }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ Auth::user()->username }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition text-gray-500">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Kondisi Kesehatan (Opsional)</label>
                    <input type="text" name="health_condition" value="{{ Auth::user()->profile->health_condition ?? '' }}" 
                        placeholder="Contoh: Asam Urat, Diabetes"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Umur (Tahun)</label>
                    <input type="number" name="age" value="{{ Auth::user()->profile->age ?? '' }}" 
                        required placeholder="Masukkan umur kamu" min="1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Berat Badan (kg)</label>
                    <input type="number" name="weight_kg" value="{{ Auth::user()->profile->weight_kg ?? '' }}" 
                        required placeholder="Contoh: 65" step="0.1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] outline-none text-sm transition">
                </div>

                <div class="space-y-1">
                    <label class="text-[13px] font-semibold text-gray-700">Target Kalori Harian (kcal)</label>
                    <input type="number" name="daily_calorie_target" value="{{ Auth::user()->profile->daily_calorie_target ?? '' }}" 
                        placeholder="Contoh: 2000"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A6741] focus:border-transparent outline-none text-sm transition">
                </div>

                <div class="h-[1px] bg-gray-100 my-4"></div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('dashboard') }}" 
                        class="flex-1 py-3 border border-gray-300 text-gray-500 rounded-xl text-sm font-semibold text-center hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="flex-[1.2] py-3 bg-[#4A6741] text-white rounded-xl text-sm font-semibold hover:bg-[#3d5435] shadow-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection