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
                >Edit Posisi Pemain</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui posisi pemain</p>
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
                    >Edit</li>
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
                                style="background: rgba(245, 158, 11, 0.1);"
                            >
                                <i
                                    class="fas fa-edit"
                                    style="color: var(--warning); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Edit Informasi Posisi</h5>
                                <small class="text-white">Perbarui posisi pemain sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/players_positions/{{ isset($players_positions_array) ? $players_positions_array->id : '' }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="positionEditForm"
                        >
                            @csrf
                            @method('PUT')

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
                                            <option
                                                value="{{ $player->id }}"
                                                @if (isset($players_positions_array) && $player->id == $players_positions_array->player_id) selected @endif
                                            >
                                                {{ $player->name }}
                                            </option>
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
                                            <option
                                                value="{{ $position->id }}"
                                                @if (isset($players_positions_array) && $position->id == $players_positions_array->position_id) selected @endif
                                            >
                                                {{ $position->name }}
                                            </option>
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
                                    class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="updateBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Update Posisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <!-- Current Data Card -->
                @if (isset($players_positions_array))
                    <div
                        class="card mb-3"
                        style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                    >
                        <div
                            class="card-header"
                            style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;"
                        >
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    class="rounded-circle p-2"
                                    style="background: rgba(16, 185, 129, 0.1);"
                                >
                                    <i
                                        class="fas fa-check-circle"
                                        style="color: var(--success); font-size: 16px;"
                                    ></i>
                                </div>
                                <div>
                                    <h5
                                        class="mb-0"
                                        style="color: var(--text-primary); font-weight: 600;"
                                    >Data Saat Ini</h5>
                                    <small class="text-white">Posisi pemain aktif</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4 text-center">
                            <!-- Current Icon -->
                            <!-- Current Photo -->
                            <div class="mb-3">
                                @if ($players_positions_array->player_photo)
                                    <img
                                        src="{{ asset('storage/' . $players_positions_array->player_photo) }}"
                                        class="rounded-circle d-block mx-auto"
                                        style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--glass-border);"
                                        alt="{{ $players_positions_array->player_name }}"
                                    >
                                @else
                                    <div
                                        class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);"
                                    >
                                        {{ substr($players_positions_array->player_name ?? 'P', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Current Info -->
                            <div>
                                <h5
                                    class="mb-2"
                                    style="color: var(--text-primary);"
                                >{{ $players_positions_array->player_name ?? 'Pemain' }}</h5>
                                <div class="mb-3">
                                    @php
                                        $positionName = $players_positions_array->position_name ?? '';
                                        $positionUpper = strtoupper($positionName);
                                        $badgeClass = 'bg-secondary';

                                        if (
                                            str_contains($positionUpper, 'GK') ||
                                            str_contains($positionUpper, 'KEEPER')
                                        ) {
                                            $badgeClass = 'bg-danger';
                                        } elseif (
                                            str_contains($positionUpper, 'DEF') ||
                                            str_contains($positionUpper, 'BACK')
                                        ) {
                                            $badgeClass = 'bg-primary';
                                        } elseif (str_contains($positionUpper, 'MID')) {
                                            $badgeClass = 'bg-success';
                                        } elseif (
                                            str_contains($positionUpper, 'FOR') ||
                                            str_contains($positionUpper, 'STRIKER') ||
                                            str_contains($positionUpper, 'WING')
                                        ) {
                                            $badgeClass = 'bg-warning';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $positionName ?: 'Posisi' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change History Card -->
                    <div
                        class="card mb-3"
                        style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                    >
                        <div class="card-body p-3">
                            <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                                <i
                                    class="fas fa-info-circle me-2"
                                    style="color: var(--info);"
                                ></i>Info Update
                            </h6>
                            <ul class="small mb-0 ps-3 text-white">
                                <li class="mb-1">ID: #{{ str_pad($players_positions_array->id, 3, '0', STR_PAD_LEFT) }}
                                </li>
                                <li class="mb-1">Dibuat:
                                    {{ $players_positions_array->created_at ? $players_positions_array->created_at->format('d F Y') : '-' }}
                                </li>
                                <li class="mb-1">Update terakhir:
                                    {{ $players_positions_array->updated_at ? $players_positions_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                                </li>
                                <li>Posisi dapat diubah sesuai kebutuhan</li>
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Position Legend -->
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-list me-2"
                                style="color: var(--warning);"
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
            const form = document.getElementById('positionEditForm');
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
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Posisi';
                    updateBtn.disabled = false;
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
