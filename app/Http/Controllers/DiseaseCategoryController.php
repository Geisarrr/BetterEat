<?php

namespace App\Http\Controllers;

use App\Models\DiseaseCategory;
use Illuminate\Http\Request;

class DiseaseCategoryController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua daftar kategori penyakit
        $categories = DiseaseCategory::all();
        return response()->json($categories);
    }

    public function create()
    {
        // Form tambah data (kosongkan jika pakai API)
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan kategori penyakit baru
        $request->validate([
            // 'unique' agar tidak ada kategori dengan nama ganda (misal: "Diabetes" diinput 2x)
            'name'        => 'required|string|max:255|unique:disease_categories',
            'description' => 'nullable|string',
        ]);

        $category = DiseaseCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Kategori penyakit berhasil ditambahkan!', 
            'data'    => $category
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail satu kategori spesifik
        $category = DiseaseCategory::findOrFail($id);
        return response()->json($category);
    }

    public function edit(string $id)
    {
        // Form edit data (kosongkan jika pakai API)
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Memperbarui data kategori penyakit
        $category = DiseaseCategory::findOrFail($id);

        $request->validate([
            // Validasi unique diabaikan untuk nama miliknya sendiri (menggunakan primary key 'category_id')
            'name'        => 'sometimes|required|string|max:255|unique:disease_categories,name,' . $id . ',category_id',
            'description' => 'nullable|string',
        ]);

        if ($request->has('name')) $category->name = $request->name;
        if ($request->has('description')) $category->description = $request->description;

        $category->save();

        return response()->json([
            'message' => 'Kategori penyakit berhasil diupdate!', 
            'data'    => $category
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus kategori penyakit
        $category = DiseaseCategory::findOrFail($id);
        $category->delete();
        
        return response()->json(['message' => 'Kategori penyakit berhasil dihapus!']);
    }
}