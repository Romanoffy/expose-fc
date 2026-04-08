@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        #id_pelatih option {
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
                >Tambah Jadwal Latihan</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Buat jadwal latihan baru dengan detail lengkap</p>
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
                                    class="fas fa-clipboard-list"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Latihan</h5>
                                <small class="text-white">Masukkan detail jadwal latihan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/latihan"
                            method="POST"
                            enctype="multipart/form-data"
                            id="latihanForm"
                        >
                            @csrf

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
                                                data-nama="{{ $pelatih->nama_pelatih }}"
                                                data-gambar="{{ $pelatih->gambar ? asset('storage/' . $pelatih->gambar) : '' }}"
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
                                    ></textarea>
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
                                    ></textarea>
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
                                    class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;"
                                    id="submitBtn"
                                >
                                    <i class="fas fa-save me-2"></i>Simpan Latihan
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
                                <small class="text-white">Tampilan jadwal latihan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Preview Icon -->
                        <div class="mb-3 text-center">
                            <div
                                id="preview-avatar"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);"
                            >
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div
                            id="preview-info"
                            class="text-center"
                        >
                            <h5
                                id="preview-pelatih"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Nama Pelatih</h5>

                            <div class="mb-3">
                                <div
                                    class="rounded p-3"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                                >
                                    <small
                                        class="d-block mb-1 text-white"
                                        style="font-weight: 500;"
                                    >Kegiatan:</small>
                                    <p
                                        id="preview-kegiatan"
                                        class="small mb-0 text-white"
                                    >Kegiatan latihan</p>
                                </div>
                            </div>

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
                                        id="preview-start"
                                        class="small text-white"
                                    >--:--</span>
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
                                        id="preview-end"
                                        class="small text-white"
                                    >--:--</span>
                                </div>
                            </div>

                            <div
                                class="rounded p-3"
                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                            >
                                <small
                                    class="d-block mb-1 text-white"
                                    style="font-weight: 500;"
                                ><i class="fas fa-sticky-note me-1"></i>Catatan:</small>
                                <p
                                    id="preview-catatan"
                                    class="small mb-0 text-white"
                                >Catatan latihan</p>
                            </div>
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
                            <li class="mb-1">Pastikan jam mulai dan selesai sudah benar</li>
                            <li class="mb-1">Deskripsikan kegiatan dengan jelas dan detail</li>
                            <li class="mb-1">Tambahkan catatan penting di kolom catatan</li>
                            <li>Pilih pelatih yang bertanggung jawab</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time preview updates
            const pelatihSelect = document.getElementById('id_pelatih');
            const kegiatanInput = document.getElementById('kegiatan_latihan');
            const jamMulaiInput = document.getElementById('jam_mulai_berlatih');
            const jamSelesaiInput = document.getElementById('jam_selesai_berlatih');
            const catatanInput = document.getElementById('catatan');

            const previewPelatih = document.getElementById('preview-pelatih');
            const previewKegiatan = document.getElementById('preview-kegiatan');
            const previewStart = document.getElementById('preview-start');
            const previewEnd = document.getElementById('preview-end');
            const previewCatatan = document.getElementById('preview-catatan');
            const previewAvatar = document.getElementById('preview-avatar');

            // Update pelatih preview with photo
            pelatihSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value) {
                    const nama = selectedOption.getAttribute('data-nama');
                    const gambar = selectedOption.getAttribute('data-gambar');

                    previewPelatih.textContent = nama;

                    // Update avatar
                    if (gambar) {
                        // Tampilkan foto
                        previewAvatar.style.backgroundImage = `url('${gambar}')`;
                        previewAvatar.style.backgroundSize = 'cover';
                        previewAvatar.style.backgroundPosition = 'center';
                        previewAvatar.innerHTML = '';
                    } else {
                        // Tampilkan inisial
                        previewAvatar.style.backgroundImage = 'none';
                        previewAvatar.innerHTML = nama.charAt(0).toUpperCase();
                        previewAvatar.style.fontSize = '32px';
                        previewAvatar.style.fontWeight = '600';
                    }
                } else {
                    // Reset ke default
                    previewPelatih.textContent = 'Nama Pelatih';
                    previewAvatar.style.backgroundImage = 'none';
                    previewAvatar.innerHTML = '<i class="fas fa-user-tie"></i>';
                    previewAvatar.style.fontSize = '24px';
                }
            });

            // Update kegiatan preview
            kegiatanInput.addEventListener('input', function() {
                const text = this.value || 'Kegiatan latihan';
                previewKegiatan.textContent = text.length > 80 ? text.substring(0, 80) + '...' : text;
            });

            // Update jam mulai preview
            jamMulaiInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const formatted = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    previewStart.textContent = formatted;
                } else {
                    previewStart.textContent = '--:--';
                }
            });

            // Update jam selesai preview
            jamSelesaiInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const formatted = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    previewEnd.textContent = formatted;
                } else {
                    previewEnd.textContent = '--:--';
                }
            });

            // Update catatan preview
            catatanInput.addEventListener('input', function() {
                const text = this.value || 'Catatan latihan';
                previewCatatan.textContent = text.length > 80 ? text.substring(0, 80) + '...' : text;
            });

            // Form validation and submission
            const form = document.getElementById('latihanForm');
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
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Latihan';
                    submitBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                    return;
                }

                // Validate time
                const startTime = new Date(jamMulaiInput.value);
                const endTime = new Date(jamSelesaiInput.value);

                if (startTime >= endTime) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Latihan';
                    submitBtn.disabled = false;
                    showNotification('Jam selesai harus lebih besar dari jam mulai', 'error');
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
