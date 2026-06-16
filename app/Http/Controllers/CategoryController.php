<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Tampilkan semua kategori dengan pagination
     */
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk membuat kategori baru
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru ke database
     * Validasi: name dan slug harus unik
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        // Validasi unik name dan slug
        $validated = $request->validated();

        // Cek duplikasi name
        if (Category::where('name', $validated['name'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama kategori "' . $validated['name'] . '" sudah digunakan.');
        }

        // Cek duplikasi slug
        if (Category::where('slug', $validated['slug'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Slug "' . $validated['slug'] . '" sudah digunakan.');
        }

        // Simpan kategori jika validasi unik passed
        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tidak digunakan (redirect ke index)
     */
    public function show(Category $category): RedirectResponse
    {
        return redirect()->route('categories.index');
    }

    /**
     * Tampilkan form untuk edit kategori
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update kategori di database
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori dari database
     * CEK: kategori tidak boleh memiliki produk aktif
     */
    public function destroy(Category $category): RedirectResponse
{
    if ($category->products()->where('status', 'active')->exists()) {
        return back()->with(
            'error',
            'Kategori masih memiliki produk aktif.'
        );
    }

    $category->products()
        ->withTrashed()
        ->forceDelete();

    $category->delete();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Kategori berhasil dihapus.');
}
}
