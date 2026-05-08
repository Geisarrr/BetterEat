<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua post beserta data user dan kategorinya
        $posts = Post::with(['user', 'category'])->get();
        return response()->json($posts);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan postingan baru
        $request->validate([
            'user_id'      => 'required|exists:users,user_id',
            'category_id'  => 'required|exists:disease_categories,category_id',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'is_moderated' => 'boolean',
        ]);

        $post = Post::create($request->all());

        return response()->json([
            'message' => 'Postingan berhasil dibuat!',
            'data'    => $post
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail satu postingan beserta relasinya
        $post = Post::with(['user', 'category'])->findOrFail($id);
        return response()->json($post);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Memperbarui postingan
        $post = Post::findOrFail($id);

        $request->validate([
            'user_id'      => 'sometimes|required|exists:users,user_id',
            'category_id'  => 'sometimes|required|exists:disease_categories,category_id',
            'title'        => 'sometimes|required|string|max:255',
            'content'      => 'sometimes|required|string',
            'is_moderated' => 'sometimes|boolean',
        ]);

        $post->update($request->all());

        return response()->json([
            'message' => 'Postingan berhasil diupdate!',
            'data'    => $post
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus postingan
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Postingan berhasil dihapus!']);
    }
}