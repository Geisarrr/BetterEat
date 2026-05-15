@extends('layouts.user')

@section('title', 'Community Hub — BetterEat')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #C5D8A4 0%, #dfeece 60%, #eef5e5 100%);
    }

    .post-card { transition: box-shadow .2s ease; }
    .post-card:hover { box-shadow: 0 4px 24px rgba(60,76,37,.10); }

    .like-btn.liked i { color: #ef4444; }
    .like-btn.liked   { color: #ef4444; }

    .tag-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        background: #EDF3E4;
        color: #3C4C25;
    }

    .reply-box          { display: none; }
    .reply-box.open     { display: block; }
    .reply-indent       { border-left: 2px solid #EDF3E4; padding-left: 16px; margin-top: 8px; }

    .search-input:focus { box-shadow: 0 0 0 3px rgba(83,100,58,.15); }
    .trend-item:hover, .contributor-item:hover { background: #F7FAF3; border-radius: 8px; }

    /* Drop zone upload */
    .drop-zone {
        border: 2px dashed #C5D8A4;
        border-radius: 14px;
        transition: border-color .2s, background .2s;
        cursor: pointer;
    }
    .drop-zone:hover,
    .drop-zone.dragover  { border-color: #53643A; background: #F7FAF3; }

    /* Preview container */
    #imgPreviewWrap      { display: none; }
    #imgPreviewWrap.show { display: block; }

    /* Edit modal preview */
    #editImgPreviewWrap      { display: none; }
    #editImgPreviewWrap.show { display: block; }
</style>
@endpush

@section('content')

{{-- ──────────────── HERO ──────────────── --}}
<section class="hero-section pt-40 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-heading font-bold text-3xl md:text-4xl text-be-primary mb-3">
            Community Hub
        </h1>
        <p class="text-be-muted text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-7">
            Berbagi resep sehat khas Indonesia, ajukan pertanyaan, dan terhubung dengan sesama pecinta kuliner dalam perjalanan menuju pola makan yang lebih baik dan seimbang.
        </p>

        <div class="relative max-w-xl mx-auto">
            <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-be-muted text-lg'></i>
            <input id="searchInput" type="text"
                placeholder="Jelajahi berbagai topik, resep, atau diskusi menarik..."
                class="search-input w-full pl-10 pr-4 py-3 rounded-full border border-gray-200 bg-white text-sm text-be-dark placeholder:text-gray-400 focus:outline-none transition">
        </div>
    </div>
</section>

{{-- ──────────────── MAIN ──────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex gap-8">

        {{-- ════════════ FEED ════════════ --}}
        <div class="flex-1 min-w-0">

            {{-- Flash / Error --}}
            @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <p class="font-semibold mb-1 flex items-center gap-1.5"><i class='bx bx-error-circle'></i> Ada kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            {{-- Create Post Trigger Box --}}
            @auth
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
                <div class="flex items-center gap-3">
                    <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}"
                         class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="">
                    <button id="triggerModal"
                        class="flex-1 text-left px-4 py-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-400 text-sm transition">
                        Apa yang sedang Anda pikirkan? Bagikan resep sehat, Artikel dll...
                    </button>
                </div>
            </div>
            @endauth

            {{-- Category Filter --}}
            <div class="flex items-center gap-2 mb-5 flex-wrap">
                <button onclick="filterCat('all')" data-cat="all"
                    class="cat-btn active-cat px-4 py-1.5 rounded-full text-sm font-semibold border border-be-primary bg-be-primary text-white transition">
                    Semua
                </button>
                @foreach($categories as $cat)
                <button onclick="filterCat({{ $cat->category_id }})" data-cat="{{ $cat->category_id }}"
                    class="cat-btn px-4 py-1.5 rounded-full text-sm font-medium border border-gray-200 text-be-muted hover:border-be-primary hover:text-be-primary bg-white transition">
                    {{ $cat->name }}
                </button>
                @endforeach
            </div>

            {{-- Posts --}}
            <div id="postsContainer" class="space-y-5">
                @forelse($posts as $post)
                <article class="post-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
                         data-category="{{ $post->category_id }}">

                    {{-- Header --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $post->user->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}"
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="">
                                <div>
                                    <p class="font-semibold text-sm text-be-dark font-heading">{{ $post->user->full_name }}</p>
                                    <p class="text-xs text-be-muted">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($post->category)
                                    <span class="tag-badge">{{ $post->category->name }}</span>
                                @endif
                                @auth
                                @if($post->user_id === Auth::id())
                                <div class="relative">
                                    <button onclick="toggleDD('dd-{{ $post->post_id }}')"
                                        class="p-1.5 rounded-lg hover:bg-gray-100 text-be-muted transition">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </button>
                                    <div id="dd-{{ $post->post_id }}"
                                         class="hidden absolute right-0 top-8 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-10 min-w-[130px]">
                                        {{-- ✅ GANTI: dari link pindah halaman → tombol buka modal edit --}}
                                        <button type="button"
                                            onclick="openEditModal(
                                                {{ $post->post_id }},
                                                {{ json_encode($post->title) }},
                                                {{ json_encode($post->content) }},
                                                {{ $post->category_id }},
                                                {{ json_encode($post->image_url) }}
                                            )"
                                            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                            <i class='bx bx-edit-alt'></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('posts.destroy', $post->post_id) }}"
                                              onsubmit="return confirm('Hapus postingan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 hover:bg-red-50">
                                                <i class='bx bx-trash'></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                @endauth
                            </div>
                        </div>

                        <h3 class="font-heading font-semibold text-be-dark text-base mb-2">{{ $post->title }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">{{ $post->content }}</p>
                    </div>

                    {{-- Gambar Post --}}
                    @if($post->image_url)
                        <div class="post-image mt-3">
                            <img
                                src="{{ asset($post->image_url) }}"
                                alt="Foto postingan"
                                class="w-full rounded-xl object-cover max-h-72"
                            >
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="px-5 pb-4 flex items-center gap-5 border-t border-gray-50 pt-3">
                        {{-- Like --}}
                        @auth
                        <form method="POST" action="{{ route('post.like', $post->post_id) }}" class="inline">
                            @csrf
                            @php $liked = $post->likes && $post->likes->contains('user_id', Auth::id()); @endphp
                            <button type="submit"
                                class="like-btn flex items-center gap-1.5 text-sm font-medium transition
                                       {{ $liked ? 'text-red-500 liked' : 'text-be-muted hover:text-red-500' }}">
                                <i class='bx {{ $liked ? "bxs-heart" : "bx-heart" }} text-lg'></i>
                                <span>{{ $post->likes ? $post->likes->count() : 0 }}</span>
                            </button>
                        </form>
                        @else
                        <span class="flex items-center gap-1.5 text-sm text-be-muted">
                            <i class='bx bx-heart text-lg'></i>
                            <span>{{ $post->likes ? $post->likes->count() : 0 }}</span>
                        </span>
                        @endauth

                        {{-- Komentar --}}
                        <button onclick="toggleComments({{ $post->post_id }})"
                            class="flex items-center gap-1.5 text-sm font-medium text-be-muted hover:text-be-primary transition">
                            <i class='bx bx-comment text-lg'></i>
                            <span>{{ $post->comments ? $post->comments->count() : 0 }}</span>
                        </button>
                    </div>

                    {{-- Komentar --}}
                    <div id="comments-{{ $post->post_id }}" class="hidden border-t border-gray-100 px-5 py-4 bg-gray-50/60">

                        @if($post->comments && $post->comments->count() > 0)
                        <div class="space-y-3 mb-4">
                            @foreach($post->comments->whereNull('parent_comment_id') as $comment)
                            <div class="flex gap-3">
                                <img src="{{ $comment->user->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->full_name ?? 'U').'&background=D6EAB5&color=3C4C25&size=32' }}"
                                     class="w-8 h-8 rounded-full flex-shrink-0 object-cover mt-0.5" alt="">
                                <div class="flex-1">
                                    <div class="bg-white rounded-xl px-3 py-2 border border-gray-100">
                                        <span class="font-semibold text-xs text-be-dark">{{ $comment->user->full_name }}</span>
                                        <p class="text-sm text-gray-700 mt-0.5">{{ $comment->content }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 px-1">
                                        <span class="text-xs text-be-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                        @auth
                                        <button onclick="toggleReply('reply-{{ $comment->comment_id }}')"
                                            class="text-xs text-be-primary font-medium hover:underline">Balas</button>
                                        @if($comment->user_id === Auth::id())
                                        <form method="POST" action="{{ route('comments.destroy', $comment->comment_id) }}"
                                              onsubmit="return confirm('Hapus komentar?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Hapus</button>
                                        </form>
                                        @endif
                                        @endauth
                                    </div>

                                    {{-- Replies --}}
                                    @if($comment->replies && $comment->replies->count() > 0)
                                    <div class="reply-indent space-y-2">
                                        @foreach($comment->replies as $reply)
                                        <div class="flex gap-2">
                                            <img src="{{ $reply->user->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($reply->user->full_name ?? 'U').'&background=D6EAB5&color=3C4C25&size=28' }}"
                                                 class="w-7 h-7 rounded-full flex-shrink-0 object-cover mt-0.5" alt="">
                                            <div class="flex-1">
                                                <div class="bg-white rounded-xl px-3 py-2 border border-gray-100">
                                                    <span class="font-semibold text-xs text-be-dark">{{ $reply->user->full_name }}</span>
                                                    <p class="text-sm text-gray-700 mt-0.5">{{ $reply->content }}</p>
                                                </div>
                                                <div class="flex items-center gap-3 mt-1 px-1">
                                                    <span class="text-xs text-be-muted">{{ $reply->created_at->diffForHumans() }}</span>
                                                    @auth
                                                    @if($reply->user_id === Auth::id())
                                                    <form method="POST" action="{{ route('comments.destroy', $reply->comment_id) }}"
                                                          onsubmit="return confirm('Hapus komentar?')" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600">Hapus</button>
                                                    </form>
                                                    @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- Form Balas --}}
                                    @auth
                                    <div id="reply-{{ $comment->comment_id }}" class="reply-box mt-2">
                                        <form method="POST" action="{{ route('comments.store') }}" class="flex gap-2">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                                            <input type="hidden" name="parent_comment_id" value="{{ $comment->comment_id }}">
                                            <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'U').'&background=D6EAB5&color=3C4C25&size=28' }}"
                                                 class="w-7 h-7 rounded-full flex-shrink-0 object-cover mt-1" alt="">
                                            <div class="flex-1 flex items-center gap-2">
                                                <input type="text" name="content" placeholder="Tulis balasan..." required
                                                    class="flex-1 px-3 py-1.5 text-sm rounded-full border border-gray-200 focus:outline-none focus:border-be-primary bg-white">
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-full bg-be-primary text-white text-xs font-semibold hover:bg-be-button transition">
                                                    Kirim
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    @endauth
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Form Komentar Baru --}}
                        @auth
                        <form method="POST" action="{{ route('comments.store') }}" class="flex gap-3">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                            <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'User').'&background=D6EAB5&color=3C4C25&size=36' }}"
                                 class="w-9 h-9 rounded-full flex-shrink-0 object-cover mt-0.5" alt="">
                            <div class="flex-1 flex items-center gap-2">
                                <input type="text" name="content" placeholder="Tulis komentar..." required
                                    class="flex-1 px-4 py-2 text-sm rounded-full border border-gray-200 focus:outline-none focus:border-be-primary bg-white transition">
                                <button type="submit"
                                    class="px-4 py-2 rounded-full bg-be-primary text-white text-sm font-semibold hover:bg-be-button transition shadow-sm">
                                    <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </form>
                        @else
                        <p class="text-sm text-be-muted text-center">
                            <a href="{{ route('login') }}" class="text-be-primary font-semibold hover:underline">Login</a>
                            untuk ikut berkomentar
                        </p>
                        @endauth

                    </div>
                </article>
                @empty
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <i class='bx bx-conversation text-5xl text-gray-300 mb-3 block'></i>
                    <p class="text-be-muted font-medium">Belum ada postingan di sini.</p>
                    <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama berbagi!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ════════════ SIDEBAR ════════════ --}}
        <aside class="hidden lg:block w-72 flex-shrink-0 space-y-5">

            {{-- Tren Saat Ini --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-heading font-bold text-sm text-be-dark mb-4 flex items-center gap-2">
                    <i class='bx bx-trending-up text-be-green'></i> Tren Saat Ini
                </h3>
                <div class="space-y-1">
                    @foreach($trendingTags as $tag)
                    <div class="trend-item flex items-center justify-between px-2 py-2 cursor-pointer transition">
                        <div>
                            <p class="text-sm font-semibold text-be-primary">{{ $tag['name'] }}</p>
                            <p class="text-xs text-be-muted">{{ number_format($tag['count']) }} posts</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Kontributor Utama --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-heading font-bold text-sm text-be-dark mb-4 flex items-center gap-2">
                    <i class='bx bx-award text-be-green'></i> Kontributor Utama
                </h3>
                <div class="space-y-1">
                    @foreach($topContributors as $contributor)
                    <div class="contributor-item flex items-center gap-3 px-2 py-2 transition">
                        <img src="{{ $contributor->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($contributor->full_name ?? 'U').'&background=D6EAB5&color=3C4C25&size=36' }}"
                             class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-be-dark truncate">{{ $contributor->full_name }}</p>
                            <p class="text-xs text-be-muted">{{ $contributor->posts_count }} postingan</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Koleksi Kesehatan --}}
            @if($sidebarRecipes && $sidebarRecipes->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-heading font-bold text-sm text-be-dark mb-4 flex items-center gap-2">
                    <i class='bx bx-leaf text-be-green'></i> Koleksi Kesehatan
                </h3>
                <div class="space-y-3">
                    @foreach($sidebarRecipes as $recipe)
                    <div class="flex gap-3 group cursor-pointer">
                        @if($recipe->image_url)
                        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                             class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                        @else
                        <div class="w-14 h-14 rounded-xl bg-be-light flex items-center justify-center flex-shrink-0">
                            <i class='bx bx-bowl-hot text-2xl text-be-muted'></i>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-be-dark leading-tight group-hover:text-be-primary transition line-clamp-2">
                                {{ $recipe->title }}
                            </p>
                            @if($recipe->category)
                            <p class="text-xs text-be-muted mt-1">{{ $recipe->category }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>
    </div>
</section>

{{-- ══════════════ MODAL BUAT POSTINGAN ══════════════ --}}
@auth
<div id="postModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 flex flex-col max-h-[90vh]">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
            <h3 class="font-heading font-bold text-be-dark">Buat Postingan</h3>
            <button onclick="closeModal()" class="p-1.5 rounded-lg hover:bg-gray-100 text-be-muted transition">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
        <form method="POST" action="{{ route('posts.store') }}"
              enctype="multipart/form-data"
              class="flex flex-col flex-1 overflow-y-auto">
            @csrf
            <div class="px-6 py-5 space-y-4 flex-1 overflow-y-auto">
                <div class="flex items-center gap-3">
                    <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->full_name ?? 'User').'&background=D6EAB5&color=3C4C25' }}"
                         class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="">
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-be-dark mb-1">{{ Auth::user()->full_name }}</p>
                        <select name="category_id" required
                            class="text-xs text-be-muted border border-gray-200 bg-gray-50 rounded-full px-3 py-1.5
                                   focus:outline-none focus:ring-2 focus:ring-be-primary w-full max-w-xs">
                            <option value="">Pilih kategori...</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="text" name="title" placeholder="Judul postingan..." required
                    class="w-full font-heading font-semibold text-be-dark text-base border-0 border-b border-gray-100
                           focus:outline-none focus:border-be-primary pb-2 placeholder:text-gray-300 transition bg-transparent">
                <textarea name="content" rows="4"
                    placeholder="Ceritakan lebih lanjut tentang resep, tips, atau pengalamanmu..." required
                    class="w-full text-sm text-gray-700 border-0 focus:outline-none resize-none
                           placeholder:text-gray-300 leading-relaxed bg-transparent"></textarea>
                <div>
                    <p class="text-xs font-semibold text-be-muted mb-2 uppercase tracking-wide">Foto (Opsional)</p>
                    <div id="dropZone"
                         class="drop-zone flex flex-col items-center justify-center gap-2 py-6 px-4"
                         onclick="document.getElementById('imageInput').click()">
                        <input type="file" id="imageInput" name="image"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="hidden" onchange="handleFileSelect(this)">
                        <i class='bx bx-cloud-upload text-4xl text-be-muted'></i>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-be-primary">Klik untuk pilih gambar</p>
                            <p class="text-xs text-gray-400 mt-0.5">atau seret & lepas file ke sini</p>
                        </div>
                        <p class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">
                            JPG · PNG · WEBP &nbsp;|&nbsp; Maks. 2 MB
                        </p>
                    </div>
                    <div id="imgPreviewWrap" class="mt-3 rounded-xl overflow-hidden border border-gray-100">
                        <div class="relative">
                            <img id="imgPreview" src="" alt="Preview" class="w-full max-h-56 object-cover">
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
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between flex-shrink-0">
                <p class="text-xs text-gray-400">Terlihat oleh semua anggota komunitas</p>
                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-be-primary text-white text-sm font-semibold
                           hover:bg-be-button transition shadow-sm">
                    Bagikan ke Komunitas
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ MODAL EDIT POSTINGAN ══════════════ --}}
{{--
    Satu modal edit dipakai untuk semua post.
    Data post diisi via JavaScript (openEditModal) saat tombol Edit diklik.
    Form action-nya diupdate dinamis sesuai post_id yang sedang diedit.
--}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 flex-shrink-0">
            <h3 class="font-heading font-bold text-be-dark flex items-center gap-2">
                <i class='bx bx-edit-alt text-be-green'></i> Edit Postingan
            </h3>
            <button onclick="closeEditModal()" class="p-1.5 rounded-lg hover:bg-gray-100 text-be-muted transition">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>

        {{--
            action dikosongkan dulu, diisi dinamis oleh openEditModal().
            method POST + @method('PUT') = Laravel method spoofing untuk PUT request.
        --}}
        <form id="editForm"
              method="POST"
              action=""
              enctype="multipart/form-data"
              class="flex flex-col flex-1 overflow-y-auto">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4 flex-1 overflow-y-auto">

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Kategori</label>
                    <select id="editCategoryId" name="category_id" required
                        class="w-full text-sm text-be-dark border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-be-primary transition">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Judul --}}
                <div>
                    <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Judul</label>
                    <input type="text" id="editTitle" name="title" placeholder="Judul postingan..." required
                        class="w-full font-heading font-semibold text-be-dark text-base border border-gray-200
                               rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-be-primary
                               bg-gray-50 placeholder:text-gray-300 transition">
                </div>

                {{-- Konten --}}
                <div>
                    <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-1.5">Konten</label>
                    <textarea id="editContent" name="content" rows="5" required
                        placeholder="Ceritakan lebih lanjut..."
                        class="w-full text-sm text-gray-700 border border-gray-200 rounded-xl px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-be-primary resize-none
                               bg-gray-50 placeholder:text-gray-300 leading-relaxed transition"></textarea>
                </div>

                {{-- Foto --}}
                <div>
                    <label class="block text-xs font-semibold text-be-muted uppercase tracking-wide mb-2">Foto (Opsional)</label>

                    {{-- Tampilan gambar saat ini (muncul jika post punya gambar) --}}
                    <div id="editCurrentImgWrap" class="hidden mb-3 rounded-xl overflow-hidden border border-gray-100">
                        <div class="relative">
                            <img id="editCurrentImg" src="" alt="Foto saat ini"
                                 class="w-full max-h-48 object-cover">
                            <span class="absolute top-2 left-2 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full">
                                Foto saat ini
                            </span>
                        </div>
                        <div class="px-3 py-2 bg-gray-50 flex items-center justify-between gap-3">
                            <p class="text-xs text-be-muted">Upload baru untuk mengganti, atau centang untuk menghapus.</p>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs text-red-500 font-medium flex-shrink-0">
                                <input type="checkbox" id="editRemoveImage" name="remove_image" value="1"
                                       onchange="toggleEditRemoveImage(this)"
                                       class="rounded border-gray-300 text-red-500">
                                Hapus
                            </label>
                        </div>
                    </div>

                    {{-- Drop Zone --}}
                    <div id="editDropZone"
                         class="drop-zone flex flex-col items-center justify-center gap-2 py-6 px-4"
                         onclick="document.getElementById('editImageInput').click()">
                        <input type="file" id="editImageInput" name="image"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="hidden" onchange="handleEditFileSelect(this)">
                        <i class='bx bx-cloud-upload text-4xl text-be-muted'></i>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-be-primary">Klik untuk pilih gambar</p>
                            <p class="text-xs text-gray-400 mt-0.5">atau seret & lepas file ke sini</p>
                        </div>
                        <p class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">
                            JPG · PNG · WEBP &nbsp;|&nbsp; Maks. 2 MB
                        </p>
                    </div>

                    {{-- Preview gambar baru yang dipilih --}}
                    <div id="editImgPreviewWrap" class="mt-3 rounded-xl overflow-hidden border border-gray-100">
                        <div class="relative">
                            <img id="editImgPreview" src="" alt="Preview" class="w-full max-h-48 object-cover">
                            <span class="absolute top-2 left-2 bg-be-primary/80 text-white text-xs px-2 py-0.5 rounded-full">
                                Foto baru
                            </span>
                            <button type="button" onclick="clearEditImage()"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 hover:bg-black/80
                                       text-white flex items-center justify-center transition">
                                <i class='bx bx-x text-sm'></i>
                            </button>
                        </div>
                        <div class="px-3 py-2 bg-gray-50 flex items-center gap-2">
                            <i class='bx bx-image text-be-muted text-base'></i>
                            <p id="editImgFileName" class="text-xs text-be-muted truncate flex-1"></p>
                            <p id="editImgFileSize" class="text-xs text-gray-400 flex-shrink-0"></p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between flex-shrink-0">
                <button type="button" onclick="closeEditModal()"
                    class="px-5 py-2.5 rounded-full border border-gray-200 text-be-muted text-sm font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-be-primary text-white text-sm font-semibold
                           hover:bg-be-button transition shadow-sm flex items-center gap-2">
                    <i class='bx bx-check'></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@push('scripts')
