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
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit User</h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">Perbarui informasi pengguna</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/users" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit</li>
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
                            <div class="rounded-circle p-2" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi User
                                </h5>
                                <small class="text-white">Perbarui data pengguna sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/users/{{ $user_array->id }}" method="POST" enctype="multipart/form-data"
                            id="userEditForm">
                            @csrf
                            @method('PUT')

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
                                        value="{{ $user_array->name }}" required>
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
                                        value="{{ $user_array->email }}" required>
                                </div>

                                <!-- Password (Optional) -->
                                <div class="col-md-12">
                                    <label for="password" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-lock me-2" style="color: var(--primary-light);"></i>
                                        Password Baru
                                        <span class="text-muted">(Opsional)</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                            placeholder="Kosongkan jika tidak ingin mengubah...">
                                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                    </div>
                                    <small class="text-white mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kosongkan jika tidak ingin mengubah password
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
                                                value="1" {{ $user_array->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label text-white" for="active">
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                                value="0" {{ !$user_array->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label text-white" for="inactive">
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times-circle me-1"></i>Inactive
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Foto Profil -->
                                <div class="col-md-12">
                                    <label for="photo" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Foto Profil (Opsional)
                                    </label>
                                    <input type="file" name="photo" id="photo" class="form-control"
                                        accept="image/*"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">

                                    @if ($user_array->photo)
                                        <div>
                                            <div class="d-flex align-items-center gap-3 p-3 rounded"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                                <img src="{{ asset('storage/' . $user_array->photo) }}" id="currentImage"
                                                    class="rounded"
                                                    style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $user_array->name }}">
                                                <div>
                                                    <h6 class="mb-1" style="color: var(--text-primary);">Gambar Saat Ini
                                                    </h6>
                                                    <small class="text-white">Upload gambar baru untuk mengganti</small>
                                                </div>
                                            </div>
                                            <small class="text-white">Kosongkan jika tidak ingin mengubah gambar</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/users" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview & Info Card -->
            <div class="col-lg-4">
                <!-- Current Data Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-check-circle" style="color: var(--success); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Data Saat Ini
                                </h5>
                                <small class="text-white">Informasi user aktif</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-center">
                            <div id="avatarPreviewContainer"
                                class="d-flex align-items-center justify-content-center mx-auto rounded-circle overflow-hidden"
                                style="width: 80px; height: 80px; background: var(--primary-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-primary); font-weight: 600;">
                                @if ($user_array->photo)
                                    <img id="avatarPreview" src="{{ asset('storage/' . $user_array->photo) }}"
                                        alt="User Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span id="avatarInitial">
                                        {{ strtoupper(substr($user_array->name ?? 'U', 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Current Info -->
                        <div>
                            <h5 class="mb-2" style="color: var(--text-primary);">{{ $user_array->name }}</h5>
                            <p class="small text-white mb-3">
                                <i class="fas fa-envelope me-1"></i>{{ $user_array->email }}
                            </p>
                            <div class="mb-3">
                                <span class="badge {{ $user_array->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    <i class="fas fa-{{ $user_array->is_active ? 'check' : 'times' }}-circle me-1"></i>
                                    {{ $user_array->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">ID: #{{ str_pad($user_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $user_array->created_at ? $user_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $user_array->updated_at ? $user_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung diterapkan</li>
                        </ul>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-shield-alt me-2" style="color: var(--warning);"></i>Keamanan
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Password minimal 8 karakter jika diubah</li>
                            <li class="mb-1">Status Inactive akan menonaktifkan akses login</li>
                            <li>Email harus valid dan unik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userEditForm');
        const updateBtn = document.getElementById('updateBtn');
        const passwordInput = document.getElementById('password');
        const inputPhoto = document.getElementById('photo');
        const previewImage = document.getElementById('previewImage');
        const currentImage = document.getElementById('currentImage');

        // --- Preview Foto Saat Ini ---
        if (currentImage && currentImage.dataset.src) {
            currentImage.src = currentImage.dataset.src;
        }

        // --- Preview Foto Baru Saat Dipilih ---
        inputPhoto.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // // ✅ Preview di form kiri
                    // if (previewImage) {
                    //     previewImage.src = e.target.result;
                    //     previewImage.classList.remove('d-none');
                    // }
                    // if (currentImage) currentImage.classList.add('d-none');

                    // ✅ Update preview kanan (avatarPreview)
                    const avatarPreview = document.getElementById('avatarPreview');
                    const avatarInitial = document.getElementById('avatarInitial');

                    if (avatarPreview) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.classList.remove('d-none');
                    }

                    if (avatarInitial) {
                        avatarInitial.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // --- Toggle Password Visibility ---
        document.getElementById('togglePassword').addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // --- Saat Submit ---
        form.addEventListener('submit', function(e) {
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
            updateBtn.disabled = true;

            if (passwordInput.value && passwordInput.value.length < 8) {
                e.preventDefault();
                updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update User';
                updateBtn.disabled = false;
                passwordInput.style.borderColor = 'var(--error)';
                showNotification('Password minimal 8 karakter', 'error');
                return;
            }
        });
    });

    // --- Notifikasi Dinamis ---
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
