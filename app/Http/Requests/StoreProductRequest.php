<?php
// app/Http/Requests/StoreProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    // Authorize request — pastikan user diizinkan
    public function authorize(): bool
    {
        return true; // Semua user bisa buat produk
    }

    // Aturan validasi
    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:200|unique:products,name',
            'slug'        => 'nullable|string|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:5000',
            'status'      => 'required|in:active,inactive,draft',
            'image'       => 'nullable|image|mimes:jpeg,png,webp|max:2048',
       ];
    }

    // Pesan error kustom (opsional)
    public function messages(): array
    {
        return [
            'name.required'    => 'Nama produk wajib diisi.',
            'name.unique'      => 'Nama produk sudah digunakan.',
            'name.min'         => 'Nama produk minimal 3 karakter.',
            'name.max'         => 'Nama produk maksimal 200 karakter.',
            'slug.unique'      => 'Slug produk sudah digunakan.',
            'price.required'   => 'Harga produk wajib diisi.',
            'price.numeric'    => 'Harga harus berupa angka.',
            'stock.required'   => 'Stok produk wajib diisi.',
            'stock.integer'    => 'Stok harus berupa angka bulat.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'status.required'  => 'Status produk wajib dipilih.',
            'status.in'        => 'Status harus: aktif, nonaktif, atau draft.',
            'image.image'      => 'File harus berupa gambar.',
            'image.mimes'      => 'Format gambar: JPEG, PNG, WebP.',
            'image.max'        => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    // Validasi rule sudah lengkap, tidak perlu prepareForValidation()
    // Controller akan generate slug dengan suffix random untuk unik
}



