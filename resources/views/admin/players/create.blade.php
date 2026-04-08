@extends('layouts.dashboard')
@section('content')

<style>
.form-control::placeholder {
  color: #fff;
  opacity: 0.6;
}

#team_id option,
#gender option,
#status option {
  color: #000;
}
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Pemain Baru</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi informasi pemain dengan detail</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/players" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-users me-1"></i>Players
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
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Pemain</h5>
                            <small class="text-white">Masukkan data lengkap pemain</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/players" method="POST" enctype="multipart/form-data" id="playerForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Team -->
                            <div class="col-md-6">
                                <label for="team_id" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-flag me-2" style="color: var(--primary-light);"></i>
                                    Tim
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="team_id" 
                                        id="team_id"
                                        class="form-select" 
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                    <option value="">Pilih Tim...</option>
                                    @foreach($teams as $team)
                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Player -->
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-user me-2" style="color: var(--primary-light);"></i>
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control"
                                       placeholder="Masukkan nama lengkap pemain"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                       required>
                            </div>

                            <!-- Birth Date -->
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-calendar me-2" style="color: var(--primary-light);"></i>
                                    Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="birth_date" 
                                       id="birth_date"
                                       class="form-control" 
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                       required>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <label for="gender" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-venus-mars me-2" style="color: var(--primary-light);"></i>
                                    Jenis Kelamin
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="gender" 
                                        id="gender"
                                        class="form-select" 
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                    <option value="">Pilih Jenis Kelamin...</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-12">
                                <label for="status" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-circle me-2" style="color: var(--primary-light);"></i>
                                    Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="status" 
                                        id="status"
                                        class="form-select" 
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                    <option value="">Pilih Status...</option>
                                    <option value="1">Active</option>
                                    <option value="2">Non Active</option>
                                </select>
                            </div>

                            <!-- Photo -->
                            <div class="col-12">
                                <label for="photo" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-camera me-2" style="color: var(--primary-light);"></i>
                                    Foto Pemain
                                    <small class="text-white">(JPG, PNG, max 1MB)</small>
                                </label>
                                <div class="input-group">
                                    <input type="file" 
                                           name="photo" 
                                           id="photo"
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
                            <a href="/admin/players" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Pemain
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
                        <div class="p-2 rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                            <small class="text-white">Tampilan data pemain</small>
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
                        <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Pemain</h5>
                        <p id="preview-team" class="text-white small mb-2">Tim belum dipilih</p>
                        <div class="mb-2">
                            <span id="preview-gender" class="badge bg-secondary">Jenis Kelamin</span>
                            <span id="preview-status" class="badge bg-secondary ms-1">Status</span>
                        </div>
                        <p id="preview-birthdate" class="text-white small mb-0">
                            <i class="fas fa-calendar me-1"></i>Tanggal lahir
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
                        <li class="mb-1">Pastikan tanggal lahir sudah benar</li>
                        <li class="mb-1">Pilih tim sesuai kategori pemain</li>
                        <li>Status aktif untuk pemain yang masih terdaftar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time preview updates
    const nameInput = document.getElementById('name');
    const teamSelect = document.getElementById('team_id');
    const birthdateInput = document.getElementById('birth_date');
    const genderSelect = document.getElementById('gender');
    const statusSelect = document.getElementById('status');
    const photoInput = document.getElementById('photo');
    
    const previewName = document.getElementById('preview-name');
    const previewTeam = document.getElementById('preview-team');
    const previewGender = document.getElementById('preview-gender');
    const previewStatus = document.getElementById('preview-status');
    const previewBirthdate = document.getElementById('preview-birthdate');
    const previewAvatar = document.getElementById('preview-avatar');

    // Update name preview
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Pemain';
        if (this.value) {
            previewAvatar.innerHTML = this.value.charAt(0).toUpperCase();
        } else {
            previewAvatar.innerHTML = '<i class="fas fa-user"></i>';
        }
    });

    // Update team preview
    teamSelect.addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        previewTeam.textContent = this.value ? selectedText : 'Tim belum dipilih';
    });

    // Update gender preview
    genderSelect.addEventListener('change', function() {
        if (this.value === '1') {
            previewGender.innerHTML = '<i class="fas fa-mars me-1"></i>Laki-laki';
            previewGender.className = 'badge bg-info';
        } else if (this.value === '2') {
            previewGender.innerHTML = '<i class="fas fa-venus me-1"></i>Perempuan';
            previewGender.className = 'badge bg-danger';
        } else {
            previewGender.textContent = 'Jenis Kelamin';
            previewGender.className = 'badge bg-secondary';
        }
    });

    // Update status preview
    statusSelect.addEventListener('change', function() {
        if (this.value === '1') {
            previewStatus.textContent = 'Active';
            previewStatus.className = 'badge bg-success ms-1';
        } else if (this.value === '2') {
            previewStatus.textContent = 'Non Active';
            previewStatus.className = 'badge bg-secondary ms-1';
        } else {
            previewStatus.textContent = 'Status';
            previewStatus.className = 'badge bg-secondary ms-1';
        }
    });

    // Update birthdate preview
    birthdateInput.addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            const formatted = date.toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            previewBirthdate.innerHTML = `<i class="fas fa-calendar me-1"></i>${formatted}`;
        } else {
            previewBirthdate.innerHTML = '<i class="fas fa-calendar me-1"></i>Tanggal lahir';
        }
    });

    // Image preview
    photoInput.addEventListener('change', function(e) {
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
    const form = document.getElementById('playerForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
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
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Pemain';
            submitBtn.disabled = false;
            showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
        }
    });

    // File validation
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 1048576) {
                showNotification('Ukuran file foto maksimal 1MB', 'error');
                this.value = '';
                return;
            }
        }
    });
});

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