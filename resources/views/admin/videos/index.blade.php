@extends('layouts.dashboard')
@section('content')
    <style>
        .video-thumbnail {
            width: 120px;
            height: 68px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--glass-border);
        }

        .video-card {
            transition: all 0.3s ease;
        }

        .video-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .badge-youtube {
            background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
        }

        .sync-button {
            background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .sync-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }

        .delete-all-button {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .delete-all-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        select {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: white;
            padding: 10px 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        select:focus {
            background: var(--glass-bg);
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        select option {
            color: black;
            background: white;
        }

        select option[disabled] {
            color: gray;
        }

        .search-box {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: white !important;
            padding: 10px 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .search-box:focus {
            background: var(--glass-bg);
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.7);
            opacity: 1;
            transition: opacity 0.2s ease;
        }

        .search-box:hover::placeholder,
        .search-box:focus::placeholder {
            opacity: 0;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .stats-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top-color: var(--primary-light);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Fade animation for content */
        .fade-content {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Checkbox styling */
        .custom-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary-light);
        }

        /* Modal styling */
        .modal-content {
            background: var(--dark-card);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }

        .modal-header {
            border-bottom: 1px solid var(--glass-border);
        }

        .modal-footer {
            border-top: 1px solid var(--glass-border);
        }

        /* Radio button styling for sync modal */
        .btn-check:checked+.btn-outline-primary {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%) !important;
            border-color: var(--primary-light) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn-outline-primary:hover {
            background: rgba(99, 102, 241, 0.05) !important;
            border-color: var(--primary-light) !important;
        }
    </style>

    <!-- Loading Overlay -->
    <div
        class="loading-overlay"
        id="loadingOverlay"
    >
        <div class="loading-spinner"></div>
    </div>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >
                    <i
                        class="fab fa-youtube me-2"
                        style="color: #FF0000;"
                    ></i>
                    Video Management
                </h4>
                <p
                    class="mb-0"
                    style="color: var(--text-secondary);"
                >
                    Kelola video YouTube dan konten multimedia
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol
                    class="breadcrumb mb-0"
                    style="background: transparent;"
                >
                    <li class="breadcrumb-item">
                        <a
                            href="/admin"
                            style="color: var(--text-secondary); text-decoration: none;"
                        >
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        style="color: var(--text-primary);"
                    >Videos</li>
                </ol>
            </nav>
        </div>

        <!-- Stats Cards -->
        <div
            class="row g-3 mb-4"
            id="statsCards"
        >
            <div class="col-md-4">
                <div class="stats-card">
                    <div
                        class="stats-icon"
                        style="background: rgba(99, 102, 241, 0.1);"
                    >
                        <i
                            class="fas fa-video"
                            style="color: var(--primary-light);"
                        ></i>
                    </div>
                    <div>
                        <p
                            class="mb-1 text-white"
                            style="font-size: 13px;"
                        >Total Videos</p>
                        <h4
                            class="mb-0"
                            style="color: var(--text-primary); font-weight: 600;"
                            id="totalVideos"
                        >
                            {{ $video_array->total() }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div
                        class="stats-icon"
                        style="background: rgba(34, 197, 94, 0.1);"
                    >
                        <i
                            class="fas fa-sync-alt"
                            style="color: var(--success);"
                        ></i>
                    </div>
                    <div>
                        <p
                            class="mb-1 text-white"
                            style="font-size: 13px;"
                        >Last Update</p>
                        <h6
                            class="mb-0"
                            style="color: var(--text-primary); font-size: 14px;"
                            id="lastUpdate"
                        >
                            {{ $video_array->first() ? $video_array->first()->updated_at->diffForHumans() : 'Belum ada' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Bar -->
        <div
            class="card mb-4"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
        >
            <div class="card-body p-3">
                <div class="row align-items-center g-3">
                    <!-- Search -->
                    <div class="col-md-5">
                        <form
                            id="searchForm"
                            class="d-flex gap-2"
                        >
                            <div class="flex-grow-1">
                                <div class="input-group">
                                    <span
                                        class="input-group-text"
                                        style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-right: none;"
                                    >
                                        <i
                                            class="fas fa-search"
                                            style="color: var(--text-secondary);"
                                        ></i>
                                    </span>
                                    <input
                                        type="text"
                                        name="search"
                                        id="searchInput"
                                        class="form-control search-box"
                                        placeholder="Cari video..."
                                        value="{{ $search }}"
                                        style="border-left: none;"
                                    >
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-search"></i>
                            </button>
                            <button
                                type="button"
                                id="clearSearch"
                                class="btn btn-secondary"
                                style="{{ $search ? '' : 'display: none;' }}"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Limit -->
                    <div class="col-md-2">
                        <select
                            name="limit"
                            id="limitSelect"
                            class="form-select search-box"
                        >
                            <option
                                value="10"
                                {{ $limit == 10 ? 'selected' : '' }}
                            >10 Video</option>
                            <option
                                value="25"
                                {{ $limit == 25 ? 'selected' : '' }}
                            >25 Video</option>
                            <option
                                value="50"
                                {{ $limit == 50 ? 'selected' : '' }}
                            >50 Video</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-5 text-end">
                        <button
                            type="button"
                            class="btn delete-all-button me-2 text-white"
                            id="deleteAllBtn"
                            style="display: none;"
                        >
                            <i class="fas fa-trash me-2"></i>
                            Hapus Terpilih (<span id="selectedCount">0</span>)
                        </button>
                        <button
                            type="button"
                            class="btn sync-button me-2 text-white"
                            data-bs-toggle="modal"
                            data-bs-target="#syncModal"
                        >
                            <i class="fab fa-youtube me-2"></i>
                            Sync YouTube
                        </button>
                        <a
                            href="/admin/videos/create"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-plus me-2"></i>
                            Tambah Manual
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Container -->
        <div id="contentContainer">
            <!-- Videos Table -->
            <div
                class="card mb-4"
                style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
            >
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table
                            class="table-hover mb-0 table"
                            style="color: var(--text-secondary);"
                        >
                            <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                                <tr>
                                    <th
                                        class="border-0 px-4 py-3 text-center"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >
                                        <input
                                            type="checkbox"
                                            id="selectAll"
                                            class="custom-checkbox"
                                            title="Pilih Semua"
                                        >
                                    </th>
                                    <th
                                        class="border-0 px-4 py-3 text-center"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >
                                        <span class="text-black">#</span>
                                    </th>
                                    <th
                                        class="border-0 py-3 text-black"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >Thumbnail</th>
                                    <th
                                        class="border-0 py-3 text-black"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >Judul</th>
                                    <th
                                        class="border-0 py-3 text-black"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >Link YouTube</th>
                                    <th
                                        class="border-0 py-3 text-center text-black"
                                        style="color: var(--text-primary); font-weight: 600; font-size: 13px;"
                                    >Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="videoTableBody">
                                @forelse($video_array as $video)
                                    @php
                                        preg_match(
                                            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/',
                                            $video->link,
                                            $matches,
                                        );
                                        $videoId = $matches[1] ?? null;
                                        $thumbnailUrl = $video->thumbnail
                                            ? asset('storage/' . $video->thumbnail)
                                            : ($videoId
                                                ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
                                                : asset('assets/placeholder.jpg'));
                                    @endphp
                                    <tr
                                        class="border-bottom"
                                        style="border-color: rgba(51, 65, 85, 0.3) !important; transition: var(--transition-fast);"
                                        onmouseover="this.style.background='rgba(99, 102, 241, 0.05)'"
                                        onmouseout="this.style.background='transparent'"
                                    >
                                        <td class="px-4 py-3 text-center">
                                            <input
                                                type="checkbox"
                                                class="video-checkbox custom-checkbox"
                                                value="{{ $video->id }}"
                                                data-video-id="{{ $video->id }}"
                                            >
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span
                                                class="badge"
                                                style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;"
                                            >
                                                #{{ str_pad($video_array->firstItem() + $loop->index, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="position-relative">
                                                <img
                                                    src="{{ $thumbnailUrl }}"
                                                    alt="{{ $video->title }}"
                                                    class="video-thumbnail"
                                                    onerror="this.src='https://via.placeholder.com/120x68?text=No+Image'"
                                                >
                                                <div
                                                    class="position-absolute"
                                                    style="top: 4px; right: 4px;"
                                                >
                                                    <span class="badge-youtube">
                                                        <i class="fab fa-youtube"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div>
                                                <h6
                                                    class="fw-semibold mb-1 text-black"
                                                    style="color: var(--text-primary); font-size: 14px;"
                                                >
                                                    {{ Str::limit($video->title, 60) }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $video->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <a
                                                href="{{ $video->link }}"
                                                target="_blank"
                                                class="text-decoration-none"
                                                style="color: var(--primary-light);"
                                            >
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                <span style="font-size: 13px;">{{ Str::limit($video->link, 40) }}</span>
                                            </a>
                                        </td>
                                        <td class="py-3 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a
                                                    href="{{ $video->link }}"
                                                    target="_blank"
                                                    class="action-btn"
                                                    style="background: rgba(99, 102, 241, 0.1);"
                                                    title="Preview"
                                                >
                                                    <i
                                                        class="fas fa-eye"
                                                        style="color: var(--primary-light);"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="/admin/videos/{{ $video->id }}/edit"
                                                    class="action-btn"
                                                    style="background: rgba(245, 158, 11, 0.1);"
                                                    title="Edit"
                                                >
                                                    <i
                                                        class="fas fa-edit"
                                                        style="color: var(--warning);"
                                                    ></i>
                                                </a>
                                                <form
                                                    action="/admin/videos/{{ $video->id }}"
                                                    method="POST"
                                                    class="d-inline delete-form"
                                                    data-id="{{ $video->id }}"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="action-btn border-0"
                                                        style="background: rgba(239, 68, 68, 0.1);"
                                                        title="Hapus"
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                            style="color: var(--error);"
                                                        ></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="6"
                                            class="py-5 text-center"
                                        >
                                            <div style="color: var(--text-light);">
                                                <i class="fas fa-video fa-3x mb-3 opacity-50"></i>
                                                <h6 style="color: var(--text-secondary);">
                                                    @if ($search)
                                                        Tidak ada video ditemukan dengan kata kunci "{{ $search }}"
                                                    @else
                                                        Belum ada video
                                                    @endif
                                                </h6>
                                                <p class="mb-3">Mulai tambahkan video atau sync dari YouTube!</p>
                                                <a
                                                    href="/admin/videos/create"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    <i class="fas fa-plus me-2"></i>Tambah Video
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($video_array->hasPages())
                <div
                    class="card"
                    style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;"
                    id="paginationCard"
                >
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div
                                style="color: var(--text-secondary); font-size: 14px;"
                                id="paginationInfo"
                            >
                                Menampilkan {{ $video_array->firstItem() ?? 0 }} sampai
                                {{ $video_array->lastItem() ?? 0 }} dari {{ $video_array->total() }} video
                            </div>
                            <div
                                class="pagination-wrapper"
                                id="paginationLinks"
                            >
                                {{ $video_array->appends(['search' => $search, 'limit' => $limit])->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Sync YouTube Modal -->
    <div
        class="modal fade"
        id="syncModal"
        tabindex="-1"
        aria-labelledby="syncModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="syncModalLabel"
                        style="color: var(--text-primary);"
                    >
                        <i
                            class="fab fa-youtube me-2"
                            style="color: #FF0000;"
                        ></i>
                        Sync Video dari YouTube
                    </h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="{{ route('videos.sync') }}"
                    method="POST"
                    id="syncFormModal"
                >
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4 text-center">
                            <p style="color: var(--text-secondary); font-size: 14px;">
                                Pilih jumlah video terbaru yang ingin di-sync dari channel YouTube Anda
                            </p>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="max_videos"
                                    id="sync10"
                                    value="10"
                                    checked
                                >
                                <label
                                    class="btn btn-outline-primary w-100 py-3"
                                    for="sync10"
                                    style="border: 2px solid var(--glass-border); background: var(--glass-bg); color: var(--text-primary);"
                                >
                                    <div class="d-flex flex-column align-items-center">
                                        <i
                                            class="fas fa-video fa-2x mb-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        <strong style="font-size: 18px;">10</strong>
                                        <small style="color: var(--text-secondary);">Video</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="max_videos"
                                    id="sync25"
                                    value="25"
                                >
                                <label
                                    class="btn btn-outline-primary w-100 py-3"
                                    for="sync25"
                                    style="border: 2px solid var(--glass-border); background: var(--glass-bg); color: var(--text-primary);"
                                >
                                    <div class="d-flex flex-column align-items-center">
                                        <i
                                            class="fas fa-film fa-2x mb-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        <strong style="font-size: 18px;">25</strong>
                                        <small style="color: var(--text-secondary);">Video</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="max_videos"
                                    id="sync50"
                                    value="50"
                                >
                                <label
                                    class="btn btn-outline-primary w-100 py-3"
                                    for="sync50"
                                    style="border: 2px solid var(--glass-border); background: var(--glass-bg); color: var(--text-primary);"
                                >
                                    <div class="d-flex flex-column align-items-center">
                                        <i
                                            class="fas fa-photo-video fa-2x mb-2"
                                            style="color: var(--primary-light);"
                                        ></i>
                                        <strong style="font-size: 18px;">50</strong>
                                        <small style="color: var(--text-secondary);">Video</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div
                            class="alert alert-info d-flex align-items-start mt-4"
                            style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.3); color: var(--text-secondary);"
                        >
                            <i
                                class="fas fa-info-circle me-2 mt-1"
                                style="color: var(--primary-light);"
                            ></i>
                            <small>
                                Video akan diambil berdasarkan tanggal upload terbaru. Video yang sudah ada di database
                                tidak akan di-duplikasi.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button
                            type="submit"
                            class="btn sync-button text-white"
                            id="syncSubmitBtn"
                        >
                            <i class="fab fa-youtube me-2"></i>Mulai Sync
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const syncFormModal = document.getElementById('syncFormModal');
            const syncSubmitBtn = document.getElementById('syncSubmitBtn');
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const limitSelect = document.getElementById('limitSelect');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const selectAllCheckbox = document.getElementById('selectAll');
            const deleteAllBtn = document.getElementById('deleteAllBtn');
            const selectedCountSpan = document.getElementById('selectedCount');

            let selectedVideos = new Set();

            // Sync form modal handler
            if (syncFormModal) {
                syncFormModal.addEventListener('submit', function(e) {
                    syncSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing...';
                    syncSubmitBtn.disabled = true;
                    loadingOverlay.classList.add('active');

                    const modal = bootstrap.Modal.getInstance(document.getElementById('syncModal'));
                    if (modal) {
                        modal.hide();
                    }
                });
            }

            // Select all checkbox handler
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.video-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                        if (this.checked) {
                            selectedVideos.add(checkbox.value);
                        } else {
                            selectedVideos.delete(checkbox.value);
                        }
                    });
                    updateDeleteAllButton();
                });
            }

            // Individual checkbox handler
            function attachCheckboxHandlers() {
                const checkboxes = document.querySelectorAll('.video-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            selectedVideos.add(this.value);
                        } else {
                            selectedVideos.delete(this.value);
                            if (selectAllCheckbox) selectAllCheckbox.checked = false;
                        }

                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;

                        updateDeleteAllButton();
                    });
                });
            }

            // Update delete all button
            function updateDeleteAllButton() {
                if (selectedCountSpan) {
                    selectedCountSpan.textContent = selectedVideos.size;
                }
                if (deleteAllBtn) {
                    deleteAllBtn.style.display = selectedVideos.size > 0 ? 'inline-block' : 'none';
                }
            }

            // Delete all button handler
            if (deleteAllBtn) {
                deleteAllBtn.addEventListener('click', function() {
                    if (selectedVideos.size === 0) {
                        showNotification('Pilih minimal satu video untuk dihapus', 'error');
                        return;
                    }

                    if (!confirm(`Yakin ingin menghapus ${selectedVideos.size} video yang dipilih?`)) {
                        return;
                    }

                    loadingOverlay.classList.add('active');

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        showNotification('CSRF token tidak ditemukan. Refresh halaman dan coba lagi.',
                            'error');
                        loadingOverlay.classList.remove('active');
                        return;
                    }

                    fetch('/admin/videos/delete-multiple', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken.content,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                ids: Array.from(selectedVideos)
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(data.message ||
                                    `${selectedVideos.size} video berhasil dihapus`, 'success');
                                selectedVideos.clear();
                                if (selectAllCheckbox) selectAllCheckbox.checked = false;
                                updateDeleteAllButton();

                                const url = new URL(window.location);
                                const currentPage = url.searchParams.get('page') || 1;
                                loadVideos(currentPage);
                            } else {
                                showNotification(data.message || 'Gagal menghapus video', 'error');
                                loadingOverlay.classList.remove('active');
                            }
                        })
                        .catch(error => {
                            showNotification('Terjadi kesalahan saat menghapus video: ' + error.message,
                                'error');
                            loadingOverlay.classList.remove('active');
                        });
                });
            }

            // Search form handler
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    selectedVideos.clear();
                    if (selectAllCheckbox) selectAllCheckbox.checked = false;
                    updateDeleteAllButton();
                    loadVideos(1);
                });
            }

            // Clear search handler
            if (clearSearch) {
                clearSearch.addEventListener('click', function() {
                    searchInput.value = '';
                    clearSearch.style.display = 'none';
                    selectedVideos.clear();
                    if (selectAllCheckbox) selectAllCheckbox.checked = false;
                    updateDeleteAllButton();
                    loadVideos(1);
                });
            }

            // Limit change handler
            if (limitSelect) {
                limitSelect.addEventListener('change', function() {
                    selectedVideos.clear();
                    if (selectAllCheckbox) selectAllCheckbox.checked = false;
                    updateDeleteAllButton();
                    loadVideos(1);
                });
            }

            // Function to load videos via AJAX
            function loadVideos(page = 1) {
                const search = searchInput.value;
                const limit = limitSelect.value;

                loadingOverlay.classList.add('active');

                const url = new URL(window.location);
                url.searchParams.set('page', page);
                url.searchParams.set('search', search);
                url.searchParams.set('limit', limit);
                window.history.pushState({}, '', url);

                fetch(`/admin/videos?page=${page}&search=${search}&limit=${limit}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newTableBody = doc.getElementById('videoTableBody');
                        if (newTableBody) {
                            document.getElementById('videoTableBody').innerHTML = newTableBody.innerHTML;
                        }

                        const newPaginationCard = doc.getElementById('paginationCard');
                        const currentPaginationCard = document.getElementById('paginationCard');

                        if (newPaginationCard) {
                            if (currentPaginationCard) {
                                currentPaginationCard.innerHTML = newPaginationCard.innerHTML;
                            } else {
                                document.getElementById('contentContainer').insertAdjacentHTML('beforeend',
                                    newPaginationCard.outerHTML);
                            }
                        } else {
                            if (currentPaginationCard) {
                                currentPaginationCard.remove();
                            }
                        }

                        const newTotalVideos = doc.getElementById('totalVideos');
                        const newLastUpdate = doc.getElementById('lastUpdate');

                        if (newTotalVideos) {
                            document.getElementById('totalVideos').textContent = newTotalVideos.textContent;
                        }
                        if (newLastUpdate) {
                            document.getElementById('lastUpdate').textContent = newLastUpdate.textContent;
                        }

                        clearSearch.style.display = search ? '' : 'none';

                        attachPaginationHandlers();
                        attachDeleteHandlers();
                        attachCheckboxHandlers();

                        document.getElementById('contentContainer').classList.add('fade-content');

                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });

                        setTimeout(() => {
                            loadingOverlay.classList.remove('active');
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat memuat data', 'error');
                        loadingOverlay.classList.remove('active');
                    });
            }

            // Attach click handlers to pagination links
            function attachPaginationHandlers() {
                const paginationLinks = document.querySelectorAll('.pagination-wrapper .page-link');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page') || 1;
                        selectedVideos.clear();
                        if (selectAllCheckbox) selectAllCheckbox.checked = false;
                        updateDeleteAllButton();
                        loadVideos(page);
                    });
                });
            }

            // Attach delete form handlers
            function attachDeleteHandlers() {
                const deleteForms = document.querySelectorAll('.delete-form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        if (confirm('Yakin ingin menghapus video ini?')) {
                            loadingOverlay.classList.add('active');
                            const formData = new FormData(this);
                            const url = this.action;

                            fetch(url, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        showNotification(data.message ||
                                            'Video berhasil dihapus', 'success');
                                        selectedVideos.delete(form.dataset.id);
                                        updateDeleteAllButton();
                                        const url = new URL(window.location);
                                        const currentPage = url.searchParams.get('page') || 1;
                                        loadVideos(currentPage);
                                    } else {
                                        showNotification(data.message ||
                                            'Gagal menghapus video', 'error');
                                        loadingOverlay.classList.remove('active');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showNotification('Terjadi kesalahan saat menghapus video',
                                        'error');
                                    loadingOverlay.classList.remove('active');
                                });
                        }
                    });
                });
            }

            // Initial attachment
            attachPaginationHandlers();
            attachDeleteHandlers();
            attachCheckboxHandlers();

            // Show notification if exists
            @if (session('success'))
                showNotification("{{ session('success') }}", 'success');
            @endif

            @if (session('error'))
                showNotification("{{ session('error') }}", 'error');
            @endif
        });

        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            const bgColor = type === 'success' ? '#22c55e' : '#ef4444';

            notification.innerHTML = `
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-${icon} fa-lg"></i>
                    <span>${message}</span>
                </div>
            `;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: #fff;
                padding: 12px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 10000;
                font-size: 14px;
                font-weight: 500;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '1';
            }, 100);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
@endsection
