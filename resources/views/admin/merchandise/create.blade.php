@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .input-group-text i {
            color: var(--text-light);
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Merchandise</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi data merchandise dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/merchandise" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-box me-1"></i>Merchandise
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Form -->
            <div class="col-lg-8">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: var(--primary-bg);">
                                <i class="fas fa-box" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi
                                    Merchandise</h5>
                                <small class="text-white">Masukkan data lengkap Merchandise</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/merchandise" method="POST" enctype="multipart/form-data" id="merchForm">
                            @csrf
                            <div class="row g-4">
                                <!-- Nama Produk -->
                                <div class="col-md-6">
                                    <label for="nama_produk" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-tag me-2" style="color: var(--primary-light);"></i>
                                        Nama Produk <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                        placeholder="Masukkan nama produk" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6">
                                    <label for="harga" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-dollar-sign me-2" style="color: var(--primary-light);"></i>
                                        Harga <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="harga" id="harga" class="form-control" placeholder="0"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6">
                                    <label for="stok" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-layer-group me-2" style="color: var(--primary-light);"></i>
                                        Stok <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="stok" id="stok" class="form-control" placeholder="0"
                                        required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Ukuran -->
                                <div class="col-md-6">
                                    <label for="ukuran" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-ruler-horizontal me-2" style="color: var(--primary-light);"></i>
                                        Ukuran
                                    </label>
                                    <input type="text" name="ukuran" id="ukuran" class="form-control"
                                        placeholder="S, M, L, XL..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Warna -->
                                <div class="col-md-6">
                                    <label for="warna" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-palette me-2" style="color: var(--primary-light);"></i>
                                        Warna
                                    </label>
                                    <input type="text" name="warna" id="warna" class="form-control"
                                        placeholder="Merah, Biru, Hitam..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-12">
                                    <label for="deskripsi" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Deskripsi <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"
                                        placeholder="Masukkan deskripsi produk"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; resize: none;"
                                        required></textarea>
                                </div>


                                <!-- Gambar -->
                                <div class="col-12">
                                    <label for="gambar" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Foto Produk <small class="text-white">(JPG, PNG, max 1MB)</small>
                                    </label>
                                    <div class="input-group">
                                        <input type="file" name="gambar" id="gambar" class="form-control"
                                            accept="image/*"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;">
                                        <span class="input-group-text"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/merchandise" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Merchandise
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Preview Card & Tips -->
            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview
                                    Merchandise</h5>
                                <small class="text-white">Tampilan data merchandise</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <!-- Preview Photo -->
                        <div class="mb-3">
                            <div id="preview-avatar"
                                class="rounded mx-auto d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 36px; color: var(--text-light);">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Produk</h5>
                            <p id="preview-price" class="text-white small mb-1">Rp 0</p>
                            <p id="preview-stock" class="text-white small mb-1">Stok: 0</p>
                            <p id="preview-size" class="text-white small mb-1">Ukuran: -</p>
                            <p id="preview-color" class="text-white small mb-0">Warna: -</p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                        </h6>
                        <ul class="text-white small mb-0 ps-3">
                            <li class="mb-1">Gunakan foto produk dengan latar bersih dan terang</li>
                            <li class="mb-1">Isi harga sesuai dengan satuan Rupiah tanpa simbol</li>
                            <li class="mb-1">Stok harus sesuai jumlah yang tersedia</li>
                            <li class="mb-1">Isi ukuran dan warna agar pembeli lebih mudah memilih</li>
                            <li>Pastikan file gambar tidak lebih dari 1MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const namaInput = document.getElementById('nama_produk');
            const hargaInput = document.getElementById('harga');
            const stokInput = document.getElementById('stok');
            const ukuranInput = document.getElementById('ukuran');
            const warnaInput = document.getElementById('warna');
            const gambarInput = document.getElementById('gambar');

            const previewName = document.getElementById('preview-name');
            const previewPrice = document.getElementById('preview-price');
            const previewStock = document.getElementById('preview-stock');
            const previewSize = document.getElementById('preview-size');
            const previewColor = document.getElementById('preview-color');
            const previewAvatar = document.getElementById('preview-avatar');

            // Update name
            namaInput.addEventListener('input', () => {
                previewName.textContent = namaInput.value || 'Nama Produk';
            });

            // Update price
            hargaInput.addEventListener('input', () => {
                previewPrice.textContent = hargaInput.value ?
                    `Rp ${Number(hargaInput.value).toLocaleString('id-ID')}` : 'Rp 0';
            });

            // Update stock
            stokInput.addEventListener('input', () => {
                previewStock.textContent = stokInput.value ? `Stok: ${stokInput.value}` : 'Stok: 0';
            });

            // Update size
            ukuranInput.addEventListener('input', () => {
                previewSize.textContent = ukuranInput.value ? `Ukuran: ${ukuranInput.value}` : 'Ukuran: -';
            });

            // Update color
            warnaInput.addEventListener('input', () => {
                previewColor.textContent = warnaInput.value ? `Warna: ${warnaInput.value}` : 'Warna: -';
            });

            // Image preview
            gambarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 1048576) {
                        showNotification('Ukuran file maksimal 1MB', 'error');
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewAvatar.style.backgroundImage = `url(${e.target.result})`;
                        previewAvatar.style.backgroundSize = 'cover';
                        previewAvatar.style.backgroundPosition = 'center';
                        previewAvatar.innerHTML = '';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewAvatar.style.backgroundImage = '';
                    previewAvatar.innerHTML = '<i class="fas fa-box"></i>';
                }
            });

            // Form submission
            const form = document.getElementById('merchForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let valid = true;
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
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Merchandise';
                    submitBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
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
        background: ${type==='success' ? 'var(--success)' : 'var(--error)'};
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
