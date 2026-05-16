@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Dashboard Admin</h2>
        <p class="text-[#75786D] mt-2 text-sm">Selamat Datang, Admin. Pusat kontrol utama sistem BetterEat</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            
            <p class="text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-1">Total User</p>
            <h3 class="text-3xl font-bold text-[#1B1C18]">{{ number_format($totalUsers) }}</h3>
            
            <div class="flex items-center gap-1.5 mt-2">
                <div class="w-1.5 h-1.5 rounded-full bg-[#2E7D32] animate-pulse"></div>
                <p class="text-[11px] text-[#2E7D32] font-bold">
                    {{ $activeUsersCount }} Aktif Minggu Ini
                </p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-[#E8F5E9] flex items-center justify-center text-[#2E7D32] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <p class="text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-1">Total Resep</p>
            <h3 class="text-3xl font-bold text-[#1B1C18]">{{ number_format($totalRecipes) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
            </div>
            <p class="text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-1">Community Hub</p>
            <h3 class="text-3xl font-bold text-[#1B1C18]">{{ number_format($totalPosts) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <p class="text-[11px] font-bold text-[#75786D] uppercase tracking-wider mb-1">Data TKPI</p>
            <h3 class="text-3xl font-bold text-[#1B1C18]">{{ number_format($totalTkpi) }}</h3>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-8">
    
    <div class="lg:col-span-8 space-y-8">
        
        <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-[15px] font-bold text-[#1B1C18]">Aktivitas Sistem</h3>
                    <p class="text-[11px] text-[#75786D]">Tren penggunaan aplikasi 7 hari terakhir</p>
                </div>
                <span class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-[#75786D]">7 Hari Terakhir</span>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('activityChart').getContext('2d');
        
        // Data dari Controller
        const labels = {!! json_encode($days) !!};
        const dataPoints = {!! json_encode($sessionCounts) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sesi Aktif',
                    data: dataPoints,
                    borderColor: '#53643A',
                    backgroundColor: 'rgba(83, 100, 58, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#53643A',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#75786D', font: { size: 10 } },
                        grid: { borderDash: [5, 5], drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#75786D', font: { size: 10 } },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>

    <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-[15px] font-bold text-[#1B1C18]">Resep Terbaru Ditambahkan</h3>
                    <a href="{{ route('admin.recipes') }}" class="text-[12px] font-bold text-[#53643A] hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-6">
                    @forelse($latestRecipes as $recipe)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#F9FAFB] border border-[#E5E5E5] flex items-center justify-center shrink-0 overflow-hidden text-[#53643A]">
                            @if($recipe->image_url)
                                <img src="{{ asset($recipe->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-[#1B1C18]">{{ $recipe->name }}</p>
                            <p class="text-[12px] text-[#75786D] mt-0.5">{{ $recipe->category }} • {{ $recipe->calories }} kcal</p>
                        </div>
                        <span class="text-[11px] text-[#75786D]">{{ $recipe->created_at ? $recipe->created_at->diffForHumans() : '' }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-[#75786D] text-center">Belum ada resep baru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-[15px] font-bold text-[#1B1C18] mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.recipes.create') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">
                        <span>+</span> Tambah Resep Baru
                    </a>
                    <a href="{{ route('admin.community') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#E8F5E9] text-[#2E7D32] rounded-xl text-sm font-bold hover:bg-[#C8E6C9] transition-colors">
                        Moderasi Hub
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                <h3 class="text-[15px] font-bold text-[#1B1C18] mb-4">Problem Reports</h3>
                @if($reportedPosts > 0)
                    <a href="{{ route('admin.community', ['status' => 'dilaporkan']) }}" class="block p-4 bg-[#FEF2F2] border border-[#FCA5A5]/50 rounded-2xl hover:bg-[#FCA5A5]/30 transition-colors">
                        <p class="text-sm font-bold text-[#DC2626]">Moderation Alert</p>
                        <p class="text-[12px] text-[#991B1B] mt-1">{{ $reportedPosts }} Laporan pending.</p>
                    </a>
                @else
                    <div class="p-4 bg-[#F9FAFB] rounded-2xl text-center border border-[#E5E5E5]">
                        <p class="text-sm font-bold text-[#53643A]">Semua Aman!</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection