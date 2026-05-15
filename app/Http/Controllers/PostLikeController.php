<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use App\Models\Post; // Tambahkan ini untuk validasi postingan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib untuk membaca user yang login

class PostLikeController extends Controller
{
    /**
     * [ACTION] Toggle Like / Unlike
     * Fungsi ini bertugas ganda: kalau belum like jadi nambah, kalau sudah like jadi ngehapus.
     */
    public function toggle($postId)
    {
        // 1. Pastikan postingan yang mau di-like itu beneran ada
        $post = Post::findOrFail($postId);
        
        // 2. Ambil ID user yang sedang login saat ini
        $userId = Auth::id();

        // 3. Cek di database apakah user ini sudah pernah nge-like postingan tersebut
        $existingLike = PostLike::where('post_id', $postId)
                                ->where('user_id', $userId)
                                ->first();

        if ($existingLike) {
            // [UNLIKE] Jika datanya sudah ada, berarti user klik tombol untuk batal nge-like
            PostLike::where('post_id', $postId)
                ->where('user_id', $userId)
                ->delete();
            
            // Kembalikan ke halaman feed tanpa pesan sukses agar UI tidak berisik (spam pop-up)
            return back();
        } else {
            // [LIKE] Jika datanya belum ada, berarti user ingin nge-like postingan ini
            PostLike::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            
            return back();
        }
    }
}