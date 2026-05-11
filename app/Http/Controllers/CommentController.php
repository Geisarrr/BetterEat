<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ditambahkan untuk Session

class CommentController extends Controller
{
    /**
     * [CREATE] Menyimpan komentar baru (Komentar utama & Balasan)
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id'           => 'required|exists:posts,post_id',
            // user_id dihapus dari validasi form karena kita ambil dari Auth
            'parent_comment_id' => 'nullable|exists:comments,comment_id',
            'content'           => 'required|string',
        ]);

        Comment::create([
            'post_id'           => $request->post_id,
            'user_id'           => Auth::id(), // Otomatis mengisi dengan ID user yang sedang login
            'parent_comment_id' => $request->parent_comment_id,
            'content'           => $request->content,
        ]);

        // Langsung kembalikan user ke halaman postingan tersebut sambil bawa pesan sukses
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * [READ] Menampilkan halaman form edit untuk satu komentar
     */
    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);

        // Keamanan: Cegah user masuk ke form edit komentar milik orang lain
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan komentar Anda.');
        }

        // FE tinggal menyiapkan file resources/views/comments/edit.blade.php
        return view('comments.edit', compact('comment'));
    }

    /**
     * [UPDATE] Memperbarui isi komentar
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);

        // Keamanan: Validasi kepemilikan sebelum mengizinkan update
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'content' => 'required|string', // Diubah jadi required karena form edit pastinya diisi
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        // Kembalikan ke halaman postingan atau feed setelah sukses edit
        return redirect()->route('posts.index')->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * [DELETE] Menghapus komentar
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);

        // Keamanan: Validasi kepemilikan sebelum menghapus
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $comment->delete(); // Balasan (replies) otomatis terhapus berkat onDelete('cascade') di DB

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}