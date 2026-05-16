@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.tkpi') }}" class="hover:text-[#53643A] transition-colors">Manajemen TKPI</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Tambah Data Pangan</span>
        </div>
        <a href="{{ route('admin.tkpi') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Tambah Data Pangan Baru</h2>
        <p class="text-[#75786D] mt-2 text-sm">Tambahkan informasi komposisi dan nilai gizi standar TKPI (Per 100 gram) ke dalam database</p>
    </div>

    <form action="{{ route('admin.tkpi.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                    <h3 class="text-[15px] font-bold text-[#1B1C18] mb-5 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Informasi Dasar
                    </h3>
                    
                    <div>
                        <label class="block text-[13px] font-bold text-[#1B1C18] mb-2">Nama Pangan</label>
                        <input type="text" name="food_name" placeholder="Contoh: Dada Ayam Rebus" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        <p class="text-[11px] text-[#75786D] mt-2">*Nama ini akan digunakan untuk pencocokan otomatis pada bahan resep.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                    <h3 class="text-[15px] font-bold text-[#1B1C18] mb-5 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        Kandungan Gizi (Per 100 Gram)
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Kalori (kcal)</label>
                            <input type="number" step="0.01" name="calories_per_100g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Protein (g)</label>
                            <input type="number" step="0.01" name="protein_g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Lemak (g)</label>
                            <input type="number" step="0.01" name="fat_g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Karbohidrat (g)</label>
                            <input type="number" step="0.01" name="carbs_g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Gula (g)</label>
                            <input type="number" step="0.01" name="sugar_g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-2">Serat (g)</label>
                            <input type="number" step="0.01" name="fiber_g" value="0" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-lg font-bold text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <a href="{{ route('admin.tkpi') }}" class="px-8 py-3 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                        Simpan Data Pangan
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection