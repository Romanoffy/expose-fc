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
                >Edit Tim</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui informasi tim {{ $team_array->name }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/teams"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-flag me-1"></i>Teams
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Edit #{{ $team_array->id }}</li>
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
                                >Edit Informasi Tim</h5>
                                <small class="text-white">Perbarui data tim sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/teams/{{ $team_array->id }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="teamEditForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Logo -->
                                <div class="col-12">
                                    <label
                                        for="logo"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-image me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Logo Tim
                                        <small class="text-white">(PNG, JPG, max 1MB)</small>
                                    </label>

                                    <!-- Current Logo Preview -->
                                    @if ($team_array->logo)
                                        <div class="mb-3">
                                            <div
                                                class="d-flex align-items-center gap-3 rounded p-3"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $team_array->logo) }}"
                                                    class="rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $team_array->name }}"
                                                >
                                                <div>
                                                    <h6
                                                        class="mb-1"
                                                        style="color: var(--text-primary);"
                                                    >Logo Saat Ini</h6>
                                                    <small class="text-white">Upload logo baru untuk mengganti</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="input-group">
                                        <input
                                            type="file"
                                            name="logo"
                                            id="logo"
                                            class="form-control"
                                            accept="image/*"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;"
                                        >
                                        <span
                                            class="input-group-text"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;"
                                        >
                                            <i
                                                class="fas fa-upload"
                                                style="color: var(--text-light);"
                                            ></i>
                                        </span>
                                    </div>
                                    <small class="text-white">Kosongkan jika tidak ingin mengubah logo</small>
                                </div>

                                <!-- Name -->
                                <div class="col-12">
                                    <label
                                        for="name"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-tag me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Tim
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ $team_array->name }}"
                                        class="form-control"
                                        placeholder="Masukkan nama tim"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label
                                        for="descriptions"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-align-left me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Deskripsi
                                    </label>
                                    <textarea
                                        name="descriptions"
                                        id="descriptions"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Masukkan deskripsi tim"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                    >{{ $team_array->descriptions }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/teams"
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
                                    <i class="fas fa-save me-2"></i>Update Tim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
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
                                <small class="text-white">Informasi tim aktif</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Current Logo -->
                        <div class="mb-3">
                            @if ($team_array->logo)
                                <img
                                    src="{{ asset('storage/' . $team_array->logo) }}"
                                    class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--glass-border);"
                                    alt="{{ $team_array->name }}"
                                >
                            @else
                                <div
                                    class="d-flex align-items-center justify-content-center mx-auto rounded"
                                    style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);"
                                >
                                    {{ substr($team_array->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- Current Info -->
                        <div>
                            <h5
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >{{ $team_array->name }}</h5>
                            <p
                                class="small mb-0 text-white"
                                style="font-style: italic;"
                            >
                                {{ $team_array->descriptions ?: 'Tidak ada deskripsi' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Change History Card -->
                <div
                    class="card"
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
                            <li class="mb-1">ID Tim: #{{ str_pad($team_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $team_array->created_at ? $team_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $team_array->updated_at ? $team_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                            <li>File yang diubah akan mengganti data lama</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('teamEditForm');
            const updateBtn = document.getElementById('updateBtn');

            form.addEventListener('submit', function(e) {
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

                const nameInput = document.getElementById('name');
                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Tim';
                    updateBtn.disabled = false;
                    showNotification('Nama tim harus diisi', 'error');
                }
            });

            document.getElementById('logo').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 1048576) {
                        showNotification('Ukuran file logo maksimal 1MB', 'error');
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