<script>
// ══════════════════════════════════════════════
// MODAL BUAT POSTINGAN (tidak berubah)
// ══════════════════════════════════════════════
function openModal(focusPhoto = false) {
    const m = document.getElementById('postModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    if (focusPhoto) setTimeout(() => document.getElementById('imageInput')?.click(), 200);
}
function closeModal() {
    document.getElementById('postModal').classList.add('hidden');
    document.getElementById('postModal').classList.remove('flex');
}

@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => openModal());
@endif

document.getElementById('triggerModal')?.addEventListener('click', () => openModal());

// ══════════════════════════════════════════════
// MODAL EDIT POSTINGAN
// ══════════════════════════════════════════════

/**
 * Dipanggil saat tombol "Edit" di dropdown diklik.
 * Mengisi semua field modal dengan data post yang dipilih,
 * lalu mengupdate action form ke endpoint update post tersebut.
 *
 * @param {number} postId      - ID post yang akan diedit
 * @param {string} title       - Judul post saat ini
 * @param {string} content     - Konten post saat ini
 * @param {number} categoryId  - ID kategori saat ini
 * @param {string|null} imageUrl - URL gambar saat ini (null jika tidak ada)
 */
function openEditModal(postId, title, content, categoryId, imageUrl) {
    // 1. Tutup dropdown yang sedang terbuka
    document.querySelectorAll('[id^="dd-"]').forEach(d => d.classList.add('hidden'));

    // 2. Isi field form dengan data post
    document.getElementById('editTitle').value    = title;
    document.getElementById('editContent').value  = content;

    // Set kategori yang dipilih
    const catSelect = document.getElementById('editCategoryId');
    catSelect.value = categoryId;

    // 3. Update action form ke route posts.update/{postId}
    //    Karena Laravel resource route POST + method spoofing PUT
    document.getElementById('editForm').action = `/posts/${postId}`;

    // 4. Tampilkan / sembunyikan gambar saat ini
    const currentImgWrap = document.getElementById('editCurrentImgWrap');
    const currentImg     = document.getElementById('editCurrentImg');
    const removeCheckbox = document.getElementById('editRemoveImage');

    // Reset state checkbox & drop zone
    removeCheckbox.checked = false;
    document.getElementById('editDropZone').style.opacity       = '';
    document.getElementById('editDropZone').style.pointerEvents = '';

    if (imageUrl) {
        currentImg.src = `/${imageUrl}`;
        currentImgWrap.classList.remove('hidden');
    } else {
        currentImgWrap.classList.add('hidden');
    }

    // 5. Reset preview gambar baru
    clearEditImage();

    // 6. Tampilkan modal
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
    clearEditImage();
}

