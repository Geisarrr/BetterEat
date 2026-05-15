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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Detail Postingan Komunitas</h2>
        <p class="text-[#75786D] mt-2 text-sm">Tinjau konten, laporan pengguna, dan ambil tindakan moderasi</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
                
                <div class="p-6 border-b border-[#E5E5E5] flex items-center justify-between bg-[#F9FAFB]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=F3F4F6&color=53643A" alt="Budi Santoso" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-[15px] font-bold text-[#1B1C18]">Budi Santoso</h3>
                            <p class="text-[13px] text-[#75786D]">budi.s@spammer.com • 14 Mei 2026, 09:15 WIB</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-[11px] font-bold text-[#4A5565] bg-[#E5E5E5] rounded-md">Tips Nutrisi</span>
                </div>

                <div class="p-6">
                    <h4 class="text-lg font-bold text-[#1B1C18] mb-3">Jual obat kurus herbal turun 10kg seminggu!</h4>
                    <p class="text-[15px] text-[#4A5565] leading-relaxed mb-6">
                        Bagi teman-teman yang kesulitan menurunkan berat badan, saya punya solusinya! Obat herbal ini dijamin bisa menurunkan berat badan 10kg hanya dalam waktu satu minggu tanpa perlu repot diet defisit kalori atau olahraga berat. Sudah terbukti! Silakan hubungi nomor WA di profil saya untuk pemesanan, stok terbatas!
                    </p>
                    
                    <div class="w-full rounded-xl overflow-hidden border border-[#E5E5E5] bg-[#F9FAFB] mb-6 aspect-video relative">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800&h=450&fit=crop" class="w-full h-full object-cover" alt="Foto Postingan">
                    </div>

                    <div class="flex items-center gap-6 pt-4 border-t border-[#E5E5E5]">
                        <div class="flex items-center gap-2 text-[#75786D]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                            <span class="text-sm font-semibold">12</span>
                        </div>
                        <div class="flex items-center gap-2 text-[#75786D]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                            <span class="text-sm font-semibold">45</span>
                        </div>
                        <div class="flex items-center gap-2 text-[#75786D]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            <span class="text-sm font-semibold">8</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl border border-[#DC2626] shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-[#DC2626]"></div>
                <h3 class="text-lg font-bold text-[#1B1C18] mb-4">Status Moderasi</h3>
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1.5 text-[12px] font-bold text-[#DC2626] bg-[#FEE2E2] rounded-full flex items-center gap-1.5 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Dilaporkan
                    </span>
                </div>
                
                <div class="space-y-3 pt-4 border-t border-[#E5E5E5]">
                    <p class="text-[13px] font-semibold text-[#1B1C18]">Rincian Laporan (3 Pengguna):</p>
                    <ul class="text-[13px] text-[#4A5565] space-y-2">
                        <li class="flex gap-2">
                            <span class="text-[#DC2626]">•</span>
                            <span>Promosi terselubung / Spam (2)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-[#DC2626]">•</span>
                            <span>Klaim kesehatan yang menyesatkan (1)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-lg font-bold text-[#1B1C18] mb-4">Aksi Admin</h3>
                <div class="space-y-3">
                    <button class="w-full px-4 py-2.5 bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] rounded-xl text-sm font-bold hover:bg-[#FEE2E2] transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Hapus Postingan
                    </button>
                    <button class="w-full px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#854D0E]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Beri Peringatan Akun
                    </button>
                    <button class="w-full px-4 py-2.5 bg-[#DCFCE7] border border-[#A7F3D0] text-[#016630] rounded-xl text-sm font-bold hover:bg-[#D1FAE5] transition-colors flex items-center justify-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Abaikan & Tandai Aman
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection