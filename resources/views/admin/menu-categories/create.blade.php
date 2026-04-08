@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
        }

        #category option {
            color: #000;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Event Baru</h4>
                <p class="mb-0 text-white" style="color: var(--text-secondary);">Tambahkan kegiatan/event untuk kategori kompetisi</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/menu-categories" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-layer-group me-1"></i>Master Kategori
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Validasi Gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
                    <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: var(--primary-bg);">
                                <i class="fas fa-plus-circle" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Event</h5>
                                <small class="text-white">Lengkapi detail event</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/menu-categories" method="POST" id="eventForm">
                            @csrf

                            <div class="row g-4">
                                <!-- Category -->
                                <div class="col-md-12">
                                    <label for="category" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-layer-group me-2" style="color: var(--warning);"></i>
                                        Kategori
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="category" id="category" 
                                            class="form-control @error('category') is-invalid @enderror"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                            required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categoryLabels as $key => $label)
                                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Event Name -->
                                <div class="col-md-12">
                                    <label for="event_name" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-futbol me-2" style="color: var(--primary-light);"></i>
                                        Nama Event
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="event_name" id="event_name" 
                                           value="{{ old('event_name') }}"
                                           class="form-control @error('event_name') is-invalid @enderror"
                                           style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                           placeholder="Masukkan nama event..."
                                           required
                                           maxlength="100">
                                    @error('event_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label" style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Deskripsi
                                    </label>
                                    <textarea name="description" id="description" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                              rows="4"
                                              placeholder="Masukkan deskripsi event (opsional)...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end mt-4 gap-3 pt-3" style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/menu-categories" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview & Info Card -->
            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
                    <div class="card-header" style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                                <small class="text-white">Tampilan event</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);">
                                <i class="fas fa-futbol"></i>
                            </div>
                        </div>

                        <div id="preview-info">
                            <h5 id="preview-event" class="mb-2" style="color: var(--text-primary);">Nama Event</h5>
                            <span id="preview-category" class="badge bg-secondary mb-3" style="font-size: 12px;">
                                <i class="fas fa-layer-group me-1"></i>Pilih Kategori
                            </span>
                            <p id="preview-description" class="small mb-3 text-white">Deskripsi akan muncul di sini</p>
                        </div>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div class="card mt-3" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-lightbulb me-2" style="color: var(--warning);"></i>Informasi Penting
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-2"><strong>Internal:</strong> Event untuk kompetisi internal</li>
                            <li class="mb-2"><strong>External:</strong> Event untuk kompetisi eksternal/umum</li>
                            <li class="mb-2"><strong>Friendly Match:</strong> Event untuk pertandingan persahabatan</li>
                            <li class="mb-1">Nama event harus unik dalam satu kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const eventNameInput = document.getElementById('event_name');
            const descriptionInput = document.getElementById('description');

            const previewCategory = document.getElementById('preview-category');
            const previewEvent = document.getElementById('preview-event');
            const previewDescription = document.getElementById('preview-description');

            // Category labels mapping
            const categoryLabels = {
                'internal': 'Internal',
                'external': 'External',
                'friendly': 'Friendly Match'
            };

            const categoryColors = {
                'internal': 'bg-primary',
                'external': 'bg-success',
                'friendly': 'bg-warning'
            };

            // Update category preview
            categorySelect.addEventListener('change', function() {
                const category = this.value;
                if (category) {
                    const label = categoryLabels[category] || category;
                    const colorClass = categoryColors[category] || 'bg-secondary';
                    previewCategory.className = `badge ${colorClass} mb-3`;
                    previewCategory.innerHTML = `<i class="fas fa-layer-group me-1"></i>${label}`;
                } else {
                    previewCategory.className = 'badge bg-secondary mb-3';
                    previewCategory.innerHTML = '<i class="fas fa-layer-group me-1"></i>Pilih Kategori';
                }
            });

            // Update event name preview
            eventNameInput.addEventListener('input', function() {
                previewEvent.textContent = this.value || 'Nama Event';
            });

            // Update description preview
            descriptionInput.addEventListener('input', function() {
                const text = this.value;
                previewDescription.textContent = text || 'Deskripsi akan muncul di sini';
                if (text.length > 100) {
                    previewDescription.textContent = text.substring(0, 100) + '...';
                }
            });

            // Form validation
            const form = document.getElementById('eventForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });

            // Initialize preview from old values
            if (categorySelect.value) categorySelect.dispatchEvent(new Event('change'));
            if (eventNameInput.value) eventNameInput.dispatchEvent(new Event('input'));
            if (descriptionInput.value) descriptionInput.dispatchEvent(new Event('input'));
        });
    </script>
@endsection