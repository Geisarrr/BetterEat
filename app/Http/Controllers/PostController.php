<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\DiseaseCategory; // Wajib ditambahkan untuk form kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ditambahkan untuk Session

class PostController extends Controller
{
    /**
     * [READ] Menampilkan halaman feed semua postingan komunitas
     */
    public function index()
    {
        $posts = Post::with(['user', 'category'])->latest()->get();
        
        // Lempar ke file resources/views/posts/index.blade.php
        return view('posts.index', compact('posts'));
    }

    /**
     * [READ] Filter Postingan Berdasarkan Kategori Kesehatan
     */
    public function getByCategory($categoryId)
    {
        $posts = Post::with(['user', 'category'])
                    ->where('category_id', $categoryId)
                    ->latest()
                    ->get();

        // Bisa menggunakan view index yang sama, tapi datanya sudah terfilter
        return view('posts.index', compact('posts'));
    }

    /**
     * TAMPILAN FORM BUAT POSTINGAN
     */
    public function create()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown <select> form FE
        $categories = DiseaseCategory::all();
        
        return view('posts.create', compact('categories'));
    }

    /**
     * [CREATE] Menyimpan postingan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            // user_id dihapus dari validasi, diganti Auth::id() di bawah
            'category_id'  => 'required|exists:disease_categories,category_id',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'image_url'    => 'nullable|string', 
        ]);

        Post::create([
            'user_id'      => Auth::id(), // Ambil identitas user yang sedang login
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'content'      => $request->content,
            'image_url'    => $request->image_url,
            'is_moderated' => false, // Default false saat pertama kali posting
        ]);

        return redirect()->route('posts.index')
                         ->with('success', 'Postingan berhasil dibagikan ke komunitas!');
    }

    /**
     * [READ] Detail satu postingan (biasanya untuk melihat komentar)
     */
    public function show(string $id)
    {
        // Eager load juga user dari tiap komentar agar FE gampang nampilin nama yang komen
        $post = Post::with(['user', 'category', 'comments.user'])->findOrFail($id);
        
        return view('posts.show', compact('post'));
    }

    /**
     * TAMPILAN FORM EDIT POSTINGAN
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        // KEAMANAN: Cegah user masuk ke form edit milik orang lain
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak berhak mengedit postingan ini.');
        }

        $categories = DiseaseCategory::all();
        
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * [UPDATE] Memperbarui postingan
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        // KEAMANAN: Cek ulang sebelum menyimpan perubahan
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category_id'  => 'required|exists:disease_categories,category_id',
            'image_url'    => 'nullable|string',
        ]);

        $post->update([
            'title'       => $request->title,
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'image_url'   => $request->image_url,
        ]);

        // Lempar kembali ke halaman detail postingan tersebut
        return redirect()->route('posts.show', $post->post_id)
                         ->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * [DELETE] Menghapus postingan
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // KEAMANAN: Cek kepemilikan sebelum hapus
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Postingan berhasil dihapus!');
    }
}