{{-- resources/views/admin/roles/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Daftar Role')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1">Daftar Role</h1>
            <p class="text-muted mb-0">Kelola role dan akses permission untuk panel admin.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Create Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Role</th>
                            <th>Jumlah Permission</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>{{ $role->permissions_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-secondary me-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus role ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    Belum ada role.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>
</div>
@endsection
