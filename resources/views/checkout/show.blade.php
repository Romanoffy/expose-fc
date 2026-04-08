<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Merchandise Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #eef2ff;
            --danger: #ef4444;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --border: #e2e8f0;
            --radius: 16px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background:RGB(10,14,24);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .checkout-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease;
        }

        .checkout-header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .checkout-header p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
        }

        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            animation: fadeInUp 0.6s ease;
        }

        .checkout-main {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 35px;
        }

        .checkout-sidebar {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 35px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* Alert Styles */
        .custom-alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }

        .custom-alert i {
            font-size: 1.3rem;
        }

        .alert-success-custom {
            background: var(--success-light);
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger-custom {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .alert-info-custom {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* Checkout Items */
        .checkout-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .checkout-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: var(--gray-light);
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .checkout-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }

        .checkout-item img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .checkout-item-info {
            flex: 1;
        }

        .checkout-item-info h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .item-details {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 5px;
        }

        .item-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background: white;
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .item-badge i {
            font-size: 0.75rem;
        }

        .item-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--success);
            white-space: nowrap;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-label-custom i {
            color: var(--primary);
        }

        .form-control, .form-select {
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-control:disabled {
            background: var(--gray-light);
            color: var(--gray);
        }

        /* Payment Method Cards */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .payment-card {
            padding: 20px;
            border: 3px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            text-align: center;
        }

        .payment-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .payment-card.active {
            border-color: var(--primary);
            background: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .payment-card i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .payment-card .payment-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 1rem;
        }

        /* Bank Options */
        .bank-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
            animation: slideDown 0.4s ease;
        }

        .bank-card {
            padding: 20px;
            border: 3px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .bank-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .bank-card.active {
            border-color: var(--primary);
            background: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .bank-logo {
            width: 80px;
            height: 50px;
            background: var(--gray-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
        }

        .bank-card .bank-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 1rem;
        }

        /* Bank Info Display */
        .bank-info-display {
            margin-top: 20px;
            padding: 25px;
            border-radius: 12px;
            color: white;
            animation: slideDown 0.4s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .bank-info-display.bca {
            background: linear-gradient(135deg, #003d7a 0%, #0056b3 100%);
        }

        .bank-info-display.bri {
            background: linear-gradient(135deg, #003d82 0%, #005eb8 100%);
        }

        .bank-info-display.mandiri {
            background: linear-gradient(135deg, #ff8c00 0%, #ffb700 100%);
        }

        .bank-info-display.dana {
            background: linear-gradient(135deg, #118eea 0%, #00adef 100%);
        }

        .bank-info-display .bank-label {
            font-size: 0.9rem;
            opacity: 0.95;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .bank-info-display .bank-number {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .bank-info-display .bank-holder {
            font-size: 1rem;
            font-weight: 600;
            opacity: 0.95;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 30px;
            background: var(--gray-light);
            border: 2px dashed var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .file-upload-label i {
            font-size: 2rem;
            color: var(--primary);
        }

        .file-name {
            margin-top: 10px;
            padding: 10px;
            background: var(--success-light);
            border-radius: 8px;
            color: #065f46;
            font-weight: 500;
            display: none;
        }

        /* Sidebar Summary */
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 20px;
            margin-top: 10px;
            border-top: 2px solid var(--dark);
        }

        .summary-label {
            color: var(--gray);
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
            color: var(--dark);
        }

        .summary-total {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
        }

        .item-count {
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Buttons */
        .btn-custom {
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .btn-primary-custom:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.5);
        }

        .btn-primary-custom:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary-custom {
            background: white;
            color: var(--gray);
            border: 2px solid var(--border);
        }

        .btn-secondary-custom:hover {
            background: var(--gray-light);
            border-color: var(--gray);
        }

        .btn-group-custom {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-group-custom button,
        .btn-group-custom a {
            flex: 1;
        }

        /* Footer */
        footer {
            text-align: center;
            color: rgba(255,255,255,0.9);
            margin-top: 60px;
            padding: 20px;
            font-size: 0.95rem;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                max-height: 1000px;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }

            .checkout-sidebar {
                position: static;
                order: -1;
            }

            .checkout-header h1 {
                font-size: 2rem;
            }

            .payment-methods,
            .bank-options {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 15px;
            }

            .checkout-main, .checkout-sidebar {
                padding: 25px 20px;
            }

            .checkout-item {
                flex-direction: column;
                text-align: center;
            }

            .checkout-item img {
                width: 100%;
                height: 200px;
            }

            .btn-group-custom {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="checkout-wrapper">
    <div class="checkout-header">
        <h1><i class="fas fa-shopping-bag"></i> Checkout</h1>
        <p>Selesaikan pesanan Anda dengan mudah dan aman</p>
    </div>

    {{-- Pesan sukses / error --}}
    @if (session('success'))
        <div class="custom-alert alert-success-custom">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="custom-alert alert-danger-custom">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (!isset($items) || $items->isEmpty())
        <div class="checkout-main">
            <div class="custom-alert alert-info-custom">
                <i class="fas fa-info-circle"></i>
                <span>Tidak ada item untuk checkout.</span>
            </div>
        </div>
    @else

        <div class="checkout-container">
            {{-- Main Content --}}
            <div class="checkout-main">
                <div class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Informasi Pemesan
                </div>

                <div class="form-group">
                    <label class="form-label-custom">
                        <i class="fas fa-user"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                </div>

                <div class="section-title" style="margin-top: 40px;">
                    <i class="fas fa-box-open"></i>
                    Ringkasan Pesanan
                </div>

                <div class="checkout-items">
                    @foreach ($items as $item)
                        <div class="checkout-item">
                            <img src="{{ asset('storage/' . ($item->merchandise->gambar ?? 'default.png')) }}" alt="{{ $item->merchandise->nama_produk ?? 'Produk' }}">
                            <div class="checkout-item-info">
                                <h5>{{ $item->merchandise->nama_produk ?? 'Nama produk tidak tersedia' }}</h5>
                                <div class="item-details">
                                    <span class="item-badge">
                                        <i class="fas fa-ruler"></i>
                                        {{ $item->ukuran ?? '-' }}
                                    </span>
                                    <span class="item-badge">
                                        <i class="fas fa-palette"></i>
                                        {{ $item->warna ?? '-' }}
                                    </span>
                                    <span class="item-badge">
                                        <i class="fas fa-shopping-cart"></i>
                                        {{ $item->jumlah ?? 1 }}x
                                    </span>
                                </div>
                            </div>
                            <div class="item-price">
                                Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('checkout.complete') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                    @csrf

                    @foreach ($items as $item)
                        @if(isset($item->id_cart))
                            <input type="hidden" name="items[]" value="{{ $item->id_cart }}">
                        @else
                            <input type="hidden" name="id_merchandise" value="{{ $item->id_merchandise }}">
                            <input type="hidden" name="jumlah" value="{{ $item->jumlah }}">
                            <input type="hidden" name="ukuran" value="{{ $item->ukuran }}">
                            <input type="hidden" name="warna" value="{{ $item->warna }}">
                        @endif
                    @endforeach

                    <div class="section-title" style="margin-top: 40px;">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat Pengiriman
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="form-label-custom">
                            <i class="fas fa-home"></i>
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" id="alamat" rows="4" class="form-control" placeholder="Masukkan alamat pengiriman lengkap..." required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="section-title" style="margin-top: 40px;">
                        <i class="fas fa-credit-card"></i>
                        Metode Pembayaran
                    </div>

                    <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="{{ old('metode_pembayaran') }}">

                    <div class="payment-methods">
                        <div class="payment-card" data-method="Transfer Bank">
                            <i class="fas fa-university"></i>
                            <div class="payment-name">Transfer Bank</div>
                        </div>
                        <div class="payment-card" data-method="COD">
                            <i class="fas fa-hand-holding-usd"></i>
                            <div class="payment-name">Bayar di Tempat</div>
                        </div>
                        <div class="payment-card" data-method="E-Wallet">
                            <i class="fas fa-wallet"></i>
                            <div class="payment-name">E-Wallet</div>
                        </div>
                        <div class="payment-card" data-method="QRIS">
                            <i class="fas fa-qrcode"></i>
                            <div class="payment-name">QRIS</div>
                        </div>
                    </div>

                    {{-- Bank Options (show when Transfer Bank selected) --}}
                    <div id="bank-options-container" style="display: none;">
                        <div class="form-label-custom" style="margin-top: 25px;">
                            <i class="fas fa-building"></i>
                            Pilih Bank
                        </div>
                        <div class="bank-options">
                            <div class="bank-card" data-bank="BCA">
                                <div class="bank-logo" style="background: #003d7a;">BCA</div>
                                <div class="bank-name">Bank BCA</div>
                            </div>
                            <div class="bank-card" data-bank="BRI">
                                <div class="bank-logo" style="background: #003d82;">BRI</div>
                                <div class="bank-name">Bank BRI</div>
                            </div>
                            <div class="bank-card" data-bank="Mandiri">
                                <div class="bank-logo" style="background: #ff8c00;">MDR</div>
                                <div class="bank-name">Bank Mandiri</div>
                            </div>
                            <div class="bank-card" data-bank="DANA">
                                <div class="bank-logo" style="background: #118eea;">DANA</div>
                                <div class="bank-name">DANA</div>
                            </div>
                        </div>

                        {{-- Bank Info Display --}}
                        <div id="bank-info-bca" class="bank-info-display bca" style="display: none;">
                            <div class="bank-label">Transfer ke rekening BCA:</div>
                            <div class="bank-number">1234 5678 9012</div>
                            <div class="bank-holder">a.n Merchandise Store</div>
                        </div>

                        <div id="bank-info-bri" class="bank-info-display bri" style="display: none;">
                            <div class="bank-label">Transfer ke rekening BRI:</div>
                            <div class="bank-number">9876 5432 1098 7654</div>
                            <div class="bank-holder">a.n Merchandise Store</div>
                        </div>

                        <div id="bank-info-mandiri" class="bank-info-display mandiri" style="display: none;">
                            <div class="bank-label">Transfer ke rekening Mandiri:</div>
                            <div class="bank-number">1357 2468 9753</div>
                            <div class="bank-holder">a.n Merchandise Store</div>
                        </div>

                        <div id="bank-info-dana" class="bank-info-display dana" style="display: none;">
                            <div class="bank-label">Transfer ke DANA:</div>
                            <div class="bank-number">0812 3456 7890</div>
                            <div class="bank-holder">a.n Merchandise Store</div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 25px;">
                        <label for="bukti_pembayaran" class="form-label-custom">
                            <i class="fas fa-receipt"></i>
                            Bukti Pembayaran <span style="color: var(--gray); font-weight: 400;">(opsional)</span>
                        </label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*">
                            <label for="bukti_pembayaran" class="file-upload-label">
                                <div>
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <div style="margin-top: 8px; font-weight: 600; color: var(--dark);">Upload Bukti Pembayaran</div>
                                    <div style="font-size: 0.85rem; color: var(--gray); margin-top: 4px;">Klik atau drag file ke sini</div>
                                </div>
                            </label>
                        </div>
                        <div class="file-name" id="file-name"></div>
                    </div>

                    <div class="btn-group-custom">
                        <a href="{{ url()->previous() }}" class="btn-custom btn-secondary-custom">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" id="btn-proses" class="btn-custom btn-primary-custom" disabled>
                            <i class="fas fa-check-circle"></i>
                            Proses Checkout
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="checkout-sidebar">
                <div class="section-title">
                    <i class="fas fa-calculator"></i>
                    Ringkasan Pembayaran
                </div>

                <div class="summary-row">
                    <span class="summary-label">Jumlah Item</span>
                    <span class="item-count">{{ $items->count() }} item</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Biaya Admin</span>
                    <span class="summary-value">Rp 0</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label" style="font-size: 1.1rem; color: var(--dark); font-weight: 700;">Total Pembayaran</span>
                    <span class="summary-total">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</span>
                </div>

                <div style="margin-top: 30px; padding: 20px; background: var(--gray-light); border-radius: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <i class="fas fa-shield-alt" style="color: var(--success); font-size: 1.5rem;"></i>
                        <div>
                            <div style="font-weight: 700; color: var(--dark);">Transaksi Aman</div>
                            <div style="font-size: 0.85rem; color: var(--gray);">100% Terpercaya</div>
                        </div>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--gray); line-height: 1.6;">
                        Data Anda dilindungi dengan enkripsi tingkat tinggi
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>

<footer>
    <div style="font-size: 1.1rem; margin-bottom: 5px;">
        <i class="fas fa-store"></i> Merchandise Store
    </div>
    &copy; {{ date('Y') }} All rights reserved. Made with <i class="fas fa-heart" style="color: #ef4444;"></i>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentCards = document.querySelectorAll('.payment-card');
    const bankCards = document.querySelectorAll('.bank-card');
    const metodeInput = document.getElementById('metode_pembayaran');
    const bankOptionsContainer = document.getElementById('bank-options-container');
    const buktiInput = document.getElementById('bukti_pembayaran');
    const btnProses = document.getElementById('btn-proses');
    const fileName = document.getElementById('file-name');
    
    let selectedPayment = '';
    let selectedBank = '';

    // Payment Method Selection
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            paymentCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            selectedPayment = this.getAttribute('data-method');
            
            // Show/hide bank options
            if (selectedPayment === 'Transfer Bank') {
                bankOptionsContainer.style.display = 'block';
                // Reset bank selection
                bankCards.forEach(c => c.classList.remove('active'));
                hideAllBankInfo();
                selectedBank = '';
                metodeInput.value = '';
                btnProses.disabled = true;
            } else {
                bankOptionsContainer.style.display = 'none';
                hideAllBankInfo();
                selectedBank = '';
                metodeInput.value = selectedPayment;
                updateButtonState();
            }
        });
    });

    // Bank Selection
    bankCards.forEach(card => {
        card.addEventListener('click', function() {
            bankCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            selectedBank = this.getAttribute('data-bank');
            
            // Update hidden input
            metodeInput.value = 'Transfer Bank - ' + selectedBank;
            
            // Show corresponding bank info
            hideAllBankInfo();
            const bankInfoId = 'bank-info-' + selectedBank.toLowerCase();
            const bankInfoElement = document.getElementById(bankInfoId);
            if (bankInfoElement) {
                bankInfoElement.style.display = 'block';
            }
            
            updateButtonState();
        });
    });

    // File Upload
    buktiInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileName.style.display = 'block';
            fileName.innerHTML = '<i class="fas fa-file-image"></i> ' + this.files[0].name;
        } else {
            fileName.style.display = 'none';
        }
        updateButtonState();
    });

    // Hide all bank info
    function hideAllBankInfo() {
        document.querySelectorAll('.bank-info-display').forEach(info => {
            info.style.display = 'none';
        });
    }

    // Update button state
    function updateButtonState() {
        if (selectedPayment === 'Transfer Bank') {
            // For transfer bank, need bank selection and proof
            btnProses.disabled = !(selectedBank && buktiInput.files.length > 0);
        } else if (selectedPayment) {
            // For other methods, just need method selection
            btnProses.disabled = false;
        } else {
            btnProses.disabled = true;
        }
    }
});
</script>

</body>
</html>