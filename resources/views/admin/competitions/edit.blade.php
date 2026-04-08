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
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Edit Kompetisi</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Ubah data kompetisi olahraga</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/competitions"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-trophy me-1"></i>Competitions
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Edit</li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages -->
        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Validasi Gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>
        @endif

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
                                    class="fas fa-edit"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Kompetisi</h5>
                                <small class="text-white">Ubah detail kompetisi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/competitions/{{ $competitions_array->id }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="competitionForm"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-md-12">
                                    <label
                                        for="name"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-trophy me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Nama Kompetisi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $competitions_array->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="Masukkan nama kompetisi..."
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Year -->
                                <div class="col-md-6">
                                    <label
                                        for="year"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-calendar me-2"
                                            style="color: var(--info);"
                                        ></i>
                                        Tahun Kegiatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="year"
                                        id="year"
                                        class="form-control @error('year') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Tahun</option>
                                        @for ($i = date('Y') + 1; $i >= 2020; $i--)
                                            <option
                                                value="{{ $i }}"
                                                {{ old('year', $competitions_array->year) == $i ? 'selected' : '' }}
                                            >
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label
                                        for="category"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-layer-group me-2"
                                            style="color: var(--warning);"
                                        ></i>
                                        Kategori/Jenis Event
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="category"
                                        id="category"
                                        class="form-control @error('category') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Kategori</option>
                                        <option
                                            value="internal"
                                            {{ old('category', $competitions_array->category) == 'internal' ? 'selected' : '' }}
                                        >Internal</option>
                                        <option
                                            value="external"
                                            {{ old('category', $competitions_array->category) == 'external' ? 'selected' : '' }}
                                        >External</option>
                                        <option
                                            value="friendly"
                                            {{ old('category', $competitions_array->category) == 'friendly' ? 'selected' : '' }}
                                        >Friendly Match</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Event Type (Dynamic based on category) -->
                                <div class="col-md-12">
                                    <label
                                        for="event_type"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-futbol me-2"
                                            style="color: var(--success);"
                                        ></i>
                                        Kegiatan/Event
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="event_type"
                                        id="event_type"
                                        class="form-control @error('event_type') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                        <option value="">Pilih Event</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Event akan muncul setelah memilih kategori
                                    </small>
                                    @error('event_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label
                                        for="description"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-align-left me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Deskripsi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        rows="4"
                                        placeholder="Masukkan deskripsi kompetisi (minimal 10 karakter)..."
                                        required
                                    >{{ old('description', $competitions_array->description) }}</textarea>
                                    <small class="text-muted d-block mt-1">
                                        <span id="charCount">0</span> karakter
                                    </small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date Range -->
                                <div class="col-md-6">
                                    <label
                                        for="tanggal_mulai"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-calendar-start me-2"
                                            style="color: var(--success);"
                                        ></i>
                                        Tanggal Mulai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="tanggal_mulai"
                                        id="tanggal_mulai"
                                        value="{{ old('tanggal_mulai', $competitions_array->tanggal_mulai ? $competitions_array->tanggal_mulai->format('Y-m-d') : '') }}"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label
                                        for="tanggal_selesai"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-calendar-check me-2"
                                            style="color: var(--danger);"
                                        ></i>
                                        Tanggal Selesai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="tanggal_selesai"
                                        id="tanggal_selesai"
                                        value="{{ old('tanggal_selesai', $competitions_array->tanggal_selesai ? $competitions_array->tanggal_selesai->format('Y-m-d') : '') }}"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required
                                    >
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/competitions"
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
                                    <i class="fas fa-save me-2"></i>Update Kompetisi
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
                                <small class="text-white">Tampilan kompetisi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <!-- Preview Icon -->
                        <div class="mb-3">
                            <div
                                class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 80px; height: 80px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 32px; color: var(--text-light);"
                            >
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div id="preview-info">
                            <h5
                                id="preview-name"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >{{ $competitions_array->name }}</h5>
                            <div class="d-flex justify-content-center mb-2 gap-2">
                                <span
                                    id="preview-year"
                                    class="badge bg-info"
                                    style="font-size: 11px;"
                                >
                                    <i class="fas fa-calendar me-1"></i>{{ $competitions_array->year }}
                                </span>
                                <span
                                    id="preview-category"
                                    class="badge bg-warning"
                                    style="font-size: 11px;"
                                >
                                    <i class="fas fa-layer-group me-1"></i>{{ ucfirst($competitions_array->category) }}
                                </span>
                            </div>
                            <span
                                id="preview-event"
                                class="badge bg-success mb-3"
                                style="font-size: 11px;"
                            >
                                <i class="fas fa-futbol me-1"></i>{{ $competitions_array->event_type }}
                            </span>
                            <p
                                id="preview-description"
                                class="small mb-3 text-white"
                            >{{ Str::limit($competitions_array->description, 100) }}</p>
                            <div class="d-flex justify-content-center mb-2 gap-2">
                                <span
                                    id="preview-start"
                                    class="badge bg-success"
                                    style="font-size: 11px;"
                                >
                                    <i
                                        class="fas fa-calendar-start me-1"></i>{{ $competitions_array->tanggal_mulai ? $competitions_array->tanggal_mulai->format('d M Y') : '-' }}
                                </span>
                                <span
                                    id="preview-end"
                                    class="badge bg-danger"
                                    style="font-size: 11px;"
                                >
                                    <i
                                        class="fas fa-calendar-check me-1"></i>{{ $competitions_array->tanggal_selesai ? $competitions_array->tanggal_selesai->format('d M Y') : '-' }}
                                </span>
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
                            ></i>Tips & Kategori Event
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-2"><strong>Internal:</strong> Liga Expose, Festival Expose</li>
                            <li class="mb-2"><strong>External:</strong> BPL, LBFF, SATURDAY LEAGUE, INDIE FOOTBALL</li>
                            <li class="mb-2"><strong>Friendly Match:</strong> Friendly Match, Trofeo, Fourfeo</li>
                            <li class="mb-1">Pilih kategori untuk melihat event yang tersedia</li>
                            <li>Pastikan tanggal selesai lebih dari tanggal mulai</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event options berdasarkan kategori
            const eventsByCategory = @json($eventsByCategory);
            const currentCategory = '{{ old('category', $competitions_array->category) }}';
            const currentEventType = '{{ old('event_type', $competitions_array->event_type) }}';

            const categorySelect = document.getElementById('category');
            const eventTypeSelect = document.getElementById('event_type');
            const nameInput = document.getElementById('name');
            const yearSelect = document.getElementById('year');
            const descriptionInput = document.getElementById('description');
            const startDateInput = document.getElementById('tanggal_mulai');
            const endDateInput = document.getElementById('tanggal_selesai');

            const previewName = document.getElementById('preview-name');
            const previewYear = document.getElementById('preview-year');
            const previewCategory = document.getElementById('preview-category');
            const previewEvent = document.getElementById('preview-event');
            const previewDescription = document.getElementById('preview-description');
            const previewStart = document.getElementById('preview-start');
            const previewEnd = document.getElementById('preview-end');

            // Update event options ketika category berubah
            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;
                eventTypeSelect.innerHTML = '<option value="">Pilih Event</option>';

                if (selectedCategory && eventsByCategory[selectedCategory]) {
                    eventTypeSelect.disabled = false;
                    eventsByCategory[selectedCategory].forEach(event => {
                        const option = document.createElement('option');
                        option.value = event;
                        option.textContent = event;
                        eventTypeSelect.appendChild(option);
                    });
                } else {
                    eventTypeSelect.disabled = true;
                    eventTypeSelect.innerHTML = '<option value="">Pilih kategori terlebih dahulu</option>';
                }

                // Update category preview
                const categoryMap = {
                    'internal': 'Internal',
                    'external': 'External',
                    'friendly': 'Friendly Match'
                };
                const category = categoryMap[this.value] || 'Kategori';
                previewCategory.innerHTML = `<i class="fas fa-layer-group me-1"></i>${category}`;
            });

            // Load existing category and event
            if (currentCategory) {
                categorySelect.dispatchEvent(new Event('change'));
                if (currentEventType) {
                    setTimeout(() => {
                        eventTypeSelect.value = currentEventType;
                        eventTypeSelect.dispatchEvent(new Event('change'));
                    }, 100);
                }
            }

            // Update name preview
            nameInput.addEventListener('input', function() {
                previewName.textContent = this.value || 'Nama Kompetisi';
            });

            // Update year preview
            yearSelect.addEventListener('change', function() {
                const year = this.value || new Date().getFullYear();
                previewYear.innerHTML = `<i class="fas fa-calendar me-1"></i>${year}`;
            });

            // Update event type preview
            eventTypeSelect.addEventListener('change', function() {
                const event = this.value || 'Event';
                previewEvent.innerHTML = `<i class="fas fa-futbol me-1"></i>${event}`;
            });

            // Update description preview with character count
            descriptionInput.addEventListener('input', function() {
                const text = this.value;
                const charCount = document.getElementById('charCount');
                charCount.textContent = text.length;

                if (text.length < 10) {
                    charCount.style.color = '#ef4444';
                } else {
                    charCount.style.color = '#10b981';
                }

                previewDescription.textContent = text || 'Deskripsi akan muncul di sini';
                if (text.length > 100) {
                    previewDescription.textContent = text.substring(0, 100) + '...';
                }
            });

            // Update start date preview
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const formatted = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    previewStart.innerHTML = `<i class="fas fa-calendar-start me-1"></i>${formatted}`;
                } else {
                    previewStart.innerHTML = '<i class="fas fa-calendar-start me-1"></i>Mulai';
                }
            });

            // Update end date preview
            endDateInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const formatted = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    previewEnd.innerHTML = `<i class="fas fa-calendar-check me-1"></i>${formatted}`;
                } else {
                    previewEnd.innerHTML = '<i class="fas fa-calendar-check me-1"></i>Selesai';
                }
            });

            // Initialize preview from current values
            if (nameInput.value) nameInput.dispatchEvent(new Event('input'));
            if (descriptionInput.value) descriptionInput.dispatchEvent(new Event('input'));
            if (startDateInput.value) startDateInput.dispatchEvent(new Event('change'));
            if (endDateInput.value) endDateInput.dispatchEvent(new Event('change'));

            // Form validation
            const form = document.getElementById('competitionForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (endDate <= startDate) {
                    e.preventDefault();
                    showNotification('Tanggal selesai harus lebih dari tanggal mulai', 'error');
                    return;
                }

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });
        });

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.innerHTML = `
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} fa-lg"></i>
                    <span>${message}</span>
                    <button class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()" style="filter: invert(1);"></button>
                </div>
            `;

            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10001;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                animation: slideInRight 0.3s ease;
                max-width: 400px;
                font-size: 14px;
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>

    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        #year option,
        #category option,
        #event_type option {
            color: #000;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endsection
