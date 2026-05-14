@extends('layouts.user')

@section('title', 'Kalkulator Gizi — BetterEat')

@push('styles')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes countUp {
        from { opacity: 0; transform: scale(.85); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes shimmer {
        0%   { background-position: -400px 0; }
        100% { background-position:  400px 0; }
    }
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0 rgba(77,124,15,.35); }
        70%  { box-shadow: 0 0 0 12px rgba(77,124,15,0); }
        100% { box-shadow: 0 0 0 0 rgba(77,124,15,0); }
    }
    @keyframes growBar {
        from { width: 0; }
    }
    @keyframes growBarV {
        from { height: 0; }
    }

    .fade-up    { animation: fadeUp .5s ease both; }
    .count-anim { animation: countUp .45s cubic-bezier(.34,1.56,.64,1) both; }

    .skeleton {
        background: linear-gradient(90deg, #e5ecd8 25%, #f0f5e8 50%, #e5ecd8 75%);
        background-size: 400px 100%;
        animation: shimmer 1.3s infinite;
        border-radius: 8px;
    }

    #food-dropdown {
        max-height: 240px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #C5D8A4 transparent;
    }
    #food-dropdown::-webkit-scrollbar { width: 4px; }
    #food-dropdown::-webkit-scrollbar-thumb { background: #C5D8A4; border-radius: 99px; }

    .food-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #EDF3E4;
        border: 1px solid #C5D8A4;
        border-radius: 20px;
        padding: 4px 10px 4px 12px;
        font-size: .82rem;
        color: #3C4C25;
        font-weight: 500;
        animation: fadeUp .25s ease both;
    }
    .food-tag button {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: #C5D8A4;
        color: #3C4C25;
        font-size: .7rem;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .food-tag button:hover { background: #a3bf7a; }

    .nutr-bar-inner {
        height: 8px;
        border-radius: 99px;
        animation: growBar .8s ease both;
    }

    #result-panel.has-result {
        animation: fadeUp .4s ease both;
    }

    #btn-hitung:not(:disabled) { animation: pulse-ring 2.5s ease infinite; }
    #btn-hitung:disabled { opacity: .55; cursor: not-allowed; animation: none; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 4px;
        font-size: .65rem; font-weight: 700;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .status-aman   { background: #DCFCE7; color: #15803D; }
    .status-cukup  { background: #FEF9C3; color: #A16207; }
    .status-batasi { background: #FEE2E2; color: #B91C1C; }

    .history-item { transition: background .18s; cursor: default; }
    .history-item:hover { background: #F4F8ED; border-radius: 12px; }

    .dropdown-item { transition: background .15s; }
    .dropdown-item:hover { background: #EDF3E4; }

    .hero-section {
        background: linear-gradient(135deg, #C5D8A4 0%, #dfeece 60%, #eef5e5 100%);
    }

    .preset-chip.active {
        border-color: #3C4C25 !important;
        background-color: #EDF3E4 !important;
        color: #3C4C25 !important;
        font-weight: 600;
    }

    #bar-prot-v, #bar-fat-v, #bar-carb-v {
        min-height: 6px;
        animation: growBarV .8s cubic-bezier(.4,0,.2,1) both;
        transition: height .7s cubic-bezier(.4,0,.2,1);
    }

    .alt-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #F0F0EC;
    }
    .alt-row:last-child { border-bottom: none; }
    .alt-left  { font-size: .8rem; color: #6B7558; }
    .alt-left .alt-name  { font-weight: 600; color: #1B1C18; font-size: .85rem; }
    .alt-left .alt-cal   { font-size: .75rem; color: #6B7558; margin-top: 1px; }
    .alt-right { font-size: .8rem; color: #6B7558; text-align: right; }
    .alt-right .alt-name { font-weight: 600; color: #3C4C25; font-size: .85rem; }
    .alt-right .alt-cal  { font-size: .75rem; color: #6B7558; margin-top: 1px; }
    .alt-arrow-icon {
        width: 28px; height: 28px;
        display: flex; align-items: center; justify-content: center;
        color: #6B7558; font-size: 1.1rem; flex-shrink: 0;
        margin: 0 8px;
    }

    .history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F0F0EC;
    }
    .history-row:last-child { border-bottom: none; }
    .tip-row  { display: flex; align-items: flex-start; gap: 10px; padding: 6px 0; }
    .tip-icon { font-size: 1.1rem; flex-shrink: 0; margin-top: 1px; }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="hero-section pt-40 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12 lg:gap-24">

            {{-- Teks kiri --}}
            <div class="flex-1 max-w-xl text-center lg:text-left">
                <span class="inline-flex items-center gap-2 text-xs font-semibold text-be-green bg-white border border-be-highlight px-3 py-1 rounded-full mb-4">
                    <i class='bx bx-book-open'></i> Sesuai Standar TKPI
                </span>
                <h1 class="font-heading font-extrabold text-4xl lg:text-5xl text-be-primary leading-tight">
                    Kalkulator Gizi
                </h1>
                <p class="mt-4 text-be-muted text-base leading-relaxed">
                    Hitung kandungan nutrisi makananmu dengan lebih akurat menggunakan standar
                    <strong class="text-be-dark">Tabel Komposisi Pangan Indonesia (TKPI)</strong>.
                    Mulailah hidup lebih sehat dari setiap suapan.
                </p>
            </div>

            {{-- Ilustrasi kanan --}}
            <div class="w-full max-w-sm sm:max-w-sm lg:max-w-sm flex justify-center">
                <div class="w-full aspect-[4/3] rounded-[32px] overflow-hidden shadow-2xl float-anim">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=640&q=80"
                         alt="Makanan Sehat Nusantara"
                         class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-5 gap-8">

    <!-- LEFT COLUMN -->
    <div class="lg:col-span-3 space-y-6">

        {{-- ── Input Makanan Card ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-heading font-bold text-be-dark text-xl">Input Makanan</h2>
                <button id="btn-reset"
                        class="text-xs text-be-muted hover:text-red-500 flex items-center gap-1 transition-colors">
                    <i class='bx bx-refresh'></i> Reset
                </button>
            </div>

            {{-- Search Nama Makanan --}}
            <div class="relative mb-5">
                <label class="block text-sm font-medium text-be-dark mb-1.5">Nama Makanan</label>
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-be-muted text-lg'></i>
                    <input id="food-search"
                           type="text"
                           placeholder="Cari makanan (ex: Nasi Goreng, Ayam Bakar)"
                           autocomplete="off"
                           class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                  text-sm text-be-dark placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-be-highlight focus:border-be-green
                                  transition">
                    <div id="search-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                        <div class="w-4 h-4 border-2 border-be-highlight border-t-be-green rounded-full animate-spin"></div>
                    </div>
                </div>
                {{-- Dropdown hasil search --}}
                <div id="food-dropdown"
                     class="hidden absolute z-30 w-full mt-1 bg-white border border-gray-200
                            rounded-xl shadow-lg overflow-hidden">
                </div>
            </div>

            {{-- Bahan Utama: preset chips + tambah custom --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-be-dark mb-2">
                    Bahan Utama <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>

                {{-- Preset bahan chips --}}
                <div class="flex flex-wrap gap-2 mb-2" id="preset-chips">
                    @php
                        $presetBahan = [
                            'Beras','Ayam','Ikan','Tempe','Daging Sapi','Telur','Udang','Bayam',
                            'Wortel','Jagung','Kangkung',
                        ];
                    @endphp
                    @foreach($presetBahan as $bahan)
                        <button type="button"
                                onclick="togglePreset(this, '{{ $bahan }}')"
                                class="preset-chip inline-flex items-center gap-1 px-3 py-1.5 rounded-full
                                       text-xs font-medium border border-gray-200 bg-be-light text-gray-600
                                       hover:border-be-highlight hover:bg-be-light hover:text-be-primary
                                       transition-all duration-150"
                                data-name="{{ $bahan }}">
                            {{ $bahan }}
                        </button>
                    @endforeach

                    {{-- Tombol + Tambah --}}
                    <button type="button" id="btn-tambah-custom"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full
                                   text-xs font-medium border border-dashed border-gray-300 text-gray-500
                                   hover:border-be-green hover:text-be-green transition-all duration-150">
                        <i class='bx bx-plus text-sm'></i> Tambah
                    </button>
                </div>

                {{-- Input tambah bahan custom (hidden) --}}
                <div id="custom-bahan-wrap" class="hidden gap-2 mt-2" style="display:none;">
                    <input id="custom-bahan-input" type="text"
                           placeholder="Nama bahan lainnya…"
                           class="flex-1 py-2 px-3 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                  text-sm text-be-dark focus:outline-none focus:ring-2 focus:ring-be-highlight">
                    <button type="button" id="btn-tambah-bahan-ok"
                            class="px-4 py-2 bg-be-primary text-white text-xs font-semibold rounded-xl
                                   hover:bg-be-button transition">
                        Tambah
                    </button>
                </div>

                {{-- Tag bahan yang sudah dipilih --}}
                <div id="food-tags" class="flex flex-wrap gap-2 mt-2 min-h-[28px]">
                    <span id="tags-placeholder" class="text-xs text-gray-400 italic self-center hidden">
                        Belum ada bahan dipilih…
                    </span>
                </div>
            </div>

            {{-- Porsi & Satuan --}}
            <div class="grid grid-cols-2 gap-4 mb-5">
                {{-- Porsi --}}
                <div>
                    <label class="block text-sm font-medium text-be-dark mb-1.5">Porsi</label>
                    <div class="flex items-center h-[46px] border border-gray-200 rounded-xl overflow-hidden bg-[#FAFAFA]">
                        <button id="qty-minus" type="button"
                                class="h-full px-3.5 text-gray-400 hover:text-be-dark hover:bg-be-light
                                       transition text-xl font-light select-none">−</button>
                        <input id="qty-input" type="number" value="1" min="0.5" step="0.5"
                               class="flex-1 h-full text-center text-sm font-semibold text-be-dark bg-transparent
                                      border-x border-gray-200 focus:outline-none">
                        <button id="qty-plus" type="button"
                                class="h-full px-3.5 text-gray-400 hover:text-be-dark hover:bg-be-light
                                       transition text-xl font-light select-none">+</button>
                    </div>
                </div>
                {{-- Satuan --}}
                <div>
                    <label class="block text-sm font-medium text-be-dark mb-1.5">Satuan</label>
                    <select id="qty-unit"
                            class="w-full h-[46px] px-3 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                   text-sm text-be-dark focus:outline-none focus:ring-2 focus:ring-be-highlight
                                   appearance-none cursor-pointer"
                            style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7558' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;">
                        <option value="200">Piring (~200g)</option>
                        <option value="150">Mangkok (~150g)</option>
                        <option value="100" selected>Porsi (~100g)</option>
                        <option value="50">Setengah Porsi (~50g)</option>
                        <option value="custom">Gram Custom…</option>
                    </select>
                </div>
            </div>

            {{-- Custom gram input (hidden by default) --}}
            <div id="custom-gram-wrap" class="hidden mb-5">
                <label class="block text-sm font-medium text-be-dark mb-1.5">Berat Custom (gram)</label>
                <input id="custom-gram" type="number" min="1" placeholder="Masukkan berat dalam gram"
                       class="w-full h-[46px] py-2 px-4 rounded-xl border border-gray-200 bg-[#FAFAFA] text-sm
                              focus:outline-none focus:ring-2 focus:ring-be-highlight text-be-dark">
            </div>

            {{-- Hitung button --}}
            <button id="btn-hitung" disabled
                    class="w-full bg-be-primary text-white font-heading font-semibold
                           py-3.5 rounded-xl text-sm hover:bg-be-button transition-colors
                           flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                Hitung Kandungan Nutrisi
            </button>
        </div>

        {{-- ── Alternatif Lebih Sehat Card — sesuai gambar ── --}}
        <div id="alt-card" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-9 h-9 rounded-xl bg-be-light flex items-center justify-center text-be-green text-lg">
                    <i class='bx bxs-bulb'></i>
                </span>
                <h2 class="font-heading font-bold text-be-dark text-base">Alternatif Lebih Sehat</h2>
            </div>
            {{-- List alternatif: sebelum → sesudah --}}
            <div id="alt-list" class="divide-y divide-gray-100"></div>
        </div>

        {{-- ── Pengingat Sehat Card — sesuai gambar ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-9 h-9 rounded-xl bg-be-light flex items-center justify-center text-be-green text-lg">
                    <i class='bx bxs-bell'></i>
                </span>
                <h2 class="font-heading font-bold text-be-dark text-base">Pengingat Sehat</h2>
            </div>
            <div class="space-y-0.5 text-sm text-be-muted">
                <div class="tip-row">
                    <span class="tip-icon"><i class='bx bx-check'></i></span>
                    <span>Minum 8 gelas air hari ini</span>
                </div>
                <div class="tip-row">
                      <span class="tip-icon"><i class='bx bx-check'></i></span>
                    <span>Kurangi konsumsi gula berlebih</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><i class='bx bx-check'></i></span>
                    <span>Hindari gorengan terlalu sering</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><i class='bx bx-check'></i></span>
                    <span>Perbanyak makan sayur</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><i class='bx bx-check'></i></span>
                    <span>Jangan lewatkan sarapan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="lg:col-span-2 space-y-6">

        {{-- ── Hasil Analisis Card ── --}}
        <div id="result-panel"
             class="bg-be-primary rounded-2xl shadow-md p-6 text-white relative overflow-hidden fade-up">
            {{-- Decorative circles --}}
            <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full pointer-events-none"></div>

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5 relative">
                <h2 class="font-heading font-bold text-base">Hasil Analisis</h2>
                <span id="result-status-badge" class="hidden status-badge status-aman">
                    <span id="result-status-text">AMAN</span>
                </span>
            </div>

            {{-- Total Kalori --}}
            <div class="text-center mb-6 relative">
                <p class="text-xs text-white/50 uppercase tracking-widest mb-1">Total Kalori</p>
                <div class="flex items-end justify-center gap-1">
                    <span id="res-cal" class="text-6xl font-heading font-extrabold leading-none">—</span>
                    <span class="text-xl text-white/60 mb-1">kcal</span>
                </div>
                {{-- Progress bar kalori --}}
                <div class="mt-3 bg-white/20 rounded-full h-1.5 overflow-hidden mx-4">
                    <div id="cal-bar" class="h-full bg-be-highlight transition-all duration-700" style="width:0%"></div>
                </div>
                <p class="text-xs text-white/40 mt-1.5" id="cal-bar-label">dari kebutuhan harian</p>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6 relative">
                <div class="bg-white/10 rounded-2xl p-4 text-center">
                    <p class="text-xs text-white/50 mb-2 font-medium">Protein</p>
                    <p class="font-heading font-extrabold text-2xl leading-none" id="res-prot">—</p>
                    <p class="text-xs text-white/40 mt-1">gram</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4 text-center">
                    <p class="text-xs text-white/50 mb-2 font-medium">Lemak</p>
                    <p class="font-heading font-extrabold text-2xl leading-none" id="res-fat">—</p>
                    <p class="text-xs text-white/40 mt-1">gram</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4 text-center">
                    <p class="text-xs text-white/50 mb-2 font-medium">Karbo</p>
                    <p class="font-heading font-extrabold text-2xl leading-none" id="res-carb">—</p>
                    <p class="text-xs text-white/40 mt-1">gram</p>
                </div>
            </div>

            <div class="border-t border-white/10 mb-5"></div>

            <div class="flex items-end justify-around gap-3 px-4" style="height: 90px;">
                <div class="flex flex-col items-center gap-1.5 flex-1">
                    <div class="w-full flex items-end justify-center" style="height:70px;">
                        <div id="bar-prot-v"
                             class="w-10 rounded-t-lg bg-orange-400 transition-all duration-700 ease-out"
                             style="height:0%"></div>
                    </div>
                    <span class="text-xs text-white/50">Protein</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 flex-1">
                    <div class="w-full flex items-end justify-center" style="height:70px;">
                        <div id="bar-fat-v"
                             class="w-10 rounded-t-lg bg-red-400 transition-all duration-700 ease-out"
                             style="height:0%"></div>
                    </div>
                    <span class="text-xs text-white/50">Lemak</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 flex-1">
                    <div class="w-full flex items-end justify-center" style="height:70px;">
                        <div id="bar-carb-v"
                             class="w-10 rounded-t-lg bg-green-400 transition-all duration-700 ease-out"
                             style="height:0%"></div>
                    </div>
                    <span class="text-xs text-white/50">Karbo</span>
                </div>
            </div>

            <div id="result-empty"
                 class="flex flex-col items-center justify-center bg-be-primary rounded-2xl text-center px-6">
            </div>
        </div>

        {{-- ── Riwayat Card — sesuai gambar ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center justify-between mb-2">
                <h2 class="font-heading font-bold text-be-dark text-base">Riwayat</h2>
                @auth
                <a href="{{ route('calorie_logs.index') }}"
                   class="text-xs text-be-green font-semibold hover:underline">Lihat Semua →</a>
                @else
                <span class="text-xs text-be-muted">Login untuk melihat</span>
                @endauth
            </div>

            {{-- Riwayat dari DB (jika login) --}}
            <div id="history-list">
                @auth
                    @forelse($recentLogs as $log)
                    <div class="history-row">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-[#F5F5F0] flex items-center justify-center text-be-muted text-sm flex-shrink-0">
                                <i class='bx bx-time-five'></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-be-dark leading-tight truncate">{{ $log->food->food_name }}</p>
                                <p class="text-xs text-be-muted">{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 ml-3">
                            <p class="text-sm font-bold text-be-dark whitespace-nowrap">{{ number_format($log->calories, 0) }} kkal</p>
                            @php
                                $pct = $log->calories / 2000 * 100;
                                $badgeCls = $pct <= 30 ? 'status-aman' : ($pct <= 60 ? 'status-cukup' : 'status-batasi');
                                $badgeLbl = $pct <= 30 ? 'AMAN' : ($pct <= 60 ? 'CUKUP' : 'BATASI');
                            @endphp
                            <span class="status-badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <i class='bx bx-history text-3xl text-be-muted/40'></i>
                        <p class="text-xs text-be-muted mt-2">Belum ada riwayat konsumsi</p>
                    </div>
                    @endforelse
                @else
                <div class="text-center py-6">
                    <i class='bx bx-lock-alt text-3xl text-be-muted/40'></i>
                    <p class="text-xs text-be-muted mt-2">
                        <a href="{{ route('login') }}" class="text-be-green hover:underline font-semibold">Login</a>
                        untuk menyimpan riwayat
                    </p>
                </div>
                @endauth
            </div>

            {{-- Riwayat dari sesi kalkulator (JS-rendered) --}}
            <div id="session-history"></div>
        </div>

        {{-- ── Info TKPI Card — sesuai gambar ── --}}
        <div class="bg-be-light rounded-2xl border p-5 fade-up">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-200/70 flex items-center justify-center text-be-muted flex-shrink-0">
                    <i class='bx bx-info-circle text-lg'></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-be-dark mb-1">Mengapa TKPI?</p>
                    <p class="text-xs text-be-muted leading-relaxed">
                        Tabel Komposisi Pangan Indonesia disesuaikan dengan jenis bahan baku dan teknik memasak yang
                        umum digunakan di Indonesia, sehingga dapat memberikan hasil yang lebih relevan dibanding basis data internasional.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
/* ================================================================
   BetterEat — Kalkulator Gizi  (JavaScript)
   Fixed: calories_kcal field name, alt card design, history badges
================================================================ */

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── State ──
let selectedFoods  = [];  
let selectedPresets = new Set();
let searchTimer    = null;
let lastResult     = null;
let lastInputFood  = null; 

// ── DOM refs ──
const foodSearch       = document.getElementById('food-search');
const dropdown         = document.getElementById('food-dropdown');
const foodTagsWrap     = document.getElementById('food-tags');
const tagsPlaceholder  = document.getElementById('tags-placeholder');
const qtyInput         = document.getElementById('qty-input');
const qtyUnit          = document.getElementById('qty-unit');
const qtyMinus         = document.getElementById('qty-minus');
const qtyPlus          = document.getElementById('qty-plus');
const customGramWrap   = document.getElementById('custom-gram-wrap');
const customGram       = document.getElementById('custom-gram');
const btnHitung        = document.getElementById('btn-hitung');
const btnReset         = document.getElementById('btn-reset');
const spinner          = document.getElementById('search-spinner');
const btnTambahCustom  = document.getElementById('btn-tambah-custom');
const customBahanWrap  = document.getElementById('custom-bahan-wrap');
const customBahanInput = document.getElementById('custom-bahan-input');
const btnTambahOk      = document.getElementById('btn-tambah-bahan-ok');

// Result refs
const resEmpty       = document.getElementById('result-empty');
const resCal         = document.getElementById('res-cal');
const resProt        = document.getElementById('res-prot');
const resFat         = document.getElementById('res-fat');
const resCarb        = document.getElementById('res-carb');
const calBar         = document.getElementById('cal-bar');
const calBarLabel    = document.getElementById('cal-bar-label');
const barProtV       = document.getElementById('bar-prot-v');
const barFatV        = document.getElementById('bar-fat-v');
const barCarbV       = document.getElementById('bar-carb-v');
const statusBadge    = document.getElementById('result-status-badge');
const statusText     = document.getElementById('result-status-text');
const altCard        = document.getElementById('alt-card');
const altList        = document.getElementById('alt-list');
const sessionHistory = document.getElementById('session-history');

/* ══════════════════════════════════════
   PRESET CHIP TOGGLE
══════════════════════════════════════ */
function togglePreset(btn, name) {
    if (selectedPresets.has(name)) {
        selectedPresets.delete(name);
        btn.classList.remove('active');
        btn.textContent = name;
        selectedFoods = selectedFoods.filter(f => f.food_name !== name);
        renderTags();
    } else {
        selectedPresets.add(name);
        btn.classList.add('active');
        fetchAndAddFood(name, btn);
    }
    updateBtn();
}

async function fetchAndAddFood(keyword, chipBtn) {
    try {
        const res  = await fetch(`/kalkulator/search?q=${encodeURIComponent(keyword)}`);
        const data = await res.json();
        if (data.length > 0) {
            const exact = data.find(f => f.food_name.toLowerCase() === keyword.toLowerCase()) ?? data[0];
            if (!selectedFoods.find(f => f.food_id === exact.food_id)) {
                selectedFoods.push(exact);
                renderTags();
            }
        } else {
            if (!selectedFoods.find(f => f.food_name === keyword)) {
                selectedFoods.push({
                    food_id: null, food_name: keyword,
                    calories_kcal: 0, protein_g: 0, fat_g: 0, carbs_g: 0,
                    notInDb: true
                });
                renderTags();
            }
        }
    } catch (e) { console.error(e); }
    updateBtn();
}

btnTambahCustom.addEventListener('click', () => {
    const isHidden = customBahanWrap.style.display === 'none' || customBahanWrap.style.display === '';
    if (isHidden) {
        customBahanWrap.style.display = 'flex';
        customBahanInput.focus();
    } else {
        customBahanWrap.style.display = 'none';
    }
});

btnTambahOk.addEventListener('click', async () => {
    const val = customBahanInput.value.trim();

    if (!val) return;

    await fetchAndAddFood(val);

    customBahanInput.value = '';
    customBahanWrap.classList.add('hidden');

    renderTags();
    updateBtn();
});

customBahanInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') btnTambahOk.click();
});

/* ══════════════════════════════════════
   SEARCH AUTOCOMPLETE
══════════════════════════════════════ */
foodSearch.addEventListener('input', () => {
    clearTimeout(searchTimer);
    const q = foodSearch.value.trim();
    if (q.length < 2) { closeDropdown(); return; }

    searchTimer = setTimeout(async () => {
        spinner.classList.remove('hidden');
        try {
            const res  = await fetch(`/kalkulator/search?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            renderDropdown(data);
        } catch (e) { console.error(e); }
        finally { spinner.classList.add('hidden'); }
    }, 280);
});

function renderDropdown(foods) {
    dropdown.innerHTML = '';
    if (!foods.length) {
        dropdown.innerHTML = `<div class="px-4 py-3 text-xs text-be-muted text-center">Makanan tidak ditemukan di database TKPI</div>`;
    } else {
        foods.forEach(f => {
            const item = document.createElement('div');
            item.className = 'dropdown-item flex items-center justify-between px-4 py-2.5 cursor-pointer';
            item.innerHTML = `
                <div>
                    <p class="text-sm font-medium text-be-dark">${escHtml(f.food_name)}</p>
                    <p class="text-xs text-be-muted">${f.calories_kcal} kcal / 100g</p>
                </div>
                <i class='bx bx-plus-circle text-be-green text-xl'></i>
            `;
            item.addEventListener('click', () => {
                addFood(f);
                foodSearch.value = '';
                closeDropdown();
            });
            dropdown.appendChild(item);
        });
    }
    dropdown.classList.remove('hidden');
}

function closeDropdown() {
    dropdown.classList.add('hidden');
    dropdown.innerHTML = '';
}

document.addEventListener('click', e => {
    if (!foodSearch.contains(e.target) && !dropdown.contains(e.target)) closeDropdown();
});

/* ══════════════════════════════════════
   ADD / REMOVE FOOD
══════════════════════════════════════ */
function addFood(food) {
    if (selectedFoods.find(f => f.food_id && f.food_id === food.food_id)) return;
    selectedFoods.push(food);
    renderTags();
    updateBtn();
}

function removeFood(foodId, foodName) {
    selectedFoods = selectedFoods.filter(f => !(f.food_id === foodId && f.food_name === foodName));
    if (selectedPresets.has(foodName)) {
        selectedPresets.delete(foodName);
        const chip = document.querySelector(`#preset-chips button[data-name="${CSS.escape(foodName)}"]`);
        if (chip) {
            chip.classList.remove('active');
            chip.textContent = foodName;
        }
    }
    renderTags();
    updateBtn();
}

function renderTags() {

    foodTagsWrap.querySelectorAll('.food-tag').forEach(el => el.remove());

    const hasTags = selectedFoods.length > 0;

    tagsPlaceholder.classList.toggle('hidden', hasTags);

    selectedFoods.forEach(f => {

        const tag = document.createElement('span');

        tag.className = 'food-tag';

        tag.innerHTML = `
            <span>${escHtml(f.food_name)}</span>
        `;

        const removeBtn = document.createElement('button');

        removeBtn.type = 'button';

        removeBtn.innerHTML = '&times;';

        removeBtn.addEventListener('click', () => {
            removeFood(f.food_id, f.food_name);
        });

        tag.appendChild(removeBtn);

        foodTagsWrap.appendChild(tag);
    });
}

/* ══════════════════════════════════════
   QTY CONTROLS
══════════════════════════════════════ */
qtyMinus.addEventListener('click', () => {
    const v = parseFloat(qtyInput.value);
    if (v > 0.5) qtyInput.value = parseFloat((v - 0.5).toFixed(1));
});
qtyPlus.addEventListener('click', () => {
    qtyInput.value = parseFloat((parseFloat(qtyInput.value) + 0.5).toFixed(1));
});
qtyUnit.addEventListener('change', () => {
    customGramWrap.classList.toggle('hidden', qtyUnit.value !== 'custom');
});

/* ══════════════════════════════════════
   UPDATE BUTTON STATE
══════════════════════════════════════ */
function updateBtn() {
    const hasValidFood = selectedFoods.some(f => f.food_id !== null);
    btnHitung.disabled = !hasValidFood;
}

/* ══════════════════════════════════════
   HITUNG
══════════════════════════════════════ */
btnHitung.addEventListener('click', async () => {
    const validFoods = selectedFoods.filter(f => f.food_id !== null);
    if (!validFoods.length) return;

    let gramPerPortion = qtyUnit.value === 'custom'
        ? (parseFloat(customGram.value) || 100)
        : parseFloat(qtyUnit.value);

    const portions  = parseFloat(qtyInput.value) || 1;
    const totalGram = gramPerPortion * portions;

    const items = validFoods.map(f => ({
        food_id:       f.food_id,
        quantity_gram: totalGram,
    }));

    lastInputFood = validFoods[0];

    btnHitung.disabled = true;
    btnHitung.innerHTML = `<span class="inline-block w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin mr-2"></span> Menghitung…`;

    try {
        const res  = await fetch('/kalkulator/calculate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ items }),
        });
        const data = await res.json();

        if (res.ok) {
            lastResult = data;
            renderResult(data, totalGram);
            addToSessionHistory(data, totalGram);
            fetchAlternatives(lastInputFood);
        } else {
            alert('Terjadi kesalahan: ' + (data.message ?? 'Coba lagi.'));
        }
    } catch (e) {
        alert('Gagal terhubung ke server.');
        console.error(e);
    } finally {
        btnHitung.disabled = false;
        btnHitung.innerHTML = `Hitung Kandungan Nutrisi`;
        updateBtn();
    }
});

/* ══════════════════════════════════════
   RENDER RESULT
══════════════════════════════════════ */
function renderResult(data, totalGram) {
    const { totals, status, daily_goal } = data;

    resEmpty.style.display = 'none';

    animateNumber(resCal,  totals.calories);
    animateNumber(resProt, totals.protein);
    animateNumber(resFat,  totals.fat);
    animateNumber(resCarb, totals.carbs);

    const calPct = Math.min(Math.round(totals.calories / (daily_goal || 2000) * 100), 100);
    calBar.style.width = calPct + '%';
    calBarLabel.textContent = `${calPct}% dari kebutuhan harian (${daily_goal} kcal)`;

    const maxVal = Math.max(totals.protein, totals.fat, totals.carbs, 1);
    const minH   = 8;
    setTimeout(() => {
        barProtV.style.height = Math.max(minH, Math.round(totals.protein / maxVal * 100)) + '%';
        barFatV.style.height  = Math.max(minH, Math.round(totals.fat      / maxVal * 100)) + '%';
        barCarbV.style.height = Math.max(minH, Math.round(totals.carbs    / maxVal * 100)) + '%';
    }, 50);

    const badgeMap = {
        green:  { cls: 'status-aman',   label: 'AMAN'   },
        yellow: { cls: 'status-cukup',  label: 'CUKUP'  },
        red:    { cls: 'status-batasi', label: 'BATASI' },
    };
    const badge = badgeMap[status.color] ?? badgeMap.green;
    statusBadge.className = `status-badge ${badge.cls}`;
    statusText.textContent = badge.label;
    statusBadge.classList.remove('hidden');
}

function animateNumber(el, target) {
    el.classList.remove('count-anim');
    void el.offsetWidth;
    el.textContent = Math.round(target);
    el.classList.add('count-anim');
}

/* ══════════════════════════════════════
   SESSION HISTORY — sesuai desain gambar
══════════════════════════════════════ */
function addToSessionHistory(data, gram) {
    const names = data.details.map(d => d.food_name).join(', ');
    const cal   = Math.round(data.totals.calories);
    const pct   = cal / (data.daily_goal || 2000) * 100;
    const badgeCls = pct <= 30 ? 'status-aman' : (pct <= 60 ? 'status-cukup' : 'status-batasi');
    const badgeLbl = pct <= 30 ? 'AMAN'        : (pct <= 60 ? 'CUKUP'        : 'BATASI');

    const item = document.createElement('div');
    item.className = 'history-row fade-up';
    item.innerHTML = `
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-[#F5F5F0] flex items-center justify-center text-be-muted text-sm flex-shrink-0">
                <i class='bx bx-time-five'></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-be-dark leading-tight truncate">${escHtml(names)}</p>
                <p class="text-xs text-be-muted">Baru saja</p>
            </div>
        </div>
        <div class="text-right flex-shrink-0 ml-3">
            <p class="text-sm font-bold text-be-dark whitespace-nowrap">${cal} kkal</p>
            <span class="status-badge ${badgeCls}">${badgeLbl}</span>
        </div>
    `;
    sessionHistory.prepend(item);
}


async function fetchAlternatives(originFood) {
    if (!originFood || !originFood.food_id) return;
    try {
        const res  = await fetch(`/kalkulator/alternatives?food_id=${originFood.food_id}`);
        const alts = await res.json();
        if (alts.length) renderAlternatives(originFood, alts);
    } catch (e) { console.error(e); }
}

function renderAlternatives(originFood, alts) {
    altList.innerHTML = '';

    // Hitung gram yang dipakai
    let gramPerPortion = qtyUnit.value === 'custom'
        ? (parseFloat(customGram.value) || 100)
        : parseFloat(qtyUnit.value);
    const portions  = parseFloat(qtyInput.value) || 1;
    const totalGram = gramPerPortion * portions;
    const ratio     = totalGram / 100;

    // Unit label
    const unitLabels = {
        '200': 'porsi', '150': 'mangkok', '100': 'porsi', '50': 'setengah porsi', 'custom': 'gram'
    };
    const unitLabel = unitLabels[qtyUnit.value] ?? 'porsi';

    alts.slice(0, 4).forEach(alt => {
        const oriCal = Math.round((originFood.calories_kcal || 0) * ratio);
        const altCal = Math.round((alt.calories_kcal || 0) * ratio);

        const row = document.createElement('div');
        row.className = 'alt-row cursor-pointer hover:bg-be-light/50 rounded-xl px-1 transition-colors';
        row.innerHTML = `
            <div class="alt-left">
                <p class="alt-name" style="text-decoration: line-through; color: #6B7558;">${escHtml(originFood.food_name)}</p>
                <p class="alt-cal">${oriCal} kcal / ${unitLabel}</p>
            </div>
            <div class="alt-arrow-icon">→</div>
            <div class="alt-right">
                <p class="alt-name">${escHtml(alt.food_name)}</p>
                <p class="alt-cal">${altCal} kcal / ${unitLabel}</p>
            </div>
        `;
        row.addEventListener('click', () => addFood(alt));
        altList.appendChild(row);
    });

    altCard.classList.remove('hidden');
}

/* ══════════════════════════════════════
   RESET
══════════════════════════════════════ */
btnReset.addEventListener('click', () => {
    selectedFoods = [];
    selectedPresets.clear();

    document.querySelectorAll('#preset-chips .preset-chip').forEach(btn => {
        btn.classList.remove('active');
        btn.textContent = btn.dataset.name;
    });

    renderTags();
    updateBtn();
    qtyInput.value = 1;
    qtyUnit.value  = '100';
    customGramWrap.classList.add('hidden');
    customBahanWrap.style.display = 'none';
    foodSearch.value = '';
    closeDropdown();

    resEmpty.style.display = '';
    resCal.textContent = resProt.textContent = resFat.textContent = resCarb.textContent = '—';
    calBar.style.width = '0%';
    calBarLabel.textContent = 'dari kebutuhan harian';
    barProtV.style.height = barFatV.style.height = barCarbV.style.height = '0%';
    statusBadge.classList.add('hidden');
    altCard.classList.add('hidden');
    altList.innerHTML = '';
    lastResult = null;
    lastInputFood = null;
});

/* ══════════════════════════════════════
   UTIL
══════════════════════════════════════ */
function escHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
</script>
@endpush