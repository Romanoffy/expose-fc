@extends('layouts.dashboard')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Blogs</h4>
            <p class="mb-0" style="color: var(--text-secondary);">Kelola data blogs Expose FC</p>
        </div>
        <a href="/admin/blogs/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Blog
        </a>
    </div>

    <!-- Main Card -->
    <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
        <div class="card-body p-0">
            <!-- Card Header -->
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom" style="border-color: var(--glass-border) !important;">
                <div>
                    <h5 class="text-white mb-1" style="color: var(--text-primary); font-weight: 600;">Daftar Blogs</h5>
                    <p class="text-white mb-0 small">Total: {{ count($blog_array) }} blog terdaftar</p>
                </div>    
                <div class="d-flex gap-2">
                    <button class="text-white btn btn-outline-secondary btn-sm">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <button class="text-white btn btn-outline-secondary btn-sm">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: var(--text-secondary);">
                    <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                        <tr>
                            <th class="border-0 py-3 px-4" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                <div class="text-black d-flex align-items-center gap-2">
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Picture</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Title</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Date</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Mini Description</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Full Description</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Writer</th>
                            <th class="text-black border-0 py-3 text-center" style="color: var(--text-primary); font-weight: 600; font-size: 13px;" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blog_array as $blog)
                        <tr class="border-bottom" style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);" 
                            onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'" 
                            onmouseout="this.style.background='transparent'">
                             <td class="py-3 px-4">
                                <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                    #{{ str_pad($blog->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if($blog->picture)
                                    <img src="{{ asset('storage/' . $blog->picture) }}" style="width:48px;height:48px;object-fit:cover;border-radius:4px;">
                                @endif
                            </td>
                            <td class="py-3">{{ $blog->title }}</td>
                            <td class="py-3">{{ $blog->date }}</td>
                            <td class="py-3">{{ $blog->mini_description }}</td>
                            <td class="py-3">{!! $blog->full_description !!}</td>
                            <td class="py-3">{{ $blog->writer }}</td>
                            <td class="py-3 text-center">
                                <a href="/admin/blogs/{{ $blog->id }}/edit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="py-3 text-center">
                                <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $blog->id }}, '{{ $blog->title }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div style="color: var(--text-light);">
                                    <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                                    <h6 style="color: var(--text-secondary);">Belum ada data blog</h6>
                                    <p class="mb-3">Mulai dengan menambahkan blog pertama</p>
                                    <a href="/admin/blogs/create" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Tambah Blog
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($blog_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $blog_array->links('pagination::bootstrap-5') }}
                    </div>
                @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--dark-card); border: 1px solid var(--glass-border);">
            <div class="modal-header" style="border-color: var(--glass-border);">
                <h5 class="modal-title" style="color: var(--text-primary);">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" style="color: var(--text-secondary);">
                <p>Apakah Anda yakin ingin menghapus blog <strong id="deleteName" style="color: var(--text-primary);"></strong>?</p>
                <p class="text-warning small mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer" style="border-color: var(--glass-border);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/blogs/${id}`;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

@endsection
