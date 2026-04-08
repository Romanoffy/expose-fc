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
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Pemain</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui informasi pemain {{ $player_array->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/players" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-users me-1"></i>Players
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $player_array->id }}</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-user-edit" style="color: var(--warning); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi Pemain</h5>
                            <small class="text-white">Perbarui data pemain sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/players/{{$player_array->id}}" method="POST" enctype="multipart/form-data" id="playerEditForm">
                        @csrf
                        @method("PUT")
                        
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
                                    <option value="{{ $team->id }}" {{ $team->id == $player_array->team_id ? 'selected' : '' }}>
                                        {{$team->name}}
                                    </option>
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
                                       value="{{ $player_array->name }}"
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
                                       value="{{ $player_array->birth_date }}"
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
                                    <option value="1" {{ $player_array->gender == 1 ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="2" {{ $player_array->gender == 2 ? 'selected' : '' }}>Perempuan</option>
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
                                    <option value="1" {{ $player_array->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $player_array->status == 2 ? 'selected' : '' }}>Non Active</option>
                                </select>
                            </div>

                            <!-- Photo -->
                            <div class="col-12">
                                <label for="photo" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-camera me-2" style="color: var(--primary-light);"></i>
                                    Foto Pemain
                                    <small class="text-white">(JPG, PNG, max 1MB)</small>
                                </label>
                                
                                <!-- Current Image Preview -->
                                @if($player_array->photo)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                        <img src="{{ asset('storage/' . $player_array->photo) }}" 
                                             class="rounded-circle" 
                                             style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                             alt="{{ $player_array->name }}">
                                        <div>
                                            <h6 class="mb-1" style="color: var(--text-primary);">Foto Saat Ini</h6>
                                            <small class="text-white">Upload foto baru untuk mengganti</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

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
                                <small class="text-white">Kosongkan jika tidak ingin mengubah foto</small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid var(--glass-border);">
                            <a href="/admin/players" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning" style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                <i class="fas fa-save me-2"></i>Update Pemain
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
                        <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-user-check" style="color: var(--success); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Data Saat Ini</h5>
                            <small class="text-white">Informasi pemain aktif</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 text-center">
                    <!-- Current Photo -->
                    <div class="mb-3">
                        @if($player_array->photo)
                            <img src="{{ asset('storage/' . $player_array->photo) }}" 
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--glass-border);"
                                 alt="{{ $player_array->name }}">
                        @else
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);">
                                {{ substr($player_array->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Current Info -->
                    <div>
                        <h5 class="mb-1" style="color: var(--text-primary);">{{ $player_array->name }}</h5>
                        <p class="text-white small mb-2">{{ $player_array->team_name ?? 'Tim tidak tersedia' }}</p>
                        <div class="mb-2">
                            @if($player_array->gender == 1)
                                <span class="badge bg-info"><i class="fas fa-mars me-1"></i>Laki-laki</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-venus me-1"></i>Perempuan</span>
                            @endif
                            @if($player_array->status == 1)
                                <span class="badge bg-success ms-1">Active</span>
                            @else
                                <span class="badge bg-secondary ms-1">Non Active</span>
                            @endif
                        </div>
                        <p class="text-white small mb-0">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($player_array->birth_date)->locale('id')->translatedFormat('d F Y') }}
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
                        <li class="mb-1">ID Pemain: #{{ str_pad($player_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                        <li class="mb-1">Bergabung: {{ $player_array->created_at ? $player_array->created_at->format('d F Y') : '-' }}</li>
                        <li class="mb-1">Update terakhir: {{ $player_array->updated_at ? $player_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</li>
                        <li>File yang diubah akan mengganti data lama</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('playerEditForm');
    const updateBtn = document.getElementById('updateBtn');

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
            updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Pemain';
            updateBtn.disabled = false;
            showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
        }
    });

    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 1048576) {
                showNotification('Ukuran file foto maksimal 1MB', 'error');
                this.value = '';
                return;
            }
            
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