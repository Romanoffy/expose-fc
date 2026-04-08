@extends('layouts.dashboard')
@section('content')

<style>
.form-control::placeholder {
  color: #fff;
  opacity: 0.6;
}

#team_id option,
#competition_id option {
  color: #000;
}
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Pendaftaran Tim</h4>
            <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui pendaftaran tim ke kompetisi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item">
                    <a href="/admin/teams_competitions" style="color: var(--text-secondary); text-decoration: none;">
                        <i class="fas fa-trophy me-1"></i>Teams Competitions
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit</li>
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
                            <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi Pendaftaran</h5>
                            <small class="text-white">Perbarui tim atau kompetisi</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/teams_competitions/{{$teams_competitions_array->id}}" method="POST" enctype="multipart/form-data" id="teamCompetitionEditForm">
                        @csrf
                        @method("PUT")
                        
                        <div class="row g-4">
                            <!-- Team -->
                            <div class="col-md-12">
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
                                    <option value="{{$team->id}}" {{ $team->id == $teams_competitions_array->team_id ? 'selected' : '' }}>
                                        {{$team->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Competition -->
                            <div class="col-md-12">
                                <label for="competition_id" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                    <i class="fas fa-trophy me-2" style="color: var(--primary-light);"></i>
                                    Kompetisi
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="competition_id" 
                                        id="competition_id"
                                        class="form-select" 
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                    <option value="">Pilih Kompetisi...</option>
                                    @foreach($competitions as $competition)
                                    <option value="{{$competition->id}}" {{ $competition->id == $teams_competitions_array->competition_id ? 'selected' : '' }}>
                                        {{$competition->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid var(--glass-border);">
                            <a href="/admin/teams_competitions" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning" style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                <i class="fas fa-save me-2"></i>Update Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="col-lg-4">
            <!-- Current Data Card -->
            @if(isset($teams_competitions_array))
            <div class="card mb-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-check-circle" style="color: var(--success); font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Data Saat Ini</h5>
                            <small class="text-white">Pendaftaran aktif</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 text-center">
                    <!-- Current Icon -->
                    <div class="mb-3">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>

                    <!-- Current Info -->
                    <div>
                        <h5 class="mb-2" style="color: var(--text-primary);">
                            {{ $teams_competitions_array->team_name ?? 'Tim' }}
                        </h5>
                        <div class="mb-2">
                            <span class="badge bg-success">
                                <i class="fas fa-trophy me-1"></i>{{ $teams_competitions_array->competition_name ?? 'Kompetisi' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mb-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-body p-3">
                    <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                        <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                    </h6>
                    <ul class="small text-white mb-0 ps-3">
                        <li class="mb-1">ID: #{{ str_pad($teams_competitions_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                        <li class="mb-1">Dibuat: {{ $teams_competitions_array->created_at ? $teams_competitions_array->created_at->format('d F Y') : '-' }}</li>
                        <li class="mb-1">Update terakhir: {{ $teams_competitions_array->updated_at ? $teams_competitions_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</li>
                        <li>Pendaftaran dapat diubah sesuai kebutuhan</li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Helper Tips -->
            <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="card-body p-3">
                    <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                        <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                    </h6>
                    <ul class="text-white small mb-0 ps-3">
                        <li class="mb-1">Pastikan tim masih aktif dalam kompetisi</li>
                        <li class="mb-1">Cek jadwal kompetisi sebelum mengubah</li>
                        <li class="mb-1">Perubahan akan langsung diterapkan</li>
                        <li>Hubungi admin jika ada masalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('teamCompetitionEditForm');
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
            updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Pendaftaran';
            updateBtn.disabled = false;
            showNotification('Harap pilih tim dan kompetisi', 'error');
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