// Tutup modal edit jika klik di luar panel sudah dihandle via onclick backdrop

// ══════════════════════════════════════════════
// UPLOAD GAMBAR — Modal Buat Post
// ══════════════════════════════════════════════
function handleFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    showPreview(input.files[0]);
}
function showPreview(file) {
    if (file.size > 2 * 1024 * 1024) { alert('Ukuran file terlalu besar. Maksimal 2 MB.'); clearImage(); return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imgPreview').src             = e.target.result;
        document.getElementById('imgFileName').textContent    = file.name;
        document.getElementById('imgFileSize').textContent    = formatBytes(file.size);
        document.getElementById('imgPreviewWrap').classList.add('show');
        document.getElementById('dropZone').style.display     = 'none';
    };
    reader.readAsDataURL(file);
}
function clearImage() {
    document.getElementById('imageInput').value             = '';
    document.getElementById('imgPreview').src               = '';
    document.getElementById('imgFileName').textContent      = '';
    document.getElementById('imgFileSize').textContent      = '';
    document.getElementById('imgPreviewWrap').classList.remove('show');
    document.getElementById('dropZone').style.display       = '';
}

// Drag & drop — modal buat post
const dz = document.getElementById('dropZone');
if (dz) {
    dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', ()  => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault(); dz.classList.remove('dragover');
        const file = e.dataTransfer.files[0]; if (!file) return;
        const dt = new DataTransfer(); dt.items.add(file);
        document.getElementById('imageInput').files = dt.files;
        showPreview(file);
    });
}

