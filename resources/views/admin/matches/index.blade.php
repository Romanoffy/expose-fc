@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Pertandingan</h4>
                <p
                    class="mb-0"
                    style="color: var(--text-secondary);"
                >Kelola data pertandingan Expose FC</p>
            </div>
            <div class="d-flex gap-2">
                <button
                    class="btn btn-outline-info btn-sm"
                    onclick="location.reload()"
                    title="Refresh Status"
                >
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
                <a
                    href="/admin/matches/create"
                    class="btn btn-primary"
                >
                    <i class="fas fa-plus me-2"></i>Tambah Pertandingan
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div
            class="card"
            style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);"
        >
            <div class="card-body p-0">
                <!-- Card Header with Filters -->
                <div
                    class="border-bottom p-4"
                    style="border-color: var(--glass-border) !important;"
                >
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5
                                class="mb-1 text-white"
                                style="color: var(--text-primary); font-weight: 600;"
                            >Daftar Pertandingan</h5>
                            <p class="small mb-0 text-white">Total: <span
                                    id="totalMatches">{{ $matches_array->total() }}</span> pertandingan terdaftar</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-outline-secondary btn-sm text-white"
                                onclick="toggleFilters()"
                            >
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-outline-secondary btn-sm text-white">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <div
                        id="filterForm"
                        style="display: none;"
                    >
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small text-white">Kompetisi</label>
                                <select
                                    id="filterCompetition"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option value="">Semua Kompetisi</option>
                                    @foreach ($competitions as $competition)
                                        <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small text-white">Status</label>
                                <select
                                    id="filterStatus"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="0">Dijadwalkan</option>
                                    <option value="1">Live</option>
                                    <option value="2">Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small text-white">Venue</label>
                                <select
                                    id="filterVenue"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option value="">Semua Venue</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small text-white">Per Page</label>
                                <select
                                    id="filterLimit"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option
                                        value="10"
                                        {{ $limit == 10 ? 'selected' : '' }}
                                    >10</option>
                                    <option
                                        value="25"
                                        {{ $limit == 25 ? 'selected' : '' }}
                                    >25</option>
                                    <option
                                        value="50"
                                        {{ $limit == 50 ? 'selected' : '' }}
                                    >50</option>
                                    <option
                                        value="100"
                                        {{ $limit == 100 ? 'selected' : '' }}
                                    >100</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small text-white">&nbsp;</label>
                                <button
                                    type="button"
                                    onclick="resetFilters()"
                                    class="btn btn-outline-secondary w-100"
                                    title="Reset Filter"
                                    style="background: rgba(239, 68, 68, 0.7);"
                                >
                                    <i class="fas fa-redo me-1"></i>Reset
                                </button>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div
                            id="activeFilters"
                            class="d-flex align-items-center mt-3 flex-wrap gap-2"
                            style="display: none !important;"
                        >
                            <span class="small text-white">Filter aktif:</span>
                            <div id="filterBadges"></div>
                        </div>
                    </div>
                </div>

                <!-- Loading Overlay -->
                <div
                    id="loadingOverlay"
                    style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; border-radius: 16px;"
                >
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div
                            class="spinner-border text-primary"
                            role="status"
                        >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div
                    class="table-responsive"
                    style="position: relative;"
                >
                    <table
                        class="table-hover mb-0 table"
                        style="color: var(--text-secondary);"
                    >
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th
                                    class="border-0 px-4 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >ID</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Kompetisi</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Tim Home</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Tim Away</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Goals</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Pemenang</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Venue</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Status</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="matchesTableBody">
                            @include('admin.matches.partials.table-rows', [
                                'matches_array' => $matches_array,
                            ])
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    class="d-flex justify-content-between align-items-center border-top px-4 py-3"
                    style="border-color: var(--glass-border) !important;"
                    id="paginationContainer"
                >
                    <div class="text-muted small">
                        Menampilkan <span id="fromItem">{{ $matches_array->firstItem() ?? 0 }}</span> - <span
                            id="toItem"
                        >{{ $matches_array->lastItem() ?? 0 }}</span>
                        dari <span id="totalItems">{{ $matches_array->total() }}</span> pertandingan
                    </div>
                    <div id="paginationLinks">
                        {{ $matches_array->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div
                class="modal-content"
                style="background: var(--dark-card); border: 1px solid var(--glass-border);"
            >
                <div
                    class="modal-header"
                    style="border-color: var(--glass-border);"
                >
                    <h5
                        class="modal-title"
                        style="color: var(--text-primary);"
                    >
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        style="filter: invert(1);"
                    ></button>
                </div>
                <div
                    class="modal-body"
                    style="color: var(--text-secondary);"
                >
                    <p class="text-white">Apakah Anda yakin ingin menghapus pertandingan:</p>
                    <div
                        class="mb-3 rounded p-3"
                        style="background: var(--glass-bg); border: 1px solid var(--glass-border);"
                    >
                        <strong
                            id="deleteName"
                            style="color: var(--text-primary);"
                        ></strong>
                    </div>
                    <div
                        class="alert alert-warning mb-0"
                        style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);"
                    >
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data
                        terkait termasuk goals.
                    </div>
                </div>
                <div
                    class="modal-footer"
                    style="border-color: var(--glass-border);"
                >
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form
                        id="deleteForm"
                        method="POST"
                        style="display: inline;"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle filter form
        function toggleFilters() {
            const filterForm = document.getElementById('filterForm');
            filterForm.style.display = filterForm.style.display === 'none' ? 'block' : 'none';
        }

        // Delete confirmation
        function confirmDelete(id, name) {
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/matches/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Setup filter event listeners
            setupFilters();
        });

        // Setup Dynamic Filters
        function setupFilters() {
            const filterCompetition = document.getElementById('filterCompetition');
            const filterStatus = document.getElementById('filterStatus');
            const filterVenue = document.getElementById('filterVenue');
            const filterLimit = document.getElementById('filterLimit');

            // Check if elements exist before adding listeners
            if (filterCompetition) filterCompetition.addEventListener('change', applyFilters);
            if (filterStatus) filterStatus.addEventListener('change', applyFilters);
            if (filterVenue) filterVenue.addEventListener('change', applyFilters);
            if (filterLimit) filterLimit.addEventListener('change', applyFilters);
        }

        // Apply Filters with AJAX
        function applyFilters() {
            const filterCompetition = document.getElementById('filterCompetition');
            const filterStatus = document.getElementById('filterStatus');
            const filterVenue = document.getElementById('filterVenue');
            const filterLimit = document.getElementById('filterLimit');

            // Safe value retrieval with fallbacks
            const competition = filterCompetition ? filterCompetition.value : '';
            const status = filterStatus ? filterStatus.value : '';
            const venue = filterVenue ? filterVenue.value : '';
            const limit = filterLimit ? filterLimit.value : '10';

            // Build query parameters
            const params = new URLSearchParams();
            if (competition) params.append('competition', competition);
            if (status !== '') params.append('status', status);
            if (venue) params.append('venue', venue);
            if (limit) params.append('limit', limit);

            // Show loading
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) loadingOverlay.style.display = 'block';

            // Fetch filtered data
            fetch(`/admin/matches?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Safely update table body
                    const tableBody = document.getElementById('matchesTableBody');
                    if (tableBody && data.html) {
                        tableBody.innerHTML = data.html;
                    }

                    // Safely update pagination
                    const paginationLinks = document.getElementById('paginationLinks');
                    if (paginationLinks && data.pagination) {
                        paginationLinks.innerHTML = data.pagination;
                    }

                    // Safely update stats
                    const totalMatches = document.getElementById('totalMatches');
                    const fromItem = document.getElementById('fromItem');
                    const toItem = document.getElementById('toItem');
                    const totalItems = document.getElementById('totalItems');

                    if (totalMatches) totalMatches.textContent = data.total || 0;
                    if (fromItem) fromItem.textContent = data.from || 0;
                    if (toItem) toItem.textContent = data.to || 0;
                    if (totalItems) totalItems.textContent = data.total || 0;

                    // Update active filters display
                    updateActiveFilters();

                    // Reinitialize tooltips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });

                    // Hide loading
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                });
        }

        // Update Active Filters Display
        function updateActiveFilters() {
            const competition = document.getElementById('filterCompetition');
            const status = document.getElementById('filterStatus');
            const venue = document.getElementById('filterVenue');
            const activeFiltersDiv = document.getElementById('activeFilters');
            const filterBadges = document.getElementById('filterBadges');

            if (!competition || !status || !venue || !activeFiltersDiv || !filterBadges) {
                return; // Exit if elements don't exist
            }

            let badges = '';
            let hasFilters = false;

            if (competition.value) {
                hasFilters = true;
                const competitionText = competition.options[competition.selectedIndex]?.text || 'Unknown';
                badges += `<span class="badge bg-primary">
                    Kompetisi: ${competitionText}
                    <a href="javascript:void(0)" onclick="clearFilter('competition')" class="ms-1 text-white">×</a>
                </span>`;
            }

            if (status.value !== '') {
                hasFilters = true;
                const statusText = status.options[status.selectedIndex]?.text || 'Unknown';
                badges += `<span class="badge bg-info">
                    Status: ${statusText}
                    <a href="javascript:void(0)" onclick="clearFilter('status')" class="ms-1 text-white">×</a>
                </span>`;
            }

            if (venue.value) {
                hasFilters = true;
                const venueText = venue.options[venue.selectedIndex]?.text || 'Unknown';
                badges += `<span class="badge bg-warning text-dark">
                    Venue: ${venueText}
                    <a href="javascript:void(0)" onclick="clearFilter('venue')" class="text-dark ms-1">×</a>
                </span>`;
            }

            if (hasFilters) {
                badges += `<a href="javascript:void(0)" onclick="resetFilters()" class="badge bg-danger text-white">
                    <i class="fas fa-times me-1"></i>Hapus Semua Filter
                </a>`;
                activeFiltersDiv.style.display = 'flex';
            } else {
                activeFiltersDiv.style.display = 'none';
            }

            filterBadges.innerHTML = badges;
        }

        // Clear Individual Filter
        function clearFilter(filterType) {
            const filterElements = {
                'competition': document.getElementById('filterCompetition'),
                'status': document.getElementById('filterStatus'),
                'venue': document.getElementById('filterVenue')
            };

            const element = filterElements[filterType];
            if (element) {
                element.value = '';
                applyFilters();
            }
        }

        // Reset All Filters
        function resetFilters() {
            const filterCompetition = document.getElementById('filterCompetition');
            const filterStatus = document.getElementById('filterStatus');
            const filterVenue = document.getElementById('filterVenue');
            const filterLimit = document.getElementById('filterLimit');

            if (filterCompetition) filterCompetition.value = '';
            if (filterStatus) filterStatus.value = '';
            if (filterVenue) filterVenue.value = '';
            if (filterLimit) filterLimit.value = '10';

            applyFilters();
        }

        // Success/Error notification
        @if (session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if (session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

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
        select option {
            color: #000;
            background: #fff;
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

        @keyframes blink-live {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        .blink-live {
            animation: blink-live 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
        }

        .pulse-badge {
            animation: pulse 2s infinite;
        }
    </style>
@endsection
