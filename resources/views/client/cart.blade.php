{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(10, 14, 24);
            min-height: 100vh;
            color: #e8ecef;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h2 {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 1rem;
        }

        /* Select All Box */
        .select-all-box {
            background: #232931;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            margin-bottom: 20px;
        }

        .select-all-box .form-check {
            display: flex;
            align-items: center;
        }

        .select-all-box .form-check-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 2px solid #3b82f6;
            background-color: transparent;
            margin: 0;
        }

        .select-all-box .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .select-all-box .form-check-label {
            cursor: pointer;
            margin-left: 12px;
            font-size: 1rem;
            color: #e8ecef;
            font-weight: 500;
        }

        /* Cart Item Card - Flat Modern Design */
        .cart-item {
            background: #232931;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 16px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .cart-item:hover {
            border-color: rgba(59, 130, 246, 0.3);
        }

        .cart-item.selected {
            border-color: #3b82f6;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, #232931 100%);
        }

        /* Item Header */
        .item-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            cursor: pointer;
            user-select: none;
        }

        .item-number {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .item-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 2px solid #3b82f6;
            border-radius: 4px;
            background-color: transparent;
            flex-shrink: 0;
        }

        .item-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .item-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            background: #1a1f2e;
            flex-shrink: 0;
        }

        .item-info {
            flex: 1;
            min-width: 0;
        }

        .item-name {
            color: #fff;
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .item-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .item-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .item-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #10b981;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .expand-icon {
            color: #6b7280;
            font-size: 1.2rem;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .item-header.expanded .expand-icon {
            transform: rotate(180deg);
        }

        /* Item Details */
        .item-details {
            display: none;
            padding: 0 20px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            animation: slideDown 0.3s ease;
        }

        .item-details.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .details-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
            margin-top: 20px;
        }

        .detail-image {
            width: 100%;
            border-radius: 8px;
            background: #1a1f2e;
            padding: 12px;
        }

        .detail-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 280px;
        }

        .detail-content h6 {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .detail-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 6px;
            font-size: 1.2rem;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .detail-value {
            font-size: 1rem;
            color: #e8ecef;
            font-weight: 500;
        }

        .detail-value.price {
            color: #10b981;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .description-card {
            background: rgba(59, 130, 246, 0.05);
            border-left: 3px solid #3b82f6;
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .description-card .label {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .description-card p {
            color: #9ca3af;
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.5;
        }

        .btn-delete {
            width: 100%;
            padding: 12px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            color: #ef4444;
        }

        /* Summary Sidebar */
        .summary-card {
            background: #232931;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            position: sticky;
            top: 20px;
        }

        .summary-header {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            padding: 20px;
            color: white;
        }

        .summary-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-body {
            padding: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .summary-row .value {
            color: #e8ecef;
            font-weight: 600;
        }

        .summary-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 12px 0;
        }

        .summary-total {
            padding: 16px 0;
            font-size: 1.05rem;
        }

        .summary-total .label {
            color: #e8ecef;
            font-weight: 600;
        }

        .summary-total .value {
            color: #10b981;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .summary-footer {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .btn-checkout {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            margin-bottom: 12px;
        }

        .btn-checkout:hover:not(:disabled) {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
        }

        .btn-checkout:disabled {
            background: #374151;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .btn-continue {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 1px solid rgba(59, 130, 246, 0.5);
            color: #3b82f6;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-continue:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
            color: #3b82f6;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: #232931;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .empty-icon {
            font-size: 5rem;
            color: #374151;
            margin-bottom: 24px;
        }

        .empty-state h4 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 24px;
        }

        .btn-start {
            padding: 14px 32px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        @media (max-width: 991px) {
            .summary-card { position: static; margin-top: 30px; }
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .item-header {
                flex-wrap: wrap;
            }

            .item-info {
                order: 3;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <h2>
                <i class="bi bi-cart3"></i> Keranjang Belanja
            </h2>
            <p>Kelola produk yang akan Anda beli</p>
        </div>

        @if ($cartItems->count() > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="select-all-box">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                Pilih Semua Produk
                            </label>
                        </div>
                    </div>

                    @foreach ($cartItems as $index => $item)
                        @if ($item->merchandise)
                            <div class="cart-item" id="item-{{ $item->id }}">
                                <div class="item-header" onclick="toggleDetails({{ $item->id }})">
                                    <div class="item-number">{{ $index + 1 }}</div>
                                    
                                    <input class="item-checkbox" type="checkbox" 
                                        value="{{ $item->id }}"
                                        data-price="{{ $item->subtotal }}"
                                        onclick="event.stopPropagation()">

                                    @if ($item->merchandise->file_gambar_product)
                                        <img src="{{ asset('storage/' . $item->merchandise->file_gambar_product) }}"
                                            alt="{{ $item->merchandise->nama }}" class="item-thumb">
                                    @else
                                        <img src="https://st5.depositphotos.com/17828278/62084/v/1600/depositphotos_620846110-stock-illustration-image-vector-symbol-shadow-missing.jpg"
                                            class="item-thumb">
                                    @endif

                                    <div class="item-info">
                                        <div class="item-name">{{ $item->merchandise->nama }}</div>
                                        <div class="item-meta">
                                            @if($item->ukuran)
                                                <span><i class="bi bi-rulers"></i> {{ $item->ukuran }}</span>
                                            @endif
                                            @if($item->warna)
                                                <span><i class="bi bi-droplet"></i> {{ $item->warna }}</span>
                                            @endif
                                            <span><i class="bi bi-box-seam"></i> {{ $item->jumlah }}x</span>
                                            <span><i class="bi bi-tag"></i> Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div class="item-price">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>

                                    <i class="bi bi-chevron-down expand-icon"></i>
                                </div>

                                <div class="item-details" id="details-{{ $item->id }}">
                                    <div class="details-grid">
                                        <div class="detail-image">
                                            @if ($item->merchandise->file_gambar_product)
                                                <img src="{{ asset('storage/' . $item->merchandise->file_gambar_product) }}"
                                                    alt="{{ $item->merchandise->nama }}">
                                            @else
                                                <img src="https://st5.depositphotos.com/17828278/62084/v/1600/depositphotos_620846110-stock-illustration-image-vector-symbol-shadow-missing.jpg">
                                            @endif
                                        </div>

                                        <div class="detail-content">
                                            <h6>{{ $item->merchandise->nama }}</h6>

                                            <div class="detail-list">
                                                <div class="detail-row">
                                                    <div class="detail-icon text-primary">
                                                        <i class="bi bi-tag-fill"></i>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Harga Satuan</div>
                                                        <div class="detail-value">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>

                                                <div class="detail-row">
                                                    <div class="detail-icon text-success">
                                                        <i class="bi bi-cart-fill"></i>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Jumlah</div>
                                                        <div class="detail-value">{{ $item->jumlah }} item</div>
                                                    </div>
                                                </div>

                                                @if($item->ukuran)
                                                <div class="detail-row">
                                                    <div class="detail-icon text-info">
                                                        <i class="bi bi-rulers"></i>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Ukuran</div>
                                                        <div class="detail-value">{{ $item->ukuran }}</div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($item->warna)
                                                <div class="detail-row">
                                                    <div class="detail-icon text-warning">
                                                        <i class="bi bi-droplet"></i>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Warna</div>
                                                        <div class="detail-value">{{ $item->warna }}</div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="detail-row">
                                                    <div class="detail-icon text-success">
                                                        <i class="bi bi-calculator-fill"></i>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Subtotal</div>
                                                        <div class="detail-value price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($item->merchandise->deskripsi)
                                                <div class="description-card">
                                                    <span class="label"><i class="bi bi-info-circle me-1"></i>Deskripsi Produk</span>
                                                    <p>{{ Str::limit($item->merchandise->deskripsi, 150) }}</p>
                                                </div>
                                            @endif

                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">
                                                    <i class="bi bi-trash me-2"></i> Hapus dari Keranjang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-header">
                            <h5><i class="bi bi-receipt-cutoff"></i> Ringkasan Belanja</h5>
                        </div>

                        <div class="summary-body">
                            <div class="summary-row">
                                <span>Total Item</span>
                                <span class="value"><span id="selectedCount">0</span> produk dipilih</span>
                            </div>
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span class="value" id="subtotalPrice">Rp 0</span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row summary-total">
                                <span class="label">Total Pembayaran</span>
                                <span class="value" id="totalPrice">Rp 0</span>
                            </div>
                        </div>

                        <div class="summary-footer">
                            <button type="button" class="btn-checkout" id="checkoutBtn" disabled>
                                <i class="bi bi-cart-check me-2"></i> Lanjut ke Pembayaran
                            </button>
                            <a href="/" class="btn-continue">
                                <i class="bi bi-arrow-left me-2"></i> Belanja Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h4>Keranjang Belanja Kosong</h4>
                <p>Yuk mulai belanja dan tambahkan produk favorit Anda!</p>
                <a href="/" class="btn-start">
                    <i class="bi bi-bag-heart me-2"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDetails(itemId) {
            const details = document.getElementById('details-' + itemId);
            const header = details.previousElementSibling;
            const item = document.getElementById('item-' + itemId);
            
            details.classList.toggle('show');
            header.classList.toggle('expanded');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const selectedCountEl = document.getElementById('selectedCount');
            const subtotalPriceEl = document.getElementById('subtotalPrice');
            const totalPriceEl = document.getElementById('totalPrice');

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateSummary() {
                let selectedCount = 0;
                let totalPrice = 0;

                itemCheckboxes.forEach(checkbox => {
                    const cartItem = checkbox.closest('.cart-item');
                    if (checkbox.checked) {
                        selectedCount++;
                        totalPrice += parseFloat(checkbox.dataset.price);
                        cartItem.classList.add('selected');
                    } else {
                        cartItem.classList.remove('selected');
                    }
                });

                selectedCountEl.textContent = selectedCount;
                subtotalPriceEl.textContent = formatRupiah(totalPrice);
                totalPriceEl.textContent = formatRupiah(totalPrice);

                checkoutBtn.disabled = selectedCount === 0;

                const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }

            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSummary();
            });

            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSummary);
            });

            checkoutBtn.addEventListener('click', function() {
                const selectedItems = Array.from(itemCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedItems.length === 0) {
                    alert('Pilih minimal satu produk untuk melanjutkan ke checkout.');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '{{ route('checkout.show') }}';

                selectedItems.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'items[]';
                    input.value = id;
                    form.appendChild(input);
                });

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                document.body.appendChild(form);
                form.submit();
            });

            updateSummary();
        });
    </script>
</body>
</html> --}}