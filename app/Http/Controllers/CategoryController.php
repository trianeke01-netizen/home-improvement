<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan seluruh data kategori.
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan halaman tambah kategori.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan data kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori.
     * (Tidak digunakan pada sistem ini)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan halaman edit kategori.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Menyimpan perubahan data kategori.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}