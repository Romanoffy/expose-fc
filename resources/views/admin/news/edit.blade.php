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

        #previewDesc * {
            color: white !important;
            background: transparent !important;
        }

        #previewDesc {
            color: white !important;
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

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit News</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Perbarui informasi news
                    {{ $news_array->title }}</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/news" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-newspaper me-1"></i>News
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Edit #{{ $news_array->id }}</li>
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
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Edit Informasi News
                                </h5>
                                <small class="text-white">Perbarui konten news sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/news/{{ $news_array->id }}" method="POST" enctype="multipart/form-data"
                            id="newsEditForm">
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

                                    @if ($news_array->picture)
                                        <div>
                                            <div class="d-flex align-items-center gap-3 p-3 rounded"
                                                style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                                <img src="{{ asset('storage/' . $news_array->picture) }}" id="currentImage"
                                                    class="rounded"
                                                    style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--glass-border);"
                                                    alt="{{ $news_array->title }}">
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
                                    <input type="text" name="title" id="title" value="{{ $news_array->title }}"
                                        class="form-control" placeholder="Masukkan judul news"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-file-alt me-2" style="color: var(--primary-light);"></i>
                                        Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>{!! $news_array->description !!}</textarea>
                                    <small class="text-white">Gunakan editor untuk memformat konten news</small>
                                </div>
                                <!-- Writer -->
                                <div class="col-md-6">
                                    <label for="writer" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-user-edit me-2" style="color: var(--primary-light);"></i>
                                        Writer
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="writer" id="writer" value="{{ $news_array->writer }}"
                                        class="form-control" placeholder="Nama penulis"
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
                                    <input type="date" name="date" id="date" value="{{ $news_array->date }}"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label for="news_category_id" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-list me-2" style="color: var(--primary-light);"></i>
                                        News Category
                                    </label>
                                    <select name="news_category_id" id="news_category_id" class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                        <option value=""  style="color: #000; background: #fff;">Select Option</option>
                                        @foreach ($news_categories as $news_category)
                                            <option value="{{ $news_category->id }}"
                                                style="color: #000; background: #fff;"
                                                {{ $news_category->id == $news_array->news_category_id ? 'selected' : '' }}>
                                                {{ $news_category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;">
                                        <i class="fas fa-toggle-on me-2" style="color: var(--primary-light);"></i>
                                        Status
                                    </label>
                                    <select name="status" id="status" class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                        <option value=""  style="color: #000; background: #fff;">Select Option</option>
                                        <option value="0"  style="color: #000; background: #fff;" {{ $news_array->status == 0 ? 'selected' : '' }}>Unpublish
                                        </option>
                                        <option value="1"  style="color: #000; background: #fff;" {{ $news_array->status == 1 ? 'selected' : '' }}>Publish
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/news" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Update News
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview & Info Column -->
            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview News</h5>
                                <small class="text-white">Data news saat ini</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            @if ($news_array->picture)
                                <img src="{{ asset('storage/' . $news_array->picture) }}" id="previewImage"
                                    class="rounded w-100"
                                    style="height: 180px; object-fit: cover; border: 2px solid var(--glass-border);"
                                    alt="{{ $news_array->title }}">
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

                        <div id="preview-info" class="text-center">
                            <h5 class="mb-1" style="color: var(--text-primary);" id="previewTitle">
                                {{ $news_array->title }}
                            </h5>
                            {{-- <p class="small text-white mb-2" id="previewDesc">
                                {!! $news_array->description !!}
                            </p> --}}
                            <div class="mb-2 text-center" style="color: white; font-size: 13px;">
                                <p class="mb-0" id="previewWriter">Penulis: {{ $news_array->writer }}</p>
                                <p class="mb-0" id="previewDate">Tanggal: {{ date('d M Y', strtotime($news_array->date)) }}</p>
                                <p class="mb-0" id="previewCategory">Kategori: {{ $news_array->category->name ?? '-' }}</p>
                                <p class="mb-0" id="previewStatus">Status: {{ $news_array->status == 1 ? 'Publish' : 'Unpublish' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-info-circle me-2" style="color: var(--info);"></i>Info Update
                        </h6>
                        <ul class="small text-white mb-0 ps-3">
                            <li class="mb-1">ID News: #{{ str_pad($news_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $news_array->created_at ? $news_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $news_array->updated_at ? $news_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
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
            .create(document.querySelector('#description'))
            .then(editor => {
                editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                    return {
                        upload: () => {
                            return new Promise((resolve, reject) => {
                                const data = new FormData();
                                loader.file.then(file => {
                                    data.append('upload', file);
                                    fetch('/admin/news/upload-image', {
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

                // // Live update description preview - COMPLETELY FIXED VERSION
                // editor.model.document.on('change:data', () => {
                //     const previewDesc = document.getElementById('previewDesc');

                //     // SOLUSI 1: Hapus SEMUA child nodes secara paksa
                //     while (previewDesc.firstChild) {
                //         previewDesc.removeChild(previewDesc.firstChild);
                //     }

                //     // SOLUSI 2: Buat temporary container untuk parsing HTML
                //     const tempDiv = document.createElement('div');
                //     tempDiv.innerHTML = editor.getData();

                //     // SOLUSI 3: Pindahkan semua nodes dari temp ke preview
                //     while (tempDiv.firstChild) {
                //         const node = tempDiv.firstChild;

                //         // Hapus semua inline styles dari node
                //         if (node.nodeType === 1) { // Element node
                //             node.removeAttribute('style');
                //             node.style.color = 'white';
                //         }

                //         previewDesc.appendChild(node);
                //     }

                //     // SOLUSI 4: Paksa styling pada semua child elements
                //     previewDesc.querySelectorAll('*').forEach(el => {
                //         el.removeAttribute('style');
                //         el.style.cssText = 'color: white !important;';
                //     });

                //     // SOLUSI 5: Paksa warna putih pada parent container
                //     previewDesc.style.cssText = 'color: white !important;';
                // });

            })
            .catch(error => console.error(error));

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const updateBtn = document.getElementById('updateBtn');

            // Live Preview Inputs
            const titleInput = document.getElementById('title');
            const writerInput = document.getElementById('writer');
            const dateInput = document.getElementById('date');
            const categoryInput = document.getElementById('news_category_id');
            const statusInput = document.getElementById('status');

            const previewTitle = document.getElementById('previewTitle');
            const previewWriter = document.getElementById('previewWriter');
            const previewDate = document.getElementById('previewDate');
            const previewCategory = document.getElementById('previewCategory');
            const previewStatus = document.getElementById('previewStatus');

            // Update Title
            titleInput.addEventListener('input', () => {
                previewTitle.textContent = titleInput.value || '{{ $news_array->title }}';
            });

            // Update Writer
            writerInput.addEventListener('input', () => {
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

            // Update Category
            categoryInput.addEventListener('change', () => {
                const selected = categoryInput.options[categoryInput.selectedIndex].text;
                previewCategory.textContent = 'Kategori: ' + (selected !== 'Select Option' ? selected : '-');
            });

            // Update Status
            statusInput.addEventListener('change', () => {
                const selected = statusInput.options[statusInput.selectedIndex].text;
                previewStatus.textContent = 'Status: ' + selected;
            });

            // Image file validation and preview
            const pictureInput = document.querySelector('input[name="picture"]');
            pictureInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                if (file.size > 2097152) { // 2MB
                    showNotification('Ukuran file gambar maksimal 2MB', 'error');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    const placeholder = document.getElementById('previewImagePlaceholder');

                    previewImage.src = e.target.result;
                    previewImage.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            });

            // Form submission handler
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
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update News';
                    updateBtn.disabled = false;
                    showNotification('Harap lengkapi semua field yang wajib diisi', 'error');
                }
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
        });
    </script>
@endpush
