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
                >Edit Video</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Perbarui informasi video</p>
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
                    >Edit</li>
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
                                style="background: rgba(245, 158, 11, 0.1);"
                            >
                                <i
                                    class="fas fa-edit"
                                    style="color: var(--warning); font-size: 16px;"
                                ></i>
                            </div>
                            <div>
                                <h5
                                    class="mb-0"
                                    style="color: var(--text-primary); font-weight: 600;"
                                >Edit Informasi Video</h5>
                                <small class="text-white">Perbarui detail video sesuai kebutuhan</small>
                            </div>
                        </div>

                        <div>
                            <h6
                                class="mb-2"
                                style="color: var(--text-primary);"
                            >{{ $video_array->title }}</h6>
                            <p
                                class="small mb-0 text-white"
                                style="word-break: break-all;"
                            >
                                <i class="fas fa-link me-1"></i>{{ $video_array->link }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div
                    class="card mb-3"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
                >
                    <div class="card-body p-3">
                        <h6 style="color: var(--text-primary); margin-bottom: 12px;">
                            <i
                                class="fas fa-info-circle me-2"
                                style="color: var(--info);"
                            ></i>Info Update
                        </h6>
                        <ul class="small mb-0 ps-3 text-white">
                            <li class="mb-1">ID: #{{ str_pad($video_array->id, 3, '0', STR_PAD_LEFT) }}</li>
                            <li class="mb-1">Dibuat:
                                {{ $video_array->created_at ? $video_array->created_at->format('d F Y') : '-' }}</li>
                            <li class="mb-1">Update terakhir:
                                {{ $video_array->updated_at ? $video_array->updated_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') : '-' }}
                            </li>
                            <li>Perubahan akan langsung diterapkan</li>
                        </ul>
                    </div>
                </div>

                <!-- Helper Tips -->
                <div
                    class="card"
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
                            <li class="mb-1">Pastikan link YouTube masih valid</li>
                            <li class="mb-1">Thumbnail opsional, bisa dikosongkan</li>
                            <li>Upload thumbnail baru jika ingin mengubah</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('videoEditForm');
            const updateBtn = document.getElementById('updateBtn');
            const thumbnailInput = document.getElementById('thumbnail');
            const linkInput = document.getElementById('link');
            const videoPreview = document.getElementById('videoPreview');

            // Thumbnail preview
            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('thumbnailPreview').src = e.target.result;
                        document.getElementById('thumbnailPreviewContainer').style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Update video preview when link changes
            linkInput.addEventListener('input', function() {
                const videoId = extractYouTubeId(this.value);
                if (videoId) {
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
            });

            form.addEventListener('submit', function(e) {
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                updateBtn.disabled = true;

                // Validate YouTube link
                const videoId = extractYouTubeId(linkInput.value);
                if (!videoId) {
                    e.preventDefault();
                    updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Video';
                    updateBtn.disabled = false;
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
