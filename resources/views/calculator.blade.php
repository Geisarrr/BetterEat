@extends('layouts.user')

@section('title', 'Kalkulator Gizi — BetterEat')

@push('styles')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
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
    @keyframes growBar   { from { width: 0; } }
    @keyframes growBarV  { from { height: 0; } }
    @keyframes slideIn   { from { opacity:0; transform:translateX(-8px); } to { opacity:1; transform:translateX(0); } }

    .fade-up    { animation: fadeUp .5s ease both; }
    .count-anim { animation: countUp .45s cubic-bezier(.34,1.56,.64,1) both; }

    /* ── Dropdown ── */
    #food-dropdown {
        max-height: 260px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #C5D8A4 transparent;
    }
    #food-dropdown::-webkit-scrollbar { width: 4px; }
    #food-dropdown::-webkit-scrollbar-thumb { background: #C5D8A4; border-radius: 99px; }

    .dropdown-item { transition: background .15s; cursor: pointer; }
    .dropdown-item:hover { background: #EDF3E4; }

    /* ── Daftar Makanan yang sudah ditambahkan ── */
    .food-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #F7FAF2;
        border: 1px solid #D6E9B8;
        border-radius: 12px;
        animation: slideIn .25s ease both;
        gap: 10px;
    }
    .food-list-item .food-info { flex: 1; min-width: 0; }
    .food-list-item .food-name {
        font-size: .875rem;
        font-weight: 600;
        color: #1B1C18;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .food-list-item .food-cal  { font-size: .75rem; color: #6B7558; margin-top: 1px; }

    /* gram editor inline */
    .gram-editor {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1px solid #C5D8A4;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        flex-shrink: 0;
    }
    .gram-editor button {
        width: 28px; height: 28px;
        font-size: 1rem; font-weight: 400;
        color: #6B7558;
        background: transparent;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
        border: none; cursor: pointer;
    }
    .gram-editor button:hover { background: #EDF3E4; color: #3C4C25; }
    .gram-editor input {
        width: 52px; height: 28px;
        text-align: center;
        font-size: .78rem;
        font-weight: 700;
        color: #1B1C18;
        border: none;
        border-left: 1px solid #C5D8A4;
        border-right: 1px solid #C5D8A4;
        outline: none;
        background: #fff;
    }
    .gram-unit {
        font-size: .7rem;
        color: #6B7558;
        padding-right: 8px;
        background: #fff;
        height: 28px;
        display: flex; align-items: center;
    }
    .food-remove-btn {
        width: 26px; height: 26px; border-radius: 50%;
        background: #FEE2E2; color: #B91C1C;
        font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        border: none; cursor: pointer;
        flex-shrink: 0;
        transition: background .15s;
    }
    .food-remove-btn:hover { background: #FECACA; }

    /* ── Hitung button ── */
    #btn-hitung:not(:disabled) { animation: pulse-ring 2.5s ease infinite; }
    #btn-hitung:disabled { opacity: .5; cursor: not-allowed; animation: none; }

    /* ── Status badge ── */
    .status-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 4px;
        font-size: .65rem; font-weight: 700;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .status-aman   { background: #DCFCE7; color: #15803D; }
    .status-cukup  { background: #FEF9C3; color: #A16207; }
    .status-batasi { background: #FEE2E2; color: #B91C1C; }

    /* ── Chart bars ── */
    #bar-prot-v, #bar-fat-v, #bar-carb-v {
        min-height: 6px;
        transition: height .7s cubic-bezier(.4,0,.2,1);
    }
    .nutr-bar-inner {
        height: 8px; border-radius: 99px;
        animation: growBar .8s ease both;
    }

    /* ── History rows ── */
    .history-row {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F0F0EC;
    }
    .history-row:last-child { border-bottom: none; }
    .tip-row { display:flex; align-items:flex-start; gap:10px; padding:6px 0; }
    .tip-icon { font-size:1.1rem; flex-shrink:0; margin-top:1px; }

    .hero-section {
        background: linear-gradient(135deg, #C5D8A4 0%, #dfeece 60%, #eef5e5 100%);
    }

    /* ── Empty state placeholder ── */
    #food-list-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 0 8px;
        color: #9CA3AF;
        font-size: .82rem;
        gap: 6px;
    }
    #food-list-empty i { font-size: 1.6rem; color: #C5D8A4; }

    /* ── Step labels ── */
    .step-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .78rem;
        font-weight: 700;
        color: #6B7558;
        letter-spacing: .05em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .step-label .step-num {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #3C4C25;
        color: #fff;
        font-size: .65rem;
        font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="hero-section pt-40 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12 lg:gap-24">
            <div class="flex-1 max-w-xl text-center lg:text-left">
                <span class="inline-flex items-center gap-2 text-xs font-semibold text-be-green bg-white border border-be-highlight px-3 py-1 rounded-full mb-4">
                    <i class='bx bx-calculator'></i> Sesuai Standar TKPI
                </span>
                <h1 class="font-heading font-extrabold text-4xl lg:text-5xl text-be-primary leading-tight">
                    Kalkulator Gizi
                </h1>
                <p class="mt-4 text-be-muted text-base leading-relaxed">
                    Hitung kandungan nutrisi makananmu dengan akurat menggunakan standar
                    <strong class="text-be-dark">Tabel Komposisi Pangan Indonesia (TKPI)</strong>.
                    Mulailah hidup lebih sehat dari setiap suapan.
                </p>
            </div>
            <div class="w-full max-w-sm flex justify-center">
                <div class="w-full aspect-[4/3] rounded-[32px] overflow-hidden shadow-2xl float-anim">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=640&q=80"
                         alt="Makanan Sehat" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-5 gap-8">

    <!-- ═══════════════════════════
         LEFT COLUMN
    ════════════════════════════ -->
    <div class="lg:col-span-3 space-y-6">

        {{-- ── Input Makanan Card ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-heading font-bold text-be-dark text-xl">Input Makanan</h2>
                <button id="btn-reset"
                        class="text-xs text-be-muted hover:text-red-500 flex items-center gap-1 transition-colors">
                    <i class='bx bx-refresh'></i> Reset
                </button>
            </div>

            {{-- ─── STEP 1: Cari & Pilih Makanan ─── --}}
            <div class="mb-5">
                <div class="step-label">
                    <span class="step-num">1</span>
                    Cari & Pilih Makanan
                </div>

                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-be-muted text-lg z-10'></i>
                    <input id="food-search"
                           type="text"
                           placeholder="Ketik nama makanan (contoh: Nasi putih, Ayam rebus…)"
                           autocomplete="off"
                           class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                  text-sm text-be-dark placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-be-highlight focus:border-be-green
                                  transition">
                    <div id="search-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                        <div class="w-4 h-4 border-2 border-be-highlight border-t-be-green rounded-full animate-spin"></div>
                    </div>

                    {{-- Dropdown hasil search --}}
                    <div id="food-dropdown"
                         class="hidden absolute z-30 w-full mt-1 bg-white border border-gray-200
                                rounded-xl shadow-lg overflow-hidden">
                    </div>
                </div>

                <p class="mt-2 text-[11px] text-be-muted leading-relaxed flex items-start gap-1.5">
                    <i class='bx bx-info-circle mt-0.5 text-be-green'></i>
                    Pilih dari daftar yang muncul. Nilai gizi dihitung per <strong>100 gram</strong> sesuai standar TKPI.
                </p>
            </div>

            {{-- ─── STEP 2: Tentukan Berat ─── --}}
            <div class="mb-5" id="weight-step">
                <div class="step-label">
                    <span class="step-num">2</span>
                    Tentukan Berat Makanan
                </div>

                <div class="flex items-center gap-3">
                    {{-- Tombol minus --}}
                    <button id="qty-minus" type="button"
                            class="w-10 h-10 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                   flex items-center justify-center text-xl text-gray-400
                                   hover:text-be-dark hover:bg-be-light transition select-none">−</button>

                    {{-- Input gram --}}
                    <div class="flex-1 relative">
                        <input id="qty-gram" type="number" value="100" min="1" step="10"
                               class="w-full h-10 text-center font-heading font-bold text-lg text-be-dark
                                      border border-gray-200 bg-[#FAFAFA] rounded-xl
                                      focus:outline-none focus:ring-2 focus:ring-be-highlight transition
                                      pr-12">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-be-muted font-medium">gram</span>
                    </div>

                    {{-- Tombol plus --}}
                    <button id="qty-plus" type="button"
                            class="w-10 h-10 rounded-xl border border-gray-200 bg-[#FAFAFA]
                                   flex items-center justify-center text-xl text-gray-400
                                   hover:text-be-dark hover:bg-be-light transition select-none">+</button>
                </div>

                {{-- Shortcut gram chips --}}
                <div class="flex gap-2 mt-3 flex-wrap">
                    @foreach([50, 100, 150, 200, 250] as $g)
                    <button type="button"
                            onclick="setGram({{ $g }})"
                            class="gram-shortcut px-3 py-1 rounded-full text-xs font-semibold
                                   border border-gray-200 bg-be-light text-be-muted
                                   hover:border-be-green hover:text-be-primary transition-all
                                   {{ $g == 100 ? 'border-be-green text-be-primary' : '' }}"
                            data-gram="{{ $g }}">
                        {{ $g }}g
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- ─── STEP 3: Tambah ke Daftar ─── --}}
            <div class="mb-5">
                <button id="btn-tambah" disabled
                        class="w-full py-2.5 rounded-xl border-2 border-dashed border-be-highlight
                               bg-be-light/50 text-be-primary text-sm font-semibold
                               flex items-center justify-center gap-2
                               hover:bg-be-light hover:border-be-green transition
                               disabled:opacity-40 disabled:cursor-not-allowed">
                    <i class='bx bx-plus-circle text-lg'></i>
                    Tambahkan ke Daftar
                </button>
            </div>

            {{-- ─── STEP 4: Daftar Makanan ─── --}}
            <div class="mb-5">
                <div class="step-label">
                    <span class="step-num">3</span>
                    Daftar Makanan
                    <span id="food-count-badge" class="hidden ml-auto text-[10px] font-bold
                           bg-be-primary text-white px-2 py-0.5 rounded-full">0</span>
                </div>

                {{-- Container daftar --}}
                <div id="food-list" class="space-y-2 min-h-[70px]">
                    <div id="food-list-empty">
                        <i class='bx bx-bowl-hot'></i>
                        <span>Belum ada makanan. Cari & tambahkan di atas.</span>
                    </div>
                </div>

                {{-- Total kalori sementara --}}
                <div id="total-preview" class="hidden mt-3 flex items-center justify-between
                     px-4 py-2.5 bg-be-primary/5 border border-be-highlight/50 rounded-xl">
                    <span class="text-xs text-be-muted font-medium">Estimasi total kalori</span>
                    <span id="total-preview-cal" class="text-sm font-heading font-bold text-be-primary">0 kal</span>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-dashed border-gray-200 mb-5"></div>

            {{-- ─── STEP 5: Hitung ─── --}}
            <div>
                <div class="step-label mb-3">
                    <span class="step-num">4</span>
                    Hitung Total Nutrisi
                </div>
                <button id="btn-hitung" disabled
                        class="w-full bg-be-primary text-white font-heading font-semibold
                               py-3.5 rounded-xl text-sm hover:bg-be-button transition-colors
                               flex items-center justify-center gap-2">
                    <i class='bx bx-calculator text-lg'></i>
                    Hitung Kandungan Nutrisi
                </button>
            </div>
        </div>

        {{-- ── Pengingat Sehat Card ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-9 h-9 rounded-xl bg-be-light flex items-center justify-center text-be-green text-lg">
                    <i class='bx bxs-bell'></i>
                </span>
                <h2 class="font-heading font-bold text-be-dark text-base">Pengingat Sehat</h2>
            </div>
            <div class="space-y-0.5 text-sm text-be-muted">
                @foreach(['Minum 8 gelas air hari ini','Kurangi konsumsi gula berlebih','Hindari gorengan terlalu sering','Perbanyak makan sayur','Jangan lewatkan sarapan'] as $tip)
                <div class="tip-row">
                    <span class="tip-icon text-be-green"><i class='bx bx-check-circle'></i></span>
                    <span>{{ $tip }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════
         RIGHT COLUMN
    ════════════════════════════ -->
    <div class="lg:col-span-2 space-y-6">

        {{-- ── Hasil Analisis Card ── --}}
        <div id="result-panel"
             class="bg-be-primary rounded-2xl shadow-md p-6 text-white relative overflow-hidden fade-up">
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
                    <span class="text-xl text-white/60 mb-1">kal</span>
                </div>
                <div class="mt-3 bg-white/20 rounded-full h-1.5 overflow-hidden mx-4">
                    <div id="cal-bar" class="h-full bg-be-highlight transition-all duration-700" style="width:0%"></div>
                </div>
                <p class="text-xs text-white/40 mt-1.5" id="cal-bar-label">dari kebutuhan harian</p>
            </div>

            {{-- Makro --}}
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

            {{-- Bar chart vertikal --}}
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
        </div>

        {{-- ── Riwayat Card ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-up">
            <div class="flex items-center justify-between mb-2">
                <h2 class="font-heading font-bold text-be-dark text-base">Riwayat</h2>
            </div>

            <div id="history-list">
                @auth
                    @forelse($recentLogs as $log)
                    <div class="history-row">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-[#F5F5F0] flex items-center justify-center text-be-muted text-sm flex-shrink-0">
                                <i class='bx bx-time-five'></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-be-dark leading-tight truncate">
                                    {{ $log->food?->food_name ?? 'Makanan Umum' }}
                                </p>
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

            {{-- Riwayat sesi kalkulator (dari JS) --}}
            <div id="session-history"></div>
        </div>

        {{-- ── Info TKPI Card ── --}}
        <div class="bg-be-light rounded-2xl border p-5 fade-up">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-200/70 flex items-center justify-center text-be-muted flex-shrink-0">
                    <i class='bx bx-info-circle text-lg'></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-be-dark mb-1">Mengapa TKPI?</p>
                    <p class="text-xs text-be-muted leading-relaxed">
                        Tabel Komposisi Pangan Indonesia disesuaikan dengan jenis bahan baku dan teknik memasak
                        umum di Indonesia, sehingga lebih relevan dibanding basis data internasional.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── State ──
let selectedFoods  = [];   // [{ food_id, food_name, calories_kcal, protein_g, fat_g, carbs_g, gram }]
let pendingFood    = null;  // makanan yang dipilih dari dropdown, belum ditambahkan
let lastResult     = null;
let searchTimer    = null;

// ── DOM ──
const foodSearch      = document.getElementById('food-search');
const dropdown        = document.getElementById('food-dropdown');
const spinner         = document.getElementById('search-spinner');
const qtyGram         = document.getElementById('qty-gram');
const qtyMinus        = document.getElementById('qty-minus');
const qtyPlus         = document.getElementById('qty-plus');
const btnTambah       = document.getElementById('btn-tambah');
const btnHitung       = document.getElementById('btn-hitung');
const btnReset        = document.getElementById('btn-reset');
const foodList        = document.getElementById('food-list');
const foodListEmpty   = document.getElementById('food-list-empty');
const foodCountBadge  = document.getElementById('food-count-badge');
const totalPreview    = document.getElementById('total-preview');
const totalPreviewCal = document.getElementById('total-preview-cal');
const sessionHistory  = document.getElementById('session-history');

// Result
const resCal      = document.getElementById('res-cal');
const resProt     = document.getElementById('res-prot');
const resFat      = document.getElementById('res-fat');
const resCarb     = document.getElementById('res-carb');
const calBar      = document.getElementById('cal-bar');
const calBarLabel = document.getElementById('cal-bar-label');
const barProtV    = document.getElementById('bar-prot-v');
const barFatV     = document.getElementById('bar-fat-v');
const barCarbV    = document.getElementById('bar-carb-v');
const statusBadge = document.getElementById('result-status-badge');
const statusText  = document.getElementById('result-status-text');

/* ══════════════════════════════════════
   GRAM SHORTCUTS
══════════════════════════════════════ */
function setGram(val) {
    qtyGram.value = val;
    document.querySelectorAll('.gram-shortcut').forEach(btn => {
        const isActive = parseInt(btn.dataset.gram) === val;
        btn.classList.toggle('border-be-green', isActive);
        btn.classList.toggle('text-be-primary', isActive);
        btn.classList.toggle('border-gray-200', !isActive);
        btn.classList.toggle('text-be-muted', !isActive);
    });
}

qtyMinus.addEventListener('click', () => {
    const v = parseInt(qtyGram.value) || 100;
    qtyGram.value = Math.max(10, v - 10);
    syncGramShortcut();
});
qtyPlus.addEventListener('click', () => {
    qtyGram.value = (parseInt(qtyGram.value) || 100) + 10;
    syncGramShortcut();
});
qtyGram.addEventListener('input', syncGramShortcut);

function syncGramShortcut() {
    const v = parseInt(qtyGram.value);
    document.querySelectorAll('.gram-shortcut').forEach(btn => {
        const isActive = parseInt(btn.dataset.gram) === v;
        btn.classList.toggle('border-be-green', isActive);
        btn.classList.toggle('text-be-primary', isActive);
        btn.classList.toggle('border-gray-200', !isActive);
        btn.classList.toggle('text-be-muted', !isActive);
    });
}

/* ══════════════════════════════════════
   SEARCH AUTOCOMPLETE
══════════════════════════════════════ */
foodSearch.addEventListener('input', () => {
    clearTimeout(searchTimer);
    pendingFood = null;
    btnTambah.disabled = true;

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
        dropdown.innerHTML = `
            <div class="px-4 py-4 text-center">
                <i class='bx bx-search-alt text-2xl text-gray-300'></i>
                <p class="text-xs text-be-muted mt-1">Makanan tidak ditemukan di database TKPI</p>
            </div>`;
    } else {
        foods.forEach(f => {
            const item = document.createElement('div');
            item.className = 'dropdown-item flex items-center justify-between px-4 py-2.5';
            item.innerHTML = `
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-be-dark truncate">${escHtml(f.food_name)}</p>
                    <p class="text-xs text-be-muted">${f.calories_kcal} kal per 100g</p>
                </div>
                <i class='bx bx-chevron-right text-be-muted text-lg ml-2'></i>
            `;
            item.addEventListener('click', () => selectFood(f));
            dropdown.appendChild(item);
        });
    }
    dropdown.classList.remove('hidden');
}

function selectFood(food) {
    pendingFood = food;
    foodSearch.value = food.food_name;
    closeDropdown();
    btnTambah.disabled = false;
    // Auto-focus ke tombol tambah
    btnTambah.focus();
}

function closeDropdown() {
    dropdown.classList.add('hidden');
    dropdown.innerHTML = '';
}

document.addEventListener('click', e => {
    if (!foodSearch.contains(e.target) && !dropdown.contains(e.target)) closeDropdown();
});

/* ══════════════════════════════════════
   TAMBAH KE DAFTAR
══════════════════════════════════════ */
btnTambah.addEventListener('click', () => {
    if (!pendingFood) return;

    const gram = parseInt(qtyGram.value) || 100;

    // Cek duplikat (food_id sama)
    const existing = selectedFoods.find(f => f.food_id === pendingFood.food_id);
    if (existing) {
        // Update gram saja
        existing.gram = gram;
        renderFoodList();
    } else {
        selectedFoods.push({ ...pendingFood, gram });
        renderFoodList();
    }

    // Reset search
    foodSearch.value = '';
    pendingFood = null;
    btnTambah.disabled = true;
    setGram(100);

    updateHitungBtn();
    updateTotalPreview();
});

/* ══════════════════════════════════════
   RENDER DAFTAR MAKANAN
══════════════════════════════════════ */
function renderFoodList() {
    // Hapus item lama kecuali empty state
    foodList.querySelectorAll('.food-list-item').forEach(el => el.remove());

    const isEmpty = selectedFoods.length === 0;
    foodListEmpty.style.display = isEmpty ? '' : 'none';
    foodCountBadge.classList.toggle('hidden', isEmpty);
    foodCountBadge.textContent = selectedFoods.length;

    selectedFoods.forEach((f, idx) => {
        const calEst = Math.round((f.calories_kcal || 0) * f.gram / 100);

        const item = document.createElement('div');
        item.className = 'food-list-item';
        item.dataset.idx = idx;

        item.innerHTML = `
            <div class="food-info">
                <p class="food-name">${escHtml(f.food_name)}</p>
                <p class="food-cal" id="cal-est-${idx}">≈ ${calEst} kal</p>
            </div>

            <div class="gram-editor">
                <button type="button" onclick="changeGramInline(${idx}, -10)">−</button>
                <input type="number" value="${f.gram}" min="1" step="10"
                       onchange="setGramInline(${idx}, this.value)"
                       class="gram-input-${idx}">
                <span class="gram-unit">g</span>
            </div>

            <button type="button" class="food-remove-btn" onclick="removeFood(${idx})">
                &times;
            </button>
        `;

        foodList.appendChild(item);
    });

    updateTotalPreview();
    updateHitungBtn();
}

function changeGramInline(idx, delta) {
    const newVal = Math.max(10, (selectedFoods[idx].gram || 100) + delta);
    selectedFoods[idx].gram = newVal;
    // update input visual
    const inp = foodList.querySelector(`.gram-input-${idx}`);
    if (inp) inp.value = newVal;
    // update kalori estimasi
    const calEl = document.getElementById(`cal-est-${idx}`);
    if (calEl) {
        const calEst = Math.round((selectedFoods[idx].calories_kcal || 0) * newVal / 100);
        calEl.textContent = `≈ ${calEst} kal`;
    }
    updateTotalPreview();
}

function setGramInline(idx, val) {
    const gram = Math.max(10, parseInt(val) || 10);
    selectedFoods[idx].gram = gram;
    const calEl = document.getElementById(`cal-est-${idx}`);
    if (calEl) {
        const calEst = Math.round((selectedFoods[idx].calories_kcal || 0) * gram / 100);
        calEl.textContent = `≈ ${calEst} kal`;
    }
    updateTotalPreview();
}

function removeFood(idx) {
    selectedFoods.splice(idx, 1);
    renderFoodList();
}

function updateTotalPreview() {
    const total = selectedFoods.reduce((sum, f) => {
        return sum + Math.round((f.calories_kcal || 0) * (f.gram || 100) / 100);
    }, 0);

    const hasFood = selectedFoods.length > 0;
    totalPreview.classList.toggle('hidden', !hasFood);
    totalPreviewCal.textContent = `${total} kal`;
}

function updateHitungBtn() {
    btnHitung.disabled = selectedFoods.length === 0;
}

/* ══════════════════════════════════════
   HITUNG
══════════════════════════════════════ */
btnHitung.addEventListener('click', async () => {
    if (!selectedFoods.length) return;

    // Bangun payload: tiap makanan dengan gram masing-masing
    const items = selectedFoods.map(f => ({
        food_id:       f.food_id,
        quantity_gram: f.gram || 100,
    }));

    btnHitung.disabled = true;
    btnHitung.innerHTML = `
        <span class="inline-block w-4 h-4 border-2 border-white/40 border-t-white
                     rounded-full animate-spin mr-2"></span> Menghitung…`;

    try {
        const res  = await fetch('/kalkulator/calculate', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify({ items }),
        });
        const data = await res.json();

        if (res.ok) {
            lastResult = data;
            renderResult(data);
            addToSessionHistory(data);
            // Ambil alternatif dari makanan pertama

        } else {
            alert('Terjadi kesalahan: ' + (data.message ?? 'Coba lagi.'));
        }
    } catch (e) {
        alert('Gagal terhubung ke server.');
        console.error(e);
    } finally {
        btnHitung.disabled = false;
        btnHitung.innerHTML = `<i class='bx bx-calculator text-lg'></i> Hitung Kandungan Nutrisi`;
        updateHitungBtn();
    }
});

/* ══════════════════════════════════════
   RENDER RESULT
══════════════════════════════════════ */
function renderResult(data) {
    const { totals, status, daily_goal } = data;

    animateNumber(resCal,  totals.calories);
    animateNumber(resProt, totals.protein);
    animateNumber(resFat,  totals.fat);
    animateNumber(resCarb, totals.carbs);

    const calPct = Math.min(Math.round(totals.calories / (daily_goal || 2000) * 100), 100);
    calBar.style.width = calPct + '%';
    calBarLabel.textContent = `${calPct}% dari kebutuhan harian (${daily_goal} kal)`;

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
    const badge = badgeMap[status?.color] ?? badgeMap.green;
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
   SESSION HISTORY
══════════════════════════════════════ */
function addToSessionHistory(data) {
    // Nama: gabungan semua makanan
    const names = selectedFoods.map(f => f.food_name).join(', ');
    const cal   = Math.round(data.totals.calories);
    const pct   = cal / (data.daily_goal || 2000) * 100;
    const badgeCls = pct <= 30 ? 'status-aman' : (pct <= 60 ? 'status-cukup' : 'status-batasi');
    const badgeLbl = pct <= 30 ? 'AMAN'        : (pct <= 60 ? 'CUKUP'        : 'BATASI');

    const item = document.createElement('div');
    item.className = 'history-row fade-up';
    item.innerHTML = `
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-[#F5F5F0] flex items-center justify-center
                        text-be-muted text-sm flex-shrink-0">
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

/* ══════════════════════════════════════
   RESET
══════════════════════════════════════ */
btnReset.addEventListener('click', () => {
    selectedFoods = [];
    pendingFood   = null;

    renderFoodList();
    updateHitungBtn();
    setGram(100);

    foodSearch.value     = '';
    btnTambah.disabled   = true;
    closeDropdown();

    // Reset result panel
    resCal.textContent = resProt.textContent = resFat.textContent = resCarb.textContent = '—';
    calBar.style.width = '0%';
    calBarLabel.textContent = 'dari kebutuhan harian';
    barProtV.style.height = barFatV.style.height = barCarbV.style.height = '0%';
    statusBadge.classList.add('hidden');
    lastResult = null;
});

/* ══════════════════════════════════════
   UTIL
══════════════════════════════════════ */
function escHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}
</script>
@endpush