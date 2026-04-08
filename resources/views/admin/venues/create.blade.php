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
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Venue</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi data venue dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/venues" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-map-marker-alt me-1"></i>Venues
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
                                <i class="fas fa-building" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Venue
                                </h5>
                                <small class="text-white">Masukkan data lengkap venue</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/venues" method="POST" enctype="multipart/form-data" id="venueForm">
                            @csrf
                            <div class="row g-4">
                                <!-- Nama Venue -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-building me-2" style="color: var(--primary-light);"></i>
                                        Nama Venue <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Masukkan nama venue" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <label for="address" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="Alamat lengkap" required
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Kota -->
                                <div class="col-md-6">
                                    <label for="kota" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-city me-2" style="color: var(--primary-light);"></i>
                                        Kota
                                    </label>
                                    <input type="text" name="kota" id="kota" class="form-control"
                                        placeholder="Kota venue"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Provinsi -->
                                <div class="col-md-6">
                                    <label for="provinsi" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map me-2" style="color: var(--primary-light);"></i>
                                        Provinsi
                                    </label>
                                    <input type="text" name="provinsi" id="provinsi" class="form-control"
                                        placeholder="Provinsi venue"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Negara -->
                                <div class="col-md-6">
                                    <label for="negara" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-flag me-2" style="color: var(--primary-light);"></i>
                                        Negara
                                    </label>
                                    <input type="text" name="negara" id="negara" class="form-control"
                                        placeholder="Negara venue"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Contact -->
                                <div class="col-md-6">
                                    <label for="contact" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-phone me-2" style="color: var(--primary-light);"></i>
                                        Contact
                                    </label>
                                    <input type="text" name="contact" id="contact" class="form-control"
                                        placeholder="Nomor telepon atau email"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>
                            </div> <!-- row g-4 -->
                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/venues" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Venue
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
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Venue
                                </h5>
                                <small class="text-white">Tampilan data venue</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Venue</h5>
                            <p id="preview-address" class="text-white small mb-1">Alamat: -</p>
                            <p id="preview-city" class="text-white small mb-1">Kota: -</p>
                            <p id="preview-province" class="text-white small mb-1">Provinsi: -</p>
                            <p id="preview-country" class="text-white small mb-1">Negara: -</p>
                            <p id="preview-contact" class="text-white small mb-0">Contact: -</p>
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
                            <li class="mb-1">Isi semua informasi venue secara jelas</li>
                            <li class="mb-1">Gunakan alamat lengkap agar mudah ditemukan</li>
                            <li class="mb-1">Cantumkan kota, provinsi, dan negara</li>
                            <li class="mb-1">Isi contact yang bisa dihubungi</li>
                            <li>Pastikan semua field wajib diisi sebelum menyimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const addressInput = document.getElementById('address');
            const cityInput = document.getElementById('kota');
            const provinceInput = document.getElementById('provinsi');
            const countryInput = document.getElementById('negara');
            const contactInput = document.getElementById('contact');

            const previewName = document.getElementById('preview-name');
            const previewAddress = document.getElementById('preview-address');
            const previewCity = document.getElementById('preview-city');
            const previewProvince = document.getElementById('preview-province');
            const previewCountry = document.getElementById('preview-country');
            const previewContact = document.getElementById('preview-contact');

            // Update live preview
            nameInput.addEventListener('input', () => {
                previewName.textContent = nameInput.value || 'Nama Venue';
            });
            addressInput.addEventListener('input', () => {
                previewAddress.textContent = addressInput.value ? `Alamat: ${addressInput.value}` :
                    'Alamat: -';
            });
            cityInput.addEventListener('input', () => {
                previewCity.textContent = cityInput.value ? `Kota: ${cityInput.value}` : 'Kota: -';
            });
            provinceInput.addEventListener('input', () => {
                previewProvince.textContent = provinceInput.value ? `Provinsi: ${provinceInput.value}` :
                    'Provinsi: -';
            });
            countryInput.addEventListener('input', () => {
                previewCountry.textContent = countryInput.value ? `Negara: ${countryInput.value}` :
                    'Negara: -';
            });
            contactInput.addEventListener('input', () => {
                previewContact.textContent = contactInput.value ? `Contact: ${contactInput.value}` :
                    'Contact: -';
            });

            // Form submission
            const form = document.getElementById('venueForm');
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
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Venue';
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
