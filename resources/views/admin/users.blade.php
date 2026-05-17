@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen User</h2>
        <p class="text-[#75786D] mt-2 text-sm">Kelola seluruh pengguna aplikasi BetterEat</p>
    </div>

    <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2 mb-6 max-w-2xl w-full">
        <div class="relative flex-grow">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
        </div>
        <button type="submit" class="bg-[#53643A] text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:bg-[#3C4C25] transition-colors shadow-sm">
            Cari
        </button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        
        <div class="px-8 py-6 border-b border-[#E5E5E5]">
            <h3 class="text-[16px] font-bold text-[#1B1C18]">Daftar User</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#E5E5E5] text-[#1B1C18]">
                        <th class="px-6 py-4 text-[13px] font-bold">Nama Pengguna</th>
                        <th class="px-6 py-4 text-[13px] font-bold">Email</th>
                        <th class="px-6 py-4 text-[13px] font-bold">Role</th>
                        <th class="px-6 py-4 text-[13px] font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-[#E5E5E5] hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#F3F4F6] text-[#53643A] flex items-center justify-center text-xs font-bold border border-[#E5E5E5]">
                                    {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                </div>
                                <span class="text-sm font-semibold text-[#1B1C18]">{{ $user->full_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#4A5565]">{{ $user->email }}</td>
            
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.users.updateRole', $user->user_id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" 
                                    class="w-[120px] text-[11px] font-bold px-2 py-1 rounded bg-[#E5E5E5] text-[#4A5565] border border-transparent focus:border-[#53643A] focus:ring-0 cursor-pointer outline-none">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-[#1B1C18] border border-[#E5E5E5] rounded hover:bg-gray-100 transition-colors">
                                    Simpan
                                </button>
                            </form>
                        </td>
            
                        <td class="px-6 py-4 flex items-center gap-2">
                            <a href="{{ route('admin.users.detail', $user->user_id) }}" class="px-3 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#E5E5E5] rounded-lg hover:bg-white bg-white">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm text-[#75786D]">Tidak ada data pengguna yang ditemukan.</td>
                    </tr>
                    @endforelse
                    </tbody>
            </table>
        </div>
        <div class="px-8 py-4 border-t border-[#E5E5E5] bg-[#F9FAFB]">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection