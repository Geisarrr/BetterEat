@extends('layouts.user')

@section('title', 'BetterEat — Hidup Sehat dengan Makanan Nusantara')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section pt-40 pb-2 bg-be-highlight">

    <div class="absolute top-24 right-0 w-[420px] h-[420px] bg-be-highlight/25 rounded-full blur-3xl pointer-events-none -z-0"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-be-light/70 rounded-full blur-3xl pointer-events-none -z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <h1 class="font-heading font-bold text-4xl sm:text-5xl lg:text-[3.2rem] leading-tight text-be-primary mb-6">
                    Hidup Sehat dengan Makanan Nusantara
                </h1>

                <p class="text-be-muted text-base sm:text-lg leading-relaxed mb-8 max-w-lg">
                    BetterEat membantu Anda memantau nutrisi makanan lokal Indonesia, menemukan resep sehat, dan bergabung bersama komunitas hidup sehat.
                </p>

                <div class="flex flex-wrap gap-3 mb-10">
                    <a href="{{ route('register') }}"
                       class="px-7 py-3 bg-be-button text-white text-sm font-semibold rounded-full shadow-md hover:shadow-lg hover:bg-opacity-90 transition-all duration-200">
                        Mulai Sekarang
                    </a>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end">
                <div class="relative w-full max-w-md float-anim">

                    <div class="rounded-3xl overflow-hidden shadow-2xl aspect-[4/3] bg-be-light">
                        <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=700&q=80"
                             alt="Makanan Sehat Nusantara"
                             class="w-full h-full object-cover">
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


<!-- FITUR UNGGULAN -->
<section class="py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="font-heading font-bold text-3xl md:text-4xl text-be-dark mb-4">
                Fitur Unggulan
            </h2>

            <p class="text-be-muted text-base max-w-xl mx-auto">
                BetterEat hadir dengan fitur lengkap untuk mendukung perjalanan hidup sehat Anda setiap hari.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @include('components.feature-card', [
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                'title' => 'Kalkulator Gizi',
                'description' => 'Hitung kebutuhan kalori, protein, karbohidrat, dan lemak harian sesuai data tubuh dan aktivitasmu secara akurat.',
                'link' => '#',
            ])

            @include('components.feature-card', [
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>',
                'title' => 'Filter Resep',
                'description' => 'Temukan resep sehat nusantara berdasarkan kalori, bahan tersedia, waktu memasak, atau jenis diet yang kamu jalani.',
                'link' => '#',
            ])

            @include('components.feature-card', [
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                'title' => 'Community Hub',
                'description' => 'Bergabung, berbagi tips, dan saling mendukung bersama ribuan anggota komunitas hidup sehat BetterEat Indonesia.',
                'link' => '#',
            ])

        </div>
    </div>
</section>


<!-- RESEP SEHAT -->
<section class="py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col items-center justify-center text-center gap-4 mb-12">
            <div>
                <h2 class="font-heading font-bold text-3xl md:text-4xl text-be-dark">
                    Resep Sehat Nusantara
                </h2>

                <p class="text-be-muted text-sm mt-2">
                    Jelajahi koleksi resep makanan tradisional Indonesia yang sehat dan bergizi
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-8">

            @forelse($recipes as $recipe)

                @include('components.recipe-card', [
                    'image' => $recipe->image_url,
                    'title' => $recipe->name,
                    'calories' => $recipe->calories,
                    'time' => null,
                    'tag' => null,
                    'slug' => $recipe->recipe_id,
                ])

            @empty

                <p class="col-span-full text-center text-gray-500">
                    Belum ada data resep.
                </p>

            @endforelse

        </div>

    </div>
</section>


<!-- ARTIKEL -->
<section class="py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="font-heading font-bold text-3xl md:text-4xl text-be-dark mb-4">
                Artikel Edukasi Kesehatan
            </h2>

            <p class="text-be-muted text-base max-w-lg mx-auto">
                Tingkatkan pengetahuan Anda tentang nutrisi dan pola hidup sehat
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse($articles as $article)

                @include('components.article-card', [
                    'image' => $article['image'],
                    'category' => $article['category'],
                    'title' => $article['title'],
                    'preview' => $article['preview'],
                    'slug' => $article['slug'],
                    'date' => $article['date'],
                ])

            @empty

                <p class="col-span-full text-center text-gray-500">
                    Belum ada artikel.
                </p>

            @endforelse

        </div>

    </div>
</section>


<!-- TESTIMONI -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#F1F5E8]">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-14">
            <h2 class="font-heading font-bold text-4xl text-[#1B1C18] mb-3">
                Testimoni Pengguna
            </h2>

            <p class="text-[#6B7280] text-base max-w-2xl mx-auto leading-relaxed">
                Bergabung dengan ribuan pengguna yang telah merasakan manfaat dari BetterEat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($testimonials as $testimonial)

                @include('components.testimonial-card', [
                    'name' => $testimonial['name'],
                    'role' => $testimonial['role'],
                    'text' => $testimonial['text'],
                    'rating' => $testimonial['rating'],
                ])

            @empty

                <p class="col-span-full text-center text-gray-500">
                    Belum ada testimonial.
                </p>

            @endforelse

        </div>

    </div>
</section>

@endsection