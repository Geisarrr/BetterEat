@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Tabel Komposisi Pangan</h2>
        <p class="text-[#75786D] mt-2 text-sm">Kelola database nutrisi bahan dan olahan makanan nusantara</p>
    </div>

    <div class="flex gap-4 mb-6">
        <div class="flex-grow flex gap-2">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari nama makanan/bahan..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
            </div>
            <button class="bg-[#53643A] text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:bg-[#3C4C25] transition-colors shadow-sm">
                Cari
            </button>
        </div>

        <select class="pl-4 pr-10 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm font-medium text-[#1B1C18] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 cursor-pointer w-48 shrink-0">
            <option>Kategori</option>
            <option>Bahan Mentah</option>
            <option>Olahan Matang</option>
        </select>

        <a href="{{ route('admin.tkpi.create') }}" class="bg-[#53643A] text-white px-5 py-2.5 rounded-xl font-medium text-sm flex items-center gap-2 hover:bg-[#3C4C25] transition-colors shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data Pangan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-[#E5E5E5]">
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] w-10">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] w-[25%]">Nama Pangan</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Takaran saji (Unit)</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] text-center">Kalori<br><span class="font-normal text-[11px]">(kcal)</span></th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] text-center">Protein<br><span class="font-normal text-[11px]">(g)</span></th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] text-center">Lemak<br><span class="font-normal text-[11px]">(g)</span></th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] text-center">Karbohidrat<br><span class="font-normal text-[11px]">(g)</span></th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5E5]">
                    
                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[14px] font-medium text-[#1B1C18]">Sate Ayam Bumbu Kacang</span>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#4A5565]">
                            1 porsi (5 tusuk)
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">285</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">15</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">12</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">20</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.tkpi.edit') }}" class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#4A5565] border border-[#E5E5E5] rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[14px] font-medium text-[#1B1C18]">Nasi Goreng Kambing</span>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#4A5565]">
                            1 porsi (250g)
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">420</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">18</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">16</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">52</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#4A5565] border border-[#E5E5E5] rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </button>
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[14px] font-medium text-[#1B1C18]">Rendang Daging Sapi</span>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#4A5565]">
                            1 porsi (150g)
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">340</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">22</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">24</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">8</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#4A5565] border border-[#E5E5E5] rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </button>
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-6 py-5">
                            <input type="checkbox" class="rounded border-[#E5E5E5] text-[#53643A] focus:ring-[#53643A]">
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[14px] font-medium text-[#1B1C18]">Gado-Gado dengan Lontong</span>
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#4A5565]">
                            1 porsi
                        </td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">310</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">12</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">18</td>
                        <td class="px-6 py-5 text-[14px] text-[#1B1C18] text-center">28</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#4A5565] border border-[#E5E5E5] rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </button>
                                <button class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-[#E5E5E5] flex justify-between items-center bg-[#F9FAFB]">
            <p class="text-[12px] text-[#75786D]">Menampilkan 4 dari 320 data pangan</p>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-[#E5E5E5] rounded bg-white text-xs text-[#1B1C18]">Prev</button>
                <button class="px-3 py-1 border border-[#E5E5E5] rounded bg-white text-xs text-[#1B1C18]">Next</button>
            </div>
        </div>
    </div>

</div>
@endsection