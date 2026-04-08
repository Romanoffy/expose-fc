@extends('layouts.dashboard')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Contacts</h4>
            <p class="mb-0" style="color: var(--text-secondary);">Kelola data kontak Expose FC</p>
        </div>
        <a href="/admin/contacts/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Contact
        </a>
    </div>

    <!-- Main Card -->
    <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
        <div class="card-body p-0">
            
            <!-- Card Header -->
            <div class="d-flex justify-content-between align-items-center border-bottom p-4" style="border-color: var(--glass-border) !important;">
                <div>
                    <h5 class="mb-1 text-white" style="color: var(--text-primary); font-weight: 600;">Daftar Contacts</h5>
                    <p class="small mb-0 text-white">Total: {{ count($contact_array) }} contacts terdaftar</p>
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
                            <th
                                    class="border-0 px-4 py-3"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                >
                                    <div class="d-flex align-items-center gap-2 text-black">
                                        <span>ID</span>
                                    </div>
                                </th>
                            <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Nama</th>
                            <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Email</th>
                            <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">No. HP</th>
                            <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">No. Telpon</th>
                            <th class="border-0 py-3 text-black" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Address</th>
                            <th class="border-0 py-3 text-black text-center" style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contact_array as $contact)
                        <tr class="border-bottom" style="border-color: rgba(51,65,85,0.3); transition: var(--transition-fast);" 
                            onmouseover="this.style.background='rgba(99,102,241,0.05)'" 
                            onmouseout="this.style.background='transparent'">
                            <td class="px-4 py-3">
                                <span class="badge" style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                    #{{ str_pad($contact->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="py-3">{{ $contact->name }}</td>
                            <td class="py-3">{{ $contact->email }}</td>
                            <td class="py-3">{{ $contact->no_hp }}</td>
                            <td class="py-3">{{ $contact->no_telp }}</td>
                            <td class="py-3">{{ $contact->address }}</td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-outline-primary btn-sm" onclick="window.location='/admin/contacts/{{ $contact->id }}/edit'"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $contact->id }}, '{{ $contact->name }}')"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center" style="color: var(--text-light);">
                                <i class="fas fa-address-book fa-3x mb-3 opacity-50"></i>
                                <h6 style="color: var(--text-secondary);">Belum ada data contacts</h6>
                                <p class="mb-3">Mulai dengan menambahkan kontak pertama</p>
                                <a href="/admin/contacts/create" class="btn btn-primary btn-sm"><i class="fas fa-plus me-2"></i>Tambah Contact</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (method_exists($contact_array, 'links'))
            <div class="border-top p-3" style="border-color: var(--glass-border) !important;">
                {{ $contact_array->links('pagination::bootstrap-5') }}
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
                <p>Apakah Anda yakin ingin menghapus contact <strong id="deleteName" style="color: var(--text-primary);"></strong>?</p>
                <p class="text-warning small mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Tindakan ini tidak dapat dibatalkan.</p>
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

<!-- JS Delete -->
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/contacts/${id}`;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

@endsection
