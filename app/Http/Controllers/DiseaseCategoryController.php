<?php

namespace App\Http\Controllers;

use App\Models\DiseaseCategory;
use Illuminate\Http\Request;

class DiseaseCategoryController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua kategori penyakit
     */
    public function index()
    {
        $categories = DiseaseCategory::all();
        
        // Mengarahkan ke file resources/views/disease_categories/index.blade.php
        return view('disease_categories.index', compact('categories'));
    }

    /**
     * TAMPILAN FORM TAMBAH DATA
     */
    public function create()
    {
        // Mengarahkan ke file resources/views/disease_categories/create.blade.php
        return view('disease_categories.create');
    }

    /**
     * [CREATE] Menyimpan kategori penyakit baru dari form
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'unique' agar tidak ada kategori ganda di tabel disease_categories
            'name'        => 'required|string|max:255|unique:disease_categories,name',
            'description' => 'nullable|string',
        ]);

        DiseaseCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Lempar kembali ke halaman index tabel kategori bawa pesan sukses
        return redirect()->route('disease_categories.index')
                         ->with('success', 'Kategori penyakit berhasil ditambahkan!');
    }

    /**
     * [READ] Menampilkan detail satu kategori spesifik
     */
    public function show(string $id)
    {
        $category = DiseaseCategory::findOrFail($id);
        
        // Mengarahkan ke file resources/views/disease_categories/show.blade.php
        return view('disease_categories.show', compact('category'));
    }

    /**
     * TAMPILAN FORM EDIT DATA
     */
    public function edit(string $id)
    {
        $category = DiseaseCategory::findOrFail($id);
        
        // Mengarahkan ke file resources/views/disease_categories/edit.blade.php
        return view('disease_categories.edit', compact('category'));
    }

    /**
     * [UPDATE] Menyimpan perubahan data kategori dari form edit
     */
    public function update(Request $request, string $id)
    {
        $category = DiseaseCategory::findOrFail($id);

        $request->validate([
            // Validasi unique diabaikan untuk nama miliknya sendiri (menggunakan primary key 'category_id')
            'name'        => 'required|string|max:255|unique:disease_categories,name,' . $id . ',category_id',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Lempar kembali ke halaman index
        return redirect()->route('disease_categories.index')
                         ->with('success', 'Kategori penyakit berhasil diupdate!');
    }

    /**
     * [DELETE] Menghapus kategori penyakit
     */
    public function destroy(string $id)
    {
        $category = DiseaseCategory::findOrFail($id);
        $category->delete();
        
        // Menggunakan back() agar kembali ke halaman sebelumnya (biasanya halaman index)
        return back()->with('success', 'Kategori penyakit berhasil dihapus!');
    }
}