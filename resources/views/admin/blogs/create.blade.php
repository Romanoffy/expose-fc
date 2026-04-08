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
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Blog Baru</h4>
                <p class="text-white mb-0" style="color: var(--text-secondary);">Lengkapi informasi blog dengan detail</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item">
                        <a href="/admin/blogs" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-blog me-1"></i>Blogs
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
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Informasi Blog</h5>
                                <small class="text-white">Masukkan data lengkap blog</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="/admin/blogs" method="POST" enctype="multipart/form-data" id="blogForm">
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
                                    <input type="text" name="title" id="title" placeholder="Judul blog"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Mini Description -->
                                <div class="col-12">
                                    <label for="mini_description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-align-left me-2" style="color: var(--primary-light);"></i>
                                        Mini Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="mini_description" id="mini_description"
                                        placeholder="Ringkasan singkat blog" class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        required>
                                </div>

                                <!-- Full Description -->
                                <div class="col-12">
                                    <label for="full_description" class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;">
                                        <i class="fas fa-file-alt me-2" style="color: var(--primary-light);"></i>
                                        Full Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="full_description" id="full_description"
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

                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-4 pt-3"
                                style="border-top: 1px solid var(--glass-border);">
                                <a href="/admin/blogs" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 10px 24px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius: 10px; padding: 10px 24px;" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Blog
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
                            <div class="p-2 rounded-circle"
                                style="background: var(--info); background: rgba(59, 130, 246, 0.1);">
                                <i class="fas fa-eye" style="color: var(--info); font-size: 16px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Preview</h5>
                                <small class="text-white">Tampilan blog sebelum disimpan</small>
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
                            <h5 id="preview-title" class="mb-1" style="color: var(--text-primary);">Judul Blog</h5>
                            <p id="preview-mini" class="text-white small mb-2">Mini description blog...</p>
                            <p id="preview-writer" class="text-white small mb-0">Penulis: -</p>
                            <p id="preview-date" class="text-white small mb-0">Tanggal: -</p>
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
                            <li class="mb-1">Gunakan judul yang menarik dan mudah diingat</li>
                            <li class="mb-1">Tambahkan gambar utama (thumbnail) dengan ukuran proporsional dan jelas</li>
                            <li class="mb-1">Tulis konten yang informatif, relevan, dan tidak terlalu panjang di satu
                                paragraf</li>
                            <li class="mb-1">Gunakan heading (<code>&lt;h2&gt;</code>, <code>&lt;h3&gt;</code>) untuk
                                memisahkan bagian penting</li>
                            <li class="mb-1">Periksa kembali ejaan dan tata bahasa sebelum menyimpan</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pictureInput = document.getElementById('picture');
                const titleInput = document.getElementById('title');
                const miniInput = document.getElementById('mini_description');
                const writerInput = document.getElementById('writer');
                const dateInput = document.getElementById('date');
                const fullDescription = document.getElementById('full_description');
                const editorDiv = document.getElementById('editor');

                const previewImage = document.getElementById('preview-image');
                const previewTitle = document.getElementById('preview-title');
                const previewMini = document.getElementById('preview-mini');
                const previewWriter = document.getElementById('preview-writer');
                const previewDate = document.getElementById('preview-date');

                // CKEditor instance with custom upload adapter
                let editorInstance;
                ClassicEditor.create(editorDiv)
                    .then(editor => {
                        editorInstance = editor;

                        editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                            return {
                                upload: () => {
                                    return new Promise((resolve, reject) => {
                                        loader.file.then(file => {
                                            const data = new FormData();
                                            data.append('upload', file);

                                            fetch('/admin/blogs/upload-image', {
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
                                    });
                                }
                            };
                        };
                    })
                    .catch(error => console.error(error));

                // Real-time preview for other fields
                titleInput.addEventListener('input', () => previewTitle.textContent = titleInput.value || 'Judul Blog');
                miniInput.addEventListener('input', () => previewMini.textContent = miniInput.value ||
                    'Mini description blog...');
                writerInput.addEventListener('input', () => previewWriter.textContent = 'Penulis: ' + (writerInput
                    .value || '-'));
                dateInput.addEventListener('input', () => previewDate.textContent = 'Tanggal: ' + (dateInput.value ||
                    '-'));

                // Preview for main picture
                pictureInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.size > 1048576) { // 1MB
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

                // Form submission
                const form = document.getElementById('blogForm');
                const submitBtn = document.getElementById('submitBtn');

                form.addEventListener('submit', function(e) {
                    const data = editorInstance.getData().trim();
                    if (!data) {
                        e.preventDefault();
                        showNotification('Full description wajib diisi', 'error');
                        return;
                    }
                    fullDescription.value = data; // copy CKEditor ke textarea untuk submit
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
@endsection
