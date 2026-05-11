<div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm group cursor-pointer">

    <!-- ICON CONTAINER -->
    <div class="w-12 h-12 rounded-xl bg-be-light flex items-center justify-center mb-5 group-hover:bg-be-highlight transition-colors duration-300">
        <svg class="w-6 h-6 text-be-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $icon !!}
        </svg>
    </div>

    <!-- TITLE -->
    <h3 class="font-heading font-semibold text-be-dark text-xl mb-4">{{ $title }}</h3>

    <!-- DESCRIPTION -->
    <p class="text-be-muted text-sm leading-relaxed mb-5">{{ $description }}</p>

    <!-- CTA -->
    <a href="{{ $link ?? '#' }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-white hover:gap-2.5 transition-all py-3 px-6 rounded-xl bg-be-button duration-200">
        Coba Sekarang
    </a>
</div>