// ══════════════════════════════════════════════
// UPLOAD GAMBAR — Modal Edit Post
// ══════════════════════════════════════════════
function handleEditFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    showEditPreview(input.files[0]);
}
function showEditPreview(file) {
    if (file.size > 2 * 1024 * 1024) { alert('Ukuran file terlalu besar. Maksimal 2 MB.'); clearEditImage(); return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('editImgPreview').src          = e.target.result;
        document.getElementById('editImgFileName').textContent = file.name;
        document.getElementById('editImgFileSize').textContent = formatBytes(file.size);
        document.getElementById('editImgPreviewWrap').classList.add('show');
        document.getElementById('editDropZone').style.display  = 'none';
    };
    reader.readAsDataURL(file);
}
function clearEditImage() {
    document.getElementById('editImageInput').value            = '';
    const preview = document.getElementById('editImgPreview');
    if (preview) preview.src                                   = '';
    const fname = document.getElementById('editImgFileName');
    if (fname) fname.textContent                               = '';
    const fsize = document.getElementById('editImgFileSize');
    if (fsize) fsize.textContent                               = '';
    document.getElementById('editImgPreviewWrap').classList.remove('show');
    document.getElementById('editDropZone').style.display      = '';
}

// Checkbox "Hapus foto" di modal edit
function toggleEditRemoveImage(cb) {
    const dropZone = document.getElementById('editDropZone');
    if (cb.checked) {
        dropZone.style.opacity       = '.4';
        dropZone.style.pointerEvents = 'none';
        clearEditImage();
    } else {
        dropZone.style.opacity       = '';
        dropZone.style.pointerEvents = '';
    }
}

