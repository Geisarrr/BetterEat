@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Resep</h2>
            <p class="text-[#75786D] mt-2 text-sm">Kelola seluruh resep makanan aplikasi BetterEat</p>
        </div>
        <a href="{{ route('admin.recipes.create') }}" class="bg-[#53643A] text-white px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-[#3C4C25] transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Resep Baru
        </a>
    </div>

    <form action="{{ route('admin.recipes') }}" method="GET" class="mb-6 flex flex-col md:flex-row items-center gap-4 bg-white p-4 rounded-2xl border border-[#E5E5E5] shadow-sm">

        <div class="relative w-full md:flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama resep..." class="w-full pl-10 pr-4 py-2 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
        </div>

        <div class="flex gap-3 w-full md:w-auto shrink-0">
            <select name="category" onchange="this.form.submit()" class="pl-4 pr-10 py-2 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all text-[#4A5565] font-medium cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
    
            <button type="submit" class="px-6 py-2 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm shrink-0">
                Cari
            </button>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        <div class="overflow-x-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#E5E5E5] text-[#1B1C18] bg-[#F9FAFB]">
                            <th class="px-6 py-4 text-[13px] font-bold">Nama Resep</th>
                            <th class="px-6 py-4 text-[13px] font-bold">Kategori Dasar</th>
                            <th class="px-6 py-4 text-[13px] font-bold text-center">Kalori</th>
                            <th class="px-6 py-4 text-[13px] font-bold">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                        @forelse($recipes as $recipe)
                        <tr class="border-b border-[#E5E5E5] hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden border border-[#E5E5E5] shrink-0 bg-gray-100">
                                        <img src="{{ $recipe->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($recipe->name).'&background=F3F4F6&color=53643A' }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-sm font-bold text-[#1B1C18]">{{ $recipe->name }}</span>
                                </div>
                            </td>
                
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[11px] font-bold text-[#53643A] bg-[#C5D8A4]/30 rounded-full">
                                    {{ $recipe->category ?? 'General' }}
                                </span>
                            </td>
                
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-[#1B1C18]">{{ round($recipe->calories) }} <span class="text-xs font-normal text-[#75786D]">kal</span></span>
                            </td>
                
                            <td class="px-6 py-4 flex items-center gap-2 pt-6">
                                <a href="{{ route('admin.recipes.detail', ['id' => $recipe->recipe_id]) }}" class="flex items-center gap-1.5 px-3 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-white bg-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    Detail
                                </a>
                    
                                <button type="button" 
                                    data-url="{{ route('admin.recipes.destroy', $recipe->recipe_id) }}"
                                    data-name="{{ $recipe->name }}"
                                    onclick="openDeleteModal(this.dataset.url, this.dataset.name)"
                                    class="p-1.5 text-[#DC2626] bg-[#FEF2F2] rounded-lg hover:bg-[#FCA5A5]/30 transition-colors border border-[#FCA5A5]/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm text-[#75786D] font-medium">Tidak ada resep yang ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-8 py-4 border-t border-[#E5E5E5] bg-[#F9FAFB]">
                    {{ $recipes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="globalDeleteForm" method="POST" class="hidden">
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
            Anda yakin ingin menghapus <b id="recipeNameToDelete"></b>?
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
            <button type="button" onclick="document.getElementById('globalDeleteForm').submit()" class="flex-1 px-4 py-2.5 bg-[#DC2626] text-white rounded-xl text-sm font-bold hover:bg-[#B91C1C] transition-colors shadow-sm">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(url, recipeName) {
        document.getElementById('globalDeleteForm').action = url;
        document.getElementById('recipeNameToDelete').innerText = recipeName;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection