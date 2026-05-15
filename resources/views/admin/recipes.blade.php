@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Resep</h2>
            <p class="text-[#75786D] mt-2 text-sm">Kelola seluruh resep makanan aplikasi BetterEat</p>
        </div>
        <button class="bg-[#53643A] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-[#3C4C25] transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Resep Baru
        </button>
    </div>

    <div class="flex gap-4 mb-6">
        <div class="flex-grow flex gap-2">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari nama resep..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
            </div>
            <button class="bg-[#53643A] text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:bg-[#3C4C25] transition-colors shadow-sm">
                Cari
            </button>
        </div>

        <select class="pl-4 pr-10 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm font-medium text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 cursor-pointer">
            <option>Kategori</option>
            <option>Diabetes</option>
            <option>Hipertensi</option>
        </select>
        
        <select class="pl-4 pr-10 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm font-medium text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 cursor-pointer">
            <option>Status</option>
            <option>Publik</option>
            <option>Draft</option>
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-[#E5E5E5]">
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] w-10">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Nama Resep</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Kategori Diet</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Kalori</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Protein</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Status</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5E5]">
                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#F3F4F6] rounded-lg overflow-hidden shrink-0 border border-[#E5E5E5]">
                                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop" alt="Resep" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] font-bold text-[#1B1C18] leading-tight">Soto Ayam Rendah Lemak</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap gap-1">
                                <span class="px-2.5 py-1 text-[10px] font-bold text-[#53643A] bg-[#C5D8A4] rounded-full">Diabetes</span>
                                <span class="px-2.5 py-1 text-[10px] font-bold text-[#4A5565] bg-[#E5E5E5] rounded-full">Diet</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#75786D]">450 kal</td>
                        <td class="px-6 py-5 text-[14px] text-[#75786D]">25g</td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#016630] bg-[#D1D5DC] rounded-full">Publik</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <button class="flex items-center gap-1 px-3 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                                <button class="p-1.5 text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="p-1.5 text-[#DC2626] border border-[#DC2626]/20 bg-[#DC2626]/5 rounded-lg hover:bg-[#DC2626]/10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#F3F4F6] rounded-lg overflow-hidden shrink-0 border border-[#E5E5E5]">
                                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=100&h=100&fit=crop" alt="Resep" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] font-bold text-[#1B1C18] leading-tight">Gado-gado Protein Tinggi</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap gap-1">
                                <span class="px-2.5 py-1 text-[10px] font-bold text-[#854D0E] bg-[#FEF9C3] rounded-full">Hipertensi</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#75786D]">380 kal</td>
                        <td class="px-6 py-5 text-[14px] text-[#75786D]">22g</td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#016630] bg-[#D1D5DC] rounded-full">Publik</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <button class="flex items-center gap-1 px-3 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                                <button class="p-1.5 text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="p-1.5 text-[#DC2626] border border-[#DC2626]/20 bg-[#DC2626]/5 rounded-lg hover:bg-[#DC2626]/10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-[#E5E5E5] flex justify-between items-center bg-[#F9FAFB]">
            <p class="text-[12px] text-[#75786D]">Menampilkan 2 dari 120 resep</p>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-[#E5E5E5] rounded bg-white text-xs text-[#1B1C18]">Prev</button>
                <button class="px-3 py-1 border border-[#E5E5E5] rounded bg-white text-xs text-[#1B1C18]">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection