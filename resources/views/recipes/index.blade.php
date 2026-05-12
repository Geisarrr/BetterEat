@extends('layouts.user')

@section('title', 'Resep Sehat Nusantara — BetterEat')

@push('styles')
<style>
    /* ── Filter Tab Pill ── */
    .tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: all .2s ease;
        white-space: nowrap;
        background: #FBF9F3;
        color: #4B5563;
        border-color: #E5E7EB;
    }
    .tab-pill:hover   { background: #EDF3E4; color: #3C4C25; border-color: #C5D8A4; }
    .tab-pill.active  { background: #3C4C25; color: #ffffff; border-color: #3C4C25; }

    /* ── Recipe Card ── */
    .recipe-card {
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #F3F4F6;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        transition: box-shadow .25s ease, transform .25s ease;
        display: flex;
        flex-direction: column;
    }
    .recipe-card:hover {
        box-shadow: 0 8px 28px rgba(60,76,37,.12);
        transform: translateY(-4px);
    }
    .recipe-card img {
        width: 100%; height: 200px;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .recipe-card:hover img { transform: scale(1.05); }

    /* ── Select Dropdown ── */
    .filter-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7558' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    width: 100%;
    height: 44px;
    padding-left: 14px;
    padding-right: 38px;
    border: 1.5px solid #E5E7EB;
    border-radius: 12px;
    font-size: 0.85rem;
    color: #374151;
    background-color: #FBF9F3;
    cursor: pointer;
    outline: none;
    transition: all .2s ease;
    }

    .filter-select:focus {
        border-color: #3C4C25;
        box-shadow: 0 0 0 3px rgba(60,76,37,.08);
    }

    /* ── Hero gradient overlay ── */
    .hero-section {
        background: linear-gradient(135deg, #C5D8A4 0%, #dfeece 60%, #eef5e5 100%);
    }

    /* ── Load more button ── */
    .btn-load-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 32px;
        border-radius: 999px;
        border: 1.5px solid #D1D5DB;
        background: #fff;
        color: #374151;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s ease;
    }
    .btn-load-more:hover { background: #EDF3E4; border-color: #3C4C25; color: #3C4C25; }

    /* ── Search input ── */
    .search-wrap { position: relative; }
    .search-wrap input {
        width: 100%;
        padding: 11px 16px 11px 42px;
        border-radius: 12px;
        border: 1.5px solid rgba(60,76,37,.18);
        background: rgba(255,255,255,.85);
        font-size: 0.9rem;
        outline: none;
        color: #1B1C18;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus {
        border-color: #3C4C25;
        box-shadow: 0 0 0 3px rgba(60,76,37,.1);
        background: #fff;
    }
    .search-wrap .search-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #6B7558; pointer-events: none;
    }

    /* ── Nutrient badge ── */
    .nutrient-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.73rem;
        font-weight: 500;
        background: #EDF3E4;
        color: #3C4C25;
    }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════
     HERO SECTION
     ════════════════════════════════════════════════════════ --}}
<section class="hero-section pt-40 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12 lg:gap-24">

            {{-- Teks kiri --}}
            <div class="flex-1 max-w-xl text-center lg:text-left">
                <h1 class="font-heading font-extrabold text-4xl lg:text-5xl text-be-primary leading-tight">
                    Resep Sehat<br>Nusantara
                </h1>
                <p class="mt-4 text-be-muted text-base leading-relaxed">
                    Nikmati lezatnya masakan Nusantara, tanpa khawatir risiko kesehatan. Temukan ribuan resep lokal yang telah disesuaikan khusus untuk kebutuhan nutrisi tubuhmu
                </p>

                {{-- Search bar --}}
                <form method="GET" action="{{ route('recipes.index') }}" id="filter-form" class="mt-6">
                    {{-- Pertahankan filter aktif saat search --}}
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                    @foreach($filters as $key => $val)
                        @if($key !== 'search' && $key !== 'category')
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endif
                    @endforeach

                    <div class="search-wrap">
                        <svg class="search-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input type="text"
                               name="search"
                               value="{{ $filters['search'] ?? '' }}"
                               placeholder="Cari nama resep..."
                               autocomplete="off">
                    </div>
                </form>
            </div>

            {{-- Ilustrasi kanan --}}
            <div class="w-full max-w-sm sm:max-w-sm lg:max-w-sm flex justify-center">
            <div class="w-full aspect-[4/3] rounded-[32px] overflow-hidden shadow-2xl float-anim">
                    <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=640&q=80"
                        alt="Makanan Sehat Nusantara"
                        class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     FILTER SECTION (Tab + Dropdown)
     ════════════════════════════════════════════════════════ --}}
