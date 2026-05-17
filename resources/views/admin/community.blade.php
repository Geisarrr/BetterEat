@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Community Hub</h2>
        <p class="text-[#75786D] mt-2 text-sm">Pantau diskusi, postingan, dan kelola laporan moderasi dari komunitas BetterEat</p>
    </div>

    <form action="{{ route('admin.community') }}" method="GET" class="mb-6 flex flex-col md:flex-row items-center gap-4 bg-white p-4 rounded-2xl border border-[#E5E5E5] shadow-sm">
    
        <div class="relative w-full md:flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul postingan atau nama penulis..." class="w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
        </div>

        <div class="flex flex-wrap md:flex-nowrap gap-3 w-full md:w-auto shrink-0">
            
            <select name="category" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm text-[#4A5565] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all cursor-pointer focus:bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm text-[#4A5565] focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all cursor-pointer focus:bg-white">
                <option value="">Status Moderasi</option>
                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                <option value="dilaporkan" {{ request('status') == 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
            </select>

            <button type="submit" class="px-6 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                Cari
            </button>
            
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-[#E5E5E5]">
                        <th class="px-6 py-4 text-left w-12">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)" class="w-4 h-4 text-[#53643A] bg-[#F9FAFB] border-[#E5E5E5] rounded focus:ring-[#53643A]/20 cursor-pointer">
                            </div>
                        </th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Penulis</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Judul Postingan</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Kategori</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Tanggal</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Status</th>
                        <th class="px-6 py-4 text-[13px] font-bold text-[#1B1C18]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr class="border-b border-[#E5E5E5] hover:bg-gray-50 transition-colors">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="row-checkbox w-4 h-4 text-[#53643A] bg-[#F9FAFB] border-[#E5E5E5] rounded focus:ring-[#53643A]/20 cursor-pointer" value="{{ $post->post_id }}">
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#E8F5E9] flex items-center justify-center text-[#2E7D32] font-bold text-sm shrink-0">
                                    {{ substr($post->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#1B1C18]">{{ $post->user->full_name ?? $post->user->name ?? 'Pengguna Tidak Dikenal' }}</p>
                                    <p class="text-[11px] text-[#75786D]">{{ $post->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-[#1B1C18]">{{ Str::limit($post->title, 40) }}</p>
                        </td>
                        
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#4A5565] bg-[#F3F4F6] rounded-md border border-[#E5E5E5]">
                                {{ $post->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-sm text-[#4A5565]">
                            {{ $post->created_at ? $post->created_at->format('d M Y') : '-' }}
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($post->is_moderated == 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#E8F5E9] text-[#2E7D32]">
                                    <div class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></div>
                                    Aman
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#FEF2F2] text-[#DC2626]">
                                    <div class="w-1.5 h-1.5 rounded-full bg-[#DC2626]"></div>
                                    Dilaporkan
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 flex items-center gap-2">
                            <a href="{{ route('admin.community.detail', $post->post_id) }}" class="p-2 text-[#53643A] bg-white border border-[#E5E5E5] rounded-lg hover:bg-gray-50 transition-colors" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>

                            <button type="button" onclick="openDeleteModal('{{ route('admin.community.destroy', $post->post_id) }}', '{{ addslashes(Str::limit($post->title, 30)) }}')" class="p-2 text-[#DC2626] bg-[#FEF2F2] border border-[#FCA5A5]/50 rounded-lg hover:bg-[#FCA5A5]/30 transition-colors" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-[#75786D] text-sm">Tidak ada postingan yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-4 border-t border-[#E5E5E5] bg-[#F9FAFB]">
            {{ $posts->links() }}
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
                        <h3 class="text-lg font-bold text-[#1B1C18]">Hapus Postingan</h3>
                        <div class="mt-2">
                            <p class="text-sm text-[#75786D]">Apakah Anda yakin ingin menghapus postingan <span id="deleteItemTitle" class="font-bold text-[#1B1C18]"></span> beserta fotonya? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-4 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#E5E5E5]">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2.5 text-base font-bold text-white bg-[#DC2626] border border-transparent rounded-xl shadow-sm hover:bg-[#B91C1C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#DC2626] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Ya, Hapus Postingan
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
    function openDeleteModal(actionUrl, itemTitle) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteItemTitle').innerText = '"' + itemTitle + '"';
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

<script>
    // Fungsi untuk Select All Checkbox
    function toggleCheckboxes(source) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
        });
    }
</script>
@endsection