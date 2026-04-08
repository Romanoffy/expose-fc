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
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">
                    Edit Sejarah
                </h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">
                    Perbarui informasi sejarah #{{ $sejarah_array->id }}
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/sejarah" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-book me-1"></i>Sejarah
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">
                        Edit #{{ $sejarah_array->id }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi
                                    Sejarah</h5>
                                <small class="text-white">Perbarui detail sejarah</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/sejarah/{{ $sejarah_array->id }}" method="POST" enctype="multipart/form-data"
                            id="sejarahEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Judul -->
                                <div class="col-md-12">
                                    <label for="judul" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Judul
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul" value="{{ $sejarah_array->judul }}"
                                        class="form-control" id="judul" placeholder="Masukkan judul..." required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Sub Judul -->
                                <div class="col-md-12">
                                    <label for="sub_judul" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-subscript me-2" style="color: var(--primary-light);"></i>
                                        Sub Judul
                                    </label>
                                    <input type="text" name="sub_judul" value="{{ $sejarah_array->sub_judul }}"
                                        class="form-control" id="sub_judul" placeholder="Masukkan sub judul..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Gambar -->
                                <div class="col-md-12">
                                    <label for="gambar" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Gambar
                                    </label>
                                    <input type="file" name="gambar" id="gambar" accept="image/*"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; padding: 8px 12px;">
                                   @if($sejarah_array->gambar)
                                <div class="mt-3">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                        <img src="{{ asset('storage/' . $sejarah_array->gambar) }}" 
                                             class="rounded-circle" 
                                             style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                             alt="{{ $sejarah_array->judul }}">
                                        <div>
                                            <h6 class="mb-1" style="color: var(--text-primary);">Foto Saat Ini</h6>
                                            <small class="text-white">Upload foto baru untuk mengganti</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div> <!-- end row g-4 -->

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/sejarah" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Sejarah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Current Data Card -->
            <div class="col-lg-4">
                
                    <div class="card mb-3"
                        style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                        <div class="card-header"
                            style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle p-2" style="background: rgba(16, 185, 129, 0.1);">
                                    <i class="fas fa-info-circle" style="color: var(--success); font-size: 16px;"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Data Saat Ini
                                    </h5>
                                    <small class="text-white">Informasi sejarah</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Current Gambar -->
                            <div class="mb-3 text-center">
                                <img id="previewGambar"
                                    src="{{ $sejarah_array->gambar ? asset('storage/' . $sejarah_array->gambar) : '' }}"
                                    class="rounded d-block mx-auto mb-2"
                                    style="width: 120px; height: 120px; object-fit: cover; border: 2px solid var(--glass-border);"
                                    alt="Preview Gambar Sejarah">
                            </div>

                            <!-- Current Judul & Sub Judul -->
                            <div class="mb-3">
                                <div class="rounded p-3"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                    <small class="d-block mb-1 text-white" style="font-weight: 500;">Judul:</small>
                                    <p id="previewJudul" class="small mb-0 text-white">{{ $sejarah_array->judul }}</p>
                                    <small class="d-block mt-2 mb-1 text-white" style="font-weight: 500;">Sub
                                        Judul:</small>
                                    <p id="previewSubJudul" class="small mb-0 text-white">{{ $sejarah_array->sub_judul }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <!-- Info Update Card -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-clock me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">ID Sejarah: #{{ str_pad($sejarah_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $sejarah_array->created_at ? $sejarah_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $sejarah_array->updated_at ? $sejarah_array->updated_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung tersimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sejarahEditForm');
            const updateBtn = document.getElementById('updateBtn');
            const inputJudul = document.getElementById('judul');
            const inputSubJudul = document.getElementById('sub_judul');
            const inputGambar = document.getElementById('gambar');

            const previewJudul = document.getElementById('previewJudul');
            const previewSubJudul = document.getElementById('previewSubJudul');
            const previewGambar = document.getElementById('previewGambar');

            // Live preview untuk judul
            inputJudul.addEventListener('input', function() {
                previewJudul.textContent = this.value || '-';
            });

            // Live preview untuk sub judul
            inputSubJudul.addEventListener('input', function() {
                previewSubJudul.textContent = this.value || '-';
            });

            // Live preview untuk gambar
            inputGambar.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewGambar.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewGambar.src = '';
                }
            });

            form.addEventListener('submit', function(e) {
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

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
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Sejarah';
                    updateBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                    return;
                }
            });
        });

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
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
