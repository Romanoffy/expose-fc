@extends('layouts.main')

<style>
    .team-vs .team-1,
    .team-vs .team-2 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* Team details wrapper */
    .team-details {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    /* LOGO TEAM - PRESISI TINGGI */
    .team-details img {
        width: 100px !important;
        height: 100px !important;
        object-fit: contain !important;
        object-position: center !important;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .team-details img:hover {
        transform: scale(1.05);
    }

    /* Team name */
    .team-details h3 {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        text-align: center;
        line-height: 1.3;
    }

    /* Next Match Section */
    .widget-next-match {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .widget-title h3 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .widget-vs {
        margin: 20px 0;
    }

    .widget-vs .team-1 img,
    .widget-vs .team-2 img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        transition: all 0.3s ease;
    }

    .widget-vs .team-1 img:hover,
    .widget-vs .team-2 img:hover {
        transform: scale(1.1);
        filter: drop-shadow(0 8px 16px rgba(59, 130, 246, 0.4));
    }

    .widget-vs h3 {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 10px;
    }

    .vs span {
        display: inline-block;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: #fff;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .widget-vs-contents h4 {
        color: #3b82f6;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .widget-vs-contents p {
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .widget-vs-contents strong {
        color: #10b981 !important;
        font-size: 1.1rem;
    }

    /* Upcoming Match Cards */
    .bg-light {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95)) !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .bg-light:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
    }

    /* Section Title */
    .title-section h2 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .team-vs .score {
            font-size: 2rem;
        }

        .team-details img {
            width: 70px !important;
            height: 70px !important;
        }

        .team-details h3 {
            font-size: 1rem;
        }

        .widget-vs .team-1 img,
        .widget-vs .team-2 img {
            width: 60px;
            height: 60px;
        }

        .vs span {
            padding: 8px 20px;
            font-size: 1rem;
        }
    }
</style>

@section('content')
    <div
        class="hero overlay"
        style="background-image: url('assets/client/images/bg_7.jpg');"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mx-auto text-center">
                    <h1 class="text-white">Matches</h1>
                    <p>Kolom pertandingan dimana hasil dari pertandingan dan jadwal yang akan datang dari
                        kompetisi yang tim EXPOSE ikuti</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Match Results Section --}}
    <div
        class="container"
        style="background: rgb(10, 14, 24);"
    >
        <div class="row">
            @forelse ($matches_array as $match)
                <div class="col-lg-12">
                    <div class="team-vs">
                        <span class="score">{{ $match->score_team1 ?? 0 }}-{{ $match->score_team2 ?? 0 }}</span>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="team-1 w-50">
                                <div class="team-details">
                                    <img
                                        src="{{ asset('storage/' . $match->team_logo_1) }}"
                                        alt="{{ $match->teamname_1 }}"
                                        class="img-fluid rounded-circle"
                                    >
                                    <h3>{{ $match->teamname_1 }}</h3>
                                </div>
                            </div>

                            <div class="team-2 w-50">
                                <div class="team-details">
                                    <img
                                        src="{{ asset('storage/' . $match->team_logo_2) }}"
                                        alt="{{ $match->teamname_2 }}"
                                        class="img-fluid rounded-circle"
                                    >
                                    <h3>{{ $match->teamname_2 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <p style="color: #94a3b8; font-size: 1.2rem;">Belum ada pertandingan yang selesai</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Next & Upcoming Matches Section --}}
    <div
        class="site-section"
        style="background: rgb(10, 14, 24); padding: 50px 0;"
    >
        <div class="container">
            {{-- Next Match --}}
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="widget-next-match">
                        <div class="widget-title">
                            <h3>Next Match</h3>
                        </div>

                        @forelse ($next_matches_array as $match)
                            <div class="widget-body mb-3">
                                <div class="widget-vs">
                                    <div
                                        class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                        <div class="team-1 text-center team-details">
                                            <img
                                                src="{{ asset('storage/' . $match->team_logo_1) }}"
                                                alt="{{ $match->teamname_1 }}"
                                                class="rounded-circle"
                                            >
                                            <h3>{{ $match->teamname_1 }}</h3>
                                        </div>
                                        <div>
                                            <span class="vs"><span>VS</span></span>
                                        </div>
                                        <div class="team-2 text-center team-details">
                                            <img
                                                src="{{ asset('storage/' . $match->team_logo_2) }}"
                                                alt="{{ $match->teamname_2 }}"
                                                class="rounded-circle"
                                            >
                                            <h3>{{ $match->teamname_2 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-vs-contents mb-4 text-center">
                                <h4>{{ $match->competition_name ?? 'Competition' }}</h4>
                                <p class="mb-5">
                                    <span class="d-block">📅
                                        {{ \Carbon\Carbon::parse($match->date)->format('d F Y, H:i') }} WIB</span>
                                    <strong class="text-primary">🏟️ {{ $match->venue_name ?? 'Venue TBD' }}</strong>
                                </p>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <p style="color: #94a3b8;">Belum ada pertandingan selanjutnya</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Upcoming Matches --}}
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading">Upcoming Matches</h2>
                </div>

                @forelse ($upcoming_matches_array as $match)
                    <div class="col-lg-6 mb-4">
                        <div class="bg-light rounded p-4">
                            <div class="widget-body">
                                <div class="widget-vs">
                                    <div
                                        class="d-flex align-items-center justify-content-around justify-content-between w-100">
                                        <div class="team-1 text-center team-details">
                                            <img
                                                src="{{ asset('storage/' . $match->team_logo_1) }}"
                                                alt="{{ $match->teamname_1 }}"
                                                class="rounded-circle"
                                            >
                                            <h3>{{ $match->teamname_1 }}</h3>
                                        </div>
                                        <div>
                                            <span class="vs"><span>VS</span></span>
                                        </div>
                                        <div class="team-2 text-center team-details">
                                            <img
                                                src="{{ asset('storage/' . $match->team_logo_2) }}"
                                                alt="{{ $match->teamname_2 }}"
                                                class="rounded-circle"
                                            >
                                            <h3>{{ $match->teamname_2 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-vs-contents mb-4 text-center">
                                <h4>{{ $match->competition_name ?? 'Competition' }}</h4>
                                <p class="mb-3">
                                    <span class="d-block">📅
                                        {{ \Carbon\Carbon::parse($match->date)->format('d F Y, H:i') }} WIB</span>
                                    <strong class="text-primary">🏟️ {{ $match->venue_name ?? 'Venue TBD' }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center">
                        <p style="color: #94a3b8; font-size: 1.2rem;">Belum ada pertandingan mendatang</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
