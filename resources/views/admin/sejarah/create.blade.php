@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        #id_sejarah option {
            color: #000;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Sejarah</h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">Buat sejarah baru dengan detail lengkap</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/sejarah" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-book me-1"></i>Sejarah
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: var(--primary-bg);">
                                <i class="fas fa-clipboard-list" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Sejarah</h5>
                                <small class="text-white">Masukkan detail sejarah</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/sejarah" method="POST" enctype="multipart/form-data" id="sejarahForm">
                            @csrf
                            <div class="row g-4">
                                <!-- Judul -->
                                <div class="col-md-12">
                                    <label for="judul" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Judul <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul..." required style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Sub Judul -->
                                <div class="col-md-12">
                                    <label for="sub_judul" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-subscript me-2" style="color: var(--primary-light);"></i>
                                        Sub Judul
                                    </label>
                                    <input type="text" name="sub_judul" id="sub_judul" class="form-control" placeholder="Masukkan sub judul..." style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Gambar -->
                                <div class="col-md-12">
                                    <label for="gambar" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Foto
                                    </label>
                                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 6px 12px;">
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-4 gap-3 pt-3" style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/sejarah" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Sejarah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                                <small class="text-white">Tampilan sejarah</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Preview Icon -->
                        <div class="mb-3 text-center">
                            <div id="preview-avatar" class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info" class="text-center">
                            <h5 id="preview-judul" class="mb-2" style="color: var(--text-primary);">Judul Sejarah</h5>
                            <p id="preview-subjudul" class="small mb-3 text-white">Sub judul sejarah</p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div class="card mt-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Judul sebaiknya adalah nama kompetisi</li>
                            <li class="mb-1">Sub judul sebaiknya ditunjukan sebagai juara keberapa dan tahun keberapa</li>
                            <li class="mb-1">Tambahkan foto Trophy untuk bukti mantap</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const judulInput = document.getElementById('judul');
            const subJudulInput = document.getElementById('sub_judul');
            const gambarInput = document.getElementById('gambar');

            const previewJudul = document.getElementById('preview-judul');
            const previewSubJudul = document.getElementById('preview-subjudul');
            const previewAvatar = document.getElementById('preview-avatar');

            // Live preview judul
            judulInput.addEventListener('input', function() {
                const text = this.value || 'Judul Sejarah';
                previewJudul.textContent = text.length > 80 ? text.substring(0, 80) + '...' : text;

                // Update avatar inisial
                if (!gambarInput.files[0]) {
                    previewAvatar.innerHTML = text ? text.charAt(0).toUpperCase() : '<i class="fas fa-book"></i>';
                    previewAvatar.style.fontSize = '32px';
                    previewAvatar.style.fontWeight = '600';
                    previewAvatar.style.backgroundImage = 'none';
                }
            });

            // Live preview sub judul
            subJudulInput.addEventListener('input', function() {
                const text = this.value || 'Sub judul sejarah';
                previewSubJudul.textContent = text.length > 80 ? text.substring(0, 80) + '...' : text;
            });

            // Live preview gambar
            gambarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewAvatar.style.backgroundImage = `url('${e.target.result}')`;
                        previewAvatar.style.backgroundSize = 'cover';
                        previewAvatar.style.backgroundPosition = 'center';
                        previewAvatar.innerHTML = '';
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewAvatar.style.backgroundImage = 'none';
                    previewAvatar.innerHTML = judulInput.value ? judulInput.value.charAt(0).toUpperCase() : '<i class="fas fa-book"></i>';
                    previewAvatar.style.fontSize = '32px';
                    previewAvatar.style.fontWeight = '600';
                }
            });

            // Form validation & submission
            const form = document.getElementById('sejarahForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = 'var(--error)';
                    } else {
                        field.style.borderColor = 'var(--glass-border)';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Sejarah';
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
