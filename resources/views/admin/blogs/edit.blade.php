@extends('layouts.dashboard')
@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            opacity: 0.6;
        }

        .ck-editor__editable_inline {
            background-color: #fff;
            color: #000;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Blog</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui informasi blog
                    {{ $blog_array->title }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/blogs" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-blog me-1"></i>Blog
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $blog_array->id }}</li>
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
                            <div class="p-2 rounded-circle" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-edit" style="color: var(--warning); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi Blog
                                </h5>
                                <small class="text-white">Perbarui konten blog sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/blogs/{{ $blog_array->id }}" method="POST" enctype="multipart/form-data"
                            id="blogEditForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Picture -->
                                <div class="col-md-6">
                                    <label for="picture" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Gambar
                                        <small class="text-white">(JPG, PNG, max 2MB)</small>
                                    </label>



                                    <div class="input-group mb-3">
                                        <input type="file" name="picture" id="picture" class="form-control"
                                            accept="image/*"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px 0 0 10px; color: var(--text-primary); padding: 12px 16px;">
                                        <span class="input-group-text"
                                            style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-left: none; border-radius: 0 10px 10px 0;">
                                            <i class="fas fa-upload" style="color: var(--text-light);"></i>
                                        </span>
                                    </div>

                                    <!-- Current Image Preview -->
                                    @if ($blog_array->picture)
                                        <div>
                                            <div class="d-flex align-items-center gap-3 p-3 rounded"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                                <img src="{{ asset('storage/' . $blog_array->picture) }}" id="currentImage"
                                                    class="rounded"
                                                    style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $blog_array->title }}">
                                                <div>
                                                    <h6 class="mb-1" style="color: var(--text-primary);">Gambar Saat Ini
                                                    </h6>
                                                    <small class="text-white">Upload gambar baru untuk mengganti</small>
                                                </div>
                                            </div>
                                            <small class="text-white">Kosongkan jika tidak ingin mengubah gambar</small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Title -->
                                <div class="col-md-6">
                                    <label for="title" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ $blog_array->title }}"
                                        class="form-control" placeholder="Masukkan judul blog"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Mini Description -->
                                <div class="col-12">
                                    <label for="miniDescription" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Mini Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="mini_description" id="miniDescription"
                                        value="{{ $blog_array->mini_description }}" class="form-control"
                                        placeholder="Deskripsi singkat blog (max 160 karakter)"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        maxlength="160" required>

                                </div>

                                <!-- Full Description -->
                                <div class="col-12">
                                    <label for="fullDescription" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-file-alt me-2" style="color: var(--primary-light);"></i>
                                        Full Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="full_description" id="fullDescription" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>{{ $blog_array->full_description }}</textarea>
                                    <small class="text-white">Gunakan editor untuk memformat konten blog</small>
                                </div>

                                <!-- Writer -->
                                <div class="col-md-6">
                                    <label for="writer" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-user-edit me-2" style="color: var(--primary-light);"></i>
                                        Writer
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="writer" id="writer"
                                        value="{{ $blog_array->writer }}" class="form-control" placeholder="Nama penulis"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--primary-light);"></i>
                                        Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date" id="date" value="{{ $blog_array->date }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/blogs" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update Blog
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
                            <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview Blog</h5>
                                <small class="text-white">Data blog saat ini</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Current Photo -->
                        <div class="mb-3">
                            @if ($blog_array->picture)
                                <img src="{{ asset('storage/' . $blog_array->picture) }}" id="previewImage"
                                    class="rounded w-100"
                                    style="height: 180px; object-fit: cover; border: 2px solid var(--glass-border);"
                                    alt="{{ $blog_array->title }}">
                            @else
                                <div id="previewImagePlaceholder"
                                    class="rounded w-100 d-flex align-items-center justify-content-center"
                                    style="height: 180px; background: var(--glass-bg); border: 2px solid var(--glass-border);">
                                    <i class="fas fa-image" style="font-size: 48px; color: var(--text-light);"></i>
                                </div>
                                <img src="" id="previewImage" class="rounded w-100 d-none"
                                    style="height: 180px; object-fit: cover; border: 2px solid var(--glass-border);"
                                    alt="">
                            @endif
                        </div>

                        <!-- Current Info -->
                        <div id="preview-info" class="text-center">
                            <h5 class="mb-1" style="color: var(--text-primary);" id="previewTitle">
                                {{ $blog_array->title }}
                            </h5>

                            <p class="small text-white mb-2" id="previewMiniDesc">
                                {{ $blog_array->mini_description }}
                            </p>
                            <div class="mb-2 text-center" style="color: white; font-size: 13px;">
                                <p class="mb-0" id="previewWriter">Penulis: {{ $blog_array->writer }}</p>
                                <p class="mb-0" id="previewDate">Tanggal:
                                    {{ date('d M Y', strtotime($blog_array->date)) }}</p>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Info Update Card -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="small text-white mb-0 ps-3">
                            <li class="mb-1">ID Blog: #{{ str_pad($blog_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $blog_array->created_at ? $blog_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $blog_array->updated_at ? $blog_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                            <li>File gambar yang diubah akan mengganti data lama</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        // CKEditor Initialization
        ClassicEditor
            .create(document.querySelector('#fullDescription'))
            .then(editor => {
                editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                    return {
                        upload: () => {
                            return new Promise((resolve, reject) => {
                                const data = new FormData();
                                loader.file.then(file => {
                                    data.append('upload', file);
                                    fetch('/admin/blogs/upload-image', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: data
                                        })
                                        .then(res => res.json())
                                        .then(res => {
                                            resolve({
                                                default: res.url
                                            });
                                        })
                                        .catch(err => reject(err));
                                });
                            });
                        }
                    };
                };
            })
            .catch(error => console.error(error));

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('blogEditForm');
            const updateBtn = document.getElementById('updateBtn');

            // Character counter for mini description
            const miniDesc = document.getElementById('miniDescription');
            const charCount = document.getElementById('charCount');

            miniDesc.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });

            // Live Preview Updates
            const titleInput = document.getElementById('title');
            const writerInput = document.getElementById('writer');
            const dateInput = document.getElementById('date');
            const miniDescInput = document.getElementById('miniDescription');

            const previewTitle = document.getElementById('previewTitle');
            const previewWriter = document.getElementById('previewWriter');
            const previewDate = document.getElementById('previewDate');
            const previewMiniDesc = document.getElementById('previewMiniDesc');

            // Update Title
            titleInput.addEventListener('input', function() {
                previewTitle.textContent = this.value || '{{ $blog_array->title }}';
            });

            // Update Writer
            writerInput.addEventListener('input', function() {
                previewWriter.textContent = 'Penulis: ' + (writerInput.value || '-');
            });

            // Update Date
            dateInput.addEventListener('input', () => {
                const date = dateInput.value ? new Date(dateInput.value) : null;
                if (date) {
                    const day = date.getDate();
                    const month = date.toLocaleString(undefined, {
                        month: 'short'
                    });
                    const year = date.getFullYear();
                    previewDate.textContent = 'Tanggal: ' + `${day} ${month} ${year}`;
                } else {
                    previewDate.textContent = 'Tanggal: -';
                }
            });




            // Update Mini Description
            miniDescInput.addEventListener('input', function() {
                previewMiniDesc.textContent = this.value || '{{ $blog_array->mini_description }}';
            });

            // Form submission handler
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

                if (!isValid) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Blog';
                    updateBtn.disabled = false;

                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                }
            });

            // Image file validation
            document.getElementById('picture').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2097152) { // 2MB
                        showNotification('Ukuran file gambar maksimal 2MB', 'error');
                        this.value = '';
                        return;
                    }

                    // Preview new image in both locations
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const currentImage = document.getElementById('currentImage');
                        const previewImage = document.getElementById('previewImage');
                        const previewPlaceholder = document.getElementById('previewImagePlaceholder');

                        if (currentImage) {
                            currentImage.src = e.target.result;
                        }

                        if (previewImage) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('d-none');
                            if (previewPlaceholder) {
                                previewPlaceholder.classList.add('d-none');
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Notification function
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

    <style>
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

        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            margin-left: auto;
        }
    </style>
@endpush