<section class="relative z-30 -mt-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto bg-white backdrop-blur-md rounded-[28px] shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-white/60 px-5 sm:px-7 lg:px-8 py-5">

        {{-- ── Tab Kategori Penyakit ── --}}
        <div class="flex items-center gap-8 overflow-x-auto pb-3 hide-scrollbar">
            @foreach($filterCategories as $cat)
                <a href="{{ route('recipes.index', array_merge($filters, ['category' => $cat, 'page' => 1])) }}"
                   class="tab-pill {{ $activeCategory === $cat ? 'active' : '' }} flex-shrink-0">

                    {{-- Ikon tiap kategori --}}
                    @if($cat === 'Semua')      
                    @elseif($cat === 'Diabetes')    
                    @elseif($cat === 'Hipertensi')  
                    @elseif($cat === 'Kolesterol')  
                    @elseif($cat === 'Asam Urat')   
                    @elseif($cat === 'Diet')       
                    @else                           
                    @endif

                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- ── Dropdown Filter ── --}}
        <form method="GET" action="{{ route('recipes.index') }}" id="dropdown-filter-form" 
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4"

            {{-- Pertahankan search & kategori aktif --}}
            @if(!empty($filters['search']))
                <input type="hidden" name="search" value="{{ $filters['search'] }}">
            @endif
            <input type="hidden" name="category" value="{{ $activeCategory }}">

            {{-- Budget --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs text-be-muted font-medium">Budget</label>
                <select name="budget" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Budget</option>
                    <option value="15000" {{ ($filters['budget'] ?? '') == '15000' ? 'selected' : '' }}>
                        s/d Rp 15.000
                    </option>
                    <option value="25000" {{ ($filters['budget'] ?? '') == '25000' ? 'selected' : '' }}>
                        s/d Rp 25.000
                    </option>
                    <option value="50000" {{ ($filters['budget'] ?? '') == '50000' ? 'selected' : '' }}>
                        s/d Rp 50.000
                    </option>
                    <option value="100000" {{ ($filters['budget'] ?? '') == '100000' ? 'selected' : '' }}>
                        s/d Rp 100.000
                    </option>
                </select>
            </div>

            {{-- Kalori --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs text-be-muted font-medium">Kalori</label>
                <select name="kalori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Pilih Kalori</option>
                    <option value="200" {{ ($filters['kalori'] ?? '') == '200' ? 'selected' : '' }}>
                        &lt; 200 kal
                    </option>
                    <option value="400" {{ ($filters['kalori'] ?? '') == '400' ? 'selected' : '' }}>
                        &lt; 400 kal
                    </option>
                    <option value="600" {{ ($filters['kalori'] ?? '') == '600' ? 'selected' : '' }}>
                        &lt; 600 kal
                    </option>
                </select>
            </div>

            {{-- Bahan Utama --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs text-be-muted font-medium">Bahan Utama</label>
                <select name="bahan" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Bahan</option>
                    @foreach(['Ayam','Ikan','Tempe','Tahu','Daging Sapi','Sayuran','Telur','Udang'] as $bahan)
                        <option value="{{ $bahan }}" {{ ($filters['bahan'] ?? '') === $bahan ? 'selected' : '' }}>
                            {{ $bahan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Terapkan Filter --}}
            <div class="flex flex-col gap-1">
                
                {{-- Label kosong agar sejajar --}}
                <label class="text-xs opacity-0 select-none">
                    Filter
                </label>

                <button type="submit"
                    class="w-full h-[44px] flex items-center justify-center gap-2
                        rounded-xl border border-transparent
                        bg-be-highlight text-be-dark
                        text-sm font-semibold
                        hover:bg-be-button hover:text-white hover:border-be-button
                        transition-all duration-200">
                    
                    <i class='bx bx-filter-alt text-base'></i>
                    <span class="leading-none">
                        Terapkan Filter
                    </span>

                </button>
            </div>

            {{-- Reset Filter (tampil jika ada filter aktif) --}}
            @if(array_filter($filters))
                <a href="{{ route('recipes.index') }}"
                   class="flex items-center gap-1 px-4 py-2.5 text-sm text-be-muted hover:text-red-500 border border-gray-200 rounded-xl transition-colors">
                    <i class='bx bx-x'></i> Reset
                </a>
            @endif

        </form>

    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     RECIPE GRID
     ════════════════════════════════════════════════════════ --}}
<section class="py-14 bg-be-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm">
                <i class='bx bx-check-circle text-xl'></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Info jumlah hasil --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="font-heading font-bold text-2xl text-be-dark">
                    @if($activeCategory !== 'Semua')
                        Resep untuk {{ $activeCategory }}
                    @elseif(!empty($filters['search']))
                        Hasil pencarian "{{ $filters['search'] }}"
                    @else
                        Semua Resep Sehat
                    @endif
                </h2>
                <p class="text-be-muted text-sm mt-1">
                    Menampilkan {{ $recipes->firstItem() ?? 0 }}–{{ $recipes->lastItem() ?? 0 }}
                    dari {{ $recipes->total() }} resep
                </p>
            </div>
        </div>

        {{-- ── Grid Resep ── --}}
        @if($recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach($recipes as $recipe)
                    <div class="recipe-card">

                        {{-- Gambar --}}
                        <div class="relative overflow-hidden bg-be-light" style="height:200px;">
                            <img src="{{ $recipe->image_src }}"
                                 alt="{{ $recipe->name }}"
                                 loading="lazy"
                                 onerror="this.src='https://placehold.co/600x400/C5D8A4/3C4C25?text={{ urlencode($recipe->name) }}'">

                            {{-- Badge kategori --}}
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold shadow-sm
                                         {{ $recipe->category_badge_color }}">
                                {{ $recipe->category_label }}
                            </span>

                            {{-- Badge GI (untuk Diabetes) --}}
                            @if($recipe->glycemic_index === 'Low')
                                <span class="absolute top-3 right-3 px-2 py-1 rounded-full text-xs font-semibold bg-white/90 text-be-green">
                                    GI Rendah
                                </span>
                            @endif
                        </div>

                        {{-- Konten --}}
                        <div class="p-5 flex flex-col flex-1">

                            {{-- Nama Resep --}}
                            <h3 class="font-heading font-bold text-lg text-be-dark leading-snug">
                                {{ $recipe->name }}
                            </h3>

                            {{-- Info nutrisi ringkas --}}
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="nutrient-chip">
                                    <i class='bx bx-flame text-orange-400'></i>
                                    {{ $recipe->formatted_calories }}
                                </span>
                                @if($recipe->protein_g > 0)
                                    <span class="nutrient-chip">
                                        <i class='bx bx-dumbbell text-purple-400'></i>
                                        {{ $recipe->protein_g }}g Protein
                                    </span>
                                @endif
                                @if($recipe->budget_estimate > 0)
                                    <span class="nutrient-chip">
                                        <i class='bx bx-money text-green-500'></i>
                                        {{ $recipe->formatted_budget }}
                                    </span>
                                @endif
                            </div>

                            {{-- Waktu masak --}}
                            @if($recipe->prep_time_minutes)
                                <p class="text-be-muted text-xs mt-2 flex items-center gap-1">
                                    <i class='bx bx-time-five'></i>
                                    {{ $recipe->formatted_prep_time }}
                                </p>
                            @endif

                            {{-- Spacer --}}
                            <div class="flex-1"></div>

                            {{-- Tombol Lihat Resep --}}
                            <a href="{{ route('recipes.show', $recipe->recipe_id) }}"
                               class="mt-5 w-full bg-be-button hover:bg-be-green text-white text-sm font-semibold
                                      py-3 rounded-2xl text-center transition-all duration-200 flex items-center justify-center gap-2">
                                Lihat Resep
                                <i class='bx bx-right-arrow-alt text-base'></i>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ── Pagination / Tampilkan Lebih Banyak ── --}}
            @if($recipes->hasMorePages())
                <div class="flex justify-center mt-12">
                    <a href="{{ $recipes->nextPageUrl() }}"
                       class="btn-load-more">
                        <i class='bx bx-chevron-down'></i>
                        Tampilkan Lebih Banyak
                        <i class='bx bx-chevron-down'></i>
                    </a>
                </div>
            @endif

            {{-- Pagination links lengkap (opsional, bisa dihapus jika pakai tombol di atas) --}}
            <div class="mt-8 flex justify-center">
                {{ $recipes->links() }}
            </div>

        @else
            {{-- ── Empty State ── --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-24 h-24 rounded-full bg-be-light flex items-center justify-center mb-6">
                    <i class='bx bx-bowl-hot text-5xl text-be-muted'></i>
                </div>
                <h3 class="font-heading font-bold text-xl text-be-dark">Resep tidak ditemukan</h3>
                <p class="text-be-muted text-sm mt-2 max-w-xs">
                    Coba ubah kata kunci pencarian atau reset filter yang aktif.
                </p>
                <a href="{{ route('recipes.index') }}"
                   class="mt-6 px-6 py-3 bg-be-button text-white text-sm font-semibold rounded-xl hover:bg-be-green transition-colors">
                    Lihat Semua Resep
                </a>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Auto-submit search saat user selesai mengetik (debounce 500ms)
    const searchInput = document.querySelector('#filter-form input[name="search"]');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 500);
        });
    }

    // Sembunyikan scrollbar horizontal tab filter (tapi tetap scrollable)
    const style = document.createElement('style');
    style.textContent = `.hide-scrollbar::-webkit-scrollbar{display:none}.hide-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}`;
    document.head.appendChild(style);
</script>
@endpush