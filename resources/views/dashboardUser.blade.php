@extends('layouts.user')

@section('title', 'Dashboard User - BetterEat')

@section('content')

@php
    // 1. Ambil Target Kalori dari Profile (Default 2000 jika kosong)
    $target = Auth::user()->profile->daily_calorie_target ?? 2000;

    // 2. Hitung Total Konsumsi Hari Ini dari tabel calorie_logs
    $terpakai = Auth::user()->calorieLogs()->whereDate('created_at', now())->sum('calories');

    // 3. Hitung Sisa & Persentase untuk Progress Circle
    $sisa = max(0, $target - $terpakai);
    $persentase = ($target > 0) ? min(round(($terpakai / $target) * 100), 100) : 0;
    
    // Keliling lingkaran SVG (2 * pi * r) = 2 * 3.14 * 70 ≈ 440
    $offset = 440 - (440 * ($persentase / 100));

    // 4. Ambil 3 Riwayat Konsumsi Terakhir Hari Ini
    $riwayatHariIni = Auth::user()->calorieLogs()
                        ->whereDate('created_at', now())
                        ->latest()
                        ->take(3)
                        ->get();
@endphp

<div class="container mx-auto px-6 lg:px-20 pt-28 pb-10">

    <div class="bg-gradient-to-r from-[#3C4C25] to-[#53643A] rounded-2xl p-8 shadow-lg mb-8 relative overflow-hidden">
        <div class="relative z-10 w-full lg:w-2/3">
            <h1 class="font-heading font-semibold text-2xl text-white mb-2">
                Selamat Pagi, {{ explode(' ', Auth::user()->full_name)[0] }}!
            </h1>
            <p class="text-[#D6EAB5] text-lg mb-6 leading-relaxed">
                Kamu telah mengonsumsi <strong>{{ number_format($terpakai) }} kkal</strong> hari ini. 
                @if($sisa > 0)
                    Tetap jaga pola makan untuk kesehatan optimal!
                @else
                    Wah, target kalorimu sudah tercapai! Perhatikan asupan selanjutnya ya.
                @endif
            </p>
            
            <div class="flex flex-wrap gap-4">
                <div class="bg-white/10 backdrop-blur-md rounded-xl py-3 px-5 flex items-center gap-3">
                    <div class="bg-[#C5D8A4] p-2 rounded-lg">
                        <i class='bx bxs-hot text-[#3C4C25]'></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/70 uppercase tracking-widest">Tercapai</p>
                        <p class="font-bold text-white text-base">{{ number_format($terpakai) }} kcal</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl py-3 px-5 flex items-center gap-3">
                    <div class="bg-[#C5D8A4] p-2 rounded-lg">
                        <i class='bx bx-bullseye text-[#3C4C25]'></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/70 uppercase tracking-widest">Progress</p>
                        <p class="font-bold text-white text-base">{{ $persentase }}%</p>
                    </div>
                </div>
            </div>
        </div>
        <i class='bx bxs-leaf absolute -right-10 -bottom-10 text-[200px] text-white opacity-5'></i>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#F1EFE7]">
                    <h2 class="font-heading font-semibold text-lg text-be-dark mb-6">Target Harian</h2>
                    
                    <div class="flex justify-center mb-6 relative">
                        <svg class="w-40 h-40 transform -rotate-90">
                            <circle cx="80" cy="80" r="70" stroke="#F1EFE7" stroke-width="12" fill="none" />
                            <circle cx="80" cy="80" r="70" stroke="#53643A" stroke-width="12" fill="none" 
                                    stroke-dasharray="440" 
                                    stroke-dashoffset="{{ $offset }}" 
                                    class="transition-all duration-1000 ease-out" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="font-bold text-3xl text-be-dark">{{ $persentase }}%</span>
                            <span class="text-xs text-[#75786D]">Tercapai</span>
                        </div>
                    </div>

                    <div class="flex justify-between gap-4 mb-6">
                        <div class="bg-be-bg rounded-xl p-3 w-full text-center">
                            <p class="text-xs text-[#75786D] mb-1">Target</p>
                            <p class="font-semibold text-be-dark">{{ number_format($target) }}</p>
                        </div>
                        <div class="bg-be-bg rounded-xl p-3 w-full text-center">
                            <p class="text-xs text-[#75786D] mb-1">Sisa</p>
                            <p class="font-semibold text-be-primary">{{ number_format($sisa) }}</p>
                        </div>
                    </div>

                    <a href="{{ route('calorie_logs.index') }}" class="w-full flex items-center justify-center gap-2 bg-[#53643A] hover:bg-[#3C4C25] text-white py-3 rounded-xl font-semibold transition-colors">
                        <i class='bx bx-plus'></i> Tambah Menu
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#F1EFE7]">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-heading font-semibold text-lg text-be-dark">Riwayat Hari Ini</h2>
                        <a href="{{ route('calorie_logs.index') }}" class="text-sm font-semibold text-be-primary hover:underline">Lihat Semua</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($riwayatHariIni as $log)
                        <div class="flex items-center gap-4 bg-be-bg p-4 rounded-xl">
                            <div class="bg-[#D6EAB5] p-3 rounded-xl text-be-primary">
                                <i class='bx bx-dish text-xl'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-be-dark">{{ $log->meal_name }}</p>
                                <p class="text-xs text-[#75786D]">{{ $log->meal_time ?? 'Waktu tidak diatur' }}</p>
                            </div>
                            <p class="font-bold text-be-primary">{{ $log->calories }} kal</p>
                        </div>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-sm text-gray-400 italic">Belum ada menu yang dicatat hari ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#F1EFE7]">
                <h2 class="font-heading font-semibold text-lg text-be-dark mb-6">Nutrisi Terpenuhi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-be-dark">Progress Kalori</span>
                            <span class="text-[#75786D]">{{ number_format($terpakai) }} / {{ number_format($target) }} kkal</span>
                        </div>
                        <div class="w-full bg-[#EFEEE7] rounded-full h-3">
                            <div class="bg-[#53643A] h-3 rounded-full" style="width: {{ $persentase }}%"></div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#F1EFE7] flex flex-col items-center">
                <div class="relative mb-4">
                    <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name).'&background=D6EAB5&color=3C4C25' }}" alt="Profile" class="w-24 h-24 rounded-full border-4 border-[#D6EAB5] object-cover">
                    <a href="{{ route('my_profile.edit') }}" class="absolute bottom-0 right-0 bg-[#53643A] border-2 border-white rounded-full p-1.5 text-white">
                        <i class='bx bx-pencil text-xs'></i>
                    </a>
                </div>

                <h3 class="font-bold text-lg text-be-dark text-center">{{ Auth::user()->full_name }}</h3>
                <div class="bg-[#D6EAB5]/30 px-3 py-1 rounded-full mt-2 mb-6 text-center">
                    <span class="text-[10px] font-semibold text-[#3C4C25] uppercase tracking-wider">
                        {{ Auth::user()->profile->health_condition ?? 'Kondisi Normal' }}
                    </span>
                </div>

                <div class="w-full bg-be-bg border border-[#F1EFE7] rounded-2xl p-4 flex flex-col justify-center">
                    <p class="text-xs text-[#75786D] mb-1">Berat Badan saat ini</p>
                    <p class="font-semibold text-lg text-be-dark">
                        {{ Auth::user()->profile->weight_kg ?? '--' }} <span class="text-sm font-medium opacity-60">kg</span>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection