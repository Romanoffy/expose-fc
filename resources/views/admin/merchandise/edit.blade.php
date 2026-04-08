@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Merchandise</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">
                    Perbarui informasi merchandise {{ $merchandise->nama_produk }}
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/merchandise" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-box me-1"></i>Merchandise
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $merchandise->id }}</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi
                                    Merchandise</h5>
                                <small class="text-white">Perbarui data merchandise sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/merchandise/{{ $merchandise->id }}" method="POST"
                            enctype="multipart/form-data" id="merchandiseEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Nama Produk -->
                                <div class="col-md-6">
                                    <label for="nama_produk" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-tag me-2" style="color: var(--primary-light);"></i>
                                        Nama Produk
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_produk" id="nama_produk"
                                        value="{{ $merchandise->nama_produk }}" class="form-control"
                                        placeholder="Masukkan nama produk"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6">
                                    <label for="harga" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-dollar-sign me-2" style="color: var(--primary-light);"></i>
                                        Harga
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="harga" id="harga" value="{{ $merchandise->harga }}"
                                        class="form-control" placeholder="Masukkan harga"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6">
                                    <label for="stok" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-layer-group me-2" style="color: var(--primary-light);"></i>
                                        Stok
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="stok" id="stok" value="{{ $merchandise->stok }}"
                                        class="form-control" placeholder="Jumlah stok tersedia"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Ukuran -->
                                <div class="col-md-6">
                                    <label for="ukuran" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-ruler-horizontal me-2" style="color: var(--primary-light);"></i>
                                        Ukuran
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="ukuran" id="ukuran" value="{{ $merchandise->ukuran }}"
                                        class="form-control" placeholder="Masukkan ukuran (S, M, L...)"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Warna -->
                                <div class="col-md-6">
                                    <label for="warna" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-palette me-2" style="color: var(--primary-light);"></i>
                                        Warna
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="warna" id="warna" value="{{ $merchandise->warna }}"
                                        class="form-control" placeholder="Masukkan warna"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <label for="deskripsi" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Deskripsi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"
                                        placeholder="Masukkan deskripsi produk"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; resize: none;"
                                        required>{{ $merchandise->deskripsi }}</textarea>
                                </div>

                                <!-- Gambar -->
                                <div class="col-md-12">
                                    <label for="gambar" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Gambar Produk
                                        <small class="text-white">(JPG, PNG, max 1MB)</small>
                                    </label>
                                    <!-- Current Preview -->
                                    @if ($merchandise->gambar)
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-3 p-3 rounded"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                                <img src="{{ asset('storage/' . $merchandise->gambar) }}"
                                                    class="rounded-circle"
                                                    style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $merchandise->nama_produk }}">
                                                <div>
                                                    <h6 class="mb-1" style="color: var(--text-primary);">Foto Saat Ini
                                                    </h6>
                                                    <small class="text-white">Upload foto baru untuk mengganti</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <input type="file" name="gambar" id="gambar" class="form-control"
                                        accept="image/*"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                    <small class="text-white">Kosongkan jika tidak ingin mengganti gambar</small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/merchandise" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Merchandise
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Preview Card -->
            <div class="col-lg-4">

                <!-- Merchandise Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-box-open" style="color: var(--success); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview
                                    Merchandise</h5>
                                <small class="text-white">Data merchandise saat ini dan live preview</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Gambar -->
                        <div class="mb-3">
                            <img id="previewCardImage"
                                src="{{ $merchandise->gambar ? asset('storage/' . $merchandise->gambar) : '' }}"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 2px solid var(--glass-border);"
                                alt="Preview Image">
                        </div>

                        <!-- Nama Produk -->
                        <h5 id="previewNama" class="mb-1" style="color: var(--text-primary); font-weight: 600;">
                            {{ $merchandise->nama_produk }}
                        </h5>
                        <p class="text-white small mb-1">Harga: <span
                                id="previewHarga">{{ number_format($merchandise->harga, 0, ',', '.') }}</span></p>
                        <p class="text-white small mb-1">Stok: <span id="previewStok">{{ $merchandise->stok }}</span></p>
                        <p class="text-white small mb-0">Ukuran: <span
                                id="previewUkuran">{{ $merchandise->ukuran }}</span> | Warna: <span
                                id="previewWarna">{{ $merchandise->warna }}</span></p>
                    </div>

                    <!-- Info Update -->
                    <div class="card"
                        style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                        <div class="card-body p-3">
                            <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                                <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                            </h6>
                            <ul class="small text-white mb-0 ps-3">
                                <li class="mb-1">ID Merchandise: #{{ str_pad($merchandise->id, 3, '0', STR_PAD_LEFT) }}
                                </li>
                                <li class="mb-1">Dibuat:
                                    {{ $merchandise->created_at ? $merchandise->created_at->format('d F Y') : '-' }}</li>
                                <li class="mb-1">Update terakhir:
                                    {{ $merchandise->updated_at ? $merchandise->updated_at->format('d F Y, H:i') : '-' }}
                                </li>
                                <li>Perubahan akan terlihat di preview saat mengetik atau mengganti gambar</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('merchandiseEditForm');
            const updateBtn = document.getElementById('updateBtn');

            const previewNama = document.getElementById('previewNama');
            const previewHarga = document.getElementById('previewHarga');
            const previewStok = document.getElementById('previewStok');
            const previewUkuran = document.getElementById('previewUkuran');
            const previewWarna = document.getElementById('previewWarna');
            const previewCardImage = document.getElementById('previewCardImage');
            const inputGambar = document.getElementById('gambar');

            // Live update text
            const fields = ['nama_produk', 'harga', 'stok', 'ukuran', 'warna'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                input.addEventListener('input', function() {
                    switch (field) {
                        case 'nama_produk':
                            previewNama.textContent = this.value ||
                                '{{ $merchandise->nama_produk }}';
                            break;
                        case 'harga':
                            previewHarga.textContent = this.value ? parseInt(this.value)
                                .toLocaleString('id-ID') :
                                '{{ number_format($merchandise->harga, 0, ',', '.') }}';
                            break;
                        case 'stok':
                            previewStok.textContent = this.value || '{{ $merchandise->stok }}';
                            break;
                        case 'ukuran':
                            previewUkuran.textContent = this.value || '{{ $merchandise->ukuran }}';
                            break;
                        case 'warna':
                            previewWarna.textContent = this.value || '{{ $merchandise->warna }}';
                            break;
                    }
                });
            });

            // Live preview image
            inputGambar.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.size > 1048576) { // 1MB
                        alert('Ukuran file maksimal 1MB');
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewCardImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

                let valid = true;
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(f => {
                    if (!f.value.trim()) {
                        valid = false;
                        f.style.borderColor = 'var(--error)';
                    } else {
                        f.style.borderColor = 'var(--glass-border)';
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Merchandise';
                    updateBtn.disabled = false;
                    alert('Harap lengkapi semua field wajib.');
                }
            });
        });

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

            notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10001;
        background: ${type === 'success' ? 'var(--success)' : 'var(--error)'};
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: var(--shadow-xl);
        animation: slideInRight 0.3s ease;
        max-width: 350px;
        font-size: 14px;
    `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>
@endsection
