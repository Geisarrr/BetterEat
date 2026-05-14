@extends('admin.layouts.app')

@section('content')
<div class="max-w-[1100px] mx-auto"> <!-- Membatasi lebar agar rapi di layar besar -->

    <!-- Header -->
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Dashboard Admin</h2> <!-- Warna teks gelap utama -->
        <div class="mt-2 text-sm">
            <span class="font-bold text-[#3C4C25]">Selamat Datang, Admin</span> <!-- Hijau gelap teks -->
            <p class="text-[#75786D] mt-1">Pusat kontrol utama sistem BetterEat</p> <!-- Warna teks abu-abu -->
        </div>
    </div>

    <!-- Stats Grid (4 Kolom) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-lg bg-[#EFEEE8] flex items-center justify-center mb-6">
                <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <p class="text-[#75786D] text-[11px] font-bold tracking-wider mb-1">TOTAL USER</p>
            <h3 class="text-[32px] font-bold text-[#1B1C18]">12,450</h3>
        </div>
        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-lg bg-[#D6EAB4] bg-opacity-30 flex items-center justify-center mb-6">
                <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <p class="text-[#75786D] text-[11px] font-bold tracking-wider mb-1">TOTAL RESEP</p>
            <h3 class="text-[32px] font-bold text-[#1B1C18]">840</h3>
        </div>
        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-lg bg-[#E8B9DA] bg-opacity-20 flex items-center justify-center mb-6"> <!-- Sedikit sentuhan pink dari palet -->
                <svg class="w-5 h-5 text-[#5E3B57]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <p class="text-[#75786D] text-[11px] font-bold tracking-wider mb-1">COMMUNITY HUB</p>
            <h3 class="text-[32px] font-bold text-[#1B1C18]">2,130</h3>
        </div>
        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-lg bg-[#EFEEE8] flex items-center justify-center mb-6">
                <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-[#75786D] text-[11px] font-bold tracking-wider mb-1">DATA TKPI</p>
            <h3 class="text-[32px] font-bold text-[#1B1C18]">5,200</h3>
        </div>
    </div>

    <!-- Middle Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Area Chart / Grafik -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col min-h-[300px]">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-base font-semibold text-[#1B1C18]">User Aktif Mingguan</h3>
                    <p class="text-[13px] text-[#75786D] mt-1">Tren penggunaan aplikasi 7 hari terakhir</p>
                </div>
                <span class="bg-[#EFEEE8] text-[#53643A] text-xs font-semibold px-4 py-2 rounded-lg">7 Hari Terakhir</span>
            </div>
            <!-- Dummy Space untuk sumbu X Grafik -->
            <div class="flex-1 flex items-end justify-between px-6 pb-2">
                <span class="text-[10px] text-[#75786D] font-bold">SEN</span>
                <span class="text-[10px] text-[#75786D] font-bold">SEL</span>
                <span class="text-[10px] text-[#75786D] font-bold">RAB</span>
                <span class="text-[10px] text-[#75786D] font-bold">KAM</span>
                <span class="text-[10px] text-[#75786D] font-bold">JUM</span>
                <span class="text-[10px] text-[#75786D] font-bold">SAB</span>
                <span class="text-[10px] text-[#75786D] font-bold">MIN</span>
            </div>
        </div>

        <!-- Kolom Kanan (Quick Actions & Reports) -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-[15px] font-semibold text-[#1B1C18] mb-4">Quick Actions</h3>
                <button class="w-full bg-[#3C4C25] hover:bg-[#2B361A] text-white text-sm font-medium py-3.5 rounded-xl mb-3 transition-colors flex items-center justify-center gap-2">
                    <span class="text-lg leading-none">+</span> Tambah Resep Baru
                </button>
                <button class="w-full bg-[#D6EAB4] hover:bg-[#C5DDA3] text-[#3C4C25] text-sm font-medium py-3.5 rounded-xl transition-colors flex items-center justify-center gap-2"> <!-- Warna tombol moderasi -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Moderasi Hub
                </button>
            </div>

            <!-- Problem Reports -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-[15px] font-semibold text-[#1B1C18] mb-4">Problem Reports</h3>
                
                <div class="bg-[#FFEDD5] p-3.5 rounded-xl flex items-start gap-3 mb-3 border border-[#FFEDD5]"> <!-- Warna Report Bug -->
                    <div class="text-[#EA580C] mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-[#9A3412]">Bug Report</p> <!-- Warna Teks Orange Gelap -->
                        <p class="text-[11px] text-[#9A3412] mt-0.5 opacity-90">Error pada kalkulator kalori</p>
                    </div>
                </div>
                
                <div class="bg-[#FEE2E2] p-3.5 rounded-xl flex items-start gap-3 border border-[#FEE2E2]"> <!-- Warna Report Moderation -->
                    <div class="text-[#DC2626] mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-[#991B1B]">Moderation</p> <!-- Warna Teks Merah Gelap -->
                        <p class="text-[11px] text-[#991B1B] mt-0.5 opacity-90">3 Postingan ditandai sebagai spam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white p-7 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-base font-semibold text-[#1B1C18]">Recent Activity</h3>
            <a href="#" class="text-sm font-medium text-[#1B1C18] hover:underline">Lihat Semua</a>
        </div>
        
        <div class="space-y-6">
            <!-- Item 1 -->
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#EFEEE8] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-[14px] font-bold text-[#1B1C18]">User baru mendaftar</h4>
                    <p class="text-[12px] text-[#75786D] mt-0.5">Seorang pengguna baru saja bergabung via Google Auth</p>
                </div>
                <span class="text-[12px] text-[#75786D]">2 menit yang lalu</span>
            </div>
            
            <hr class="border-gray-100"> <!-- Garis Pemisah -->
            
            <!-- Item 2 -->
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#EFEEE8] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-[14px] font-bold text-[#1B1C18]">Resep Ayam Bakar ditambahkan</h4>
                    <p class="text-[12px] text-[#75786D] mt-0.5">Kontributor @ChefAndri mengunggah resep baru</p>
                </div>
                <span class="text-[12px] text-[#75786D]">15 menit yang lalu</span>
            </div>
            
            <hr class="border-gray-100"> <!-- Garis Pemisah -->
            
            <!-- Item 3 -->
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#EFEEE8] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#53643A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-[14px] font-bold text-[#1B1C18]">Update Data TKPI</h4>
                    <p class="text-[12px] text-[#75786D] mt-0.5">Sistem menyinkronkan data gizi terbaru dari Kemenkes</p>
                </div>
                <span class="text-[12px] text-[#75786D]">1 jam yang lalu</span>
            </div>
        </div>
    </div>

</div>
@endsection