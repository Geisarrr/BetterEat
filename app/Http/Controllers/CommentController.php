<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua komentar beserta user dan balasannya
        $comments = Comment::with(['user', 'replies'])->get();
        return response()->json($comments);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan komentar baru (baik komentar utama maupun balasan)
        $request->validate([
            'post_id'           => 'required|exists:posts,post_id',
            'user_id'           => 'required|exists:users,user_id',
            // parent_comment_id bisa kosong jika ini komentar utama
            'parent_comment_id' => 'nullable|exists:comments,comment_id',
            'content'           => 'required|string',
        ]);

        $comment = Comment::create($request->all());

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan!',
            'data'    => $comment
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail satu komentar beserta user dan balasannya
        $comment = Comment::with(['user', 'replies', 'post'])->findOrFail($id);
        return response()->json($comment);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Memperbarui isi komentar
        $comment = Comment::findOrFail($id);

        $request->validate([
            // ID tidak boleh diubah, hanya isi konten yang boleh diubah
            'content' => 'sometimes|required|string',
        ]);

        if ($request->has('content')) {
            $comment->content = $request->content;
        }

        $comment->save();

        return response()->json([
            'message' => 'Komentar berhasil diperbarui!',
            'data'    => $comment
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus komentar. 
        // Berkat onDelete('cascade') di migration, balasan komentar ini juga akan otomatis terhapus!
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus!']);
    }
}