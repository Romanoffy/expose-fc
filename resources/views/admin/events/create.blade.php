@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        #kategori option {
            color: #000;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Event Baru</h4>
                <p class="text-white mb-0">Lengkapi informasi event dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/event" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-calendar me-1"></i>Event
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Form -->
            <div class="col-lg-8">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: var(--primary-bg);">
                                <i class="fas fa-calendar-plus" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Event
                                </h5>
                                <small class="text-white">Masukkan data lengkap event</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/events" method="POST" enctype="multipart/form-data" id="eventForm">
                            @csrf

                            <div class="row g-4">
                                <!-- Nama Event -->
                                <div class="col-md-6">
                                    <label for="nama" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Nama Event <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        placeholder="Masukkan nama event"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-6">
                                    <label for="tanggal_mulai" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-calendar-plus me-2" style="color: var(--primary-light);"></i>
                                        Tanggal Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-6">
                                    <label for="tanggal_selesai" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-calendar-check me-2" style="color: var(--primary-light);"></i>
                                        Tanggal Selesai <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Venue -->
                                <div class="col-md-6">
                                    <label for="venue_id" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                        Venue <span class="text-danger">*</span>
                                    </label>
                                    <select name="venue_id" id="venue_id" class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                        <option value="">Pilih venue...</option>
                                        @foreach ($venues as $venue)
                                            <option value="{{ $venue->id }}" style="color: #000; background: #fff;">
                                                {{ $venue->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Deskripsi <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description" rows="4" class="form-control"
                                        placeholder="Deskripsikan event secara detail..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; resize: vertical;"
                                        required></textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/events" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-save me-2"></i>Simpan Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="col-lg-4">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
                    <div class="card-body text-center p-4">
                        <!-- Poster Preview -->
                        <div class="mb-3">
                            <div
                                id="preview-avatar"
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light); font-weight: 600;"
                            >
                                E
                            </div>
                        </div>

                        <!-- Nama Event -->
                        <h5 id="preview-name" class="mb-1" style="color: var(--text-primary);">Nama Event</h5>

                        <!-- Tanggal Mulai -->
                        <p id="preview-tanggal-mulai" class="text-white small mb-1">Tanggal mulai belum dipilih</p>

                        <!-- Tanggal Selesai -->
                        <p id="preview-tanggal-selesai" class="text-white small mb-1">Tanggal selesai belum dipilih</p>

                        <!-- Venue -->
                        <p id="preview-venue" class="text-white small mb-2">Lokasi belum dipilih</p>

                        <!-- Deskripsi -->
                        <p id="preview-description" class="text-white small" style="font-style: italic;">
                            Deskripsi event akan tampil di sini...
                        </p>
                    </div>
                </div>
                <!-- Helper Tips -->
                <div class="card mt-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Tips
                        </h6>
                        <ul class="text-white small mb-0 ps-3">
                            <li class="mb-1">Gunakan judul event yang singkat dan jelas</li>
                            <li class="mb-1">Pastikan tanggal dan waktu sesuai jadwal sebenarnya</li>
                            <li class="mb-1">Gunakan deskripsi yang informatif agar peserta memahami tujuan event</li>
                            <li>Pastikan lokasi dan kontak penyelenggara terisi dengan benar</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const namaInput = document.getElementById('nama');
            const previewName = document.getElementById('preview-name');
            const previewAvatar = document.getElementById('preview-avatar');
            const mulaiInput = document.getElementById('tanggal_mulai');
            const selesaiInput = document.getElementById('tanggal_selesai');
            const venueSelect = document.getElementById('venue_id');
            const descriptionTextarea = document.getElementById('description');
            const previewMulai = document.getElementById('preview-tanggal-mulai');
            const previewSelesai = document.getElementById('preview-tanggal-selesai');
            const previewVenue = document.getElementById('preview-venue');
            const previewDescription = document.getElementById('preview-description');
            const form = document.getElementById('eventForm');
            const submitBtn = document.getElementById('submitBtn');

            // Preview Nama Event
            namaInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    previewName.textContent = value;
                    previewAvatar.textContent = value.charAt(0).toUpperCase();
                } else {
                    previewName.textContent = 'Nama Event';
                    previewAvatar.textContent = 'E';
                }
            });

            // Preview Tanggal Mulai
            mulaiInput.addEventListener('input', () => {
                previewMulai.textContent = mulaiInput.value || 'Tanggal mulai belum dipilih';
            });

            // Preview Tanggal Selesai
            selesaiInput.addEventListener('input', () => {
                previewSelesai.textContent = selesaiInput.value || 'Tanggal selesai belum dipilih';
            });

            // Preview Venue
            venueSelect.addEventListener('change', () => {
                if (venueSelect.value) {
                    previewVenue.innerHTML =
                        `<span class="badge bg-info">${venueSelect.options[venueSelect.selectedIndex].text}</span>`;
                } else {
                    previewVenue.innerHTML = `<span class="badge bg-secondary">Belum dipilih</span>`;
                }
            });

            // Preview Deskripsi
            descriptionTextarea.addEventListener('input', () => {
                const text = descriptionTextarea.value || 'Deskripsi event akan tampil di sini...';
                previewDescription.textContent = text.length > 100 ? text.substring(0, 100) + '...' : text;
            });

            form.addEventListener('submit', function(e) {
                // Validasi tanggal selesai harus setelah tanggal mulai
                const mulai = mulaiInput.value;
                const selesai = selesaiInput.value;

                if (mulai && selesai && selesai < mulai) {
                    e.preventDefault();
                    showNotification('Tanggal selesai harus setelah tanggal mulai!', 'error');
                    selesaiInput.style.borderColor = 'var(--error)';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Event';
                    return;
                } else {
                    selesaiInput.style.borderColor = 'var(--glass-border)';
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
