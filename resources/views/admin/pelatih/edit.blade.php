@extends('layouts.dashboard')
@section('content')

<style>
.form-control::placeholder {
  color: #fff;   /* warna putih */
  opacity: 0.6;    /* biar gak transparan */
}
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Pelatih</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui informasi pelatih {{ $pelatih_array->nama_pelatih }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/pelatih" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-chalkboard-teacher me-1"></i>Pelatih
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $pelatih_array->id }}</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: var(--warning); background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-user-edit" style="color: var(--warning); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi Pelatih</h5>
                            <small class="text-white">Perbarui data pelatih sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/pelatih/{{ $pelatih_array->id }}" method="POST" enctype="multipart/form-data" id="pelatihEditForm">
                        @csrf
                        @method("PUT")
                        
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
                                       value="{{ $pelatih_array->nama_pelatih }}"
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
                                       value="{{ $pelatih_array->email }}"
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
                                    <option value="Lisensi D Nasional" {{ $pelatih_array->lisensi == 'Lisensi D Nasional' ? 'selected' : '' }}>
                                        Lisensi D Nasional
                                    </option>
                                    <option value="Lisensi C AFC" {{ $pelatih_array->lisensi == 'Lisensi C AFC' ? 'selected' : '' }}>
                                        Lisensi C AFC
                                    </option>
                                    <option value="Lisensi B AFC" {{ $pelatih_array->lisensi == 'Lisensi B AFC' ? 'selected' : '' }}>
                                        Lisensi B AFC
                                    </option>
                                    <option value="Lisensi Pro Kontinental" {{ $pelatih_array->lisensi == 'Lisensi Pro Kontinental' ? 'selected' : '' }}>
                                        Lisensi Pro Kontinental
                                    </option>
                                </select>
                            </div>

                            <!-- File Lisensi -->
                            <div class="col-md-6">
                                <label for="file_lisensi" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-file-pdf me-2" style="color: var(--primary-light);"></i>
                                    File Lisensi
                                    <small class="text-white">(PDF, max 2MB)</small>
                                </label>
                                <div class="mb-2">
                                    @if($pelatih_array->file_lisensi)
                                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                                            <i class="fas fa-file-pdf" style="color: var(--success);"></i>
                                            <span class="small" style="color: var(--success);">File saat ini:</span>
                                            <a href="{{ asset('storage/' . $pelatih_array->file_lisensi) }}" 
                                               target="_blank" 
                                               class="text-decoration-none small fw-semibold"
                                               style="color: var(--success);">
                                                Lihat Dokumen
                                            </a>
                                        </div>
                                    @else
                                        <div class="small text-white">Belum ada file diupload</div>
                                    @endif
                                </div>
                                <input type="file" 
                                       name="file_lisensi" 
                                       id="file_lisensi"
                                       class="form-control" 
                                       accept="application/pdf"
                                       style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                <small class="text-white">Kosongkan jika tidak ingin mengubah file</small>
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
                                          required>{{ $pelatih_array->pengalaman }}</textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-12">
                                <label for="gambar" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-camera me-2" style="color: var(--primary-light);"></i>
                                    Foto Pelatih
                                    <small class="text-white">(JPG, PNG, max 1MB)</small>
                                </label>
                                
                                <!-- Current Image Preview -->
                                @if($pelatih_array->gambar)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                        <img src="{{ asset('storage/' . $pelatih_array->gambar) }}" 
                                             class="rounded-circle" 
                                             style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                             alt="{{ $pelatih_array->nama_pelatih }}">
                                        <div>
                                            <h6 class="mb-1" style="color: var(--text-primary);">Foto Saat Ini</h6>
                                            <small class="text-white">Upload foto baru untuk mengganti</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

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
                                <small class="text-white">Kosongkan jika tidak ingin mengubah foto</small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid var(--glass-border);">
                            <a href="/admin/pelatih" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning" style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                <i class="fas fa-save me-2"></i>Update Pelatih
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="col-lg-4">
            <!-- Current Data Card -->
            <div class="card mb-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: var(--success); background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-user-check" style="color: var(--success); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Data Saat Ini</h5>
                            <small class="text-white">Informasi pelatih aktif</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 text-center">
                    <!-- Current Photo -->
                    <div class="mb-3">
                        @if($pelatih_array->gambar)
                            <img src="{{ asset('storage/' . $pelatih_array->gambar) }}" 
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--glass-border);"
                                 alt="{{ $pelatih_array->nama_pelatih }}">
                        @else
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);">
                                {{ substr($pelatih_array->nama_pelatih, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Current Info -->
                    <div>
                        <h5 class="mb-1" style="color: var(--text-primary);">{{ $pelatih_array->nama_pelatih }}</h5>
                        <p class="text-white small mb-2">{{ $pelatih_array->email }}</p>
                        <div class="mb-3">
                            @php
                                $badgeColor = match($pelatih_array->lisensi) {
                                    'Lisensi Pro Kontinental' => 'var(--success)',
                                    'Lisensi B AFC' => 'var(--info)',
                                    'Lisensi C AFC' => 'var(--warning)',
                                    'Lisensi D Nasional' => 'var(--text-light)',
                                    default => 'var(--text-light)'
                                };
                            @endphp
                            <span class="badge" style="background: {{ $badgeColor }}; color: white; font-size: 11px; padding: 4px 8px;">
                                {{ $pelatih_array->lisensi }}
                            </span>
                        </div>
                        <p class="small text-white mb-0" style="font-style: italic;">
                            {{ Str::limit($pelatih_array->pengalaman, 100) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Change History Card -->
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-body p-3">
                    <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                        <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                    </h6>
                    <ul class="small text-white mb-0 ps-3">
                        <li class="mb-1">ID Pelatih: #{{ str_pad($pelatih_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                        <li class="mb-1">Bergabung: {{ $pelatih_array->created_at ? $pelatih_array->created_at->format('d F Y') : '-' }}</li>
                        <li class="mb-1">Update terakhir: {{ $pelatih_array->updated_at ? $pelatih_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</li>
                        <li>File yang diubah akan mengganti data lama</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation and submission
    const form = document.getElementById('pelatihEditForm');
    const updateBtn = document.getElementById('updateBtn');

    form.addEventListener('submit', function(e) {
        // Add loading state
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
        updateBtn.disabled = true;
        
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
            updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Pelatih';
            updateBtn.disabled = false;
            
            showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
        }
    });

    // File validation
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 1048576) { // 1MB
                showNotification('Ukuran file foto maksimal 1MB', 'error');
                this.value = '';
                return;
            }
            
            // Preview new image
            const reader = new FileReader();
            reader.onload = function(e) {
                const existingImg = document.querySelector('.card-body img');
                if (existingImg) {
                    existingImg.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('file_lisensi').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2097152) { // 2MB
                showNotification('Ukuran file lisensi maksimal 2MB', 'error');
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