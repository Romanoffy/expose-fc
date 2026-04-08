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
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Edit Posisi</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui informasi posisi</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/positions"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-map-marker-alt me-1"></i>Posisi
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
                                <small class="text-white">Perbarui nama posisi sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/positions/{{ $position_array->id }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="positionEditForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Position Name -->
                                <div class="col-md-12">
                                    <label
                                        for="name"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-tag me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Posisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        value="{{ $position_array->name }}"
                                        placeholder="Contoh: Midfielder, Striker, Goalkeeper..."
                                        required
                                    >
                                    <small class="text-white mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Gunakan nama posisi yang jelas dan mudah dipahami
                                    </small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/positions"
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

            <!-- Preview & Info Card -->
            <div class="col-lg-4">
                <!-- Current Data Card -->
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
                                <small class="text-white">Posisi aktif</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Current Icon -->
                        <div class="mb-3">
                            @php
                                $currentName = $position_array->name ?? '';
                                $nameUpper = strtoupper($currentName);
                                $iconClass = 'fa-map-marker-alt';
                                
                                if (str_contains($nameUpper, 'GK') || str_contains($nameUpper, 'KEEPER')) {
                                    $iconClass = 'fa-hands';
                                } elseif (str_contains($nameUpper, 'DEF') || str_contains($nameUpper, 'BACK')) {
                                    $iconClass = 'fa-shield-alt';
                                } elseif (str_contains($nameUpper, 'MID')) {
                                    $iconClass = 'fa-sync-alt';
                                } elseif (str_contains($nameUpper, 'FOR') || str_contains($nameUpper, 'STRIKER') || str_contains($nameUpper, 'WING')) {
                                    $iconClass = 'fa-futbol';
                                }
                            @endphp
                            <div
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);"
                            >
                                <i class="fas {{ $iconClass }}"></i>
                            </div>
                        </div>

                        <!-- Current Info -->
                        <div>
                            <h5
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >{{ $position_array->name }}</h5>
                            <div class="mb-3">
                                @php
                                    $badgeClass = 'bg-secondary';
                                    
                                    if (str_contains($nameUpper, 'GK') || str_contains($nameUpper, 'KEEPER')) {
                                        $badgeClass = 'bg-danger';
                                    } elseif (str_contains($nameUpper, 'DEF') || str_contains($nameUpper, 'BACK')) {
                                        $badgeClass = 'bg-primary';
                                    } elseif (str_contains($nameUpper, 'MID')) {
                                        $badgeClass = 'bg-success';
                                    } elseif (str_contains($nameUpper, 'FOR') || str_contains($nameUpper, 'STRIKER') || str_contains($nameUpper, 'WING')) {
                                        $badgeClass = 'bg-warning';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fas {{ $iconClass }} me-1"></i>{{ $position_array->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
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
                            <li class="mb-1">ID: #{{ str_pad($position_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat: {{ $position_array->created_at ? $position_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir: {{ $position_array->updated_at ? $position_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</li>
                            <li>Perubahan akan langsung diterapkan</li>
                        </ul>
                    </div>
                </div>

                <!-- Position Examples -->
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-list me-2"
                                style="color: var(--warning);"
                            ></i>Contoh Posisi
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
            const nameInput = document.getElementById('name');

            form.addEventListener('submit', function(e) {
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Posisi';
                    updateBtn.disabled = false;
                    nameInput.style.borderColor = 'var(--error)';
                    showNotification('Harap masukkan nama posisi', 'error');
                } else {
                    nameInput.style.borderColor = 'var(--glass-border)';
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