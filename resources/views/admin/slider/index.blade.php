@extends('layouts.dashboard')
@section('content')
    <style>
        td blockquote {
            color: black;
            border-left: 4px solid var(--primary-light);
            padding-left: 12px;
            margin: 8px 0;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Slider</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Kelola gambar slider Expose FC</p>
            </div>
            <a href="/admin/slider/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Slider
            </a>
        </div>

        <!-- Main Card -->
        <div class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
            <div class="card-body p-0">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom"
                    style="border-color: var(--glass-border) !important;">
                    <div>
                        <h5 class="text-white mb-1" style="color: var(--text-primary); font-weight: 600;">Daftar Slider</h5>
                        <p class="text-white mb-0 small">Total: {{ count($sliders) }} slider terdaftar</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="color: var(--text-secondary);">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 py-3 px-4"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                    <div class="text-black d-flex align-items-center gap-2">
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th class="text-black border-0 py-3"
                                    style="color: var(--text-primary); font-weight:600; font-size:13px;">gambar</th>
                                <th class="text-black border-0 py-3"
                                    style="color: var(--text-primary); font-weight:600; font-size:13px;">Status</th>
                                <th class="text-black border-0 py-3 text-center"
                                    style="color: var(--text-primary); font-weight:600; font-size:13px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                                <tr class="border-bottom"
                                    style="border-color: rgba(51,65,85,0.3); transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99,102,241,0.05)'"
                                    onmouseout="this.style.background='transparent'">

                                    <td class="py-3 px-4">
                                        <span class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size:11px; padding:4px 8px;">
                                            #{{ str_pad($loop->index + 1, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <td class="py-3">
                                        @if ($slider->gambar)
                                            <img class="rounded"
                                                style="height:60px; width:120px; object-fit:cover; border:1px solid var(--glass-border);"
                                                src="{{ asset('storage/' . $slider->gambar) }}">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        <span class="badge {{ $slider->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}"
                                            style="font-size: 12px; padding: 6px 10px; border-radius: 8px;">
                                            {{ $slider->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/admin/slider/{{ $slider->id }}/edit"
                                                class="btn btn-outline-primary btn-sm"
                                                style="padding:6px 10px; font-size:12px;" title="Edit Slider">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                style="padding:6px 10px; font-size:12px;" title="Hapus Slider"
                                                onclick="confirmDelete({{ $slider->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-gambars fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada data slider</h6>
                                            <p class="mb-3">Tambahkan slider pertama kamu sekarang!</p>
                                            <a href="/admin/slider/create" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>Tambah Slider
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($sliders, 'links'))
                    <div class="border-top p-3" style="border-color: var(--glass-border) !important;">
                        {{ $sliders->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--dark-card); border:1px solid var(--glass-border);">
                <div class="modal-header" style="border-color: var(--glass-border);">
                    <h5 class="modal-title" style="color: var(--text-primary);">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p>Apakah Anda yakin ingin menghapus slider ini?</p>
                    <p class="text-warning small mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer" style="border-color: var(--glass-border);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/admin/slider/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
