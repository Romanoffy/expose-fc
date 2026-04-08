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
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Tambah Tim ke Kompetisi</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Daftarkan tim ke kompetisi</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/teams_competitions"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-trophy me-1"></i>Teams Competitions
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: var(--primary-bg);"
                            >
                                <i
                                    class="fas fa-plus-circle"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Pendaftaran</h5>
                                <small class="text-white">Pilih tim dan kompetisi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/teams_competitions"
                            method="POST"
                            enctype="multipart/form-data"
                            id="teamCompetitionForm"
                        >
                            @csrf

                            <div class="row g-4">
                                <!-- Team -->
                                <div class="col-md-12">
                                    <label
                                        for="team_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-flag me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Tim
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="team_id"
                                        id="team_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Tim...</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Competition -->
                                <div class="col-md-12">
                                    <label
                                        for="competition_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-trophy me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Kompetisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="competition_id"
                                        id="competition_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Kompetisi...</option>
                                        @foreach ($competitions as $competition)
                                            <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/teams_competitions"
                                    class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                >
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="submitBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Daftarkan Tim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div
                        class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle p-2"
                                style="background: rgba(59, 130, 246, 0.1);"
                            >
                                <i
                                    class="fas fa-eye"
                                    style="color: var(--info); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Preview</h5>
                                <small class="text-white">Pendaftaran tim</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Preview Icon -->
                        <div class="mb-3">
                            <div
                                id="preview-icon"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);"
                            >
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5
                                id="preview-team"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Pilih Tim</h5>
                            <div class="mb-2">
                                <span
                                    id="preview-competition"
                                    class="badge bg-secondary"
                                >Pilih Kompetisi</span>
                            </div>
                            <p
                                class="small mb-0 text-white"
                                style="font-style: italic;"
                            >
                                Pilih tim dan kompetisi untuk melihat preview
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-lightbulb me-2"
                                style="color: var(--warning);"
                            ></i>Tips
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">Satu tim bisa mengikuti beberapa kompetisi</li>
                            <li class="mb-1">Pastikan tim sudah terdaftar sebelumnya</li>
                            <li class="mb-1">Cek jadwal kompetisi yang tersedia</li>
                            <li>Pendaftaran dapat diubah sewaktu-waktu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teamSelect = document.getElementById('team_id');
            const competitionSelect = document.getElementById('competition_id');

            const previewTeam = document.getElementById('preview-team');
            const previewCompetition = document.getElementById('preview-competition');
            const previewIcon = document.getElementById('preview-icon');

            // Update team preview
            teamSelect.addEventListener('change', function() {
                const selectedText = this.options[this.selectedIndex].text;
                previewTeam.textContent = this.value ? selectedText : 'Pilih Tim';

                if (this.value) {
                    previewIcon.innerHTML = '<i class="fas fa-flag"></i>';
                } else {
                    previewIcon.innerHTML = '<i class="fas fa-trophy"></i>';
                }
            });

            // Update competition preview
            competitionSelect.addEventListener('change', function() {
                const selectedText = this.options[this.selectedIndex].text;

                if (this.value) {
                    previewCompetition.innerHTML = `<i class="fas fa-trophy me-1"></i>${selectedText}`;
                    previewCompetition.className = 'badge bg-success';
                } else {
                    previewCompetition.textContent = 'Pilih Kompetisi';
                    previewCompetition.className = 'badge bg-secondary';
                }
            });

            // Form validation
            const form = document.getElementById('teamCompetitionForm');
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
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Daftarkan Tim';
                    submitBtn.disabled = false;
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
