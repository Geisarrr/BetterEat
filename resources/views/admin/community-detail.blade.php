@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.community') }}" class="hover:text-[#53643A] transition-colors">Manajemen Community Hub</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Detail Postingan</span>
        </div>
        <a href="{{ route('admin.community') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white border border-[#E5E5E5] rounded-3xl shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-[#E5E5E5] flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#E8F5E9] flex items-center justify-center text-[#2E7D32] font-bold text-lg">
                    {{ substr($post->user->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <p class="text-base font-bold text-[#1B1C18]">{{ $post->user->name ?? 'Pengguna Tidak Dikenal' }}</p>
                    <p class="text-[12px] text-[#75786D]">{{ $post->created_at ? $post->created_at->format('d M Y, H:i') : '-' }}</p>
                </div>
            </div>
            
            <span class="px-3 py-1 text-[11px] font-bold text-[#4A5565] bg-[#F3F4F6] rounded-md border border-[#E5E5E5]">
                Kategori: {{ $post->category->name ?? 'Umum' }}
            </span>
        </div>

        <div class="p-6 space-y-4">
            <h2 class="text-xl font-bold text-[#1B1C18]">{{ $post->title }}</h2>
            <p class="text-[15px] text-[#4A5565] leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
            
            @if($post->image_url)
                <div class="mt-4 rounded-2xl overflow-hidden border border-[#E5E5E5]">
                    <img src="{{ asset($post->image_url) }}" alt="Foto Postingan" class="w-full h-auto object-cover max-h-[500px]">
                </div>
            @endif
        </div>

        <div class="p-6 bg-[#F9FAFB] border-t border-[#E5E5E5] flex items-center justify-between">
            <div class="text-sm font-bold text-[#75786D] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                {{ $post->comments->count() }} Komentar
            </div>
            
            <button type="button" onclick="openDeleteModal('{{ route('admin.community.destroy', $post->post_id) }}', '{{ addslashes(Str::limit($post->title, 30)) }}')" class="p-2 text-[#DC2626] bg-[#FEF2F2] border border-[#FCA5A5]/50 rounded-lg hover:bg-[#FCA5A5]/30 transition-colors" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
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
@endsection