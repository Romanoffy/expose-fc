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
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Contact</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi data contact dengan detail</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/contacts" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-address-book me-1"></i>Contacts
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <!-- Form -->
        <div class="col-lg-8">
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: var(--primary-bg);">
                            <i class="fas fa-address-book" style="color: var(--primary-light); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Contact</h5>
                            <small class="text-white">Masukkan data lengkap contact</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="/admin/contacts" method="POST" enctype="multipart/form-data" id="contactForm">
                        @csrf
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    <i class="fas fa-user me-2" style="color: var(--primary-light);"></i>
                                    Nama Contact <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama contact" required
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    <i class="fas fa-envelope me-2" style="color: var(--primary-light);"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                            </div>

                            <!-- No HP -->
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    <i class="fas fa-mobile-alt me-2" style="color: var(--primary-light);"></i>
                                    No HP
                                </label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Masukkan nomor HP"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                            </div>

                            <!-- No Telpon -->
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    <i class="fas fa-phone me-2" style="color: var(--primary-light);"></i>
                                    No Telpon
                                </label>
                                <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Masukkan nomor telepon"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label for="address" class="form-label" style="color: var(--text-primary); font-weight: 500;">
                                    <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                    Address
                                </label>
                                <textarea name="address" id="address" class="form-control" placeholder="Masukkan alamat lengkap"
                                          style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"></textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid var(--glass-border);">
                            <a href="/admin/contacts" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Contact
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview & Tips -->
        <div class="col-lg-4">
            <!-- Preview Card -->
            <div class="card mb-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Contact</h5>
                            <small class="text-white">Tampilan data contact</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                            <div
                                id="preview-avatar"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light); font-weight: 600;"
                            >
                                N
                            </div>
                        </div>
                    <div id="preview-info">
                        <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Contact</h5>
                        <p id="preview-email" class="text-white small mb-1">Email: -</p>
                        <p id="preview-nohp" class="text-white small mb-1">No HP: -</p>
                        <p id="preview-notelp" class="text-white small mb-1">No Telpon: -</p>
                        <p id="preview-address" class="text-white small mb-0">Alamat: -</p>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-body p-3">
                    <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                        <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                    </h6>
                    <ul class="text-white small mb-0 ps-3">
                        <li class="mb-1">Isi semua informasi contact dengan jelas</li>
                        <li class="mb-1">Gunakan email dan nomor yang valid</li>
                        <li class="mb-1">Alamat lengkap memudahkan pencarian</li>
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
    const emailInput = document.getElementById('email');
    const hpInput = document.getElementById('no_hp');
    const telpInput = document.getElementById('no_telp');
    const addressInput = document.getElementById('address');

    const previewName = document.getElementById('preview-name');
    const previewAvatar = document.getElementById('preview-avatar');
    const previewEmail = document.getElementById('preview-email');
    const previewHp = document.getElementById('preview-nohp');
    const previewTelp = document.getElementById('preview-notelp');
    const previewAddress = document.getElementById('preview-address');

    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');

    // Preview Nama + Avatar
    nameInput.addEventListener('input', () => {
        const value = nameInput.value.trim();
        previewName.textContent = value || 'Nama Contact';
        previewAvatar.textContent = value ? value.charAt(0).toUpperCase() : 'C';
    });

    // Preview Email
    emailInput.addEventListener('input', () => {
        previewEmail.textContent = emailInput.value ? `Email: ${emailInput.value}` : 'Email belum diisi';
    });

    // Preview No HP
    hpInput.addEventListener('input', () => {
        previewHp.textContent = hpInput.value ? `No HP: ${hpInput.value}` : 'No HP belum diisi';
    });

    // Preview No Telpon
    telpInput.addEventListener('input', () => {
        previewTelp.textContent = telpInput.value ? `No Telpon: ${telpInput.value}` : 'No Telpon belum diisi';
    });

    // Preview Address
    addressInput.addEventListener('input', () => {
        previewAddress.textContent = addressInput.value ? `Alamat: ${addressInput.value}` : 'Alamat belum diisi';
    });

    // Submit Form
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
});
</script>



@endsection
