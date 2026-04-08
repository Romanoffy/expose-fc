@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">
                    Edit Venue
                </h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">
                    Perbarui informasi venue #{{ $venue_array->id }}
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/venues" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-map-marker-alt me-1"></i>Venues
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $venue_array->id }}</li>
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
                                    Venue</h5>
                                <small class="text-white">Perbarui detail venue</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/venues/{{ $venue_array->id }}" method="POST" enctype="multipart/form-data"
                            id="venueEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Nama Venue -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-building me-2" style="color: var(--primary-light);"></i>
                                        Nama Venue <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ $venue_array->name }}" id="name"
                                        class="form-control" placeholder="Masukkan nama venue" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <label for="address" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address" value="{{ $venue_array->address }}" id="address"
                                        class="form-control" placeholder="Masukkan alamat" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Kota -->
                                <div class="col-md-6">
                                    <label for="kota" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-city me-2" style="color: var(--primary-light);"></i>
                                        Kota <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kota" value="{{ $venue_array->kota }}" id="kota"
                                        class="form-control" placeholder="Kota" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Provinsi -->
                                <div class="col-md-6">
                                    <label for="provinsi" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map me-2" style="color: var(--primary-light);"></i>
                                        Provinsi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="provinsi" value="{{ $venue_array->provinsi }}"
                                        id="provinsi" class="form-control" placeholder="Provinsi" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Negara -->
                                <div class="col-md-6">
                                    <label for="negara" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-flag me-2" style="color: var(--primary-light);"></i>
                                        Negara <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="negara" value="{{ $venue_array->negara }}" id="negara"
                                        class="form-control" placeholder="Negara" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Contact -->
                                <div class="col-md-6">
                                    <label for="contact" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-phone me-2" style="color: var(--primary-light);"></i>
                                        Contact <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="contact" value="{{ $venue_array->contact }}"
                                        id="contact" class="form-control" placeholder="Contact" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>
                            </div>
                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/venues" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Venue
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
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Venue
                                </h5>
                                <small class="text-white">Tampilan data venue</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <!-- Preview Info -->
                        <h5 id="previewName" class="mb-1" style="color: var(--text-primary);">{{ $venue_array->name }}
                        </h5>
                        <p id="previewAddress" class="text-white small mb-1">Alamat: {{ $venue_array->address }}</p>
                        <p id="previewKota" class="text-white small mb-1">Kota: {{ $venue_array->kota }}</p>
                        <p id="previewProvinsi" class="text-white small mb-1">Provinsi: {{ $venue_array->provinsi }}</p>
                        <p id="previewNegara" class="text-white small mb-1">Negara: {{ $venue_array->negara }}</p>
                        <p id="previewContact" class="text-white small mb-0">Contact: {{ $venue_array->contact }}</p>

                    </div>
                </div>

                <!-- Tips -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-clock me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="text-white small mb-0 ps-3">
                            <li class="mb-1">ID Venue: #{{ str_pad($venue_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $venue_array->created_at ? $venue_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $venue_array->updated_at ? $venue_array->updated_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung tersimpan</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('venueEditForm');
                const updateBtn = document.getElementById('updateBtn');

                const inputName = document.getElementById('name');
                const inputAddress = document.getElementById('address');
                const inputKota = document.getElementById('kota');
                const inputProvinsi = document.getElementById('provinsi');
                const inputNegara = document.getElementById('negara');
                const inputContact = document.getElementById('contact');

                const previewName = document.getElementById('previewName');
                const previewAddress = document.getElementById('previewAddress');
                const previewKota = document.getElementById('previewKota');
                const previewProvinsi = document.getElementById('previewProvinsi');
                const previewNegara = document.getElementById('previewNegara');
                const previewContact = document.getElementById('previewContact');

                // Live preview
                inputName.addEventListener('input', () => previewName.textContent = inputName.value || 'Nama Venue');
                inputAddress.addEventListener('input', () => previewAddress.textContent = 'Alamat: ' + (inputAddress
                    .value || '-'));
                inputKota.addEventListener('input', () => previewKota.textContent = 'Kota: ' + (inputKota.value ||
                    '-'));
                inputProvinsi.addEventListener('input', () => previewProvinsi.textContent = 'Provinsi: ' + (
                    inputProvinsi.value || '-'));
                inputNegara.addEventListener('input', () => previewNegara.textContent = 'Negara: ' + (inputNegara
                    .value || '-'));
                inputContact.addEventListener('input', () => previewContact.textContent = 'Contact: ' + (inputContact
                    .value || '-'));

                // Form submission & validation
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
                        updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Venue';
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
