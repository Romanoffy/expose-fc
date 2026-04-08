@extends('layouts.main')

<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content')


@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --border-radius: 16px;
    }

    /* Stock Badge - Improved */
    .card-stock-overlay {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .stock-badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .stock-badge.in-stock {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .stock-badge.in-stock::before {
        background: white;
    }

    .stock-badge.low-stock {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    .stock-badge.low-stock::before {
        background: white;
    }

    .stock-badge.out-of-stock {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    .stock-badge.out-of-stock::before {
        background: white;
        animation: none;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    /* Modal Improvements */
    .modal-content {
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .modal-body {
        padding: 2rem !important;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .modal-title-custom {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .btn-close-custom {
        background: #f3f4f6;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 20px;
        color: #6b7280;
    }

    .btn-close-custom:hover {
        background: #e5e7eb;
        transform: rotate(90deg);
    }

    /* Product Image */
    .product-image-wrapper {
        position: relative;
        width: 100%;
        height: 320px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image-wrapper:hover .product-image {
        transform: scale(1.05);
    }

    /* Price Section - Improved */
    .price-section {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .price-label {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .price-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    /* Description Box - Improved */
    .description-box {
        background: #f9fafb;
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .description-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .description-text {
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }

    /* Form Controls - Improved */
    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: white;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .form-select:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
    }

    /* Quantity Box - Completely Redesigned */
    .quantity-box {
        background: white;
        padding: 1.25rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .quantity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .quantity-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .qty-btn {
        width: 40px;
        height: 40px;
        border: 2px solid #e5e7eb;
        background: white;
        border-radius: 10px;
        font-size: 1.25rem;
        font-weight: 600;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: scale(1.05);
    }

    .qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-input {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        color: #1f2937;
        background: #f9fafb;
    }

    .total-section {
        margin-left: auto;
        text-align: right;
        padding-left: 1rem;
        border-left: 2px solid #e5e7eb;
    }

    .total-label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .total-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }

    /* Alert - Improved */
    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 2px solid #fecaca;
        border-radius: 12px;
        color: #991b1b;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger i {
        color: #dc2626;
    }

    /* Modal Footer - Improved */
    .modal-footer {
        border-top: 2px solid #f3f4f6;
        padding: 1.5rem 2rem;
        gap: 0.75rem;
    }

    .btn-cancel {
        padding: 0.75rem 1.5rem;
        border: 2px solid #e5e7eb;
        background: white;
        color: #6b7280;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .btn-success {
        padding: 0.75rem 1.5rem;
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover:not(:disabled) {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-success:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-checkout {
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
    }

    /* Out of Stock Overlay */
    .out-of-stock-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .out-of-stock-text {
        background: white;
        color: var(--danger-color);
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.25rem;
        letter-spacing: 2px;
    }

    /* Card Hover Effect */
    .post-entry.card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .post-entry.card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .custom-card-image {
        transition: transform 0.3s ease;
    }

    .post-entry.card:hover .custom-card-image {
        transform: scale(1.05);
    }

    /* Notification Styles */
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        z-index: 9999;
        opacity: 0;
        transform: translateX(400px);
        transition: all 0.3s ease;
    }

    .custom-notification.show {
        opacity: 1;
        transform: translateX(0);
    }

    .custom-notification-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .custom-notification-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .custom-notification-error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .custom-notification-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .notification-icon {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .notification-message {
        font-size: 0.95rem;
    }

    /* Spinner Bootstrap */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }

    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }

    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
</style>
<div class="hero overlay" style="background-image: url('assets/client/images/bg_8.jpg');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mx-auto text-center">
                <h1 class="text-white">Merchandise</h1>
                <p>Merchandise official expose.</p>
            </div>
        </div>
    </div>
</div>

<div class="latest-news">
    <div class="container">
        <div class="row">
            <div class="col-12 title-section">
                <h2 class="heading">Merchandise</h2>
            </div>
        </div>
        <div class="row no-gutters">
            @foreach ($merchandise_array as $merchandise)
                <div class="col-md-4 mb-4">
                    <div class="post-entry card" style="cursor: pointer; position: relative;"
                        onclick="openModal({{ $merchandise->id }}, {{ $merchandise->stok }})">

                        <div class="card-stock-overlay">
                            @if ($merchandise->stok > 0)
                                @if ($merchandise->stok <= 5)
                                    <span class="stock-badge low-stock">{{ $merchandise->stok }} Tersisa</span>
                                @else
                                    <span class="stock-badge in-stock">Stok Tersedia</span>
                                @endif
                            @else
                                <span class="stock-badge out-of-stock">Habis</span>
                            @endif
                        </div>

                        <a href="javascript:void(0);">
                            @if ($merchandise->gambar)
                                <div style="position: relative;">
                                    <img class="img-fluid custom-card-image" src="{{ asset('storage/' . $merchandise->gambar) }}">
                                    @if ($merchandise->stok <= 0)
                                        <div class="out-of-stock-overlay">
                                            <div class="out-of-stock-text">STOK HABIS</div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </a>
                        <div class="caption">
                            <div class="caption-inner">
                                <h3 class="mb-3">{{ $merchandise->nama_produk }}</h3>
                                <div class="author d-flex align-items-center">
                                    <div class="text">
                                        <h4>Rp {{ number_format($merchandise->harga, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Pembelian -->
               <!-- Modal Pembelian -->
                <div class="modal fade" id="modalNews{{ $merchandise->id }}" tabindex="-1"
                    aria-labelledby="modalNewsLabel{{ $merchandise->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 720px;">
                        <div class="modal-content" style="border-radius: var(--border-radius);">
                            <div class="modal-body">
                                <!-- Custom Header -->
                                <div class="modal-header-custom">
                                    <h5 class="modal-title-custom">{{ $merchandise->nama_produk }}</h5>
                                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal">×</button>
                                </div>

                                @if ($merchandise->stok <= 0)
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Maaf, produk ini sedang habis!</strong> Silakan tunggu restock atau pilih produk lain.
                                    </div>
                                @endif

                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <div class="product-image-wrapper">
                                            @if ($merchandise->gambar)
                                                <img src="{{ asset('storage/' . $merchandise->gambar) }}"
                                                    class="product-image" alt="{{ $merchandise->nama_produk }}">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100">
                                                    <span style="font-size: 4rem; color: #9ca3af;">👕</span>
                                                </div>
                                            @endif
                                            @if ($merchandise->stok <= 0)
                                                <div class="out-of-stock-overlay">
                                                    <div class="out-of-stock-text">HABIS</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="price-section">
                                            <div class="price-label">Harga Satuan</div>
                                            <h4 class="price-value">Rp {{ number_format($merchandise->harga, 0, ',', '.') }}</h4>
                                        </div>

                                        <div class="description-box">
                                            <div class="description-label">Tentang Produk</div>
                                            <p class="description-text">
                                                {{ $merchandise->deskripsi ?? 'Produk merchandise berkualitas tinggi dari Expose FC.' }}
                                            </p>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                                                <select id="select_ukuran_{{ $merchandise->id }}" class="form-select" required
                                                    {{ $merchandise->stok <= 0 ? 'disabled' : '' }}>
                                                    <option value="" disabled selected>Pilih ukuran</option>
                                                    @foreach (explode(',', $merchandise->ukuran) as $size)
                                                        <option value="{{ trim($size) }}">{{ trim($size) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Warna <span class="text-danger">*</span></label>
                                                <select id="select_warna_{{ $merchandise->id }}" class="form-select" required
                                                    {{ $merchandise->stok <= 0 ? 'disabled' : '' }}>
                                                    <option value="" disabled selected>Pilih warna</option>
                                                    @foreach (explode(',', $merchandise->warna) as $color)
                                                        <option value="{{ trim($color) }}">{{ trim($color) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="quantity-box">
                                            <div class="quantity-header">
                                                <span class="quantity-label">Jumlah Pesanan</span>
                                                @if ($merchandise->stok > 0)
                                                    @if ($merchandise->stok <= 5)
                                                        <span class="stock-badge low-stock">{{ $merchandise->stok }} Tersisa</span>
                                                    @else
                                                        <span class="stock-badge in-stock">Stok: {{ $merchandise->stok }}</span>
                                                    @endif
                                                @else
                                                    <span class="stock-badge out-of-stock">Stok Habis</span>
                                                @endif
                                            </div>

                                            <div class="quantity-controls">
                                                <button type="button" class="qty-btn"
                                                    onclick="decreaseQty({{ $merchandise->id }})"
                                                    {{ $merchandise->stok <= 0 ? 'disabled' : '' }}>−</button>
                                                <input type="number" id="qty_{{ $merchandise->id }}" value="1" min="1"
                                                    max="{{ $merchandise->stok }}" class="qty-input" readonly
                                                    {{ $merchandise->stok <= 0 ? 'disabled' : '' }}>
                                                <button type="button" class="qty-btn"
                                                    onclick="increaseQty({{ $merchandise->id }}, {{ $merchandise->stok }})"
                                                    {{ $merchandise->stok <= 0 ? 'disabled' : '' }}>+</button>

                                                <div class="total-section">
                                                    <div class="total-label">Total Harga</div>
                                                    <p class="total-value" id="total_{{ $merchandise->id }}">
                                                        Rp {{ number_format($merchandise->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>

                                <!-- Button Tambah ke Keranjang (AJAX) -->
                                
                             <button type="button" class="btn btn-success" 
        onclick="addToCart({{ $merchandise->id }})"
        style="{{ $merchandise->stok <= 0 ? 'display:none;' : '' }}"
        id="btn_add_cart_{{ $merchandise->id }}">
    Tambah ke Keranjang →
</button>

                                <!-- Form Beli Sekarang -->
                                <form method="get" action="{{ route('checkout.show') }}" style="{{ $merchandise->stok <= 0 ? 'display:none;' : '' }}">
                                    @csrf
                                    <input type="hidden" name="id_merchandise" value="{{ $merchandise->id }}">
                                    <input type="hidden" name="ukuran" id="buy_ukuran_{{ $merchandise->id }}">
                                    <input type="hidden" name="warna" id="buy_warna_{{ $merchandise->id }}">
                                    <input type="hidden" name="jumlah" id="buy_jumlah_{{ $merchandise->id }}">
                                    <button type="submit" class="btn-checkout"
                                        onclick="event.preventDefault();
                                                 const uk = document.getElementById('select_ukuran_{{ $merchandise->id }}').value;
                                                 const wr = document.getElementById('select_warna_{{ $merchandise->id }}').value;
                                                 if (!uk || !wr) { alert('Silakan pilih ukuran dan warna!'); return; }
                                                 document.getElementById('buy_ukuran_{{ $merchandise->id }}').value = uk;
                                                 document.getElementById('buy_warna_{{ $merchandise->id }}').value = wr;
                                                 document.getElementById('buy_jumlah_{{ $merchandise->id }}').value = document.getElementById('qty_{{ $merchandise->id }}').value;
                                                 this.closest('form').submit();">
                                        Lanjutkan ke Checkout →
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
// Ambil CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Membuka modal produk
function openModal(id, stok) {
    if (stok <= 0) {
        showNotification('Maaf, produk ini sedang habis. Silakan pilih produk lain.', 'warning');
        return;
    }
    const modalElement = document.getElementById('modalNews' + id);
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

// Mengatur jumlah
function increaseQty(id, max) {
    const qtyInput = document.getElementById(`qty_${id}`);
    let currentQty = parseInt(qtyInput.value);
    if (currentQty < max) {
        currentQty++;
        qtyInput.value = currentQty;
        updateTotal(id);
    } else {
        showNotification(`Stok maksimal: ${max} pcs`, 'warning');
    }
}

function decreaseQty(id) {
    const qtyInput = document.getElementById(`qty_${id}`);
    let currentQty = parseInt(qtyInput.value);
    if (currentQty > 1) {
        currentQty--;
        qtyInput.value = currentQty;
        updateTotal(id);
    }
}

// Update total harga
function updateTotal(id) {
    const qty = parseInt(document.getElementById(`qty_${id}`).value);
    const hargaText = document.querySelector(`#modalNews${id} .price-value`).textContent;
    const harga = parseInt(hargaText.replace(/[^0-9]/g, ''));
    const total = qty * harga;
    document.getElementById(`total_${id}`).textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Tambah ke keranjang via AJAX
function addToCart(id) {
    const ukuran = document.getElementById(`select_ukuran_${id}`).value;
    const warna = document.getElementById(`select_warna_${id}`).value;
    const jumlah = document.getElementById(`qty_${id}`).value;

    if (!ukuran || !warna) {
        showNotification('Silakan pilih ukuran dan warna!', 'warning');
        return;
    }

    const btn = document.getElementById(`btn_add_cart_${id}`);
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menambahkan...';

    fetch('{{ route("cart.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id_merchandise: id,
            ukuran: ukuran,
            warna: warna,
            jumlah: jumlah
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Berhasil ditambahkan ke keranjang!', 'success');
            updateCartBadge();
            setTimeout(() => {
                const modalElement = document.getElementById(`modalNews${id}`);
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
            }, 1000);
        } else {
            showNotification(data.message || 'Gagal menambahkan ke keranjang!', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

// Update badge cart
function updateCartBadge() {
    fetch('{{ route("cart.count") }}')
        .then(res => res.json())
        .then(data => {
            const badge = document.querySelector('.cart-badge');
            if (badge) {
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? 'inline-block' : 'none';
            }
        })
        .catch(error => console.error('Error updating cart badge:', error));
}

// Notifikasi custom
function showNotification(message, type='info') {
    const oldNotif = document.querySelector('.custom-notification');
    if (oldNotif) oldNotif.remove();

    const notification = document.createElement('div');
    notification.className = `custom-notification custom-notification-${type}`;
    const icon = type === 'success' ? '✓' : type === 'warning' ? '⚠' : type === 'error' ? '✕' : 'ℹ';
    notification.innerHTML = `<span class="notification-icon">${icon}</span> <span class="notification-message">${message}</span>`;
    document.body.appendChild(notification);

    setTimeout(() => notification.classList.add('show'), 100);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

@endsection