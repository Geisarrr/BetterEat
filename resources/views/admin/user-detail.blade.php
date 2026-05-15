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
            <div class="w-20 h-20 rounded-full bg-[#C5D8A4] text-[#53643A] flex items-center justify-center text-2xl font-bold shrink-0 border-2 border-[#E5E5E5]">
                AS
            </div>
            <div>
                <h3 class="text-xl font-bold text-[#1B1C18] tracking-tight">Aditya Santoso</h3>
                <p class="text-sm text-[#75786D] mb-2.5">aditya.santoso@email.com</p>
                
                <div class="flex items-center gap-2 mb-2.5">
                    <span class="px-3 py-1 text-[11px] font-bold text-[#53643A] bg-[#53643A]/10 rounded-full">User</span>
                    <span class="px-3 py-1 text-[11px] font-bold text-[#016630] bg-[#DCFCE7] rounded-full flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-[#016630] rounded-full"></span> Active
                    </span>
                </div>
                
                <div class="flex items-center gap-4 text-[12px] font-medium text-[#75786D]">
                    <span class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Bergabung: 10 Mei 2026
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Login terakhir: 2 jam lalu
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="px-4 py-2.5 bg-[#53643A] text-white rounded-xl text-sm font-semibold hover:bg-[#3C4C25] transition-colors flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit User
            </button>
            <button class="px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#75786D]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                Reset Password
            </button>
            <button class="px-4 py-2.5 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#75786D]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Suspend
            </button>
            <button class="px-4 py-2.5 bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] rounded-xl text-sm font-semibold hover:bg-[#FEE2E2] transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Delete
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Total Login</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18]">127</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Resep Disimpan</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18]">48</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Postingan Hub</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18]">23</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-[#75786D] mb-1">Jurnal Kalori</p>
                <h4 class="text-3xl font-extrabold text-[#1B1C18]">92</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#F3F4F6] flex items-center justify-center text-[#53643A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] p-8">
        <h3 class="text-lg font-bold text-[#1B1C18] mb-8 pb-4 border-b border-[#E5E5E5]">Informasi Personal & Akun</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-12">
            
            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Nama Lengkap</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">Aditya Santoso</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Username</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">adityasantoso</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Alamat Email</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">aditya.santoso@email.com</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Nomor Telepon</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">+62 812-3456-7890</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Jenis Kelamin</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">Laki-laki</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Tanggal Lahir</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">15 Maret 1995</p>
            </div>

            <div class="lg:col-span-3">
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Alamat</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Role Akun</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">User Reguler</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Perangkat Terdaftar</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">iOS Mobile, Web Browser</p>
            </div>

            <div>
                <p class="text-[13px] font-semibold text-[#75786D] mb-1">Metode Login</p>
                <p class="text-[15px] font-medium text-[#1B1C18]">Email & Password</p>
            </div>

        </div>
    </div>

</div>
@endsection