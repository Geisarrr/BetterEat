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
        <p class="text-[#75786D] mt-2 text-sm">Tambahkan informasi komposisi dan nilai gizi standar TKPI ke dalam database</p>
    </div>

    <form action="#" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <div class="bg-white p-8 rounded-2xl border border-[#E5E5E5] shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-[#1B1C18] border-b border-[#E5E5E5] pb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Informasi Dasar
                </h3>

                <div>
                    <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Nama Pangan</label>
                    <input type="text" placeholder="Contoh: Dada Ayam Rebus" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-[#1B1C18] font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Kategori</label>
                        <select class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-[#1B1C18] font-medium">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="mentah">Bahan Mentah</option>
                            <option value="olahan">Olahan Matang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Takaran Saji (Unit)</label>
                        <input type="text" placeholder="Contoh: 100g / 1 porsi" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-[#1B1C18] font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Bahan Utama (Untuk Filter Pencarian)</label>
                    <input type="text" placeholder="Contoh: Ayam, Garam" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-[#1B1C18] font-medium">
                    <p class="text-[11px] text-[#75786D] mt-1.5">Pisahkan dengan koma. Contoh: Beras, Ayam, Sapi</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-[#E5E5E5] shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-[#1B1C18] border-b border-[#E5E5E5] pb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#53643A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    Kandungan Gizi (Per Takaran Saji)
                </h3>

                <div class="grid grid-cols-2 gap-6">
                    <div class="p-4 bg-[#F9FAFB] rounded-xl border border-[#E5E5E5]">
                        <label class="block text-[12px] font-bold text-[#75786D] uppercase mb-2">Kalori (kcal)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="0" class="w-full text-xl font-extrabold text-[#1B1C18] bg-transparent border-b-2 border-[#E5E5E5] focus:border-[#53643A] focus:outline-none transition-colors pb-1">
                        </div>
                    </div>

                    <div class="p-4 bg-[#F9FAFB] rounded-xl border border-[#E5E5E5]">
                        <label class="block text-[12px] font-bold text-[#75786D] uppercase mb-2">Protein (g)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="0" class="w-full text-xl font-extrabold text-[#1B1C18] bg-transparent border-b-2 border-[#E5E5E5] focus:border-[#53643A] focus:outline-none transition-colors pb-1">
                        </div>
                    </div>

                    <div class="p-4 bg-[#F9FAFB] rounded-xl border border-[#E5E5E5]">
                        <label class="block text-[12px] font-bold text-[#75786D] uppercase mb-2">Lemak (g)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="0" class="w-full text-xl font-extrabold text-[#1B1C18] bg-transparent border-b-2 border-[#E5E5E5] focus:border-[#53643A] focus:outline-none transition-colors pb-1">
                        </div>
                    </div>

                    <div class="p-4 bg-[#F9FAFB] rounded-xl border border-[#E5E5E5]">
                        <label class="block text-[12px] font-bold text-[#75786D] uppercase mb-2">Karbohidrat (g)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="0" class="w-full text-xl font-extrabold text-[#1B1C18] bg-transparent border-b-2 border-[#E5E5E5] focus:border-[#53643A] focus:outline-none transition-colors pb-1">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-end gap-4 border-t border-[#E5E5E5] pt-6">
            <a href="{{ route('admin.tkpi') }}" class="px-6 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                Simpan Data Pangan
            </button>
        </div>
    </form>

</div>
@endsection