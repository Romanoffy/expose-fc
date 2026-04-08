@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Transaksi</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Kelola transaksi pembelian merchandise Expose FC</p>
            </div>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Transaksi
            </a>
        </div>

        <!-- Main Card -->
        <div class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
            <div class="card-body p-0">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom p-4"
                    style="border-color: var(--glass-border) !important;">
                    <div>
                        <h5 class="mb-1 text-white" style="color: var(--text-primary); font-weight: 600;">Daftar Transaksi
                        </h5>
                        <p class="small mb-0 text-white">Total: {{ $transaksi->total() }} transaksi tercatat</p>
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

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-hover mb-0 table" style="color: var(--text-secondary);">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 px-4 py-3" style="font-size: 13px;">ID</th>
                                <th class="border-0 py-3">User</th>
                                <th class="border-0 py-3">alamat</th>
                                <th class="border-0 py-3">Tanggal</th>
                                <th class="border-0 py-3">Metode Pembayaran</th>
                                <th class="border-0 py-3">Total Harga</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="border-0 py-3">Bukti Pembayaran</th>
                                <th class="border-0 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $item)
                                <!-- Baris utama transaksi -->
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseTransaksi{{ $item->id }}"
                                    aria-expanded="false" aria-controls="collapseTransaksi{{ $item->id }}"
                                    class="border-bottom" style="cursor: pointer; transition: all .3s ease;"
                                    onmouseover="this.style.background='rgba(99,102,241,0.05)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="px-4 py-3">
                                        <span class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                            #{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="py-3">{{ $item->alamat ?? '-' }}</td>
                                    <td class="py-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                                    <td class="py-3">{{ ucfirst($item->metode_pembayaran) }}</td>
                                    <td class="py-3">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColors = [
                                                'Menunggu Konfirmasi' => 'danger',
                                                'confirmed' => 'warning',
                                                'pending' => 'warning',
                                                'paid' => 'info',
                                                'success' => 'success',
                                                'failed' => 'danger',
                                                'canceled' => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$item->status] ?? 'light' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if ($item->bukti_pembayaran)
                                            <img src="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran"
                                                style="max-width: 100px; max-height: 100px; object-fit: contain; border-radius: 8px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-outline-primary btn-sm"
                                                onclick="window.location='{{ route('transaksi.edit', $item->id) }}'">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->user->name ?? 'User' }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Accordion Detail Transaksi -->
                                <tr class="collapse-row">
                                    <td colspan="8" class="p-0">
                                        <div id="collapseTransaksi{{ $item->id }}"
                                            class="accordion-collapse collapse bg-light transition-smooth">
                                            <div class="p-4">
                                                <div class="border rounded p-3" style="background: rgba(255,255,255,0.03);">
                                                    <h6 class="fw-bold text-dark mb-3">
                                                        <i class="fas fa-list me-2 text-info"></i>Detail Transaksi
                                                    </h6>
                                                    @if ($item->detailTransaksi->isEmpty())
                                                        <p class="text-muted mb-0">Tidak ada detail transaksi.</p>
                                                    @else
                                                        <table class="table table-sm table-bordered align-middle text-dark"
                                                            style="background-color: #f8f9fa;">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Nama Produk</th>
                                                                    <th>Warna</th>
                                                                    <th>Ukuran</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item->detailTransaksi as $d)
                                                                    <tr>
                                                                        <td>{{ $d->merchandise->nama_produk ?? '-' }}</td>
                                                                        <td>{{ $d->warna ?? '-' }}</td>
                                                                        <td>{{ $d->ukuran ?? '-' }}</td>
                                                                        <td>{{ $d->jumlah }}</td>
                                                                        <td>Rp{{ number_format($d->harga_satuan, 0, ',', '.') }}
                                                                        </td>
                                                                        <td>Rp{{ number_format($d->subtotal, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-5 text-center" style="color: var(--text-light);">
                                        <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                                        <h6 style="color: var(--text-secondary);">Belum ada transaksi</h6>
                                        <p class="mb-3">Belum ada transaksi yang tercatat</p>
                                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm"><i
                                                class="fas fa-plus me-2"></i>Tambah Transaksi</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($transaksi, 'links'))
                    <div class="border-top p-3" style="border-color: var(--glass-border) !important;">
                        {{ $transaksi->links('pagination::bootstrap-5') }}
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p>Apakah Anda yakin ingin menghapus transaksi milik <strong id="deleteName"
                            style="color: var(--text-primary);"></strong>?</p>
                    <p class="text-warning small mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Tindakan ini tidak
                        dapat dibatalkan.</p>
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
            document.getElementById('deleteForm').action = `/admin/transaksi/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <style>
        /* Animasi smooth accordion */
        .transition-smooth.collapse {
            transition: all 0.4s ease-in-out;
        }
    </style>
@endsection
