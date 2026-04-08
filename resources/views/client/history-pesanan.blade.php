<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: rgb(10, 14, 24);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            padding: 40px 0;
            color: #e8ecef;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .page-header h1 {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .history-card {
            background: #232931;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 24px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .history-card:hover {
            border-color: rgba(59, 130, 246, 0.3);
        }

        .history-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .date-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 600;
        }

        .date-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-badge.selesai .status-dot {
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        .status-badge.proses .status-dot {
            background: #f59e0b;
            box-shadow: 0 0 8px #f59e0b;
            animation: pulse 2s infinite;
        }

        .status-badge.batal .status-dot {
            background: #ef4444;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .history-body {
            padding: 24px;
        }

        .product {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            margin-bottom: 16px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .product:hover {
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .product:last-child {
            margin-bottom: 0;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
        }

        .product-img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            background: #1a1f2e;
            border: 2px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .product-details {
            flex: 1;
            min-width: 0;
        }

        .product-details h3 {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 6px;
            font-size: 0.85rem;
            color: #9ca3af;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .meta-item strong {
            color: #e8ecef;
        }

        .product-pricing {
            text-align: right;
            flex-shrink: 0;
            margin-left: 20px;
        }

        .quantity {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 6px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 10px;
        }

        .subtotal {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .subtotal strong {
            color: #10b981;
            font-size: 1.1rem;
            display: block;
            margin-top: 4px;
        }

        .history-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 24px;
            background: rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 1rem;
            color: #9ca3af;
            font-weight: 500;
        }

        .total-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #10b981;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: #232931;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .empty-icon {
            font-size: 5rem;
            margin-bottom: 24px;
            opacity: 0.3;
        }

        .empty-state h3 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .product {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .product-info {
                width: 100%;
            }

            .product-pricing {
                width: 100%;
                text-align: left;
                margin-left: 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .history-footer {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .total-amount {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 0;
            }

            .page-header {
                margin-bottom: 32px;
            }

            .page-header h1 {
                font-size: 1.75rem;
                flex-direction: column;
            }

            .product-img {
                width: 70px;
                height: 70px;
            }

            .product-details h3 {
                font-size: 1rem;
            }

            .meta-item {
                font-size: 0.8rem;
                padding: 4px 10px;
            }

            .history-header {
                padding: 16px 20px;
            }

            .history-body {
                padding: 20px;
            }

            .product {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>
                <span>🛍️</span>
                <span>Riwayat Pembelian</span>
            </h1>
            <p>Lihat semua transaksi pembelian Anda</p>
        </div>

        @forelse($transaksi as $trx)
            <div class="history-card">
                <div class="history-header">
                    <div class="date-info">
                        <div class="date-icon">📅</div>
                        <span>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}</span>
                    </div>
                    <div class="status-badge {{ strtolower($trx->status) }}">
                        <span class="status-dot"></span>
                        <span>{{ ucfirst($trx->status) }}</span>
                    </div>
                </div>

                <div class="history-body">
                    @foreach($trx->detailTransaksi as $detail)
                        <div class="product">
                            <div class="product-info">
                                @if($detail->merchandise && $detail->merchandise->gambar)
                                    <img src="{{ asset('storage/' . $detail->merchandise->gambar) }}" 
                                         alt="{{ $detail->merchandise->nama }}" 
                                         class="product-img">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" 
                                         class="product-img" 
                                         alt="No image">
                                @endif
                                
                                <div class="product-details">
                                    <h3>{{ $detail->merchandise->nama ?? 'Produk tidak tersedia' }}</h3>
                                    <div class="product-meta">
                                        @if($detail->ukuran)
                                        <span class="meta-item">
                                            📏 <strong>{{ $detail->ukuran }}</strong>
                                        </span>
                                        @endif
                                        @if($detail->warna)
                                        <span class="meta-item">
                                            🎨 <strong>{{ $detail->warna }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="product-pricing">
                                <div class="quantity">{{ $detail->jumlah }} pcs</div>
                                <div class="subtotal">
                                    Subtotal
                                    <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="history-footer">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-amount">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3>Belum Ada Riwayat Pembelian</h3>
                <p>Mulai berbelanja sekarang untuk melihat riwayat transaksi Anda</p>
            </div>
        @endforelse
    </div>
</body>
</html>