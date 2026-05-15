@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.users') }}" class="hover:text-[#53643A] transition-colors">Manajemen User</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Detail Pengguna</span>
        </div>
        <a href="{{ route('admin.users') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Detail Pengguna</h2>
        <p class="text-[#75786D] mt-2 text-sm">Informasi lengkap profil dan statistik pengguna BetterEat</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] p-6 mb-6 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-full bg-[#C5D8A4] text-[#53643A] flex items-center justify-center text-xl font-bold border-4 border-white shadow-sm shrink-0">
                {{ strtoupper(substr($user->full_name, 0, 2)) }}
            </div>
            <div>
                <h3 class="text-xl font-bold text-[#1B1C18]">{{ $user->full_name }}</h3>
                <p class="text-[13px] text-[#75786D] mb-2">{{ $user->email }}</p>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-[11px] font-bold text-[#4A5565] bg-[#E5E5E5] rounded-md">{{ ucfirst($user->role) }}</span>
                    <span class="px-2.5 py-1 text-[11px] font-bold text-[#016630] bg-[#DCFCE7] rounded-md flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#016630]"></span>
                        Active
                    </span>
                </div>
                <div class="flex items-center gap-4 mt-3 text-[12px] text-[#75786D]">
                    <div class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Bergabung: {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <form id="deleteUserForm" action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-4 py-2 border border-[#FCA5A5] bg-[#FEF2F2] text-[#DC2626] rounded-xl text-sm font-bold hover:bg-[#FEE2E2] transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Resep Disimpan</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18] mt-2">{{ $stat_resep_disimpan }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Postingan Hub</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18] mt-2">{{ $stat_postingan }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Jurnal Kalori</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18] mt-2">{{ $stat_jurnal }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] p-8">
        <h3 class="text-lg font-bold text-[#1B1C18] mb-8 pb-4 border-b border-[#E5E5E5]">Informasi Personal & Akun</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Nama Lengkap</p>
                <p class="text-sm font-medium text-[#1B1C18]">{{ $user->full_name }}</p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Username</p>
                <p class="text-sm font-medium text-[#1B1C18]">{{ $user->username }}</p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Alamat Email</p>
                <p class="text-sm font-medium text-[#1B1C18]">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Role Akun</p>
                <p class="text-sm font-medium text-[#1B1C18]">{{ ucfirst($user->role) }}</p>
            </div>
    
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Nomor Telepon</p>
                <p class="text-sm font-medium text-[#1B1C18]">-</p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Jenis Kelamin</p>
                <p class="text-sm font-medium text-[#1B1C18]">-</p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Umur</p>
                <p class="text-sm font-medium text-[#1B1C18]">
                    {{ $user->profile->age ?? '-' }} Tahun
                </p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Berat Badan</p>
                <p class="text-sm font-medium text-[#1B1C18]">
                    {{ $user->profile->weight_kg ?? '-' }} kg
                </p>
            </div>
            <div>
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Target Kalori Harian</p>
                <p class="text-sm font-medium text-[#1B1C18]">
                    {{ $user->profile->daily_calorie_target ?? '-' }} kcal
                </p>
            </div>
            <div class="md:col-span-2">
                <p class="text-[12px] font-semibold text-[#75786D] mb-1">Kondisi Kesehatan</p>
                <p class="text-sm font-medium text-[#1B1C18] bg-[#F9FAFB] p-3 rounded-lg border border-[#E5E5E5] mt-1">
                    {{ $user->profile->health_condition ?? 'Tidak ada riwayat kondisi kesehatan spesifik.' }}
                </p>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center backdrop-blur-sm transition-all">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full mx-4 shadow-2xl transform scale-100">
        
        <div class="w-14 h-14 rounded-full bg-[#FEF2F2] flex items-center justify-center mb-5 mx-auto border-4 border-white shadow-sm">
            <svg class="w-6 h-6 text-[#DC2626]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </div>
        
        <h3 class="text-xl font-bold text-center text-[#1B1C18] mb-2">Hapus Pengguna?</h3>
        <p class="text-sm text-center text-[#75786D] mb-6 leading-relaxed">
            Tindakan ini tidak dapat dibatalkan. Semua data terkait pengguna ini akan terhapus secara permanen dari sistem.
        </p>
        
        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="flex-1 px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">
                Batal
            </button>
            <button type="button" onclick="document.getElementById('deleteUserForm').submit()" class="flex-1 px-4 py-2.5 bg-[#DC2626] text-white rounded-xl text-sm font-bold hover:bg-[#B91C1C] transition-colors shadow-sm">
                Ya, Hapus
            </button>
        </div>

    </div>
</div>
@endsection