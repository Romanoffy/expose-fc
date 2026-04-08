@extends('layouts.dashboard')
<style>
    #searchInput::placeholder {
        color: white;
        opacity: 1;
    }

    
</style>
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4
                    class="mb-1"
                    style="color: var(--text-primary); font-weight: 600;"
                >Manajemen Goal Pertandingan</h4>
                <p
                    class="mb-0 text-white"
                    style="color: var(--text-secondary);"
                >Pilih pertandingan untuk mengelola goal</p>
            </div>
            <div class="d-flex gap-2">
                <button
                    class="btn btn-outline-info btn-sm text-white"
                    onclick="applyFilters()"
                    title="Refresh"
                >
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
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
                            <p class="small mb-0 text-white">Total: <span id="totalMatches">{{ $matches->total() }}</span>
                                pertandingan</p>
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
                            <div class="col-md-4">
                                <label class="form-label small text-white">Cari Pertandingan</label>
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Cari tim..."
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small text-white">Kompetisi</label>
                                <select
                                    id="filterCompetition"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option value="">Semua Kompetisi</option>
                                    @foreach (\App\Models\Competitions::orderBy('name')->get() as $competition)
                                        <option
                                            value="{{ $competition->id }}"
                                            {{ request('competition') == $competition->id ? 'selected' : '' }}
                                        >
                                            {{ $competition->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small text-white">Status</label>
                                <select
                                    id="filterStatus"
                                    class="form-control"
                                    style="background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"
                                >
                                    <option value="">Semua Status</option>
                                    <option
                                        value="0"
                                        {{ request('status') === '0' ? 'selected' : '' }}
                                    >Dijadwalkan</option>
                                    <option
                                        value="1"
                                        {{ request('status') === '1' ? 'selected' : '' }}
                                    >Live</option>
                                    <option
                                        value="2"
                                        {{ request('status') === '2' ? 'selected' : '' }}
                                    >Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small text-white">&nbsp;</label>
                                <button
                                    type="button"
                                    onclick="resetFilters()"
                                    class="btn btn-outline-secondary w-100"
                                    style="background:rgba(239, 68, 68, 0.7);"
                                    title="Reset Filter"
                                >
                                    <i class="fas fa-redo me-1"></i>Reset
                                </button>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div
                            id="activeFiltersContainer"
                            class="d-flex align-items-center mt-3 flex-wrap gap-2"
                            style="display: none !important;"
                        >
                            <span class="small text-white">Filter aktif:</span>
                            <div
                                id="activeFilterBadges"
                                class="d-flex flex-wrap gap-2"
                            ></div>
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
                                >Pertandingan</th>
                                <th
                                    class="border-0 py-3 text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Tanggal</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Skor</th>
                                <th
                                    class="border-0 py-3 text-center text-black"
                                    style="font-weight: 600; font-size: 13px;"
                                >Goals</th>
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
                            @include('admin.match_goals.partials.table-rows', ['matches' => $matches])
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="paginationContainer">
                    @if ($matches->hasPages())
                        <div
                            class="d-flex justify-content-between align-items-center border-top px-4 py-3"
                            style="border-color: var(--glass-border) !important;"
                        >
                            <div class="text-muted small">
                                Menampilkan <span id="fromItem">{{ $matches->firstItem() ?? 0 }}</span> - <span
                                    id="toItem"
                                >{{ $matches->lastItem() ?? 0 }}</span>
                                dari <span id="totalItems">{{ $matches->total() }}</span> pertandingan
                            </div>
                            <div id="paginationLinks">
                                {{ $matches->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        let currentPage = 1;

        // Toggle filter form
        function toggleFilters() {
            const filterForm = document.getElementById('filterForm');
            filterForm.style.display = filterForm.style.display === 'none' ? 'block' : 'none';
        }

        // Apply filters with AJAX
        function applyFilters(page = 1) {
            currentPage = page;

            const search = document.getElementById('searchInput').value;
            const competition = document.getElementById('filterCompetition').value;
            const status = document.getElementById('filterStatus').value;

            // Build query parameters
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (competition) params.append('competition', competition);
            if (status !== '') params.append('status', status);
            if (page > 1) params.append('page', page);

            // Update URL without refresh
            const newUrl = `{{ route('match_goals.index') }}${params.toString() ? '?' + params.toString() : ''}`;
            window.history.pushState({}, '', newUrl);

            // Show loading
            document.getElementById('loadingOverlay').style.display = 'block';

            // Fetch filtered data
            fetch(newUrl, {
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
                    // Update table body
                    const tableBody = document.getElementById('matchesTableBody');
                    if (tableBody && data.html) {
                        tableBody.innerHTML = data.html;
                    }

                    // Update pagination
                    const paginationContainer = document.getElementById('paginationContainer');
                    if (paginationContainer && data.pagination) {
                        paginationContainer.innerHTML = data.pagination;
                    }

                    // Update stats
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
                    reinitializeTooltips();

                    // Hide loading
                    document.getElementById('loadingOverlay').style.display = 'none';

                    // Scroll to top of table
                    document.querySelector('.table-responsive').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
                    document.getElementById('loadingOverlay').style.display = 'none';
                });
        }

        // Handle pagination clicks
        function changePage(page) {
            applyFilters(page);
        }

        // Update active filters display
        function updateActiveFilters() {
            const search = document.getElementById('searchInput').value;
            const competition = document.getElementById('filterCompetition').value;
            const status = document.getElementById('filterStatus').value;

            const container = document.getElementById('activeFiltersContainer');
            const badgesDiv = document.getElementById('activeFilterBadges');

            let badges = '';
            let hasFilters = false;

            if (search) {
                hasFilters = true;
                badges += `<span class="badge bg-primary">
                    Pencarian: ${search}
                    <a href="javascript:void(0)" onclick="clearFilter('search')" class="ms-1 text-white">×</a>
                </span>`;
            }

            if (competition) {
                hasFilters = true;
                const competitionText = document.getElementById('filterCompetition').options[document.getElementById(
                    'filterCompetition').selectedIndex].text;
                badges += `<span class="badge bg-info">
                    Kompetisi: ${competitionText}
                    <a href="javascript:void(0)" onclick="clearFilter('competition')" class="ms-1 text-white">×</a>
                </span>`;
            }

            if (status !== '') {
                hasFilters = true;
                const statusLabels = {
                    '0': 'Dijadwalkan',
                    '1': 'Live',
                    '2': 'Selesai'
                };
                badges += `<span class="badge bg-warning text-dark">
                    Status: ${statusLabels[status]}
                    <a href="javascript:void(0)" onclick="clearFilter('status')" class="text-dark ms-1">×</a>
                </span>`;
            }

            if (hasFilters) {
                badges += `<a href="javascript:void(0)" onclick="resetFilters()" class="badge bg-danger text-white">
                    <i class="fas fa-times me-1"></i>Hapus Semua Filter
                </a>`;
                container.style.display = 'flex';
            } else {
                container.style.display = 'none';
            }

            badgesDiv.innerHTML = badges;
        }

        // Clear individual filter
        function clearFilter(filterType) {
            if (filterType === 'search') {
                document.getElementById('searchInput').value = '';
            } else if (filterType === 'competition') {
                document.getElementById('filterCompetition').value = '';
            } else if (filterType === 'status') {
                document.getElementById('filterStatus').value = '';
            }
            applyFilters();
        }

        // Reset all filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterCompetition').value = '';
            document.getElementById('filterStatus').value = '';

            // Update URL
            window.history.pushState({}, '', '{{ route('match_goals.index') }}');

            applyFilters();
        }

        // Reinitialize tooltips
        function reinitializeTooltips() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                // Dispose old tooltip
                const oldTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                if (oldTooltip) {
                    oldTooltip.dispose();
                }
                // Create new tooltip
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            reinitializeTooltips();

            // Update active filters on load
            updateActiveFilters();

            // Auto-apply filters on input change (with debounce)
            const searchInput = document.getElementById('searchInput');
            const competitionSelect = document.getElementById('filterCompetition');
            const statusSelect = document.getElementById('filterStatus');

            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => applyFilters(), 500);
            });

            competitionSelect.addEventListener('change', function() {
                applyFilters();
            });

            statusSelect.addEventListener('change', function() {
                applyFilters();
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                location.reload();
            });
        });

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
