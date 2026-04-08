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
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Tambah Posisi</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Buat posisi baru untuk pemain</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/positions"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-map-marker-alt me-1"></i>Posisi
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: var(--primary-bg);"
                            >
                                <i
                                    class="fas fa-map-marker-alt"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Posisi</h5>
                                <small class="text-white">Masukkan nama posisi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/positions"
                            method="POST"
                            enctype="multipart/form-data"
                            id="positionForm"
                        >
                            @csrf

                            <div class="row g-4">
                                <!-- Position Name -->
                                <div class="col-md-12">
                                    <label
                                        for="name"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-tag me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Posisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="Contoh: Midfielder, Striker, Goalkeeper..."
                                        required
                                    >
                                    <small class="text-white mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Gunakan nama posisi yang jelas dan mudah dipahami
                                    </small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/positions"
                                    class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                >
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="submitBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Simpan Posisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: rgba(59, 130, 246, 0.1);"
                            >
                                <i
                                    class="fas fa-eye"
                                    style="color: var(--info); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Preview</h5>
                                <small class="text-white">Tampilan posisi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Preview Icon -->
                        <div class="mb-3">
                            <div
                                id="preview-icon"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);"
                            >
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5
                                id="preview-name"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Nama Posisi</h5>
                            <div class="mb-3">
                                <span
                                    id="preview-badge"
                                    class="badge bg-secondary"
                                >Belum diisi</span>
                            </div>
                            <p
                                class="small mb-0 text-white"
                                style="font-style: italic;"
                            >
                                Masukkan nama posisi untuk melihat preview
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-lightbulb me-2"
                                style="color: var(--warning);"
                            ></i>Tips
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Gunakan singkatan standar (GK, DF, MF, FW)</li>
                            <li class="mb-1">Atau gunakan nama lengkap (Goalkeeper, Defender)</li>
                            <li class="mb-1">Hindari nama posisi yang ambigu</li>
                            <li>Posisi dapat diubah sewaktu-waktu</li>
                        </ul>
                    </div>
                </div>

                <!-- Position Examples -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-info-circle me-2"
                                style="color: var(--info);"
                            ></i>Contoh Posisi
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span
                                class="badge bg-danger"
                                style="font-size: 10px;"
                            >GK - Goalkeeper</span>
                            <span
                                class="badge bg-primary"
                                style="font-size: 10px;"
                            >DF - Defender</span>
                            <span
                                class="badge bg-success"
                                style="font-size: 10px;"
                            >MF - Midfielder</span>
                            <span
                                class="badge bg-warning"
                                style="font-size: 10px;"
                            >FW - Forward</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const previewName = document.getElementById('preview-name');
            const previewBadge = document.getElementById('preview-badge');
            const previewIcon = document.getElementById('preview-icon');

            // Update position preview with color coding
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();
                
                if (value) {
                    previewName.textContent = value;
                    
                    let badgeClass = 'bg-secondary';
                    let iconClass = 'fa-map-marker-alt';
                    const valueUpper = value.toUpperCase();

                    // Color code based on position type
                    if (valueUpper.includes('GK') || valueUpper.includes('KEEPER')) {
                        badgeClass = 'bg-danger';
                        iconClass = 'fa-hands';
                    } else if (valueUpper.includes('DEF') || valueUpper.includes('BACK')) {
                        badgeClass = 'bg-primary';
                        iconClass = 'fa-shield-alt';
                    } else if (valueUpper.includes('MID')) {
                        badgeClass = 'bg-success';
                        iconClass = 'fa-sync-alt';
                    } else if (valueUpper.includes('FOR') || valueUpper.includes('STRIKER') || 
                               valueUpper.includes('WING')) {
                        badgeClass = 'bg-warning';
                        iconClass = 'fa-futbol';
                    }

                    previewBadge.className = `badge ${badgeClass}`;
                    previewBadge.innerHTML = `<i class="fas ${iconClass} me-1"></i>${value}`;
                    
                    previewIcon.innerHTML = `<i class="fas ${iconClass}"></i>`;
                } else {
                    previewName.textContent = 'Nama Posisi';
                    previewBadge.className = 'badge bg-secondary';
                    previewBadge.textContent = 'Belum diisi';
                    previewIcon.innerHTML = '<i class="fas fa-map-marker-alt"></i>';
                }
            });

            // Form validation and submission
            const form = document.getElementById('positionForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Posisi';
                    submitBtn.disabled = false;
                    nameInput.style.borderColor = 'var(--error)';
                    showNotification('Harap masukkan nama posisi', 'error');
                } else {
                    nameInput.style.borderColor = 'var(--glass-border)';
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