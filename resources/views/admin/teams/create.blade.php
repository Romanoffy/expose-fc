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
                >Tambah Tim Baru</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Lengkapi informasi tim dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/teams"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-flag me-1"></i>Teams
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
                                    class="fas fa-flag"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Tim</h5>
                                <small class="text-white">Masukkan data lengkap tim</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/teams"
                            method="POST"
                            enctype="multipart/form-data"
                            id="teamForm"
                        >
                            @csrf

                            <div class="row g-4">
                                <!-- Logo -->
                                <div class="col-12">
                                    <label
                                        for="logo"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-image me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Logo Tim
                                        <small class="text-white">(PNG, JPG, max 1MB)</small>
                                    </label>
                                    <div class="input-group">
                                        <input
                                            type="file"
                                            name="logo"
                                            id="logo"
                                            class="form-control"
                                            accept="image/*"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;"
                                        >
                                        <span
                                            class="input-group-text"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;"
                                        >
                                            <i
                                                class="fas fa-upload"
                                                style="color: var(--text-light);"
                                            ></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-12">
                                    <label
                                        for="name"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-tag me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Tim
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        placeholder="Masukkan nama tim"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label
                                        for="descriptions"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-align-left me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Deskripsi
                                    </label>
                                    <textarea
                                        name="descriptions"
                                        id="descriptions"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Masukkan deskripsi tim"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                    ></textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/teams"
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
                                    <i class="fas fa-save me-2"></i>Simpan Tim
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
                                <small class="text-white">Tampilan data tim</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Preview Logo -->
                        <div class="mb-3">
                            <div
                                id="preview-logo"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);"
                            >
                                <i class="fas fa-flag"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5
                                id="preview-name"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Nama Tim</h5>
                            <p
                                id="preview-description"
                                class="small mb-0 text-white"
                                style="font-style: italic;"
                            >
                                Deskripsi tim akan muncul di sini
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
                            <li class="mb-1">Gunakan logo dengan format persegi untuk hasil terbaik</li>
                            <li class="mb-1">Nama tim harus unik dan mudah diingat</li>
                            <li class="mb-1">Deskripsi membantu menjelaskan kategori atau divisi tim</li>
                            <li>Logo akan otomatis di-resize</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('descriptions');
            const logoInput = document.getElementById('logo');

            const previewName = document.getElementById('preview-name');
            const previewDescription = document.getElementById('preview-description');
            const previewLogo = document.getElementById('preview-logo');

            // Update name preview
            nameInput.addEventListener('input', function() {
                previewName.textContent = this.value || 'Nama Tim';
                if (this.value && !logoInput.files[0]) {
                    previewLogo.innerHTML = this.value.charAt(0).toUpperCase();
                    previewLogo.style.fontSize = '32px';
                }
            });

            // Update description preview
            descriptionInput.addEventListener('input', function() {
                previewDescription.textContent = this.value || 'Deskripsi tim akan muncul di sini';
            });

            // Logo preview
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 1048576) {
                        showNotification('Ukuran file logo maksimal 1MB', 'error');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewLogo.style.backgroundImage = `url(${e.target.result})`;
                        previewLogo.style.backgroundSize = 'cover';
                        previewLogo.style.backgroundPosition = 'center';
                        previewLogo.innerHTML = '';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form validation
            const form = document.getElementById('teamForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Tim';
                    submitBtn.disabled = false;
                    showNotification('Nama tim harus diisi', 'error');
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
