@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.recipes') }}" class="hover:text-[#53643A] transition-colors">Manajemen Resep</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Tambah Resep Baru</span>
        </div>
        <a href="{{ route('admin.recipes') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Tambah Resep Baru</h2>
        <p class="text-[#75786D] mt-2 text-sm">Masukkan informasi detail, bahan, dan langkah memasak</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
                    <label class="block text-[13px] font-semibold text-[#75786D] mb-3">Foto Resep</label>
                    <div class="w-full aspect-square rounded-xl border-2 border-dashed border-[#E5E5E5] bg-[#F9FAFB] flex flex-col items-center justify-center hover:bg-gray-50 transition-colors cursor-pointer group">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform text-[#53643A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="text-sm font-semibold text-[#1B1C18]">Klik untuk unggah foto</p>
                        <p class="text-xs text-[#75786D] mt-1">PNG, JPG up to 5MB</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm space-y-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Nama Resep</label>
                        <input type="text" placeholder="Contoh: Soto Ayam Rendah Lemak" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                    </div>
                    
                    <div>
                        <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Kategori Diet</label>
                        <select class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                            <option value="">Pilih Kategori</option>
                            <option value="diabetes">Diabetes</option>
                            <option value="hipertensi">Hipertensi</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Kalori (kal)</label>
                            <input type="number" placeholder="0" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Protein (g)</label>
                            <input type="number" placeholder="0" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-[#75786D] mb-1.5">Status Publikasi</label>
                        <select class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                            <option value="publik">Publik</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-[#1B1C18]">Bahan-bahan</h3>
                        <button type="button" class="text-xs font-bold text-[#53643A] hover:text-[#3C4C25] bg-[#C5D8A4]/30 px-3 py-1.5 rounded-lg transition-colors">
                            + Tambah Baris
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="text" placeholder="Contoh: 250g Dada Ayam Fillet" class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                            <button type="button" class="p-2.5 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="text" placeholder="Bahan selanjutnya..." class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                            <button type="button" class="p-2.5 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-[#1B1C18]">Langkah Pembuatan</h3>
                        <button type="button" class="text-xs font-bold text-[#53643A] hover:text-[#3C4C25] bg-[#C5D8A4]/30 px-3 py-1.5 rounded-lg transition-colors">
                            + Tambah Langkah
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-1">1</div>
                            <textarea rows="2" placeholder="Jelaskan langkah pertama..." class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white resize-none"></textarea>
                            <button type="button" class="h-10 w-10 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0 flex items-center justify-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-1">2</div>
                            <textarea rows="2" placeholder="Langkah selanjutnya..." class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white resize-none"></textarea>
                            <button type="button" class="h-10 w-10 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0 flex items-center justify-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-4 border-t border-[#E5E5E5] pt-6">
            <a href="{{ route('admin.recipes') }}" class="px-6 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                Simpan Resep Baru
            </button>
        </div>
    </form>

</div>
@endsection