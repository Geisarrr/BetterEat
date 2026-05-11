<div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 h-full flex flex-col">

    <!-- IMAGE -->
    <div class="relative h-52 overflow-hidden bg-be-light">

        @if(!empty($image))
            <img src="{{ $image }}"
                 alt="{{ $title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @endif

        <!-- TAG -->
        @if(!empty($tag))
            <span class="absolute top-3 left-3 px-3 py-1 bg-white/95 text-be-primary text-xs font-medium rounded-full shadow-sm">
                {{ $tag }}
            </span>
        @endif
    </div>

    <!-- CONTENT -->
    <div class="p-6 flex flex-col flex-1">

        <!-- TITLE -->
        <h3 class="font-heading font-bold text-2xl text-be-dark leading-tight min-h-[40px]">
            {{ $title }}
        </h3>

        <!-- INFO -->
        <div class="flex items-center gap-4 text-be-muted text-sm mt-3 mb-6">

            @if(!empty($calories))
                <span>{{ $calories }} kal</span>
            @endif

            @if(!empty($time))
                <span>{{ $time }}</span>
            @endif
        </div>

        <!-- BUTTON -->
        <a href="{{ url('/resep/' . ($slug ?? '#')) }}"
           class="mt-auto w-full bg-be-button hover:bg-[#4D7C0F] text-white text-sm font-semibold py-3 rounded-2xl text-center transition-all duration-200">
            Lihat Resep
        </a>

    </div>
</div>