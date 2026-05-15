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
            <button class="px-5 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-semibold hover:bg-[#3C4C25] transition-colors flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit Resep
            </button>
            <button class="px-5 py-2.5 bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] rounded-xl text-sm font-semibold hover:bg-[#FEE2E2] transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-4 rounded-2xl border border-[#E5E5E5] shadow-sm">
                <div class="aspect-square rounded-xl overflow-hidden mb-4 border border-[#F3F4F6]">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&h=500&fit=crop" class="w-full h-full object-cover" alt="Soto Ayam">
                </div>
                <h3 class="text-xl font-bold text-[#1B1C18] mb-1">Soto Ayam Rendah Lemak</h3>
                <div class="flex gap-2 mb-4">
                    <span class="px-2.5 py-1 text-[10px] font-bold text-[#53643A] bg-[#C5D8A4] rounded-full">Diabetes</span>
                    <span class="px-2.5 py-1 text-[10px] font-bold text-[#4A5565] bg-[#E5E5E5] rounded-full">Diet</span>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-[#F3F4F6]">
                    <div class="text-center">
                        <p class="text-[11px] font-bold text-[#75786D] uppercase">Kalori</p>
                        <p class="text-lg font-extrabold text-[#1B1C18]">450 <span class="text-xs font-medium">kal</span></p>
                    </div>
                    <div class="text-center border-l border-[#F3F4F6]">
                        <p class="text-[11px] font-bold text-[#75786D] uppercase">Protein</p>
                        <p class="text-lg font-extrabold text-[#1B1C18]">25 <span class="text-xs font-medium">g</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
                <h4 class="text-sm font-bold text-[#1B1C18] mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Informasi Tambahan
                </h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-[12px] text-[#75786D] mb-1">Status Publikasi</p>
                        <span class="px-3 py-1 text-[11px] font-bold text-[#016630] bg-[#DCFCE7] rounded-full">Publik</span>
                    </div>
                    <div>
                        <p class="text-[12px] text-[#75786D] mb-1">Dibuat Oleh</p>
                        <p class="text-sm font-bold text-[#1B1C18]">Admin - BetterEat Team</p>
                    </div>
                    <div>
                        <p class="text-[12px] text-[#75786D] mb-1">Terakhir Diperbarui</p>
                        <p class="text-sm font-medium text-[#1B1C18]">15 Mei 2026, 14:20</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] p-8">
                <h3 class="text-lg font-bold text-[#1B1C18] mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Bahan-bahan (Ingredients)
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-[#4A5565] text-sm bg-[#F9FAFB] p-3 rounded-xl border border-[#F3F4F6]">
                        <span class="w-6 h-6 bg-[#C5D8A4] text-[#53643A] rounded-full flex items-center justify-center text-[10px] font-bold">1</span>
                        250g Dada Ayam Fillet, rebus dan suwir
                    </li>
                    <li class="flex items-center gap-3 text-[#4A5565] text-sm bg-[#F9FAFB] p-3 rounded-xl border border-[#F3F4F6]">
                        <span class="w-6 h-6 bg-[#C5D8A4] text-[#53643A] rounded-full flex items-center justify-center text-[10px] font-bold">2</span>
                        1.5 Liter Kuah Kaldu Ayam Rendah Lemak
                    </li>
                    <li class="flex items-center gap-3 text-[#4A5565] text-sm bg-[#F9FAFB] p-3 rounded-xl border border-[#F3F4F6]">
                        <span class="w-6 h-6 bg-[#C5D8A4] text-[#53643A] rounded-full flex items-center justify-center text-[10px] font-bold">3</span>
                        Bumbu halus: Bawang merah, putih, kunyit, jahe (sangrai)
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] p-8">
                <h3 class="text-lg font-bold text-[#1B1C18] mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    Langkah Pembuatan
                </h3>
                <div class="space-y-6 relative before:absolute before:left-4 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#E5E5E5]">
                    <div class="relative pl-10">
                        <span class="absolute left-0 top-0 w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-white">1</span>
                        <p class="text-sm text-[#4A5565] leading-relaxed">Tumis bumbu halus dengan sedikit olive oil hingga harum dan matang sempurna.</p>
                    </div>
                    <div class="relative pl-10">
                        <span class="absolute left-0 top-0 w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-white">2</span>
                        <p class="text-sm text-[#4A5565] leading-relaxed">Masukkan kaldu ayam, didihkan, lalu masukkan suwiran ayam dan koreksi rasa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection