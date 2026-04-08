@extends('layouts.dashboard')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Event</h4>
            <p class="mb-0" style="color: var(--text-secondary);">Kelola daftar event Expose FC</p>
        </div>
        <a href="/admin/events/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Event
        </a>
    </div>

    <!-- Main Card -->
    <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
        <div class="card-body p-0">
            <!-- Card Header -->
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom" style="border-color: var(--glass-border) !important;">
                <div>
                    <h5 class="text-white mb-1" style="color: var(--text-primary); font-weight: 600;">Daftar Event</h5>
                    <p class="text-white mb-0 small">Total: {{ count($event_array) }} event terdaftar</p>
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

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: var(--text-secondary);">
                    <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                        <tr>
                            <th class="border-0 py-3 px-4" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                <div class="text-black d-flex align-items-center gap-2">
                                    <span>ID</span>
                                </div>
                            </th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px; ">Nama</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Deskripsi</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Tanggal Mulai</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Tanggal Selesai</th>
                            <th class="text-black border-0 py-3" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Venue</th>
                            <th class="text-black border-0 py-3 text-center" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event_array as $event)
                        <tr class="border-bottom" 
                            style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);" 
                            onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'" 
                            onmouseout="this.style.background='transparent'">
                            
                            <td class="py-3 px-4">
                                <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                    #{{ str_pad($event->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="py-3">{{ $event->nama }}</td>
                            <td class="py-3" style="max-width: 250px;">{{ Str::limit($event->description, 80) }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y H:i') }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y H:i') }}</td>
                            <td class="py-3">{{ $event->venue_name }}</td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="/admin/events/{{ $event->id }}/edit" 
                                       class="btn btn-outline-primary btn-sm" 
                                       style="padding: 6px 10px; font-size: 12px;"
                                       title="Edit Event">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            style="padding: 6px 10px; font-size: 12px;"
                                            title="Hapus Event"
                                            onclick="confirmDelete({{ $event->id }}, '{{ $event->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div style="color: var(--text-light);">
                                    <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i>
                                    <h6 style="color: var(--text-secondary);">Belum ada data event</h6>
                                    <p class="mb-3">Mulai dengan menambahkan event pertama</p>
                                    <a href="/admin/events/create" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Tambah Event
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($event_array, 'links'))
                    <div
                        class="border-top p-3"
                        style="border-color: var(--glass-border) !important;"
                    >
                        {{ $event_array->links('pagination::bootstrap-5') }}
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
                <p>Apakah Anda yakin ingin menghapus event <strong id="deleteName" style="color: var(--text-primary);"></strong>?</p>
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
    document.getElementById('deleteForm').action = `/admin/events/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

@endsection
