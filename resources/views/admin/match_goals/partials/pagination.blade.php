{{-- resources/views/admin/match_goals/partials/pagination.blade.php --}}
@if ($matches->hasPages())
    <div class="d-flex justify-content-between align-items-center border-top px-4 py-3" style="border-color: var(--glass-border) !important;">
        <div class="text-muted small">
            Menampilkan <span id="fromItem">{{ $matches->firstItem() ?? 0 }}</span> - <span id="toItem">{{ $matches->lastItem() ?? 0 }}</span>
            dari <span id="totalItems">{{ $matches->total() }}</span> pertandingan
        </div>
        <div id="paginationLinks">
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($matches->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $matches->currentPage() - 1 }})">‹</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max(1, $matches->currentPage() - 2);
                        $end = min($matches->lastPage(), $matches->currentPage() + 2);
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="changePage(1)">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $matches->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $i }})">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor

                    @if($end < $matches->lastPage())
                        @if($end < $matches->lastPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $matches->lastPage() }})">{{ $matches->lastPage() }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($matches->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $matches->currentPage() + 1 }})">›</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">›</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif