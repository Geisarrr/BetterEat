@extends('admin.layouts.app')

@section('content')
<div class="w-full">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Manajemen Pengguna</h2>
        <p class="text-[#75786D] mt-2 text-sm">Kelola seluruh pengguna aplikasi BetterEat</p>
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
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Ahmad Rizki</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">ahmad.rizki@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#53643A] bg-[#53643A]/10 rounded-full tracking-wide">Admin</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Siti Nurhaliza</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">siti.nur@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#E5E5E5] rounded-full tracking-wide">Nutritionist</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Budi Santoso</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">budi.santoso@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Rina Wati</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">rina.wati@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#E5E5E5] rounded-full tracking-wide">Nutritionist</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Dedi Kurniawan</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">dedi.k@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-white bg-[#53643A] rounded-lg hover:bg-[#3C4C25] transition-colors">Detail</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#53643A] border border-[#53643A] rounded-lg hover:bg-[#53643A]/5 transition-colors">Ubah Role</button>
                                <button class="px-4 py-1.5 text-[12px] font-semibold text-[#DC2626] border border-[#DC2626] rounded-lg hover:bg-[#DC2626]/5 transition-colors">Reset Akun</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-[#F9FAFB] transition-colors">
                        <td class="px-8 py-4 text-[14px] text-[#1B1C18]">Maya Sari</td>
                        <td class="px-8 py-4 text-[14px] text-[#75786D]">maya.sari@bettereat.com</td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 text-[11px] font-bold text-[#1B1C18] bg-[#F9FAFB] border border-[#E5E5E5] rounded-full tracking-wide">User</span>
                        </td>
                        <td class="px-8 py-4">
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