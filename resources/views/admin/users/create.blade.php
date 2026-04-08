@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah User</h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">Buat akun pengguna baru</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/users" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
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
                            <div class="rounded-circle p-2" style="background: var(--primary-bg);">
                                <i class="fas fa-user-plus" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi User</h5>
                                <small class="text-white">Masukkan data pengguna</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/users" method="POST" enctype="multipart/form-data" id="userForm">
                            @csrf

                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-md-12">
                                    <label for="name" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-user me-2" style="color: var(--primary-light);"></i>
                                        Nama Lengkap
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="Masukkan nama lengkap..." required>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12">
                                    <label for="email" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-envelope me-2" style="color: var(--primary-light);"></i>
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="contoh@email.com" required>
                                </div>

                                <!-- Password -->
                                <div class="col-md-12">
                                    <label for="password" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-lock me-2" style="color: var(--primary-light);"></i>
                                        Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                            placeholder="Minimal 8 karakter..." required>
                                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                    </div>
                                    <small class="d-block mt-1 text-white">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Password minimal 8 karakter
                                    </small>
                                </div>

                                <!-- Status -->
                                <div class="col-md-12">
                                    <label class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-toggle-on me-2" style="color: var(--primary-light);"></i>
                                        Status Akun
                                    </label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="active"
                                                value="1" checked>
                                            <label class="form-check-label text-white" for="active">
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                                value="0">
                                            <label class="form-check-label text-white" for="inactive">
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times-circle me-1"></i>Inactive
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Upload Photo -->
                                <div class="col-md-12">
                                    <label for="photo" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Foto Profil
                                    </label>
                                    <input type="file" name="photo" id="photo" class="form-control"
                                        accept="image/*"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 10px 16px;">
                                    <small class="d-block mt-1 text-white">
                                        <i class="fas fa-info-circle me-1"></i>Format yang didukung: JPG, PNG, maksimal 2MB
                                    </small>
                                </div>

                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/users" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                                <small class="text-white">Tampilan user</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Preview Avatar -->
                        <!-- Preview Avatar -->
                        <div class="mb-3 position-relative">
                            <div id="preview-avatar"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light); font-weight: 600;">
                                <span id="avatar-initial">U</span>
                                <img id="avatar-image" src="" alt=""
                                    style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>


                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5 id="preview-name" class="mb-2" style="color: var(--text-primary);">Nama User</h5>
                            <p id="preview-email" class="small mb-3 text-white">
                                <i class="fas fa-envelope me-1"></i>
                                email@example.com
                            </p>
                            <div class="mb-3">
                                <span id="preview-status" class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Gunakan email yang valid dan aktif</li>
                            <li class="mb-1">Password minimal 8 karakter</li>
                            <li class="mb-1">Status Inactive untuk user yang belum diverifikasi</li>
                            <li>User dapat login setelah status Active</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const activeRadio = document.getElementById('active');
            const inactiveRadio = document.getElementById('inactive');

            const previewName = document.getElementById('preview-name');
            const previewEmail = document.getElementById('preview-email');
            const previewStatus = document.getElementById('preview-status')
            // Photo preview
            const photoInput = document.getElementById('photo');
            const avatarInitial = document.getElementById('avatar-initial');
            const avatarImage = document.getElementById('avatar-image');

            photoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarImage.src = e.target.result;
                        avatarImage.style.display = 'block';
                        avatarInitial.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    avatarImage.src = '';
                    avatarImage.style.display = 'none';
                    avatarInitial.style.display = 'flex';
                }
            });


            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Update name preview
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    previewName.textContent = value;
                    
                } else {
                    previewName.textContent = 'Nama User';
                    
                }
            });

            // Update email preview
            emailInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    previewEmail.innerHTML = `<i class="fas fa-envelope me-1"></i>${value}`;
                } else {
                    previewEmail.innerHTML = '<i class="fas fa-envelope me-1"></i>email@example.com';
                }
            });

            // Update status preview
            activeRadio.addEventListener('change', function() {
                if (this.checked) {
                    previewStatus.className = 'badge bg-success';
                    previewStatus.innerHTML = '<i class="fas fa-check-circle me-1"></i>Active';
                }
            });

            inactiveRadio.addEventListener('change', function() {
                if (this.checked) {
                    previewStatus.className = 'badge bg-secondary';
                    previewStatus.innerHTML = '<i class="fas fa-times-circle me-1"></i>Inactive';
                }
            });

            // Form validation
            const form = document.getElementById('userForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Validate password length
                if (passwordInput.value.length < 8) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan User';
                    submitBtn.disabled = false;
                    passwordInput.style.borderColor = 'var(--error)';
                    showNotification('Password minimal 8 karakter', 'error');
                    return;
                }

                // Validate email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value)) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan User';
                    submitBtn.disabled = false;
                    emailInput.style.borderColor = 'var(--error)';
                    showNotification('Format email tidak valid', 'error');
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
