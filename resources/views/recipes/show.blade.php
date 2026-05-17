@extends('layouts.user')

@section('title', $recipe->name . ' — BetterEat')

@push('styles')
<style>
    /* ── Nutrition Progress Bar ── */
    .nutrition-bar-bg {
        background: #EDF3E4;
        border-radius: 999px;
        height: 8px;
        overflow: hidden;
    }
    .nutrition-bar-fill {
        height: 100%;
        border-radius: 999px;
        animation: growBar .9s ease forwards;
    }
    @keyframes growBar { from { width: 0; } }

    /* ── Step circle ── */
    .step-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #3C4C25;
        color: white;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    /* ── Ingredient bullet ── */
    .ingredient-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px dashed #E5E7EB;
        font-size: 0.9rem;
        color: #374151;
    }
    .ingredient-item:last-child { border-bottom: none; }

    /* ── Badge GI ── */
    .gi-badge {
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .gi-low    { background: #DCFCE7; color: #15803D; }
    .gi-medium { background: #FEF9C3; color: #92400E; }
    .gi-high   { background: #FEE2E2; color: #B91C1C; }

    /* ── Related card ── */
    .related-card {
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #F3F4F6;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
        transition: box-shadow .2s, transform .2s;
    }
    .related-card:hover { box-shadow: 0 6px 20px rgba(60,76,37,.1); transform: translateY(-3px); }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════
     BREADCRUMB
     ════════════════════════════════ --}}
<div class="bg-white border-b border-gray-100 pt-20 pb-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-be-muted">
            <a href="{{ route('home') }}" class="hover:text-be-button transition-colors">Home</a>
            <i class='bx bx-chevron-right'></i>
            <a href="{{ route('recipes.index') }}" class="hover:text-be-button transition-colors">Resep Sehat</a>
            <i class='bx bx-chevron-right'></i>
            <span class="text-be-dark font-medium truncate max-w-xs">{{ $recipe->name }}</span>
        </nav>
    </div>
</div>

{{-- ════════════════════════════════
     KONTEN UTAMA
     ════════════════════════════════ --}}
<section class="py-10 bg-be-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm">
                <i class='bx bx-check-circle text-xl'></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ═══════════════════════════════════════
                 KOLOM KIRI (2/3): Detail resep
                 ═══════════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-7">

                {{-- ── Card Utama Resep ── --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">

                    {{-- Gambar --}}
                    <div class="relative h-72 sm:h-96 bg-be-light overflow-hidden">
                        <img src="{{ asset($recipe->image_url) }}"
                            alt="{{ $recipe->name }}"
                            class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/800x400/C5D8A4/3C4C25?text={{ urlencode($recipe->name) }}'">

                        {{-- Overlay badges --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                        {{-- Badge kategori --}}
                        <span class="absolute top-5 left-5 px-4 py-1.5 rounded-full text-sm font-semibold shadow
                                     {{ $recipe->category_badge_color }}">
                            {{ $recipe->category_label }}
                        </span>

                        {{-- Badge GI --}}
                        <span class="absolute top-5 right-5 gi-badge gi-{{ strtolower($recipe->glycemic_index) }}">
                            GI {{ $recipe->glycemic_index === 'Low' ? 'Rendah' : ($recipe->glycemic_index === 'Medium' ? 'Sedang' : 'Tinggi') }}
                        </span>

                        {{-- Save / Bookmark (Auth only) --}}
                        @auth
                            <form action="{{ route('saved_recipes.toggle', $recipe->recipe_id) }}"
                                  method="POST"
                                  class="absolute bottom-5 right-5">
                                @csrf
                                <button type="submit"
                                        class="w-11 h-11 rounded-full bg-white/90 hover:bg-white shadow flex items-center justify-center transition-all">
                                    <i class='bx bx-bookmark text-be-button text-xl'></i>
                                </button>
                            </form>
                        @endauth
                    </div>

                    {{-- Info dasar --}}
                    <div class="p-7">

                        <h1 class="font-heading font-extrabold text-3xl text-be-dark">{{ $recipe->name }}</h1>

                        @if($recipe->description)
                            <p class="text-be-muted mt-3 leading-relaxed">{{ $recipe->description }}</p>
                        @endif

                        {{-- Chips info --}}
                        <div class="flex flex-wrap gap-3 mt-5">
                            @if($recipe->calories)
                                <div class="flex items-center gap-2 px-4 py-2 bg-orange-50 rounded-xl">
                                    <i class='bx bx-flame text-orange-400 text-lg'></i>
                                    <div>
                                        <p class="text-xs text-gray-400">Kalori</p>
                                        <p class="font-semibold text-sm text-be-dark">{{ $recipe->formatted_calories }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($recipe->budget_estimate)
                                <div class="flex items-center gap-2 px-4 py-2 bg-green-50 rounded-xl">
                                    <i class='bx bx-money text-green-500 text-lg'></i>
                                    <div>
                                        <p class="text-xs text-gray-400">Estimasi Budget</p>
                                        <p class="font-semibold text-sm text-be-dark">{{ $recipe->formatted_budget }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($recipe->prep_time_minutes)
                                <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-xl">
                                    <i class='bx bx-time-five text-blue-400 text-lg'></i>
                                    <div>
                                        <p class="text-xs text-gray-400">Waktu Masak</p>
                                        <p class="font-semibold text-sm text-be-dark">{{ $recipe->formatted_prep_time }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- ── Bahan-Bahan ── --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-gray-100">
                    <h2 class="font-heading font-bold text-xl text-be-dark mb-5 flex items-center gap-2">
                        <i class='bx bx-list-ul text-be-green'></i>
                        Bahan-Bahan
                    </h2>

                    <div class="divide-y divide-dashed divide-gray-100">
                        @foreach($recipe->ingredients_array as $index => $ingredient)
                            <div class="ingredient-item">
                                <span class="w-6 h-6 flex-shrink-0 rounded-full bg-be-light flex items-center justify-center text-xs font-bold text-be-primary mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <span>{{ $ingredient }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Langkah Memasak ── --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-gray-100">
                    <h2 class="font-heading font-bold text-xl text-be-dark mb-6 flex items-center gap-2">
                        <i class='bx bx-cook text-be-green'></i>
                        Langkah Memasak
                    </h2>

                    <div class="space-y-6">
                        @foreach($recipe->cooking_steps_array as $index => $step)
                            <div class="flex gap-4 items-start">
                                <div class="step-circle">{{ $index + 1 }}</div>
                                <p class="text-be-dark text-sm leading-relaxed pt-1.5">
                                    {{-- Hapus awalan "1. ", "2. " jika sudah ada di teks --}}
                                    {{ preg_replace('/^\d+\.\s*/', '', $step) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ═══════════════════════════════════════
                 KOLOM KANAN (1/3): Gizi & Sidebar
                 ═══════════════════════════════════════ --}}
            <div class="space-y-6">

                {{-- ── Kandungan Gizi ── --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    <h2 class="font-heading font-bold text-lg text-be-dark mb-5 flex items-center gap-2">
                        <i class='bx bx-bar-chart-alt-2 text-be-green'></i>
                        Kandungan Gizi
                    </h2>

                    @php
                        // Nilai referensi harian (AKG 2000 kal)
                        $nutrients = [
                            ['label' => 'Kalori',       'value' => $recipe->calories,   'unit' => 'kal',  'max' => 2000, 'color' => 'bg-orange-400'],
                            ['label' => 'Protein',      'value' => $recipe->protein_g,  'unit' => 'g',    'max' => 60,   'color' => 'bg-purple-400'],
                            ['label' => 'Lemak',        'value' => $recipe->fat_g,      'unit' => 'g',    'max' => 67,   'color' => 'bg-yellow-400'],
                            ['label' => 'Karbohidrat',  'value' => $recipe->carbs_g,    'unit' => 'g',    'max' => 300,  'color' => 'bg-blue-400'],
                            ['label' => 'Gula',         'value' => $recipe->sugar_g,    'unit' => 'g',    'max' => 50,   'color' => 'bg-pink-400'],
                            ['label' => 'Serat',        'value' => $recipe->fiber_g,    'unit' => 'g',    'max' => 28,   'color' => 'bg-green-500'],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($nutrients as $n)
                            @php
                                $pct = $n['max'] > 0 ? min(100, round(($n['value'] / $n['max']) * 100)) : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-be-muted">{{ $n['label'] }}</span>
                                    <span class="font-semibold text-be-dark">
                                        {{ number_format($n['value'], 1) }} {{ $n['unit'] }}
                                    </span>
                                </div>
                                <div class="nutrition-bar-bg">
                                    <div class="nutrition-bar-fill {{ $n['color'] }}"
                                         style="width: {{ $pct }}%"></div>
                                </div>
                                <p class="text-right text-xs text-gray-400 mt-0.5">
                                    {{ $pct }}% AKG
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status keamanan --}}
                    <div class="mt-6 p-4 rounded-2xl
                        {{ $recipe->sugar_g <= 5 && $recipe->glycemic_index === 'Low'
                            ? 'bg-green-50 border border-green-200'
                            : ($recipe->sugar_g <= 15
                                ? 'bg-yellow-50 border border-yellow-200'
                                : 'bg-red-50 border border-red-200') }}">
                        <p class="text-sm font-semibold
                            {{ $recipe->sugar_g <= 5 && $recipe->glycemic_index === 'Low'
                                ? 'text-green-700'
                                : ($recipe->sugar_g <= 15
                                    ? 'text-yellow-700'
                                    : 'text-red-700') }}">
                            @if($recipe->sugar_g <= 5 && $recipe->glycemic_index === 'Low')
                                ✅ Aman untuk Penderita Diabetes
                            @elseif($recipe->sugar_g <= 15)
                                ⚠️ Dikonsumsi dengan Porsi Wajar
                            @else
                                ❌ Perlu Dibatasi untuk Penderita Diabetes
                            @endif
                        </p>
                        <p class="text-xs mt-1
                            {{ $recipe->sugar_g <= 5 ? 'text-green-600' : ($recipe->sugar_g <= 15 ? 'text-yellow-600' : 'text-red-600') }}">
                            Gula: {{ $recipe->sugar_g }}g · GI: {{ $recipe->glycemic_index }}
                        </p>
                    </div>

                    {{-- Tombol back --}}
                    <a href="{{ route('recipes.index') }}"
                       class="mt-5 flex items-center justify-center gap-2 w-full py-3 rounded-2xl
                              border border-gray-200 text-sm text-be-muted hover:bg-be-light hover:text-be-primary
                              transition-colors">
                        <i class='bx bx-arrow-back'></i>
                        Kembali ke Daftar Resep
                    </a>
                </div>

            </div>
        </div>

        {{-- ════════════════════════════════════════════
             RESEP SERUPA
             ════════════════════════════════════════════ --}}
        @if($relatedRecipes->count() > 0)
            <div class="mt-14">
                <h2 class="font-heading font-bold text-2xl text-be-dark mb-7">
                    Resep Serupa
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedRecipes as $related)
                        <div class="related-card">
                            <div class="h-44 overflow-hidden bg-be-light">
                                <img src="{{ asset($related->image_url) }}"
                                    alt="{{ $related->name }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-400"
                                    onerror="this.src='https://placehold.co/400x200/C5D8A4/3C4C25?text={{ urlencode($related->name) }}'">
                            </div>
                            <div class="p-5">
                                <h3 class="font-heading font-bold text-base text-be-dark">{{ $related->name }}</h3>
                                <div class="flex gap-3 text-xs text-be-muted mt-2">
                                    <span>{{ $related->formatted_calories }}</span>
                                    <span>{{ $related->formatted_budget }}</span>
                                </div>
                                <a href="{{ route('recipes.show', $related->recipe_id) }}"
                                   class="mt-4 block w-full text-center py-2.5 rounded-xl bg-be-button text-white text-sm font-semibold
                                          hover:bg-be-green transition-colors">
                                    Lihat Resep
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection