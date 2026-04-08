@php
    $paginationData = isset($matches) ? $matches : $matches_array;
@endphp

@if ($paginationData->hasPages())
    <nav>
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginationData->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $paginationData->currentPage() - 1 }})">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginationData->getUrlRange(1, $paginationData->lastPage()) as $page => $url)
                @if ($page == $paginationData->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $page }})">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginationData->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $paginationData->currentPage() + 1 }})">›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">›</span>
                </li>
            @endif
        </ul>
    </nav>

    <script>
        function changePage(page) {
            const competition = document.getElementById('filterCompetition');
            const status = document.getElementById('filterStatus');
            const venue = document.getElementById('filterVenue');
            const limit = document.getElementById('filterLimit');

            // Safe value retrieval with fallbacks
            const competitionValue = competition ? competition.value : '';
            const statusValue = status ? status.value : '';
            const venueValue = venue ? venue.value : '';
            const limitValue = limit ? limit.value : '10';

            // Build query parameters
            const params = new URLSearchParams();
            if (competitionValue) params.append('competition', competitionValue);
            if (statusValue !== '') params.append('status', statusValue);
            if (venueValue) params.append('venue', venueValue);
            if (limitValue) params.append('limit', limitValue);
            params.append('page', page);

            // Show loading
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) loadingOverlay.style.display = 'block';

            // Fetch page data
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
                
                // Reinitialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                
                // Hide loading
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                
                // Scroll to top of table
                const tableResponsive = document.querySelector('.table-responsive');
                if (tableResponsive) {
                    tableResponsive.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error notification if function exists
                if (typeof showNotification === 'function') {
                    showNotification('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
                }
                
                // Hide loading
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            });
        }
    </script>
@endif