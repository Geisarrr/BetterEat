<div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm group">

    <div class="relative h-44 overflow-hidden bg-be-light">
        @if(!empty($image))
            <img src="{{ $image }}" alt="{{ $title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                 loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-be-highlight" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        @endif

        @if(!empty($category))
            <span class="absolute top-3 left-3 px-2.5 py-1 bg-be-primary text-white text-xs font-medium rounded-full">
                {{ $category }}
            </span>
        @endif
    </div>

    <div class="p-5">
        @if(!empty($date))
            <p class="text-be-muted text-xs mb-1.5">{{ $date }}</p>
        @endif

        <h3 class="font-heading font-semibold text-be-dark text-sm leading-snug mb-2 line-clamp-2">
            {{ $title }}
        </h3>

        <p class="text-be-muted text-xs leading-relaxed mb-4 line-clamp-3">
            {{ $preview }}
        </p>

        <a href="{{ url('/artikel/' . ($slug ?? '#')) }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-be-primary hover:underline">
            Baca Selengkapnya
        </a>
    </div>
</div>