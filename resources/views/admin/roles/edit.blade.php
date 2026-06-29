{{-- resources/views/admin/roles/edit.blade.php --}}
@extends('layouts.master')

@section('title', 'Edit Role')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h4 mb-1">Edit Role</h1>
        <p class="text-muted mb-0">Perbarui nama role dan permission yang dimiliki.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="form-control" placeholder="Contoh: manager">
                </div>

                <div class="mb-3">
                    <label class="form-label">Permission</label>
                    <div class="row g-2">
                        @php
                            $selectedPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                        @endphp

                        @forelse($permissions as $permission)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        id="permission_{{ $permission->id }}"
                                        {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">Belum ada permission tersedia.</div>
                        @endforelse
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
