@extends('layouts.dashboard')

@section('content')
    <style>
        .form-control::placeholder {
            color: #fff;
            /* warna putih */
            opacity: 0.6;
            /* biar gak transparan */
        }
    </style>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah News Baru</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi informasi news dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/news" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-newspaper me-1"></i>News
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: var(--text-primary);">Tambah Baru</li>
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
                            <div class="p-2 rounded-circle" style="background: var(--primary-bg);">
                                <i class="fas fa-plus me-0" style="color: var(--primary-light); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi News</h5>
                                <small class="text-white">Masukkan data lengkap news</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/news" method="POST" enctype="multipart/form-data" id="newsForm">
                            @csrf
                            <div class="row g-4">

                                <!-- Picture -->
                                <div class="col-md-6">
                                    <label for="picture" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-image me-2" style="color: var(--primary-light);"></i>
                                        Gambar
                                    </label>
                                    <input type="file" name="picture" id="picture" class="form-control"
                                        accept="image/*"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;">
                                </div>

                                <!-- Title -->
                                <div class="col-md-6">
                                    <label for="title" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-heading me-2" style="color: var(--primary-light);"></i>
                                        Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" placeholder="Judul news"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-file-alt me-2" style="color: var(--primary-light);"></i>
                                        Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description"
                                        style="position: absolute; opacity: 0; height: 1px; width: 1px; pointer-events: none;"></textarea>
                                    <div id="editor"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; padding: 12px 16px;">
                                    </div>
                                </div>

                                <!-- Writer -->
                                <div class="col-md-6">
                                    <label for="writer" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-user-edit me-2" style="color: var(--primary-light);"></i>
                                        Writer
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="writer" id="writer" placeholder="Nama penulis"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--primary-light);"></i>
                                        Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date" id="date" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>


                                <!-- News Category -->
                                <div class="col-md-6">
                                    <label for="news_category" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-list me-2" style="color: var(--primary-light);"></i>
                                        News Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="news_category_id" id="news_category" class="form-select"
                                        style="color: #fff; background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; padding: 12px 16px;"
                                        required>
                                        <option value="" style="color: #000; background: #fff;">Select Option
                                        </option>
                                        @foreach ($news_categories as $news_category)
                                            <option value="{{ $news_category->id }}"
                                                style="color: #000; background: #fff;">
                                                {{ $news_category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-toggle-on me-2" style="color: var(--primary-light);"></i>
                                        Status
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-select"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                        <option value="" style="color: #000; background: #fff;">Select Option
                                        </option>
                                        <option value="0" style="color: #000; background: #fff;">Unpublish</option>
                                        <option value="1" style="color: #000; background: #fff;">Publish</option>
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
                                    style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan News
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                    <div class="card-header"
                        style="background: var(--glass-bg); border-bottom: 1px solid var(--glass-border); border-radius: 16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-circle" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                                <small class="text-white">Tampilan news sebelum disimpan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div id="preview-image" class="rounded mx-auto"
                                style="width: 100%; height: 180px; background: var(--glass-bg); border: 3px solid var(--glass-border); font-size: 24px; color: var(--text-light); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>

                        <div id="preview-info">
                            <h5 id="preview-title" class="mb-1" style="color: var(--text-primary);">Judul News</h5>
                            {{-- <p id="preview-description" class="text-white small mb-2">Deskripsi</p> --}}
                            <p id="preview-writer" class="text-white small mb-0">Penulis: -</p>
                            <p id="preview-date" class="text-white small mb-0">Tanggal: -</p>
                            <p id="preview-category" class="text-white small mb-0">Kategori: -</p>
                            <p id="preview-status" class="text-white small mb-0">Status: -</p>
                        </div>

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
                            <li class="mb-1">Gunakan judul berita yang padat, jelas, dan menggugah rasa ingin tahu</li>
                            <li class="mb-1">Tuliskan isi berita secara faktual dan hindari opini pribadi</li>
                            <li class="mb-1">Unggah foto atau thumbnail yang relevan dengan berita (format JPG/PNG, max
                                2MB)</li>
                            <li class="mb-1">Cantumkan sumber atau narasumber jika ada kutipan langsung</li>
                            <li>Periksa kembali sebelum mem-publish untuk memastikan tidak ada kesalahan informasi</li>
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
        document.addEventListener('DOMContentLoaded', function() {
            const pictureInput = document.getElementById('picture');
            const titleInput = document.getElementById('title');
            const writerInput = document.getElementById('writer');
            const dateInput = document.getElementById('date');
            const descriptionField = document.getElementById('description');
            const editorDiv = document.getElementById('editor');
            const categoryInput = document.getElementById('news_category');
            const statusInput = document.getElementById('status');

            const previewImage = document.getElementById('preview-image');
            const previewTitle = document.getElementById('preview-title');
            // const previewDescription = document.getElementById('preview-description');
            const previewWriter = document.getElementById('preview-writer');
            const previewDate = document.getElementById('preview-date');
            const previewCategory = document.getElementById('preview-category');
            const previewStatus = document.getElementById('preview-status');

            let editorInstance;

            // CKEditor
            ClassicEditor.create(editorDiv)
                .then(editor => {
                    editorInstance = editor;
                    editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                        return {
                            upload: () => new Promise((resolve, reject) => {
                                loader.file.then(file => {
                                    const data = new FormData();
                                    data.append('upload', file);

                                    fetch('/admin/news/upload-image', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: data
                                        })
                                        .then(res => res.json())
                                        .then(res => resolve({
                                            default: res.url
                                        }))
                                        .catch(err => reject(err));
                                });
                            })
                        };
                    };

                    // // Live preview for description
                    // editor.model.document.on('change:data', () => {
                    //     previewDescription.innerHTML = editorInstance.getData() ||
                    //         'Deskripsi ';
                    // });
                })
                .catch(error => console.error(error));

            // Preview for other inputs
            titleInput.addEventListener('input', () => previewTitle.textContent = titleInput.value || 'Judul News');
            writerInput.addEventListener('input', () => previewWriter.textContent = 'Penulis: ' + (writerInput
                .value || '-'));
            dateInput.addEventListener('input', () => previewDate.textContent = 'Tanggal: ' + (dateInput.value ||
                '-'));

            // Preview for main picture
            pictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 1048576) {
                        showNotification('Ukuran file gambar maksimal 1MB', 'error');
                        this.value = '';
                        previewImage.style.backgroundImage = '';
                        previewImage.innerHTML = '<i class="fas fa-image"></i>';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.style.backgroundImage = `url(${e.target.result})`;
                        previewImage.style.backgroundSize = 'cover';
                        previewImage.style.backgroundPosition = 'center';
                        previewImage.innerHTML = '';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.style.backgroundImage = '';
                    previewImage.innerHTML = '<i class="fas fa-image"></i>';
                }
            });
            // Update preview ketika user pilih category / status
            categoryInput.addEventListener('change', () => {
                const selected = categoryInput.options[categoryInput.selectedIndex].text;
                previewCategory.textContent = 'Kategori: ' + (selected !== 'Select Option' ? selected :
                    '-');
            });

            statusInput.addEventListener('change', () => {
                const selected = statusInput.options[statusInput.selectedIndex].text;
                previewStatus.textContent = 'Status: ' + (selected !== 'Select Option' ? selected : '-');
            });

            // Form submission
            const form = document.getElementById('newsForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                const data = editorInstance.getData().trim();
                if (!data) {
                    e.preventDefault();
                    showNotification('Description wajib diisi', 'error');
                    return;
                }
                descriptionField.value = data;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
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
@endpush
