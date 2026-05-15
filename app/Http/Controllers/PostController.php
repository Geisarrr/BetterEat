<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\DiseaseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan semua post (jika dipakai sebagai resource index)
     */
    public function index()
    {
        $posts = Post::with(['user', 'category', 'comments', 'likes'])->latest()->get();
        $categories = DiseaseCategory::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Menyimpan post baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:disease_categories,category_id',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {

            if (!file_exists(public_path('uploads/posts'))) {
                mkdir(public_path('uploads/posts'), 0777, true);
            }

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/posts'), $filename);

            $imageUrl = 'uploads/posts/' . $filename;
        }

        Post::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'image_url'   => $imageUrl,
        ]);

        return redirect()
            ->route('community')
            ->with('success', 'Postingan berhasil dibagikan!');
    }

    /**
     * Menampilkan form edit post
     * — dipanggil via GET /posts/{post}/edit
     */
    public function edit(Post $post)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit postingan ini.');
        }

        $categories = DiseaseCategory::all();

        // Jika ingin halaman terpisah, uncomment baris ini:
        // return view('posts.edit', compact('post', 'categories'));

        // Untuk pendekatan modal (redirect kembali ke community dengan data edit):
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $postId)
    {
        // Cari post berdasarkan post_id
        $post = Post::where('post_id', $postId)->firstOrFail();

        // Pastikan hanya pemilik post yang bisa edit
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        // Validasi
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:disease_categories,category_id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update data dasar
        $post->title       = $request->title;
        $post->content     = $request->content;
        $post->category_id = $request->category_id;

        // =========================
        // HAPUS FOTO LAMA
        // =========================
        if ($request->remove_image) {

            if ($post->image_url && file_exists(public_path($post->image_url))) {
                unlink(public_path($post->image_url));
            }

            $post->image_url = null;
        }

        // =========================
        // UPLOAD FOTO BARU
        // =========================
        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if ($post->image_url && file_exists(public_path($post->image_url))) {
                unlink(public_path($post->image_url));
            }

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/posts'), $filename);

            $post->image_url = 'uploads/posts/' . $filename;
        }

        $post->save();

        return back()->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus gambar dari storage jika ada
        if ($post->image_url && str_starts_with($post->image_url, 'storage/')) {
            $oldPath = str_replace('storage/', '', $post->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $post->delete();

        return redirect()->route('community')->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * Filter post berdasarkan kategori (AJAX / page filter)
     */
    public function getByCategory($category)
    {
        $posts = Post::with(['user', 'category', 'comments', 'likes'])
                     ->where('category_id', $category)
                     ->latest()
                     ->get();

        return response()->json($posts);
    }

    
}