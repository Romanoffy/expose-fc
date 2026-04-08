@extends('layouts.dashboard')
@section('content')

<style>
.form-control::placeholder {
  color: #fff;   /* warna putih */
  opacity: 0.6;    /* biar gak transparan */
}

#lisensi option {
  color: #000; /* warna teks option hitam */
}


</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Pelatih Baru</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi informasi pelatih dengan detail</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/pelatih" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-chalkboard-teacher me-1"></i>Pelatih
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
                        <div class="p-2 rounded-circle" style="background: var(--primary-bg);">
                            <i class="fas fa-user-plus" style="color: var(--primary-light); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Pelatih</h5>
                            <small class="text-white">Masukkan data lengkap pelatih</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/pelatih" method="POST" enctype="multipart/form-data" id="pelatihForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Nama Pelatih -->
                            <div class="col-md-6">
                                <label for="nama_pelatih" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-user me-2" style="color: var(--primary-light);"></i>
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_pelatih" 
                                       id="nama_pelatih"
                                       class="form-control"
                                       placeholder="Masukkan nama lengkap pelatih"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-envelope me-2" style="color: var(--primary-light);"></i>
                                    Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="form-control" 
                                       placeholder="pelatih@example.com"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                       required>
                            </div>

                            <!-- Lisensi -->
                            <div class="col-md-6">
                                <label for="lisensi" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-certificate me-2" style="color: var(--primary-light);"></i>
                                    Lisensi Kepelatihan
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="lisensi" 
                                        id="lisensi"
                                        class="form-select" 
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                    <option value="">Pilih Lisensi...</option>
                                    <option value="Lisensi D Nasional">Lisensi D Nasional</option>
                                    <option value="Lisensi C AFC">Lisensi C AFC</option>
                                    <option value="Lisensi B AFC">Lisensi B AFC</option>
                                    <option value="Lisensi Pro Kontinental">Lisensi Pro Kontinental</option>
                                </select>
                            </div>

                            <!-- File Lisensi -->
                            <div class="col-md-6">
                                <label for="file_lisensi" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-file-pdf me-2" style="color: var(--primary-light);"></i>
                                    File Lisensi
                                    <small class="text-white">(PDF, max 2MB)</small>
                                </label>
                                <input type="file" 
                                       name="file_lisensi" 
                                       id="file_lisensi"
                                       class="form-control" 
                                       accept="application/pdf"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                            </div>

                            <!-- Pengalaman -->
                            <div class="col-12">
                                <label for="pengalaman" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-history me-2" style="color: var(--primary-light);"></i>
                                    Pengalaman Kepelatihan
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="pengalaman" 
                                          id="pengalaman"
                                          rows="4" 
                                          class="form-control"
                                          placeholder="Deskripsikan pengalaman kepelatihan, klub yang pernah ditangani, prestasi, dll..."
                                          style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; resize: vertical;"
                                          required></textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-12">
                                <label for="gambar" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-camera me-2" style="color: var(--primary-light);"></i>
                                    Foto Pelatih
                                    <small class="text-white">(JPG, PNG, max 1MB)</small>
                                </label>
                                <div class="input-group">
                                    <input type="file" 
                                           name="gambar" 
                                           id="gambar"
                                           class="form-control" 
                                           accept="image/*"
                                           style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;">
                                    <span class="input-group-text" style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;">
                                        <i class="fas fa-upload" style="color: var(--text-light);"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid var(--glass-border);">
                            <a href="/admin/pelatih" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Pelatih
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
                        <div class="p-2 rounded-circle" style="background: var(--info); background: rgba(59, 130, 246, 0.1);">
                            <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                            <small class="text-white">Tampilan data pelatih</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 text-center">
                    <!-- Preview Photo -->
                    <div class="mb-3">
                        <div id="preview-avatar" class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>

                    <!-- Preview Info -->
                    <div id="preview-info">
                        <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Pelatih</h5>
                        <p id="preview-email" class="text-white small mb-2">email@example.com</p>
                        <div id="preview-license" class="mb-3">
                            <span class="badge bg-secondary">Belum dipilih</span>
                        </div>
                        <p id="preview-experience" class="text-white small mb-0" style="font-style: italic;">
                            Pengalaman kepelatihan akan ditampilkan di sini...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Helper Tips -->
            <div class="card mt-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-body p-3">
                    <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                        <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                    </h6>
                    <ul class="text-white small mb-0 ps-3">
                        <li class="mb-1">Gunakan foto dengan latar belakang yang bersih</li>
                        <li class="mb-1">File lisensi harus dalam format PDF, max 2MB</li>
                        <li class="mb-1">Deskripsikan pengalaman secara detail</li>
                        <li>Pastikan email aktif untuk komunikasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time preview updates
    const namaInput = document.getElementById('nama_pelatih');
    const emailInput = document.getElementById('email');
    const lisensiSelect = document.getElementById('lisensi');
    const pengalamanTextarea = document.getElementById('pengalaman');
    const gambarInput = document.getElementById('gambar');
    
    const previewName = document.getElementById('preview-name');
    const previewEmail = document.getElementById('preview-email');
    const previewLicense = document.getElementById('preview-license');
    const previewExperience = document.getElementById('preview-experience');
    const previewAvatar = document.getElementById('preview-avatar');

    // Update name preview
    namaInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Pelatih';
        if (this.value) {
            previewAvatar.innerHTML = this.value.charAt(0).toUpperCase();
        } else {
            previewAvatar.innerHTML = '<i class="fas fa-user"></i>';
        }
    });

    // Update email preview
    emailInput.addEventListener('input', function() {
        previewEmail.textContent = this.value || 'email@example.com';
    });

    // Update license preview
    lisensiSelect.addEventListener('change', function() {
        const colors = {
            'Lisensi D Nasional': 'bg-secondary',
            'Lisensi C AFC': 'bg-warning',
            'Lisensi B AFC': 'bg-info',
            'Lisensi Pro Kontinental': 'bg-success'
        };
        
        if (this.value) {
            previewLicense.innerHTML = `<span class="badge ${colors[this.value] || 'bg-secondary'}">${this.value}</span>`;
        } else {
            previewLicense.innerHTML = '<span class="badge bg-secondary">Belum dipilih</span>';
        }
    });

    // Update experience preview
    pengalamanTextarea.addEventListener('input', function() {
        const text = this.value || 'Pengalaman kepelatihan akan ditampilkan di sini...';
        previewExperience.textContent = text.length > 100 ? text.substring(0, 100) + '...' : text;
    });

    // Image preview
    gambarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewAvatar.style.backgroundImage = `url(${e.target.result})`;
                previewAvatar.style.backgroundSize = 'cover';
                previewAvatar.style.backgroundPosition = 'center';
                previewAvatar.innerHTML = '';
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation and submission
    const form = document.getElementById('pelatihForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Add loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Basic validation
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
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Pelatih';
            submitBtn.disabled = false;
            
            // Show error message
            showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
        }
    });

    // File validation
    gambarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 1048576) { // 1MB
                showNotification('Ukuran file foto maksimal 1MB', 'error');
                this.value = '';
                return;
            }
        }
    });

    document.getElementById('file_lisensi').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {       
            if (file.size > 2097152) { // 2MB
                showNotification('Ukuran file lisensi maksimal 10MB', 'error');
                this.value = '';
                return;
            }
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