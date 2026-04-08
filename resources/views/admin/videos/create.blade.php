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
                >Tambah Video</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Tambahkan video dari YouTube</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin/videos"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-video me-1"></i>Videos
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
                                    class="fab fa-youtube"
                                    style="color: var(--primary-light); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Informasi Video</h5>
                                <small class="text-white">Masukkan detail video YouTube</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form
                            action="/admin/videos"
                            method="POST"
                            enctype="multipart/form-data"
                            id="videoForm"
                        >
                            @csrf

                            <div class="row g-4">
                                <!-- Title -->
                                <div class="col-md-12">
                                    <label
                                        for="title"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-heading me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Judul Video
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="Masukkan judul video..."
                                        required
                                    >
                                </div>

                                <!-- YouTube Link -->
                                <div class="col-md-12">
                                    <label
                                        for="link"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fab fa-youtube me-2"
                                            style="color: #FF0000;"
                                        ></i>
                                        Link YouTube
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="url"
                                        name="link"
                                        id="link"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        required
                                    >
                                    <small class="d-block mt-1 text-white">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Masukkan URL video YouTube lengkap
                                    </small>
                                </div>

                                <!-- Thumbnail Upload -->
                                <div class="col-md-12">
                                    <label
                                        for="thumbnail"
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500; margin-bottom: 8px;"
                                    >
                                        <i
                                            class="fas fa-image me-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        Thumbnail
                                        <span class="text-muted">(Opsional)</span>
                                    </label>
                                    <input
                                        type="file"
                                        name="thumbnail"
                                        id="thumbnail"
                                        class="form-control"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px;"
                                        accept="image/*"
                                    >
                                    <small class="d-block mt-1 text-white">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Jika tidak diupload, thumbnail YouTube akan digunakan otomatis
                                    </small>
                                </div>

                                <!-- Thumbnail Preview -->
                                <div
                                    class="col-md-12"
                                    id="thumbnailPreviewContainer"
                                    style="display: none;"
                                >
                                    <label
                                        class="form-label"
                                        style="color: var(--text-primary); font-weight: 500;"
                                    >
                                        Preview Thumbnail
                                    </label>
                                    <div
                                        class="position-relative"
                                        style="max-width: 400px;"
                                    >
                                        <img
                                            id="thumbnailPreview"
                                            class="img-fluid rounded"
                                            style="border: 2px solid var(--glass-border);"
                                        >
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger position-absolute"
                                            style="top: 10px; right: 10px;"
                                            onclick="removeThumbnail()"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="d-flex justify-content-end mt-4 gap-3 pt-3"
                                style="border-top: 1px solid var(--glass-border);"
                            >
                                <a
                                    href="/admin/videos"
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
                                    <i class="fas fa-save me-2"></i>Simpan Video
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
                                style="background: rgba(255, 0, 0, 0.1);"
                            >
                                <i
                                    class="fab fa-youtube"
                                    style="color: #FF0000; font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Preview Video</h5>
                                <small class="text-white">Tampilan video</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Video Preview -->
                        <div class="mb-3">
                            <div
                                id="videoPreview"
                                class="rounded"
                                style="background: var(--glass-bg); border: 2px solid var(--glass-border); aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center; overflow: hidden;"
                            >
                                <div class="text-center text-white">
                                    <i
                                        class="fab fa-youtube fa-3x mb-2"
                                        style="opacity: 0.3;"
                                    ></i>
                                    <p class="small mb-0">Preview YouTube</p>
                                </div>
                            </div>
                        </div>

                        <div id="preview-info">
                            <h6
                                id="preview-title"
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >Judul Video</h6>
                            <p
                                id="preview-link"
                                class="small mb-0 text-white"
                                style="word-break: break-all;"
                            >
                                <i class="fas fa-link me-1"></i>
                                Link belum dimasukkan
                            </p>
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
                            <li class="mb-1">Gunakan link YouTube yang valid</li>
                            <li class="mb-1">Thumbnail otomatis diambil dari YouTube</li>
                            <li class="mb-1">Atau upload thumbnail custom</li>
                            <li>Format link: youtube.com/watch?v=xxx</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const linkInput = document.getElementById('link');
            const thumbnailInput = document.getElementById('thumbnail');
            const previewTitle = document.getElementById('preview-title');
            const previewLink = document.getElementById('preview-link');
            const videoPreview = document.getElementById('videoPreview');
            const thumbnailPreview = document.getElementById('thumbnailPreview');
            const thumbnailPreviewContainer = document.getElementById('thumbnailPreviewContainer');

            // Update title preview
            titleInput.addEventListener('input', function() {
                const value = this.value.trim();
                previewTitle.textContent = value || 'Judul Video';
            });

            // Update link preview and extract video ID
            linkInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    previewLink.innerHTML = `<i class="fas fa-link me-1"></i>${value}`;

                    // Extract YouTube video ID
                    const videoId = extractYouTubeId(value);
                    if (videoId) {
                        // Show YouTube embed preview
                        videoPreview.innerHTML = `
                            <iframe 
                                width="100%" 
                                height="100%" 
                                src="https://www.youtube.com/embed/${videoId}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                            ></iframe>
                        `;
                    }
                } else {
                    previewLink.innerHTML = '<i class="fas fa-link me-1"></i>Link belum dimasukkan';
                    videoPreview.innerHTML = `
                        <div class="text-center text-white">
                            <i class="fab fa-youtube fa-3x mb-2" style="opacity: 0.3;"></i>
                            <p class="small mb-0">Preview YouTube</p>
                        </div>
                    `;
                }
            });

            // Thumbnail preview
            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailPreview.src = e.target.result;
                        thumbnailPreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form validation
            const form = document.getElementById('videoForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Validate YouTube link
                const videoId = extractYouTubeId(linkInput.value);
                if (!videoId) {
                    e.preventDefault();
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Video';
                    submitBtn.disabled = false;
                    linkInput.style.borderColor = 'var(--error)';
                    showNotification('Link YouTube tidak valid', 'error');
                    return;
                }
            });
        });

        function extractYouTubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function removeThumbnail() {
            document.getElementById('thumbnail').value = '';
            document.getElementById('thumbnailPreviewContainer').style.display = 'none';
        }

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
