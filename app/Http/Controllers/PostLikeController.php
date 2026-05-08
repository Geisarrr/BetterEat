<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua data like beserta user dan post-nya
        $likes = PostLike::with(['user', 'post'])->get();
        return response()->json($likes);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menambahkan Like pada postingan
        $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'user_id' => 'required|exists:users,user_id',
        ]);

        // Cek apakah sudah pernah di-like sebelumnya
        $alreadyLiked = PostLike::where('post_id', $request->post_id)
                                ->where('user_id', $request->user_id)
                                ->first();

        if ($alreadyLiked) {
            return response()->json(['message' => 'Kamu sudah menyukai postingan ini!'], 400);
        }

        $like = PostLike::create($request->all());

        return response()->json([
            'message' => 'Postingan berhasil di-like!',
            'data'    => $like
        ]);
    }

    public function show(Request $request)
    {
        // [READ] Cek spesifik apakah seorang user menyukai post tertentu (bisa dipakai untuk UI tombol Like)
        $request->validate([
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $like = PostLike::where('post_id', $request->post_id)
                        ->where('user_id', $request->user_id)
                        ->first();

        if ($like) {
            return response()->json(['is_liked' => true, 'data' => $like]);
        }

        return response()->json(['is_liked' => false], 404);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Secara logika aplikasi, fitur Like tidak pernah di-update. 
        // Hanya ada status ditambah (Like) atau dihapus (Unlike).
        return response()->json(['message' => 'Method not allowed untuk tabel Like. Gunakan Store atau Destroy.'], 405);
    }

    public function destroy(Request $request)
    {
        // [DELETE] Menghapus Like (Unlike)
        $request->validate([
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $deleted = PostLike::where('post_id', $request->post_id)
                           ->where('user_id', $request->user_id)
                           ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Like berhasil dihapus (Unlike)!']);
        }

        return response()->json(['message' => 'Data like tidak ditemukan!'], 404);
    }
}