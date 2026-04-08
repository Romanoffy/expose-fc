@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Latihan</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Kelola jadwal dan kegiatan latihan</p>
            </div>
            <a href="/admin/latihan/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Latihan
            </a>
        </div>

        <!-- Main Card -->
        <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
            <div class="card-body p-0">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom p-4" style="border-color: var(--glass-border) !important;">
                    <div>
                        <h5 class="mb-1 text-white" style="color: var(--text-primary); font-weight: 600;">Daftar Latihan</h5>
                        <p class="small mb-0 text-white">Total: {{ count($latihan_array) }} jadwal latihan</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm text-white">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-secondary btn-sm text-white">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-responsive">
                    <table class="table-hover mb-0 table" style="color: var(--text-secondary);">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 px-4 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                    <div class="d-flex align-items-center gap-2 text-black">
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Pelatih</th>
                                <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Kegiatan</th>
                                <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Jadwal</th>
                                <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Catatan</th>
                                <th class="border-0 py-3 text-center text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latihan_array as $latihan)
                                <tr class="border-bottom" style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                    onmouseout="this.style.background='transparent'">
                                    
                                    <!-- ID -->
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                            #{{ str_pad($latihan->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <!-- Pelatih Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($latihan->gambar)
                                                <img src="{{ asset('storage/' . $latihan->gambar) }}" 
                                                     class="rounded-circle"
                                                     style="width: 48px; height: 48px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                     alt="{{ $latihan->nama_pelatih }}">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 18px; border: 2px solid var(--glass-border);">
                                                    {{ substr($latihan->nama_pelatih, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold mb-0 text-black" style="color: var(--text-primary); font-size: 14px;">
                                                    {{ $latihan->nama_pelatih }}
                                                </h6>
                                                <small class="text-muted">Pelatih</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kegiatan -->
                                    <td class="py-3">
                                        <div style="max-width: 250px;">
                                            <span class="text-black" style="font-size: 13px;">
                                                {{ Str::limit($latihan->kegiatan_latihan, 50) }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Jadwal -->
                                    <td class="py-3">
                                        <div style="font-size: 12px;">
                                            <div class="mb-1">
                                                <i class="fas fa-play-circle me-2" style="color: var(--success); font-size: 11px;"></i>
                                                <span class="text-black">{{ \Carbon\Carbon::parse($latihan->jam_mulai_berlatih)->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div>
                                                <i class="fas fa-stop-circle me-2" style="color: var(--error); font-size: 11px;"></i>
                                                <span class="text-black">{{ \Carbon\Carbon::parse($latihan->jam_selesai_berlatih)->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Catatan -->
                                    <td class="py-3">
                                        <div style="max-width: 200px;">
                                            <span class="text-muted small">
                                                {{ Str::limit($latihan->catatan, 40) }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/admin/latihan/{{ $latihan->id }}/edit"
                                               class="btn btn-outline-primary btn-sm"
                                               style="padding: 6px 10px; font-size: 12px;"
                                               title="Edit Latihan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    style="padding: 6px 10px; font-size: 12px;"
                                                    title="Hapus Latihan"
                                                    onclick="confirmDelete({{ $latihan->id }}, '{{ $latihan->kegiatan_latihan }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-5 text-center">
                                        <div style="color: var(--text-light);">
                                            <i class="fas fa-calendar-alt fa-3x mb-3 opacity-50"></i>
                                            <h6 style="color: var(--text-secondary);">Belum ada jadwal latihan</h6>
                                            <p class="mb-3">Mulai dengan menambahkan jadwal latihan pertama</p>
                                            <a href="/admin/latihan/create" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>Tambah Latihan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (method_exists($latihan_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $latihan_array->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--dark-card); border: 1px solid var(--glass-border);">
                <div class="modal-header" style="border-color: var(--glass-border);">
                    <h5 class="modal-title" style="color: var(--text-primary);">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p>Apakah Anda yakin ingin menghapus latihan <strong id="deleteName" style="color: var(--text-primary);"></strong>?</p>
                    <p class="text-warning small mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer" style="border-color: var(--glass-border);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
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
            document.getElementById('deleteForm').action = `/admin/latihan/${id}`;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection