@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Pengguna</h2>
        <p class="text-[#75786D] mt-2 text-sm">Kelola seluruh pengguna aplikasi BetterEat</p>
    </div>

    <div class="flex gap-2 mb-6 max-w-2xl">
        <div class="relative flex-grow">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#75786D]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Cari nama atau email pengguna..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all">
        </div>
        <button class="bg-[#53643A] text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:bg-[#3C4C25] transition-colors shadow-sm">
            Cari
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">
        
        <div class="px-8 py-6 border-b border-[#E5E5E5]">
            <h3 class="text-[16px] font-bold text-[#1B1C18]">Daftar User</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-[#E5E5E5]">
                        <th class="px-8 py-4 text-[13px] font-bold text-[#1B1C18] whitespace-nowrap">Nama Pengguna</th>
                        <th class="px-8 py-4 text-[13px] font-bold text-[#1B1C18] whitespace-nowrap">Email</th>
                        <th class="px-8 py-4 text-[13px] font-bold text-[#1B1C18] whitespace-nowrap">Role</th>
                        <th class="px-8 py-4 text-[13px] font-bold text-[#1B1C18] whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5E5]">
                    
                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Ahmad+Rizki&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Ahmad Rizki</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">ahmad.rizki@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#53643A] bg-[#53643A]/10 rounded-full tracking-wide">Admin</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Siti Nurhaliza</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">siti.nur@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#E5E5E5] rounded-full tracking-wide">Nutritionist</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Budi Santoso</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">budi.santoso@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Rina+Wati&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Rina Wati</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">rina.wati@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#E5E5E5] rounded-full tracking-wide">Nutritionist</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Dedi+Kurniawan&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Dedi Kurniawan</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">dedi.k@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 border border-[#E5E5E5] shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Maya+Sari&background=F3F4F6&color=53643A" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[14px] text-[#1B1C18] font-medium">Maya Sari</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-[14px] text-[#75786D]">maya.sari@bettereat.com</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection