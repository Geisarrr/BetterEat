<!-- @extends('layouts.user')

@section('title', 'Edit Postingan — BetterEat')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #C5D8A4 0%, #dfeece 60%, #eef5e5 100%);
    }

    .drop-zone {
        border: 2px dashed #C5D8A4;
        border-radius: 14px;
        transition: border-color .2s, background .2s;
        cursor: pointer;
    }
    .drop-zone:hover,
    .drop-zone.dragover { border-color: #53643A; background: #F7FAF3; }

    #imgPreviewWrap      { display: none; }
    #imgPreviewWrap.show { display: block; }

    .form-card {
        box-shadow: 0 4px 32px rgba(60,76,37,.08);
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-section pt-40 pb-16">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h1 class="font-heading font-bold text-3xl text-be-primary mb-2">Edit Postingan</h1>
        <p class="text-be-muted text-sm">Perbarui konten postingan kamu di bawah ini.</p>
    </div>
</section>

{{-- FORM --}}
<section class="max-w-2xl mx-auto px-4 py-10">

    {{-- Error --}}
    @if($errors->any())
    <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
        <p class="font-semibold mb-1 flex items-center gap-1.5"><i class='bx bx-error-circle'></i> Ada kesalahan:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm form-card overflow-hidden">

        {{-- Header Card --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <img src="{{ $post->user->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}"
                 class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="">
            <div>
                <p class="font-semibold text-sm text-be-dark font-heading">{{ $post->user->full_name }}</p>
                <p class="text-xs text-be-muted">Memperbarui postingan</p>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('posts.update', $post->post_id) }}"
              enctype="multipart/form-data"
              class="px-6 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Kategori</label>
                <select name="category_id" required
                    class="w-full text-sm text-be-dark border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-be-primary focus:border-transparent transition">
                    <option value="">Pilih kategori...</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}"
                        {{ $post->category_id == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Judul</label>
                <input type="text" name="title"
                    value="{{ old('title', $post->title) }}"
                    placeholder="Judul postingan..." required
                    class="w-full font-heading font-semibold text-be-dark text-base border border-gray-200
                           rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-be-primary
                           focus:border-transparent bg-gray-50 placeholder:text-gray-300 transition">
            </div>

            {{-- Konten --}}
            <div>
                <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Konten</label>
                <textarea name="content" rows="6" required
                    placeholder="Ceritakan lebih lanjut..."
                    class="w-full text-sm text-gray-700 border border-gray-200 rounded-xl px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-be-primary focus:border-transparent
                           resize-none bg-gray-50 placeholder:text-gray-300 leading-relaxed transition">{{ old('content', $post->content) }}</textarea>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-2">Foto (Opsional)</label>

                {{-- Gambar saat ini --}}
                @if($post->image_url)
                <div id="currentImgWrap" class="mb-3 rounded-xl overflow-hidden border border-gray-100">
                    <div class="relative">
                        <img src="{{ asset($post->image_url) }}" alt="Foto saat ini"
                             class="w-full max-h-56 object-cover">
                        <span class="absolute top-2 left-2 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full">
                            Foto saat ini
                        </span>
                    </div>
                    <div class="px-3 py-2 bg-gray-50 flex items-center justify-between">
                        <p class="text-xs text-be-muted">Unggah foto baru untuk mengganti, atau centang untuk menghapus.</p>
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs text-red-500 font-medium flex-shrink-0 ml-3">
                            <input type="checkbox" name="remove_image" value="1"
                                   onchange="toggleRemoveImage(this)"
                                   class="rounded border-gray-300 text-red-500">
                            Hapus foto
                        </label>
                    </div>
                </div>
                @endif

                {{-- Drop Zone --}}
                <div id="dropZone"
                     class="drop-zone flex flex-col items-center justify-center gap-2 py-6 px-4"
                     onclick="document.getElementById('imageInput').click()">

                    <input type="file"
                           id="imageInput"
                           name="image"
                           accept="image/jpeg,image/jpg,image/png,image/webp"
                           class="hidden"
                           onchange="handleFileSelect(this)">

                    <i class='bx bx-cloud-upload text-4xl text-be-muted'></i>
                    <div class="text-center">
                        <p class="text-sm font-semibold text-be-primary">
                            {{ $post->image_url ? 'Klik untuk ganti gambar' : 'Klik untuk pilih gambar' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">atau seret & lepas file ke sini</p>
                    </div>
                    <p class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">
                        JPG · PNG · WEBP &nbsp;|&nbsp; Maks. 2 MB
                    </p>
                </div>

                {{-- Preview gambar baru --}}
                <div id="imgPreviewWrap" class="mt-3 rounded-xl overflow-hidden border border-gray-100">
                    <div class="relative">
                        <img id="imgPreview" src="" alt="Preview"
                             class="w-full max-h-56 object-cover">
                        <span class="absolute top-2 left-2 bg-be-primary/80 text-white text-xs px-2 py-0.5 rounded-full">
                            Foto baru
                        </span>
                        <button type="button" onclick="clearImage()"
                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 hover:bg-black/80
                                   text-white flex items-center justify-center transition">
                            <i class='bx bx-x text-sm'></i>
                        </button>
                    </div>
                    <div class="px-3 py-2 bg-gray-50 flex items-center gap-2">
                        <i class='bx bx-image text-be-muted text-base'></i>
                        <p id="imgFileName" class="text-xs text-be-muted truncate flex-1"></p>
                        <p id="imgFileSize" class="text-xs text-gray-400 flex-shrink-0"></p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <a href="{{ route('community') }}"
                   class="px-5 py-2.5 rounded-full border border-gray-200 text-be-muted text-sm font-medium
                          hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-be-primary text-white text-sm font-semibold
                           hover:bg-be-button transition shadow-sm flex items-center gap-2">
                    <i class='bx bx-check'></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Preview Gambar ──
function handleFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    showPreview(input.files[0]);
}

function showPreview(file) {
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2 MB.');
        clearImage();
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imgPreview').src    = e.target.result;
        document.getElementById('imgFileName').textContent = file.name;
        document.getElementById('imgFileSize').textContent = formatBytes(file.size);
        document.getElementById('imgPreviewWrap').classList.add('show');
        document.getElementById('dropZone').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    document.getElementById('imageInput').value        = '';
    document.getElementById('imgPreview').src          = '';
    document.getElementById('imgFileName').textContent = '';
    document.getElementById('imgFileSize').textContent = '';
    document.getElementById('imgPreviewWrap').classList.remove('show');
    document.getElementById('dropZone').style.display = '';
}

function formatBytes(bytes) {
    if (bytes < 1024)        return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(0) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

// ── Checkbox "Hapus Foto" ──
function toggleRemoveImage(cb) {
    const dz = document.getElementById('dropZone');
    if (cb.checked) {
        dz.style.opacity = '.4';
        dz.style.pointerEvents = 'none';
    } else {
        dz.style.opacity = '';
        dz.style.pointerEvents = '';
    }
}

// ── Drag & Drop ──
const dz = document.getElementById('dropZone');
if (dz) {
    dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', ()  => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (!file) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('imageInput').files = dt.files;
        showPreview(file);
    });
}
</script>
@endpush -->