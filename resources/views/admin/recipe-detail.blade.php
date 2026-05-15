@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.recipes') }}" class="hover:text-[#53643A] transition-colors">Manajemen Resep</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Detail Resep</span>
        </div>
        <a href="{{ route('admin.recipes') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-[#1B1C18]">Detail Resep</h2>
            <p class="text-[#75786D] mt-2 text-sm">Informasi lengkap, bahan, dan langkah pembuatan resep</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.recipes.edit', $recipe->recipe_id) }}" class="px-5 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-semibold hover:bg-[#3C4C25] transition-colors flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit Resep
            </a>
            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-5 py-2.5 bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] rounded-xl text-sm font-semibold hover:bg-[#FEE2E2] transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <div class="rounded-2xl overflow-hidden mb-6 h-72 bg-gray-100 border border-[#E5E5E5]">
                    <img src="{{ $recipe->image_url ? asset($recipe->image_url) : 'https://ui-avatars.com/api/?name='.urlencode($recipe->name).'&background=F3F4F6&color=53643A' }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                </div>
                
                <h2 class="text-2xl font-bold text-[#1B1C18] mb-3">{{ $recipe->name }}</h2>
                
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-3 py-1 text-[11px] font-bold text-[#016630] bg-[#DCFCE7] rounded-full">
                        {{ $recipe->category ?? 'General' }}
                    </span>
                </div>
                
                <div class="py-4 border-t border-[#E5E5E5] text-center">
                    <p class="text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-1">Kalori</p>
                    <p class="text-xl font-extrabold text-[#1B1C18]">{{ round($recipe->calories) }} <span class="text-sm font-medium text-[#75786D]">kal</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-sm font-bold text-[#1B1C18] mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#75786D]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Informasi Tambahan
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[11px] font-semibold text-[#75786D] mb-1">Dibuat Oleh</p>
                        <p class="text-sm font-medium text-[#1B1C18]">Admin BetterEat</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-[#75786D] mb-1">Terakhir Diperbarui</p>
                        <p class="text-sm font-medium text-[#1B1C18]">{{ $recipe->updated_at ? $recipe->updated_at->translatedFormat('d F Y, H:i') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-[15px] font-bold text-[#1B1C18] mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Bahan-bahan (Ingredients)
                </h3>
                
                <div class="space-y-3">
                    @if($recipe->ingredients)
                        @foreach(explode("\n", $recipe->ingredients) as $index => $ingredient)
                            @if(trim($ingredient) != '')
                            <div class="flex items-center gap-3 p-3 bg-[#F9FAFB] rounded-xl border border-[#E5E5E5]">
                                <div class="w-6 h-6 rounded-full bg-[#C5D8A4]/40 text-[#53643A] flex items-center justify-center text-[10px] font-bold shrink-0">{{ $index + 1 }}</div>
                                <p class="text-sm text-[#4A5565]">{{ $ingredient }}</p>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-sm text-[#75786D] italic">Belum ada data bahan.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-[15px] font-bold text-[#1B1C18] mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    Langkah Pembuatan
                </h3>
                
                <div class="space-y-4">
                    @if($recipe->cooking_steps)
                        @foreach(explode("\n", $recipe->cooking_steps) as $index => $step)
                            @if(trim($step) != '')
                            <div class="flex gap-4">
                                <div class="w-7 h-7 rounded-full bg-[#53643A] text-white flex items-center justify-center text-[11px] font-bold shrink-0 mt-0.5">{{ $index + 1 }}</div>
                                <p class="text-sm text-[#4A5565] leading-relaxed pt-1">{{ $step }}</p>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-sm text-[#75786D] italic">Belum ada langkah pembuatan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form id="deleteRecipeForm" action="{{ route('admin.recipes.destroy', $recipe->recipe_id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full mx-4 shadow-2xl transform scale-100">
        <div class="w-14 h-14 rounded-full bg-[#FEF2F2] flex items-center justify-center mb-5 mx-auto border-4 border-white shadow-sm">
            <svg class="w-6 h-6 text-[#DC2626]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </div>
        <h3 class="text-xl font-bold text-center text-[#1B1C18] mb-2">Hapus Resep?</h3>
        <p class="text-sm text-center text-[#75786D] mb-6 leading-relaxed">
            Tindakan ini tidak dapat dibatalkan. Resep <b>{{ $recipe->name }}</b> akan terhapus secara permanen.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="flex-1 px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
            <button type="button" onclick="document.getElementById('deleteRecipeForm').submit()" class="flex-1 px-4 py-2.5 bg-[#DC2626] text-white rounded-xl text-sm font-bold hover:bg-[#B91C1C] transition-colors shadow-sm">Ya, Hapus</button>
        </div>
    </div>
</div>
@endsection