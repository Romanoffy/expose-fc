@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        #player_id option,
        #position_id option {
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
                >Tambah Posisi Pemain</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Tetapkan posisi untuk pemain</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/players_positions"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-map-marker-alt me-1"></i>Posisi Pemain
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
                                    class="fas fa-user-tag"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Posisi</h5>
                                <small class="text-white">Pilih pemain dan posisinya</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/players_positions"
                            method="POST"
                            enctype="multipart/form-data"
                            id="positionForm"
                        >
                            @csrf

                            <div class="row g-4">
                                <!-- Player -->
                                <div class="col-md-12">
                                    <label
                                        for="player_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-user me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Pemain
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="player_id"
                                        id="player_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Pemain...</option>
                                        @foreach ($players as $player)
                                            <option value="{{ $player->id }}">{{ $player->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Position -->
                                <div class="col-md-12">
                                    <label
                                        for="position_id"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-map-marker-alt me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Posisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="position_id"
                                        id="position_id"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Posisi...</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
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
                                    href="/admin/players_positions"
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
                                    <i class="fas fa-save me-2"></i>Simpan Posisi
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
                                <small class="text-white">Tampilan posisi pemain</small>
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
                                <i class="fas fa-user-tag"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5
                                id="preview-player"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Pilih Pemain</h5>
                            <div class="mb-3">
                                <span
                                    id="preview-position"
                                    class="badge bg-secondary"
                                >Pilih Posisi</span>
                            </div>
                            <p
                                class="small mb-0 text-white"
                                style="font-style: italic;"
                            >
                                Pilih pemain dan posisi untuk melihat preview
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
                            <li class="mb-1">Satu pemain bisa memiliki beberapa posisi</li>
                            <li class="mb-1">Pilih posisi yang paling sering dimainkan</li>
                            <li class="mb-1">Posisi dapat diubah sewaktu-waktu</li>
                            <li>Pastikan pemain dan posisi sudah benar</li>
                        </ul>
                    </div>
                </div>

                <!-- Position Legend -->
                <div
                    class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-info-circle me-2"
                                style="color: var(--info);"
                            ></i>Posisi Umum
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span
                                class="badge bg-danger"
                                style="font-size: 10px;"
                            >GK - Goalkeeper</span>
                            <span
                                class="badge bg-primary"
                                style="font-size: 10px;"
                            >DF - Defender</span>
                            <span
                                class="badge bg-success"
                                style="font-size: 10px;"
                            >MF - Midfielder</span>
                            <span
                                class="badge bg-warning"
                                style="font-size: 10px;"
                            >FW - Forward</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playerSelect = document.getElementById('player_id');
            const positionSelect = document.getElementById('position_id');
            const previewPlayer = document.getElementById('preview-player');
            const previewPosition = document.getElementById('preview-position');
            const previewIcon = document.getElementById('preview-icon');

            // Data pemain dengan foto dari server
            const playersData = {
                @foreach ($players as $player)
                    '{{ $player->id }}': {
                        name: '{{ $player->name }}',
                        photo: '{{ $player->photo ? asset('storage/' . $player->photo) : '' }}'
                    },
                @endforeach
            };

            // Update player preview dengan foto
            playerSelect.addEventListener('change', function() {
                const playerId = this.value;
                const playerData = playersData[playerId];

                if (playerData) {
                    previewPlayer.textContent = playerData.name;

                    // Tampilkan foto jika ada
                    if (playerData.photo) {
                        previewIcon.style.backgroundImage = `url(${playerData.photo})`;
                        previewIcon.style.backgroundSize = 'cover';
                        previewIcon.style.backgroundPosition = 'center';
                        previewIcon.innerHTML = '';
                    } else {
                        // Tampilkan inisial jika tidak ada foto
                        previewIcon.style.backgroundImage = 'none';
                        previewIcon.innerHTML = playerData.name.charAt(0).toUpperCase();
                        previewIcon.style.fontSize = '24px';
                    }
                } else {
                    previewPlayer.textContent = 'Pilih Pemain';
                    previewIcon.style.backgroundImage = 'none';
                    previewIcon.innerHTML = '<i class="fas fa-user-tag"></i>';
                    previewIcon.style.fontSize = '32px';
                }
            });

            // Update position preview dengan color coding
            positionSelect.addEventListener('change', function() {
                const selectedText = this.options[this.selectedIndex].text;

                if (this.value) {
                    let badgeClass = 'bg-secondary';
                    const positionUpper = selectedText.toUpperCase();

                    // Color code based on position type
                    if (positionUpper.includes('GK') || positionUpper.includes('KEEPER')) {
                        badgeClass = 'bg-danger';
                    } else if (positionUpper.includes('DEF') || positionUpper.includes('BACK')) {
                        badgeClass = 'bg-primary';
                    } else if (positionUpper.includes('MID')) {
                        badgeClass = 'bg-success';
                    } else if (positionUpper.includes('FOR') || positionUpper.includes('STRIKER') ||
                        positionUpper.includes('WING')) {
                        badgeClass = 'bg-warning';
                    }

                    previewPosition.className = `badge ${badgeClass}`;
                    previewPosition.innerHTML = `<i class="fas fa-map-marker-alt me-1"></i>${selectedText}`;
                } else {
                    previewPosition.className = 'badge bg-secondary';
                    previewPosition.textContent = 'Pilih Posisi';
                }
            });

            // Form validation and submission
            const form = document.getElementById('positionForm');
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
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Posisi';
                    submitBtn.disabled = false;
                    showNotification('Harap pilih pemain dan posisi', 'error');
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
