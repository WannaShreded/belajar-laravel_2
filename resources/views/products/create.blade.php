{{-- Penggunaan Component Layout --}}


{{-- resources/views/products/create.blade.php --}}


@extends('layouts.master')


@section('title', 'Tambah Produk')


@section('content')


<div class="container">




<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">
        Tambah Produk Baru
    </h4>


    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>


<div class="card shadow-sm border-0">
    <div class="card-body">


        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf


            <div class="mb-3">
                <label class="form-label">
                    Nama Produk <span class="text-danger">*</span>
                </label>


                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Kategori <span class="text-danger">*</span>
                </label>


                <select
                    name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror"
                    required
                >
                    <option value="">
                        Pilih Kategori
                    </option>


                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Harga <span class="text-danger">*</span>
                </label>


                <input
                    type="number"
                    name="price"
                    class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price') }}"
                    step="0.01"
                    required
                >
                @error('price')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Stok <span class="text-danger">*</span>
                </label>


                <input
                    type="number"
                    name="stock"
                    class="form-control @error('stock') is-invalid @enderror"
                    value="{{ old('stock', 0) }}"
                    required
                >
                @error('stock')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Deskripsi
                </label>


                <textarea
                    name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="4"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Status <span class="text-danger">*</span>
                </label>


                <select
                    name="status"
                    class="form-select @error('status') is-invalid @enderror"
                    required
                >
                    <option value="">
                        Pilih Status
                    </option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">
                    Gambar Produk
                </label>


                <input
                    type="file"
                    name="image"
                    class="form-control @error('image') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/webp"
                >
                <small class="form-text text-muted">
                    Format: JPEG, PNG, WebP | Maksimal 2MB
                </small>
                @error('image')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="d-flex gap-2">
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="bi bi-check-circle"></i> Simpan Produk
                </button>
                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>


        </form>


    </div>
</div>




</div>


@endsection
