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
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">
                    Edit Contact
                </h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">
                    Perbarui informasi contact #{{ $contact_array->id }}
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/contacts" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-address-book me-1"></i>Contacts
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $contact_array->id }}
                    </li>
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
                            <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi
                                    Contact</h5>
                                <small class="text-white">Perbarui detail contact</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/contacts/{{ $contact_array->id }}" method="POST" enctype="multipart/form-data"
                            id="contactEditForm">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <!-- Nama Contact -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-user me-2" style="color: var(--primary-light);"></i>
                                        Nama Contact <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ $contact_array->name }}"
                                        class="form-control" placeholder="Masukkan nama contact" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-envelope me-2" style="color: var(--primary-light);"></i>
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ $contact_array->email }}"
                                        class="form-control" placeholder="Masukkan email" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>
                                <!-- No HP -->
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-mobile-alt me-2" style="color: var(--primary-light);"></i>
                                        No HP
                                    </label>
                                    <input type="text" name="no_hp" id="no_hp" value="{{ $contact_array->no_hp }}"
                                        class="form-control" placeholder="Masukkan nomor HP"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- No Telpon -->
                                <div class="col-md-6">
                                    <label for="no_telp" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-phone me-2" style="color: var(--primary-light);"></i>
                                        No Telpon
                                    </label>
                                    <input type="text" name="no_telp" id="no_telp"
                                        value="{{ $contact_array->no_telp }}" class="form-control"
                                        placeholder="Masukkan nomor telepon"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label for="address" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                        Address
                                    </label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Masukkan alamat lengkap"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">{{ $contact_array->address }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/contacts" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Contact
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview & Tips -->
            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-eye" style="color: var(--primary); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Contact
                                </h5>
                                <small class="text-white">Tampilan data contact</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div id="preview-avatar"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light); font-weight: 600;">
                                {{ strtoupper(substr($contact_array->name, 0, 1)) }}
                            </div>
                        </div>
                        <div id="preview-info">
                            <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">
                                {{ $contact_array->name }}</h5>
                            <p id="preview-email" class="text-white small mb-1">Email: {{ $contact_array->email }}</p>
                            <p id="preview-nohp" class="text-white small mb-1">No HP: {{ $contact_array->no_hp ?: '-' }}
                            </p>
                            <p id="preview-notelp" class="text-white small mb-1">No Telpon:
                                {{ $contact_array->no_telp ?: '-' }}</p>
                            <p id="preview-address" class="text-white small mb-0">Alamat:
                                {{ $contact_array->address ?: '-' }}</p>
                        </div>
                    </div>

                </div>

                <!-- Tips Card -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-clock me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="text-white small mb-0 ps-3">
                            <li class="mb-1">ID Contact: #{{ str_pad($contact_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $contact_array->created_at ? $contact_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $contact_array->updated_at ? $contact_array->updated_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung tersimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('contactEditForm');
                const updateBtn = document.getElementById('updateBtn');

                const inputName = document.getElementById('name');
                const inputEmail = document.getElementById('email');
                const inputHp = document.getElementById('no_hp');
                const inputTelp = document.getElementById('no_telp');
                const inputAddress = document.getElementById('address');

                const previewAvatar = document.getElementById('preview-avatar');
                const previewName = document.getElementById('preview-name');
                const previewEmail = document.getElementById('preview-email');
                const previewHp = document.getElementById('preview-nohp');
                const previewTelp = document.getElementById('preview-notelp');
                const previewAddress = document.getElementById('preview-address');

                // Live preview
                inputName.addEventListener('input', () => {
                    const val = inputName.value.trim();
                    previewName.textContent = val || 'Nama Contact';
                    previewAvatar.textContent = val ? val.charAt(0).toUpperCase() : 'C';
                });

                inputEmail.addEventListener('input', () => {
                    previewEmail.textContent = inputEmail.value ? `Email: ${inputEmail.value}` :
                        'Email belum diisi';
                });

                inputHp.addEventListener('input', () => {
                    previewHp.textContent = inputHp.value ? `No HP: ${inputHp.value}` : 'No HP belum diisi';
                });

                inputTelp.addEventListener('input', () => {
                    previewTelp.textContent = inputTelp.value ? `No Telpon: ${inputTelp.value}` :
                        'No Telpon belum diisi';
                });

                inputAddress.addEventListener('input', () => {
                    previewAddress.textContent = inputAddress.value ? `Alamat: ${inputAddress.value}` :
                        'Alamat belum diisi';
                });

                // Form submission & validation
                form.addEventListener('submit', function(e) {
                    updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
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
                        updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Contact';
                        updateBtn.disabled = false;
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
                    <i class="fas fa-${type==='success' ? 'check-circle' : 'exclamation-circle'}"></i>
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
