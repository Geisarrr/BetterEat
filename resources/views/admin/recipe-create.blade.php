@extends('admin.layouts.app')

@section('content')
<div class="w-full pb-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-[#75786D] font-medium">
            <a href="{{ route('admin.recipes') }}" class="hover:text-[#53643A] transition-colors">Manajemen Resep</a>
            <span>/</span>
            <span class="text-[#1B1C18]">Tambah Resep Baru</span>
        </div>
        <a href="{{ route('admin.recipes') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#E5E5E5] rounded-xl text-sm font-bold text-[#1B1C18] hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#1B1C18]">Tambah Resep Baru</h2>
        <p class="text-[#75786D] mt-2 text-sm">Masukkan nama resep, pilih bahan standar TKPI, dan tentukan langkah pembuatan</p>
    </div>

    <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                    <p class="text-[13px] font-bold text-[#1B1C18] mb-3">Foto Resep</p>
                    <div class="relative group cursor-pointer">
                        <input type="file" name="image" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewImage(this)">
                        <div id="imagePreviewContainer" class="border-2 border-dashed border-[#E5E5E5] rounded-2xl h-64 flex flex-col items-center justify-center bg-[#F9FAFB] group-hover:border-[#53643A] transition-colors overflow-hidden relative">
                            <div id="uploadPlaceholder" class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-[#75786D] mb-3 group-hover:text-[#53643A] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-sm font-bold text-[#1B1C18]">Klik untuk unggah foto</p>
                                <p class="text-[11px] text-[#75786D] mt-1">PNG, JPG up to 5MB</p>
                            </div>
                            <img id="imagePreview" src="" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm space-y-5">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1B1C18] mb-2">Nama Resep</label>
                        <input type="text" name="name" placeholder="Contoh: Salad Quinoa & Tempe Kukus" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1B1C18] mb-2">Kategori Utama</label>
                        <input type="text" name="category" placeholder="Contoh: General, Diet, Diabetes" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                    </div>
                    <div class="p-4 bg-[#F3F4F6] rounded-2xl border border-dashed border-[#E5E5E5]">
                        <p class="text-[12px] font-bold text-[#53643A] mb-1">💡 Kalkulator Gizi Otomatis Aktif</p>
                        <p class="text-[11px] text-[#75786D] leading-relaxed">Nilai Kalori, Protein, Karbohidrat, Lemak, Gula, dan Serat akan dikalkulasi otomatis oleh sistem berdasarkan takaran gram bahan yang kamu masukkan.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[15px] font-bold text-[#1B1C18]">Bahan-bahan (Komposisi TKPI)</h3>
                        <button type="button" onclick="addIngredient()" class="text-[11px] font-bold text-[#53643A] hover:text-[#3C4C25] bg-[#C5D8A4]/30 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                            <span>+</span> Tambah Baris
                        </button>
                    </div>
                    
                    <div id="ingredient-container" class="space-y-3">
                        <div class="flex items-center gap-3">
                            <select name="ingredient_ids[]" required class="flex-1 px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
                                <option value="">-- Pilih Bahan TKPI --</option>
                                @foreach($foods as $food)
                                    <option value="{{ $food->food_id }}">{{ $food->food_name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="quantities[]" placeholder="Berat (g)" required min="1" class="w-32 px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-center">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-[#E5E5E5] shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[15px] font-bold text-[#1B1C18]">Langkah Pembuatan</h3>
                        <button type="button" onclick="addStep()" class="text-[11px] font-bold text-[#53643A] hover:text-[#3C4C25] bg-[#C5D8A4]/30 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                            <span>+</span> Tambah Langkah
                        </button>
                    </div>
                    
                    <div id="step-container" class="space-y-4">
                        <div class="flex gap-3">
                            <div class="step-number w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 mt-1">1</div>
                            <textarea name="steps[]" rows="2" placeholder="Jelaskan langkah pertama..." required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('admin.recipes') }}" class="px-8 py-3 bg-white border border-[#E5E5E5] text-[#1B1C18] rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-[#53643A] text-white rounded-xl text-sm font-bold hover:bg-[#3C4C25] transition-colors shadow-sm">Simpan Resep</button>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="ingredient-template">
    <div class="flex items-center gap-3">
        <select name="ingredient_ids[]" required class="flex-1 px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white">
            <option value="">-- Pilih Bahan TKPI --</option>
            @foreach($foods as $food)
                <option value="{{ $food->food_id }}">{{ $food->food_name }}</option>
            @endforeach
        </select>
        <input type="number" name="quantities[]" placeholder="Berat (g)" required min="1" class="w-32 px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white text-center">
        <button type="button" onclick="this.parentElement.remove()" class="p-2.5 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0 border border-[#FCA5A5]/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </button>
    </div>
</template>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('uploadPlaceholder').classList.add('hidden');
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addIngredient() {
        const container = document.getElementById('ingredient-container');
        const template = document.getElementById('ingredient-template').content.cloneNode(true);
        container.appendChild(template);
    }

    function addStep() {
        const container = document.getElementById('step-container');
        const div = document.createElement('div');
        div.className = 'flex gap-3';
        div.innerHTML = `
            <div class="step-number w-8 h-8 bg-[#53643A] text-white rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 mt-1"></div>
            <textarea name="steps[]" rows="2" placeholder="Langkah selanjutnya..." required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-[#E5E5E5] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#53643A]/20 transition-all focus:bg-white resize-none"></textarea>
            <button type="button" onclick="this.parentElement.remove(); updateStepNumbers();" class="h-10 w-10 text-[#DC2626] bg-[#FEF2F2] rounded-xl hover:bg-[#FCA5A5]/30 transition-colors shrink-0 flex items-center justify-center mt-1 border border-[#FCA5A5]/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>`;
        container.appendChild(div);
        updateStepNumbers();
    }

    function updateStepNumbers() {
        document.querySelectorAll('.step-number').forEach((el, index) => {
            el.innerText = index + 1;
        });
    }
</script>
@endsection