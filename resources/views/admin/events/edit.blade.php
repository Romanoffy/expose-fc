@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            /* warna putih */
            opacity: 0.6;
            /* biar gak transparan */
        }

        select.form-select option {
            background: var(--dark-card);
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Event</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui informasi event
                    {{ $event_array->nama }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/events" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-calendar-alt me-1"></i>Event
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $event_array->id }}</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle"
                                style="background: var(--warning); background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-calendar-alt" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi
                                    Event</h5>
                                <small class="text-white">Perbarui data event sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/events/{{ $event_array->id }}" method="POST" enctype="multipart/form-data"
                            id="pelatihEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Nama Event -->
                                <div class="col-md-6">
                                    <label for="nama" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Nama Event
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama" value="{{ $event_array->nama }}"
                                        class="form-control" placeholder="Masukkan nama event"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-6">
                                    <label for="tanggal_mulai" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-calendar-day me-2" style="color: var(--primary-light);"></i>
                                        Tanggal Mulai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai"
                                        value="{{ $event_array->tanggal_mulai ? \Carbon\Carbon::parse($event_array->tanggal_mulai)->format('Y-m-d\TH:i') : '' }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-6">
                                    <label for="tanggal_selesai" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-calendar-check me-2" style="color: var(--primary-light);"></i>
                                        Tanggal Selesai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai"
                                        value="{{ $event_array->tanggal_selesai ? \Carbon\Carbon::parse($event_array->tanggal_selesai)->format('Y-m-d\TH:i') : '' }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Venue -->
                                <div class="col-md-6">
                                    <label for="venue_id" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                        Venue
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="venue_id" id="venue_id" class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                        <option value="">Pilih Venue...</option>
                                        @foreach ($venues as $venue)
                                            <option value="{{ $venue->id }}"
                                                {{ $venue->id == $event_array->venue_id ? 'selected' : '' }}>
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-12">
                                    <label for="description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Deskripsi Event
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description" rows="4" class="form-control"
                                        placeholder="Tuliskan deskripsi singkat mengenai event..."
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; resize: vertical;"
                                        required>{{ $event_array->description }}</textarea>
                                </div>

                                <!-- Photo -->
                                {{-- <div class="col-12">
                                    <label for="gambar" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-camera me-2" style="color: var(--primary-light);"></i>
                                        Foto Event
                                        <small class="text-white">(JPG, PNG, max 1MB)</small>
                                    </label>

                                    <!-- Current Image Preview -->
                                    @if ($event_array->gambar)
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-3 p-3 rounded"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                                <img src="{{ asset('storage/' . $event_array->gambar) }}"
                                                    class="rounded-circle"
                                                    style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $event_array->nama }}">
                                                <div>
                                                    <h6 class="mb-1" style="color: var(--text-primary);">Foto Saat Ini
                                                    </h6>
                                                    <small class="text-white">Upload foto baru untuk mengganti</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="input-group">
                                        <input type="file" name="gambar" id="gambar" class="form-control"
                                            accept="image/*"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;">
                                        <span class="input-group-text"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;">
                                            <i class="fas fa-upload" style="color: var(--text-light);"></i>
                                        </span>
                                    </div>
                                    <small class="text-white">Kosongkan jika tidak ingin mengubah foto</small>
                                </div> --}}
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/events" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <!-- Current Data Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle"
                                style="background: var(--success); background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-calendar-check" style="color: var(--success); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Event
                                </h5>
                                <small class="text-white">Informasi event yang akan tampil</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Current Photo -->
                        <div class="mb-3">
                            @if ($event_array->gambar)
                                <img id="previewImage" src="{{ asset('storage/' . $event_array->gambar) }}"
                                    class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--glass-border);"
                                    alt="{{ $event_array->nama }}">
                            @else
                                <div id="previewImage"
                                    class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light);">
                                    {{ substr($event_array->nama, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- Current Info -->
                        <div>
                            <h5 id="previewNama" class="mb-1" style="color: var(--text-primary);">
                                {{ $event_array->nama }}</h5>
                            <p class="text-white small mb-2" id="previewVenue">{{ $event_array->venue->name ?? '-' }}</p>
                            <p class="small text-white mb-1" id="previewMulai">
                                {{ $event_array->tanggal_mulai ? \Carbon\Carbon::parse($event_array->tanggal_mulai)->format('d F Y, H:i') : '-' }}
                            </p>
                            <p class="small text-white mb-2" id="previewSelesai">
                                {{ $event_array->tanggal_selesai ? \Carbon\Carbon::parse($event_array->tanggal_selesai)->format('d F Y, H:i') : '-' }}
                            </p>

                            <p class="small text-white mb-0" style="font-style: italic;" id="previewDesc">
                                {{ Str::limit($event_array->description, 100) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Change History Card -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="small text-white mb-0 ps-3">
                            <li class="mb-1">ID Event: #{{ str_pad($event_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Mulai:
                                {{ $event_array->tanggal_mulai ? \Carbon\Carbon::parse($event_array->tanggal_mulai)->format('d F Y, H:i') : '-' }}
                            </li>
                            <li class="mb-1">Selesai:
                                {{ $event_array->tanggal_selesai ? \Carbon\Carbon::parse($event_array->tanggal_selesai)->format('d F Y, H:i') : '-' }}
                            </li>
                            <li class="mb-1">Update terakhir:
                                {{ $event_array->updated_at ? $event_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation and submission (same as saved)
            const form = document.getElementById('pelatihEditForm');
            const updateBtn = document.getElementById('updateBtn');

            form.addEventListener('submit', function(e) {
                // Add loading state
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

                // Basic validation
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

                // Tambahan: validasi tanggal selesai harus setelah tanggal mulai
                const mulai = document.getElementById('tanggal_mulai').value;
                const selesai = document.getElementById('tanggal_selesai').value;
                if (mulai && selesai && selesai < mulai) {
                    isValid = false;
                    showNotification('Tanggal selesai harus setelah tanggal mulai!', 'error');
                    document.getElementById('tanggal_selesai').style.borderColor = 'var(--error)';
                }

                if (!isValid) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Event';
                    updateBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                }
            });

            // Image preview & validation (same as saved)
            const gambarInput = document.getElementById('gambar');
            if (gambarInput) {
                gambarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.size > 1048576) { // 1MB
                            showNotification('Ukuran file foto maksimal 1MB', 'error');
                            this.value = '';
                            return;
                        }

                        // Preview new image in the preview card
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const existingImg = document.getElementById('previewImage');
                            if (existingImg) {
                                if (existingImg.tagName === 'IMG') {
                                    existingImg.src = ev.target.result;
                                } else {
                                    // it's a div - replace with img
                                    const parent = existingImg.parentElement;
                                    existingImg.remove();
                                    const img = document.createElement('img');
                                    img.id = 'previewImage';
                                    img.className = 'rounded-circle';
                                    img.style.width = '80px';
                                    img.style.height = '80px';
                                    img.style.objectFit = 'cover';
                                    img.style.border = '3px solid var(--glass-border)';
                                    img.src = ev.target.result;
                                    parent.insertBefore(img, parent.firstChild);
                                }
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Update preview fields live (same behavior as saved)
            const inputNama = document.getElementById('nama');
            const inputDesc = document.getElementById('description');
            const inputVenue = document.getElementById('venue_id');
            const previewNama = document.getElementById('previewNama');
            const previewVenue = document.getElementById('previewVenue');
            const previewDesc = document.getElementById('previewDesc');

            if (inputNama) {
                inputNama.addEventListener('input', function() {
                    previewNama.textContent = this.value || '{{ $event_array->nama }}';
                });
            }
            if (inputDesc) {
                inputDesc.addEventListener('input', function() {
                    previewDesc.textContent = this.value ? this.value.substring(0, 100) :
                        '{{ Str::limit($event_array->description, 100) }}';
                });
            }
            if (inputVenue) {
                inputVenue.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    previewVenue.textContent = selected ? selected.text :
                        '{{ $event_array->venue->name ?? '-' }}';
                });
            }
        });
        // === Tambahan: realtime update tanggal mulai & selesai ===
        const inputMulai = document.getElementById('tanggal_mulai');
        const inputSelesai = document.getElementById('tanggal_selesai');
        const previewMulai = document.getElementById('previewMulai');
        const previewSelesai = document.getElementById('previewSelesai');

        if (inputMulai) {
            inputMulai.addEventListener('input', function() {
                previewMulai.textContent = formatTanggal(this.value);
            });
        }

        if (inputSelesai) {
            inputSelesai.addEventListener('input', function() {
                previewSelesai.textContent = formatTanggal(this.value);
            });
        }

        function formatTanggal(value) {
            if (!value) return '-';
            const date = new Date(value);
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }



        // Notification function (same as saved)
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
