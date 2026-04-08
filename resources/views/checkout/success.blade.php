<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Berhasil - Merchandise Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background:RGB(10,14,24);
            color: #111827;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
        h1 { color: #059669; margin-bottom: 10px; }
        p { color: #475569; margin-bottom: 24px; }
        .order-summary { background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 24px; text-align: left; }
        .order-summary h5 { font-weight: 700; margin-bottom: 10px; }
        .order-item { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .order-item.total { font-weight: 700; border-top: 2px solid #667eea; padding-top: 10px; margin-top: 10px; }
        .product-img { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1px solid #e2e8f0; }
        .btn-group { display: flex; gap: 12px; justify-content: center; }
        .btn-custom { padding: 10px 18px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; font-size: 1rem; }
        .btn-store { background: RGB(13,18,107); color: white; }
        .btn-store:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(102,126,234,0.4); }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>
    <h1>Checkout Berhasil!</h1>
    <p>Terima kasih telah berbelanja di <strong>Merchandise Store</strong>.<br>
    Pesanan Anda sedang kami proses dan akan segera dikirim.</p>

    <div class="order-summary">
        <h5>Ringkasan Pesanan</h5>

        @foreach($transaksi->detailTransaksi as $item)
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('storage/' . ($item->merchandise->gambar ?? 'default.png')) }}" class="product-img me-3" alt="{{ $item->merchandise->nama_produk }}">
                <div class="flex-grow-1">
                    <div class="order-item">
                        <span>Produk</span>
                        <span>{{ $item->merchandise->nama_produk }}</span>
                    </div>
                    <div class="order-item">
                        <span>Ukuran | Warna</span>
                        <span>{{ $item->ukuran ?? '-' }} | {{ $item->warna ?? '-' }}</span>
                    </div>
                    <div class="order-item">
                        <span>Jumlah</span>
                        <span>{{ $item->jumlah }}</span>
                    </div>
                    <div class="order-item">
                        <span>Harga Satuan</span>
                        <span>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach

        <div class="order-item total">
            <span>Total Pembayaran</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>

        <div class="order-item">
            <span>Metode Pembayaran</span>
            <span>{{ ucfirst($transaksi->metode_pembayaran) }}</span>
        </div>

        <div class="order-item">
            <span>Alamat Pengiriman</span>
            <span>{{ $transaksi->alamat }}</span>
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('client.merchandise') }}" class="btn btn-custom btn-store">
            <i class="fas fa-store me-2"></i> Kembali ke Toko
        </a>
    </div>
</div>

</body>
</html>
