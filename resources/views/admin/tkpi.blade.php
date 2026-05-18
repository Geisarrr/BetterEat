@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Tabel Komposisi Pangan</h2>
            <p class="text-[#75786D] mt-2 text-sm">Kelola database nutrisi bahan dan olahan makanan nusantara</p>
        </div>
        <a href="{{ route('admin.tkpi.create') }}" class="px-5 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm flex items-center gap-2 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Data Pangan
        </a>
    </div>

    <form action="{{ route('admin.tkpi') }}" method="GET" class="mb-6 flex flex-col md:flex-row items-center gap-4 bg-white p-4 rounded-2xl border border-[#E5E5E5] shadow-sm">
        <div class="relative w-full md:flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama makanan/bahan pangan..." class="w-full pl-10 pr-4 py-2 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
        </div>

        <div class="flex gap-3 w-full md:w-auto shrink-0">
            <button type="submit" class="px-8 py-2 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                Cari
            </button>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[#E5E5E5] text-[#1B1C18] bg-[#F9FAFB]">
                    <th class="px-6 py-4 text-[13px] font-bold">Nama Pangan</th>
                    <th class="px-6 py-4 text-[13px] font-bold">Takaran Saji</th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Kalori <span class="font-normal text-[#75786D] text-[11px]">(kal)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Protein <span class="font-normal text-[#75786D] text-[11px]">(g)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Lemak <span class="font-normal text-[#75786D] text-[11px]">(g)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Karbohidrat <span class="font-normal text-[#75786D] text-[11px]">(g)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Gula <span class="font-normal text-[#75786D] text-[11px]">(g)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Serat <span class="font-normal text-[#75786D] text-[11px]">(g)</span></th>
                    <th class="px-6 py-4 text-[13px] font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($foods as $food)
                <tr class="border-b border-[#E5E5E5] hover:bg-gray-50 transition-colors">

                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-[#1B1C18]">{{ $food->food_name }}</span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-[12px] font-medium text-[#4A5565] bg-[#F3F4F6] rounded-md">100g</span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-semibold text-[#1B1C18]">{{ round($food->calories_per_100g) }}</span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-[#4A5565]">{{ round($food->protein_g, 1) }}</span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-[#4A5565]">{{ round($food->fat_g, 1) }}</span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-[#4A5565]">{{ round($food->carbs_g, 1) }}</span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-[#4A5565]">{{ round($food->sugar_g ?? 0, 1) }}</span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-[#4A5565]">{{ round($food->fiber_g ?? 0, 1) }}</span>
                    </td>
                    
                    <td class="px-6 py-4 flex items-center justify-center gap-2">
                        <a href="{{ route('admin.tkpi.edit', $food->food_id) }}" class="px-3 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-white bg-white transition-colors flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Edit
                        </a>
                        
                        <button type="button" onclick="openDeleteModal('{{ route('admin.tkpi.destroy', $food->food_id) }}', '{{ addslashes($food->food_name) }}')" class="px-3 py-1.5 text-[#DC2626] bg-[#FEF2F2] rounded-lg hover:bg-[#FCA5A5]/30 transition-colors border border-[#FCA5A5]/50 flex items-center gap-1.5 text-[12px] font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <p class="text-sm text-[#75786D] font-medium">Tidak ada data pangan yang ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-8 py-4 border-t border-[#E5E5E5] bg-[#F9FAFB]">
            {{ $foods->links() }}
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-[#E5E5E5]">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-[#FEF2F2] rounded-full sm:mx-0 sm:h-10 sm:w-10 border border-[#FCA5A5]/50">
                        <svg class="w-5 h-5 text-[#DC2626]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-bold text-[#1B1C18]" id="modal-title">Hapus Data Pangan</h3>
                        <div class="mt-2">
                            <p class="text-sm text-[#75786D]">Apakah Anda yakin ingin menghapus bahan <span id="deleteItemName" class="font-bold text-[#1B1C18]"></span>? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-4 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#E5E5E5]">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2.5 text-base font-bold text-white bg-[#DC2626] border border-transparent rounded-xl shadow-sm hover:bg-[#B91C1C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#DC2626] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Ya, Hapus Data
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="inline-flex justify-center w-full px-4 py-2.5 mt-3 text-base font-bold text-[#1B1C18] bg-white border border-[#E5E5E5] rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#53643A] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, itemName) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteItemName').innerText = itemName;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection