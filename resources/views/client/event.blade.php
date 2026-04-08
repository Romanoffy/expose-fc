@extends('layouts.main')

@section('content')

    {{-- HERO --}}
    <div
        class="hero overlay position-relative"
        style="background-image: url('{{ asset('assets/client/images/bg_8.jpg') }}');
           background-size: cover;
           background-position: center;
           height: 100vh;"
    >
        <div
            class="overlay position-absolute bottom-0 end-0 start-0 top-0"
            style="background: rgba(0,0,0,0.1);"
        ></div>
        <div class="position-relative d-flex flex-column justify-content-center h-100 container text-center">
            <h1 class="fw-bold mb-2 text-white">All Events</h1>
            <p class="text-light fs-5">Temukan berbagai acara menarik dari Expose dan dunia sepak bola!</p>
        </div>
    </div>

{{-- FILTER SECTION --}}
<div class="filter-section py-4">
    <div class="container">
        <div class="d-flex justify-content-end align-items-center mb-3 text-white">
            <a href="{{ route('client.event') }}" class="clear-all" id="clearFilters">Clear All</a>
        </div>
        <form id="filterForm" class="filter-form d-flex flex-wrap align-items-end gap-3" action="{{ route('client.event') }}" method="GET">
            <div class="filter-group d-flex flex-column">
                <label for="search" class="filter-label">Cari Event</label>
                <input type="text" name="search" id="search" class="filter-input" placeholder="Cari event..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group d-flex flex-column">
                <label for="from" class="filter-label">Dari Tanggal</label>
                <input type="date" name="from" id="from" class="filter-input" value="{{ request('from') }}">
            </div>
            <div class="filter-group d-flex flex-column">
                <label for="to" class="filter-label">Sampai Tanggal</label>
                <input type="date" name="to" id="to" class="filter-input" value="{{ request('to') }}">
            </div>
            <div class="filter-group d-flex flex-column">
                <label for="year" class="filter-label">Tahun</label>
                <select name="year" id="year" class="filter-select">
                    <option value="">All Years</option>
                    @foreach ($yearCounts as $yc)
                        <option value="{{ $yc->year }}" {{ request('year') == $yc->year ? 'selected' : '' }}>
                            {{ $yc->year }} ({{ $yc->total }} Events)
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

{{-- EVENT LIST --}}
<div class="site-section" style="background: linear-gradient(180deg, rgb(10, 14, 24)); padding: 60px 0;" id="eventResults">
    <div class="container">
        @if ($events->count() > 0)
            <div class="mb-4 d-flex justify-content-between align-items-center text-white event-result-header">
                <h4 class="section-header fw-bold">
                    Event <span class="text-gradient-strong">Result</span>
                </h4>
                <span class="text-muted small">{{ $events->count() }} Events</span>
            </div>

                @foreach ($events as $event)
                    @php
                        $now = \Carbon\Carbon::now();
                        $startDate = \Carbon\Carbon::parse($event->tanggal_mulai);
                        $endDate = \Carbon\Carbon::parse($event->tanggal_selesai);
                        if ($startDate->isFuture()) {
                            $badgeText = 'Mendatang';
                            $badgeColor = '#fbbf24';
                            $badgeIcon = '<i class="fas fa-hourglass-start"></i>';
                        } elseif ($startDate->isPast() && $endDate->isFuture()) {
                            $badgeText = 'Sedang Berlangsung';
                            $badgeColor = '#ef4444';
                            $badgeIcon = '<i class="fas fa-broadcast-tower"></i>';
                        } else {
                            $badgeText = 'Selesai';
                            $badgeColor = '#10b981';
                            $badgeIcon = '<i class="fas fa-check-circle"></i>';
                        }
                    @endphp

                    <div class="card event-card mb-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <img
                                    src="{{ asset('assets/client/images/bg_7.jpg') }}"
                                    alt="{{ $event->nama }}"
                                    class="img-fluid h-100 w-100 object-fit-cover event-img"
                                >
                            </div>
                            <div class="col-md-8 p-4 text-white">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span
                                        class="badge event-badge"
                                        style="background-color: {{ $badgeColor }}"
                                    >
                                        {!! $badgeIcon !!} {{ $badgeText }}
                                    </span>
                                    <span class="text-muted small">
                                        {{ $startDate->translatedFormat('d M') }} -
                                        {{ $endDate->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <h5 class="fw-bold">{{ $event->nama }}</h5>
                                <p class="match-info-text mb-1">📍 {{ $event->venue->name ?? '-' }}</p>
                                <p class="match-info-text mb-0">
                                    {{ $event->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="py-5 text-center text-white">
                    <div style="font-size: 5rem; opacity: 0.5;">⚽</div>
                    <h4
                        class="fw-semibold mt-3"
                        style="color: #cbd5e1;"
                    >No Matches Found</h4>
                    <p
                        class="text-muted"
                        style="font-size: 1.1rem;"
                    >Try adjusting your filters</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        :root {
            --blue-main: #002fff;
            --blue-dark: #03185c;
            --text-light: #e0e7ff;
            --bg-card: rgba(35, 41, 49, 0.95);
            --navy-gradient: linear-gradient(180deg, #04041F 0%, #0a0a2e 50%, #04041F 100%);
        }

    /* Filter Section */
    .filter-section {
        background: linear-gradient(115deg, rgb(10, 14, 24) 76%);
        box-shadow: 0 4px 25px rgba(0,0,0,0.4);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

        .clear-all {
            color: #fff;
            opacity: 0.8;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .clear-all:hover {
            opacity: 1;
            color: #fff;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1 1 180px;
        }

        .filter-label {
            color: #fff;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }

    .filter-input, .filter-select {
        background-color: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #fff;
        padding: 0.55rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s;
        appearance: none;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: var(--blue-main);
        box-shadow: 0 0 8px rgba(0, 47, 255, 0.6);
    }

    .filter-select option {
        background-color: #0a0a2e;
        color: #fff;
    }

        /* Event Result Title */
        .text-gradient-strong {
            background: linear-gradient(90deg, var(--blue-main), var(--blue-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            letter-spacing: 0.5px;
        }

        /* Event Card */
        .event-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 25px rgba(0, 47, 255, 0.25);
        }

        .event-badge {
            font-weight: 600;
            color: #000;
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 0.8rem;
        }

    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

{{-- AJAX filter tanpa reload halaman --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function(){
        function loadEvents(){
            let params = $('#filterForm').serialize();
            $.ajax({
                url: "{{ route('client.event') }}",
                type: 'GET',
                data: params,
                success: function(response){
                    let newContent = $(response).find('#eventResults').html();
                    $('#eventResults').html(newContent);
                    history.replaceState(null, null, "?" + params);
                },
                error: function(){
                    alert('Gagal load data event, coba lagi ya!');
                }
            });
        }

        // Auto filter saat input/select berubah tanpa tombol submit
        $('#filterForm').on('input change', 'input, select', function(){
            loadEvents();
        });

        // Clear all filter
        $('#clearFilters').click(function(e){
            e.preventDefault();
            $('#filterForm')[0].reset();
            loadEvents();
        });
    });
</script>

@endsection
