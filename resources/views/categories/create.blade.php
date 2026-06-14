@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle"></i> Tambah Kategori Baru
            </h1>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                        @csrf

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama kategori"
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label fw-semibold">
                                Slug <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   id="slug"
                                   name="slug"
                                   value="{{ old('slug') }}"
                                   placeholder="slug-kategori"
                                   readonly>
                            <small class="form-text text-muted mt-1">
                                <i class="bi bi-info-circle"></i> Auto-generate dari nama, bisa diedit manual.
                            </small>
                            @error('slug')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Kategori Aktif
                                </label>
                                <small class="d-block text-muted mt-1">
                                    Kategori aktif dapat digunakan untuk produk baru.
                                </small>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Kategori
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-md-4">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title fw-semibold mb-3">
                        <i class="bi bi-lightbulb"></i> Tips
                    </h6>
                    <ul class="small text-muted list-unstyled">
                        <li><i class="bi bi-check-lg"></i> Nama kategori harus unik</li>
                        <li><i class="bi bi-check-lg"></i> Slug otomatis dari nama (bisa diubah)</li>
                        <li><i class="bi bi-check-lg"></i> Deskripsi opsional untuk detail kategori</li>
                        <li><i class="bi bi-check-lg"></i> Status aktif untuk kategori default</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-slug generation
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    let isAutoGenerating = true;

    // Convert text to slug
    function toSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')        // Remove special chars
            .replace(/\s+/g, '-')            // Replace spaces with -
            .replace(/-+/g, '-')             // Replace multiple - with single -
            .replace(/^-+|-+$/g, '');        // Remove leading/trailing -
    }

    // Listen to name input
    nameInput.addEventListener('input', function () {
        if (isAutoGenerating) {
            slugInput.value = toSlug(this.value);
        }
    });

    // Slug manual edit
    slugInput.addEventListener('focus', function () {
        isAutoGenerating = false;
        this.removeAttribute('readonly');
    });

    // Reset auto-generate if slug is empty
    slugInput.addEventListener('input', function () {
        if (this.value === '') {
            isAutoGenerating = true;
            slugInput.value = toSlug(nameInput.value);
        }
    });

    // Re-enable auto-generate on blur if slug was emptied
    slugInput.addEventListener('blur', function () {
        if (this.value === '') {
            isAutoGenerating = true;
            this.setAttribute('readonly', '');
        }
    });

    // Generate slug on initial name value
    if (nameInput.value) {
        slugInput.value = toSlug(nameInput.value);
    }
</script>
@endpush
@endsection
