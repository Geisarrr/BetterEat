<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-md h-full flex flex-col">

    <!-- RATING -->
    <div class="flex items-center gap-1 mb-5">

        @for($i = 1; $i <= 5; $i++)
            <svg
                class="w-4 h-4 {{ $i <= ($rating ?? 5) ? 'text-[#5E6F3B]' : 'text-gray-200' }}"
                fill="currentColor"
                viewBox="0 0 20 20"
                aria-hidden="true"
            >
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor

    </div>

    <!-- TESTIMONI -->
    <p class="text-[#6B7280] text-sm leading-7 italic mb-8 flex-1">
        "{{ $text }}"
    </p>

   <!-- USER INFO -->
    <div>
        <h4 class="font-semibold text-[#1B1C18] text-sm">
            {{ $name }}
        </h4>

        @if(!empty($role))
            <p class="text-xs text-[#9CA3AF] mt-1">
                {{ $role }}
            </p>
        @endif
    </div>

</div>