// Drag & drop — modal edit
const editDz = document.getElementById('editDropZone');
if (editDz) {
    editDz.addEventListener('dragover',  e => { e.preventDefault(); editDz.classList.add('dragover'); });
    editDz.addEventListener('dragleave', ()  => editDz.classList.remove('dragover'));
    editDz.addEventListener('drop', e => {
        e.preventDefault(); editDz.classList.remove('dragover');
        const file = e.dataTransfer.files[0]; if (!file) return;
        const dt = new DataTransfer(); dt.items.add(file);
        document.getElementById('editImageInput').files = dt.files;
        showEditPreview(file);
    });
}

// ══════════════════════════════════════════════
// UTILITAS BERSAMA
// ══════════════════════════════════════════════
function formatBytes(bytes) {
    if (bytes < 1024)        return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(0) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

// ══════════════════════════════════════════════
// KOMENTAR & REPLY
// ══════════════════════════════════════════════
function toggleComments(id) {
    document.getElementById('comments-' + id)?.classList.toggle('hidden');
}
function toggleReply(id) {
    document.getElementById(id)?.classList.toggle('open');
}

// ══════════════════════════════════════════════
// DROPDOWN (edit/hapus)
// ══════════════════════════════════════════════
function toggleDD(id) {
    document.querySelectorAll('[id^="dd-"]').forEach(d => {
        if (d.id !== id) d.classList.add('hidden');
    });
    document.getElementById(id)?.classList.toggle('hidden');
}
document.addEventListener('click', e => {
    if (!e.target.closest('[onclick^="toggleDD"]'))
        document.querySelectorAll('[id^="dd-"]').forEach(d => d.classList.add('hidden'));
});

// ══════════════════════════════════════════════
// FILTER KATEGORI
// ══════════════════════════════════════════════
function filterCat(catId) {
    document.querySelectorAll('.cat-btn').forEach(btn => {
        const on = btn.dataset.cat == catId;
        btn.classList.toggle('bg-be-primary',    on);
        btn.classList.toggle('text-white',        on);
        btn.classList.toggle('border-be-primary', on);
        btn.classList.toggle('text-be-muted',    !on);
        btn.classList.toggle('border-gray-200',  !on);
        btn.classList.toggle('bg-white',         !on);
    });
    document.querySelectorAll('#postsContainer > article').forEach(card => {
        card.style.display = (catId === 'all' || card.dataset.category == catId) ? '' : 'none';
    });
}

// ══════════════════════════════════════════════
// PENCARIAN REAL-TIME
// ══════════════════════════════════════════════
document.getElementById('searchInput')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#postsContainer > article').forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush