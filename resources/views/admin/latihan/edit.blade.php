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
                >Edit Jadwal Latihan</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui informasi jadwal latihan #{{ $latihan->id }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/latihan"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-calendar-alt me-1"></i>Latihan
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Edit #{{ $latihan->id }}</li>
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
                                >Edit Informasi Latihan</h5>
                                <small class="text-white">Perbarui detail jadwal latihan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/latihan/{{ $latihan->id }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="latihanEditForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Pelatih -->
                                <div class="col-md-12">
                                    <label
                                        for="id_pelatih"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-user-tie me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Pelatih
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="id_pelatih"
                                        id="id_pelatih"
                                        class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Pelatih...</option>
                                        @foreach ($pelatih_array as $pelatih)
                                            <option
                                                value="{{ $pelatih->id }}"
                                                {{ $pelatih->id == $latihan->id_pelatih ? 'selected' : '' }}
                                            >
                                                {{ $pelatih->nama_pelatih }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kegiatan Latihan -->
                                <div class="col-md-12">
                                    <label
                                        for="kegiatan_latihan"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-clipboard-check me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Kegiatan Latihan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="kegiatan_latihan"
                                        id="kegiatan_latihan"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Masukkan detail kegiatan latihan..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >{{ $latihan->kegiatan_latihan }}</textarea>
                                </div>

                                <!-- Jam Mulai -->
                                <div class="col-md-6">
                                    <label
                                        for="jam_mulai_berlatih"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-clock me-2"
                                            style="color: var(--success);"
                                        ></i>
                                        Jam Mulai Berlatih
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="jam_mulai_berlatih"
                                        id="jam_mulai_berlatih"
                                        value="{{ $latihan->jam_mulai_berlatih }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                </div>

                                <!-- Jam Selesai -->
                                <div class="col-md-6">
                                    <label
                                        for="jam_selesai_berlatih"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-clock me-2"
                                            style="color: var(--error);"
                                        ></i>
                                        Jam Selesai Berlatih
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="jam_selesai_berlatih"
                                        id="jam_selesai_berlatih"
                                        value="{{ $latihan->jam_selesai_berlatih }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                </div>

                                <!-- Catatan -->
                                <div class="col-12">
                                    <label
                                        for="catatan"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-sticky-note me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Catatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="catatan"
                                        id="catatan"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Masukkan catatan tambahan..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >{{ $latihan->catatan }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/latihan"
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
                                    <i class="fas fa-save me-2"></i>Update Latihan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Current Data Card -->
            <div class="col-lg-4">
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
                                    class="fas fa-info-circle"
                                    style="color: var(--success); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Data Saat Ini</h5>
                                <small class="text-white">Informasi jadwal aktif</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Current Pelatih -->
                        <div class="mb-3 text-center">
                            @php
                                $currentPelatih = $pelatih_array->firstWhere('id', $latihan->id_pelatih);
                            @endphp
                            @if ($currentPelatih && $currentPelatih->gambar)
                                <img
                                    src="{{ asset('storage/' . $currentPelatih->gambar) }}"
                                    class="rounded-circle d-block mx-auto mb-2"
                                    style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                    alt="{{ $currentPelatih->nama_pelatih }}"
                                >
                            @else
                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                    style="width: 60px; height: 60px; background: var(--primary-bg); color: var(--text-primary); font-weight: 600; font-size: 20px; border: 2px solid var(--glass-border);"
                                >
                                    {{ $currentPelatih ? substr($currentPelatih->nama_pelatih, 0, 1) : '?' }}
                                </div>
                            @endif
                            <h6
                                class="mb-0"
                                style="color: var(--text-primary);"
                            >{{ $currentPelatih->nama_pelatih ?? 'Pelatih tidak tersedia' }}</h6>
                            <small class="text-white">Pelatih</small>
                        </div>

                        <!-- Current Kegiatan -->
                        <div class="mb-3">
                            <div
                                class="rounded p-3"
                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                            >
                                <small
                                    class="d-block mb-1 text-white"
                                    style="font-weight: 500;"
                                >Kegiatan:</small>
                                <p class="small mb-0 text-white">{{ $latihan->kegiatan_latihan }}</p>
                            </div>
                        </div>

                        <!-- Current Schedule -->
                        <div class="mb-3">
                            <div
                                class="d-flex justify-content-between align-items-center mb-2 rounded p-2"
                                style="background: var(--glass-bg);"
                            >
                                <small class="text-white"><i
                                        class="fas fa-play-circle me-1"
                                        style="color: var(--success);"
                                    ></i>Mulai:</small>
                                <span
                                    class="small text-white">{{ \Carbon\Carbon::parse($latihan->jam_mulai_berlatih)->format('d M Y, H:i') }}</span>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center rounded p-2"
                                style="background: var(--glass-bg);"
                            >
                                <small class="text-white"><i
                                        class="fas fa-stop-circle me-1"
                                        style="color: var(--error);"
                                    ></i>Selesai:</small>
                                <span
                                    class="small text-white">{{ \Carbon\Carbon::parse($latihan->jam_selesai_berlatih)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <!-- Current Catatan -->
                        <div
                            class="rounded p-3"
                            style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                        >
                            <small
                                class="d-block mb-1 text-white"
                                style="font-weight: 500;"
                            ><i class="fas fa-sticky-note me-1"></i>Catatan:</small>
                            <p class="small mb-0 text-white">{{ $latihan->catatan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Update Card -->
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-clock me-2"
                                style="color: var(--info);"
                            ></i>Info Update
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">ID Latihan: #{{ str_pad($latihan->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $latihan->created_at ? $latihan->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $latihan->updated_at ? $latihan->updated_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung tersimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('latihanEditForm');
            const updateBtn = document.getElementById('updateBtn');
            const jamMulaiInput = document.getElementById('jam_mulai_berlatih');
            const jamSelesaiInput = document.getElementById('jam_selesai_berlatih');

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
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Latihan';
                    updateBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                    return;
                }

                // Validate time
                const startTime = new Date(jamMulaiInput.value);
                const endTime = new Date(jamSelesaiInput.value);

                if (startTime >= endTime) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Latihan';
                    updateBtn.disabled = false;
                    showNotification('Jam selesai harus lebih besar dari jam mulai', 'error');
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
