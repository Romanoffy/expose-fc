@extends('layouts.main')

@section('content')
    <style>
        /* ===================================
                                                                                                                                                                                                                                               MATCH SECTION - LOGO TEAM FIX
                                                                                                                                                                                                                                               =================================== */

        /* Team containers */
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

        /* NEWS SECTION STYLE */
        .post-entry-news {
            background: #2d3a4c;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .post-entry-news:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        .custom-card-image-news {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .caption-news {
            padding: 15px;
        }

        .caption-news h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #fff;
        }

        .caption-news .text h4 {
            font-size: 0.95rem;
            font-weight: 500;
            color: #ddd;
        }

        .caption-news span {
            font-size: 0.85rem;
            color: #ccc;
        }

        .modal-body-news {
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-image-news {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .news-description {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            line-height: 1.6;
            color: #333;
        }

        /* Style foto grid di modal */
        .gallery-photo-item {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .gallery-photo-item:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .post-entry {
            background: #2d3a4c;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .post-entry:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        .custom-card-image {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .caption {
            padding: 15px;
        }

        .caption h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .caption .text h4 {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .caption span {
            font-size: 0.85rem;
            color: #ffffff;
        }

        /* STYLE UMUM UNTUK SEMUA MODAL */
        .modal-body-custom {
            max-height: 75vh;
            overflow-y: auto;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            line-height: 1.6;
        }

        .modal-body-custom img {
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .modal-body-custom>div,
        .gallery-description,
        .description-content {
            color: #222;
            font-size: 1rem;
            word-break: break-word;
        }

        /* Scrollbar halus */
        .modal-body-custom::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body-custom::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        .modal-body-custom::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        /* NEWS MODAL */
        .modal-content-news {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header-custom {
            background: linear-gradient(135deg, #2d3a4c, #2d3a4c);
            border-bottom: none;
            padding: 18px 24px;
        }

        .modal-header-custom h5 {
            font-weight: 600;
            margin: 0;
            color: #ffffff;
        }

        .modal-header-custom .close span {
            color: #ffffff;
            font-size: 1.5rem;
        }

        .modal-subheader {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            padding: 10px 24px;
            font-size: 0.9rem;
            color: #555;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-body-news {
            padding: 20px 24px;
            max-height: 75vh;
            overflow-y: auto;
        }

        .modal-body-news img {
            width: 50%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .news-description {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            line-height: 1.7;
            color: #333;
            font-size: 1rem;
        }

        /* BLOGS MODAL */
        .modal-content-blogs {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
            overflow: hidden;
        }

        .modal-body-blogs {
            padding: 24px;
            max-height: 75vh;
            overflow-y: auto;
        }

        .modal-body-blogs img {
            width: 50%;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .modal-body-blogs>div {
            color: #222;
            font-size: 1rem;
            line-height: 1.7;
            word-break: break-word;
        }

        /* GALLERY MODAL */
        .modal-content-gallery {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-body-gallery {
            padding: 24px;
            max-height: 75vh;
            overflow-y: auto;
        }

        .modal-body-gallery img {
            border-radius: 12px;
            width: 50%;
            margin-bottom: 16px;
        }

        .gallery-description {
            color: #333;
            line-height: 1.6;
            font-size: 1rem;
            margin-top: 15px;
            word-break: break-word;
        }

        .standings-home-section {
            background: rgb(10, 14, 24);
            padding: 60px 0;
        }

        .competition-header-home {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: rgba(35, 41, 49, 0.95);
            border-radius: 12px 12px 0 0;
            border-bottom: 3px solid #007bff;
            flex-wrap: wrap;
            gap: 15px;
        }

        .competition-title-home {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .competition-title-home i {
            color: #007bff;
            margin-right: 10px;
        }

        .competition-badge-home {
            color: white;
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            white-space: nowrap;
        }

        .standings-table-wrapper-home {
            overflow-x: auto;
            background: rgba(35, 41, 49, 0.95);
            border-radius: 0 0 12px 12px;
        }

        .standings-table-home {
            width: 100%;
            border-collapse: collapse;
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        }

        .standings-table-home thead {
            background: rgba(0, 123, 255, 0.1);
            border-bottom: 2px solid rgba(0, 123, 255, 0.5);
        }

        .standings-table-home th {
            color: #94a3b8;
            font-size: clamp(0.65rem, 1.5vw, 0.75rem);
            text-transform: uppercase;
            font-weight: 700;
            padding: clamp(12px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
            white-space: nowrap;
        }

        .standings-table-home th:first-child {
            text-align: left;
            padding-left: clamp(15px, 2vw, 25px);
        }

        .standings-table-home tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .standings-table-home tbody tr:hover {
            background: rgba(0, 123, 255, 0.05);
        }

        .standings-table-home td {
            padding: clamp(12px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
            color: #94a3b8;
        }

        .standings-table-home td:first-child {
            text-align: left;
        }



        .position-cell-home {
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            color: #ffffff;
            padding-left: clamp(15px, 2vw, 25px) !important;
        }

        .team-cell-home {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: flex-start;
        }

        .team-logo-small-home {
            width: clamp(28px, 5vw, 35px);
            height: clamp(28px, 5vw, 35px);
            object-fit: contain;
            flex-shrink: 0;
        }

        .team-logo-placeholder-home {
            width: clamp(28px, 5vw, 35px);
            height: clamp(28px, 5vw, 35px);
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            flex-shrink: 0;
        }

        .team-name-home {
            color: #ffffff;
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .champion-badge-home {
            background: rgb(13, 18, 107);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: clamp(0.6rem, 1.5vw, 0.7rem);
            font-weight: 700;
            margin-left: 8px;
        }

        .qualification-badge-home {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .qual-champion-home {
            background: #fbbf24;
            box-shadow: 0 0 6px #fbbf24;
        }

        .qual-playoff-home {
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        .goal-diff-home {
            font-weight: 600;
        }

        .points-cell-home {
            color: white !important;
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .standings-footer-home {
            padding: 20px;
            text-align: center;
            background: rgba(35, 41, 49, 0.95);
            border-radius: 0 0 12px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-see-more-home {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .btn-see-more-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
            color: white;
            text-decoration: none;
        }

        .empty-state-home {
            text-align: center;
            padding: 80px 20px;
            background: rgba(35, 41, 49, 0.95);
            border-radius: 12px;
            color: #94a3b8;
        }

        .empty-state-home i {
            font-size: 4rem;
            opacity: 0.5;
            margin-bottom: 20px;
            color: #007bff;
        }

        .empty-state-home h4 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .empty-state-home p {
            font-size: 1.1rem;
            margin: 0;
        }

        @media (max-width: 576px) {

            .standings-table-home th,
            .standings-table-home td {
                padding: 8px 4px;
                font-size: 0.65rem;
            }

            .standings-table-home th {
                font-size: 0.6rem;
            }

            .position-cell-home {
                font-size: 0.75rem;
                padding-left: 8px !important;
            }

            .team-logo-small-home,
            .team-logo-placeholder-home {
                width: 22px;
                height: 22px;
            }

            .team-name-home {
                font-size: 0.7rem;
            }

            .champion-badge-home {
                font-size: 0.55rem;
                padding: 1px 4px;
            }

            .qualification-badge-home {
                width: 4px;
                height: 4px;
            }

            .points-cell-home {
                font-size: 0.85rem;
            }
        }

        .event-hero-content {
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            font-family: "Poppins", sans-serif;
            color: #fff;
        }

        .event-hero-content .container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            text-align: right;
            padding: 0 4rem;
            padding-top: 100px;
        }

        .event-hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.8rem;
            letter-spacing: -0.4px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .event-hero-content p {
            max-width: 460px;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.82);
            font-weight: 400;
        }

        /* === COUNTDOWN === */
        .event-hero-content #countdown-hero {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            padding: 14px 28px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            box-shadow: 0 0 20px rgba(0, 31, 255, 0.25);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .event-hero-content #countdown-hero>div {
            text-align: center;
            color: rgb(13, 18, 107);
            min-width: 65px;
        }

        .event-hero-content #countdown-hero h2 {
            font-size: 1.6rem;
            margin-bottom: 2px;
            color: white;
            font-weight: 600;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.2);
        }

        .event-hero-content #countdown-hero small {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        /* === TOMBOL === */
        .event-hero-content .btn {
            background: linear-gradient(90deg, #002fff, #03185c);
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            display: inline-block;
            box-shadow: 0 0 15px rgba(0, 31, 255, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .event-hero-content .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 25px rgba(0, 31, 255, 0.6);
        }

        .event-hero-content {
            z-index: 2;
            min-height: 100vh;
            text-align: right;
            padding-top: 0;
            padding-bottom: 0;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .gallery-photo-item {
                height: 150px;
            }

            .standings-home-section {
                padding: 40px 0;
            }

            .competition-header-home {
                padding: 15px;
                flex-direction: column;
                align-items: flex-start;
            }

            .competition-title-home {
                font-size: 1.2rem;
            }

            .competition-badge-home {
                font-size: 0.75rem;
                padding: 6px 12px;
            }

            .standings-table-home {
                font-size: 0.7rem;
            }

            .standings-table-home th,
            .standings-table-home td {
                padding: 10px 6px;
            }

            .position-cell-home {
                padding-left: 12px !important;
            }

            .team-cell-home {
                gap: 8px;
            }

            .team-logo-small-home,
            .team-logo-placeholder-home {
                width: 25px;
                height: 25px;
            }

            .btn-see-more-home {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .empty-state-home {
                padding: 60px 20px;
            }

            .empty-state-home i {
                font-size: 3rem;
            }

            .empty-state-home h4 {
                font-size: 1.2rem;
            }

            .empty-state-home p {
                font-size: 0.95rem;
            }

            .event-hero-content .container {
                padding: 0 2rem;
                padding-top: 40px;
                padding-bottom: 40px;
                min-height: 60vh;
                /* Lebih pendek di mobile */
            }

            .event-hero-content h1 {
                font-size: 2.2rem;
            }

            .event-hero-content p {
                font-size: 0.9rem;
                max-width: 100%;
            }

            .event-hero-content #countdown-hero {
                justify-content: center;
                flex-wrap: wrap;
                gap: 12px;
            }
        }
    </style>

    <!-- Background Slider -->
        @if ($sliders->count() > 0)
            <div id="heroBackgroundSlider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="4000"
                data-pause="false" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;">
                <div class="carousel-inner" style="height: 100%;">
                    @foreach ($sliders as $index => $slider)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 100%;">
                            <img class="d-block w-100" src="{{ asset('storage/' . $slider->gambar) }}"
                                alt="Background Slider {{ $index + 1 }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
                <ol class="carousel-indicators" style="z-index: 3;">
                    @foreach ($sliders as $index => $slider)
                        <li data-target="#heroBackgroundSlider" data-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
            </div>
        @else
            <div
                style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-size: cover; background-position: center; z-index: 0;">
            </div>
        @endif
        <div class="overlay"
            style="background: rgba(0, 0, 0, 0.404); position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0.1;">
        </div>
        <div
            class="position-relative d-flex flex-column flex-md-row align-items-end justify-content-center container text-white"
            style="z-index:2; min-height:100vh;"
        >
            {{-- event yg sebelah kanan --}}
            <div
                class="event-hero-content position-relative d-flex flex-column align-items-end justify-content-center container text-white">
                @if ($event_array->count() > 0)
                    @php
                        $latestEvent = $event_array->first();
                    @endphp

                    <h1
                        class="fw-bold display-4 mb-3"
                        style="font-size:3rem;"
                    >
                        {{ $latestEvent->nama }}
                    </h1>

                    <p
                        class="lead mb-4"
                        style="max-width: 500px;"
                    >{{ Str::words($latestEvent->description ?? 'Jangan lewatkan event seru kami', 20, '...') }}</p>

                    <div
                        id="countdown-hero"
                        class="d-flex justify-content-end fs-5 fw-bold mb-4 flex-wrap gap-3 text-white"
                    >
                    </div>

                    <a
                        href="{{ route('client.event') }}"
                        class="btn"
                    >
                        SEE MORE →
                    </a>

                    <script>
                        (function() {
                            const eventDate = new Date(
                                "{{ \Carbon\Carbon::parse($latestEvent->tanggal_mulai)->format('Y-m-d H:i:s') }}").getTime();
                            const el = document.getElementById('countdown-hero');

                            function updateCountdown() {
                                const now = new Date().getTime();
                                const distance = eventDate - now;

                                if (distance <= 0) {
                                    el.innerHTML = "<span class='text-success fw-bold'>🎉 Event Sedang Berlangsung!</span>";
                                    return;
                                }

                                const weeks = Math.floor(distance / (1000 * 60 * 60 * 24 * 7));
                                const days = Math.floor((distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                el.innerHTML = `
                            <div style="text-align:center; min-width:50px;">
                                <h2>${weeks}</h2><small>WEEKS</small>
                            </div>
                            <div style="text-align:center; min-width:50px;">
                                <h2>${days}</h2><small>DAYS</small>
                            </div>
                            <div style="text-align:center; min-width:50px;">
                                <h2>${hours}</h2><small>HR</small>
                            </div>
                            <div style="text-align:center; min-width:50px;">
                                <h2>${minutes}</h2><small>MIN</small>
                            </div>
                            <div style="text-align:center; min-width:50px;">
                                <h2>${seconds}</h2><small>SEC</small>
                            </div>
                        `;
                            }

                            updateCountdown();
                            setInterval(updateCountdown, 1000);
                        })();
                    </script>
                @else
                    <h1 class="display-4 mb-3 text-white">Event</h1>
                    <p class="lead mb-4">Jangan lewatkan event seru kami</p>
                    <a
                        href="{{ route('client.event') }}"
                        class="btn"
                    >
                        SEE MORE →
                    </a>
                @endif
            </div>
        </div>

    </div>
    </div>
    </div>




    {{-- Matches Section - DIPINDAHKAN KE SINI (SETELAH HERO) --}}
    <div class="container">
        @if ($latestFinishedMatch)
            {{-- Latest Finished Match --}}
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="d-flex team-vs">
                        <span
                            class="score">{{ $latestFinishedMatch->score_team1 }}-{{ $latestFinishedMatch->score_team2 }}</span>
                        <div class="team-1 w-50">
                            <div class="team-details w-100 text-center">
                                <img
                                    src="{{ asset('storage/' . $latestFinishedMatch->team_logo_1) }}"
                                    alt="Image"
                                    class="img-fluid rounded-circle"
                                >
                                <h3>{{ $latestFinishedMatch->teamname_1 }}</h3>
                            </div>
                        </div>
                        <div class="team-2 w-50">
                            <div class="team-details w-100 text-center">
                                <img
                                    src="{{ asset('storage/' . $latestFinishedMatch->team_logo_2) }}"
                                    alt="Image"
                                    class="img-fluid rounded-circle"
                                >
                                <h3>{{ $latestFinishedMatch->teamname_2 }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Match Action Buttons --}}
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button
                                class="btn btn-primary mx-2 px-4 py-2"
                                onclick="window.location.href='{{ route('tournament.match.detail.page', $latestFinishedMatch->id) }}'"
                                style="font-weight: 600; border-radius: 8px; background: rgb(13, 18, 107);"
                            >
                                <i class="fas fa-info-circle mr-2"></i>Detail Match
                            </button>
                            <button
                                class="btn btn-outline-light mx-2 px-4 py-2"
                                onclick="window.location.href='{{ url('/matches') }}'"
                                style="font-weight: 600; border-radius: 8px;"
                            >
                                <i class="fas fa-list mr-2"></i>View All Matches
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- News --}}
    <div class="latest-news section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading text-white">News</h2>
                </div>
            </div>
            <div class="carousel-swiper-wrapper">
                <div class="swiper newsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($news_array as $news)
                            <div class="swiper-slide">
                                <div
                                    class="post-card"
                                    data-toggle="modal"
                                    data-target="#modalNews{{ $news->id }}"
                                >
                                    <img
                                        src="{{ asset('storage/' . $news->picture) }}"
                                        alt="{{ $news->title }}"
                                        class="card-image-full"
                                    >
                                    <div class="card-overlay">
                                        <h3 class="card-title">{{ $news->title }}</h3>
                                        <p class="card-meta">
                                            {{ strftime('%A, %e %B %Y', strtotime($news->date)) }} &bullet;
                                            {{ $news->category_name }}
                                        </p>
                                        <span class="read-more-indicator">Read more →</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button
                    class="carousel-control-prev news-prev"
                    type="button"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next news-next"
                    type="button"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="see-more-container mt-4 text-right">
                <a
                    href="/news"
                    class="see-more-link text-primary"
                >See More »</a>
            </div>
        </div>
    </div>

    {{-- Modals News --}}
    @foreach ($news_array as $news)
        <div
            class="modal fade"
            id="modalNews{{ $news->id }}"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $news->title }}</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img
                            src="{{ asset('storage/' . $news->picture) }}"
                            alt="{{ $news->title }}"
                            class="modal-image-full"
                        >
                        <div>{!! $news->description !!}</div>
                    </div>
                    <div class="modal-footer">
                        <a
                            href="/detail-news/{{ $news->id }}"
                            class="btn btn-primary w-100"
                        >Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- standings --}}
    <div class="standings-home-section">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section mb-4">
                    <h2 class="heading">Standings</h2>
                </div>
            </div>

            @if ($firstCompetition)
                <div class="row">
                    <div class="col-lg-12">
                        {{-- Competition Header --}}
                        <div class="competition-header-home">
                            <h3 class="competition-title-home">
                                <i class="fas fa-trophy"></i>
                                Klasemen {{ $firstCompetition->name }}
                            </h3>
                            <span
                                class="competition-badge-home"
                                style="background: {{ match ($firstCompetition->category ?? 'internal') {
                                    'internal' => '#007bff',
                                    'external' => '#f59e0b',
                                    'friendly' => '#10b981',
                                    default => '#6b7280',
                                } }}"
                            >
                                {{ strtoupper($firstCompetition->category ?? 'INTERNAL') }}
                            </span>
                        </div>

                        @if ($homeStandings && count($homeStandings) > 0)
                            {{-- Standings Table --}}
                            <div class="standings-table-wrapper-home">
                                <table class="standings-table-home">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Team</th>
                                            <th>MP</th>
                                            <th>W</th>
                                            <th>D</th>
                                            <th>L</th>
                                            <th>GF</th>
                                            <th>GA</th>
                                            <th>GD</th>
                                            <th>PTS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($homeStandings as $index => $standing)
                                            <tr>
                                                <td class="position-cell-home">
                                                    @if ($index == 0)
                                                        <span class="qualification-badge-home qual-champion-home"></span>
                                                    @elseif($index < 4)
                                                        <span class="qualification-badge-home qual-playoff-home"></span>
                                                    @endif
                                                    {{ $index + 1 }}
                                                </td>
                                                <td>
                                                    <div class="team-cell-home">
                                                        @if ($standing->team->logo)
                                                            <img
                                                                src="{{ asset('storage/' . $standing->team->logo) }}"
                                                                alt="{{ $standing->team->name }}"
                                                                class="team-logo-small-home"
                                                            >
                                                        @else
                                                            <div class="team-logo-placeholder-home">
                                                                {{ substr($standing->team->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <span class="team-name-home">
                                                            {{ $standing->team->name }}
                                                            @if ($index == 0)
                                                                <span class="champion-badge-home">TOP</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>{{ $standing->matches_played }}</td>
                                                <td>{{ $standing->wins }}</td>
                                                <td>{{ $standing->draws }}</td>
                                                <td>{{ $standing->losses }}</td>
                                                <td>{{ $standing->goals_for }}</td>
                                                <td>{{ $standing->goals_against }}</td>
                                                <td
                                                    class="goal-diff-home"
                                                    style="color: {{ $standing->goal_difference >= 0 ? '#10b981' : '#ef4444' }}"
                                                >
                                                    {{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}
                                                </td>
                                                <td class="points-cell-home">{{ $standing->points }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- See More Button --}}
                            <div class="standings-footer-home">
                                <a
                                    href="/standings"
                                    class="btn-see-more-home"
                                >
                                    <i class="fas fa-th-list"></i> Lihat Semua Klasemen
                                </a>
                            </div>
                        @else
                            {{-- Empty State: Competition exists but no teams/matches --}}
                            <div class="empty-state-home">
                                <i class="fas fa-info-circle"></i>
                                <h4>Klasemen Masih Kosong</h4>
                                <p>Tim belum terdaftar atau pertandingan belum dimulai untuk kompetisi ini.</p>
                            </div>
                            {{-- See More Button --}}
                            <div class="standings-footer-home">
                                <a
                                    href="/standings"
                                    class="btn-see-more-home"
                                >
                                    <i class="fas fa-th-list"></i> Lihat Semua Klasemen
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- Empty State: No competitions --}}
                <div class="empty-state-home">
                    <i class="fas fa-trophy"></i>
                    <h4>Belum Ada Kompetisi</h4>
                    <p>Belum ada kompetisi yang ditambahkan. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>
    </div>



    {{-- Videos --}}
    <div class="site-section section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading text-white">Videos</h2>
                </div>
            </div>
            <div class="carousel-swiper-wrapper">
                <div class="swiper videoSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($video_array as $video)
                            <div class="swiper-slide">
                                <div class="video-card">
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
                                                ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg"
                                                : 'https://via.placeholder.com/400x225?text=No+Thumbnail');
                                    @endphp
                                    <img
                                        src="{{ $thumbnailUrl }}"
                                        alt="{{ $video->title }}"
                                        class="img-fluid"
                                    >
                                    <a
                                        href="{{ $video->link }}"
                                        class="play-overlay d-flex align-items-center justify-content-center"
                                        data-fancybox
                                    >
                                        <span class="play-icon"><span class="icon-play"></span></span>
                                        <div class="play-caption text-white">
                                            <h3 class="m-0">{{ Str::limit($video->title, 40, '...') }}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button
                    class="carousel-control-prev video-prev"
                    type="button"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next video-next"
                    type="button"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="see-more-container mt-4 text-right">
                <a
                    href="/videos"
                    class="see-more-link text-primary"
                >See More »</a>
            </div>
        </div>
    </div>

    {{-- Gallery --}}
    <div class="latest-gallery section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading text-white">Gallery</h2>
                </div>
            </div>
            <div class="carousel-swiper-wrapper">
                <div class="swiper gallerySwiper">
                    <div class="swiper-wrapper">
                        @php
                            $galleries = \App\Models\Gallery::with(['photos' => fn($q) => $q->where('status', 'Aktif')])
                                ->where('status', 'Aktif')
                                ->latest()
                                ->take(6)
                                ->get();
                        @endphp
                        @foreach ($galleries as $gallery)
                            @php
                                $firstPhoto = $gallery->thumbnail
                                    ? asset('storage/' . $gallery->thumbnail)
                                    : ($gallery->photos->first()
                                        ? asset('storage/' . $gallery->photos->first()->photo)
                                        : 'https://via.placeholder.com/400');
                            @endphp
                            <div class="swiper-slide">
                                <div
                                    class="post-card"
                                    data-toggle="modal"
                                    data-target="#modalGallery{{ $gallery->id }}"
                                >
                                    <img
                                        src="{{ $firstPhoto }}"
                                        alt="{{ $gallery->title }}"
                                        class="card-image-full"
                                    >
                                    <div class="card-overlay">
                                        <h3 class="card-title">{{ $gallery->title }}</h3>
                                        <p class="card-meta">
                                            {{ strftime('%A, %e %B %Y', strtotime($gallery->created_at)) }} &bullet;
                                            {{ $gallery->photos->count() }} Photos
                                        </p>
                                        <span class="read-more-indicator">Read more →</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button
                    class="carousel-control-prev gallery-prev"
                    type="button"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next gallery-next"
                    type="button"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="see-more-container mt-4 text-right">
                <a
                    href="/gallery"
                    class="see-more-link text-primary"
                >See More »</a>
            </div>
        </div>
    </div>

    {{-- Modals Gallery --}}
    @foreach ($galleries as $gallery)
        @php
            $firstPhoto = $gallery->thumbnail
                ? asset('storage/' . $gallery->thumbnail)
                : ($gallery->photos->first()
                    ? asset('storage/' . $gallery->photos->first()->photo)
                    : 'https://via.placeholder.com/400');
        @endphp
        <div
            class="modal fade"
            id="modalGallery{{ $gallery->id }}"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $gallery->title }}</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img
                            src="{{ $firstPhoto }}"
                            alt="{{ $gallery->title }}"
                            class="modal-image-full"
                        >
                        @if ($gallery->photos->count() > 0)
                            <div class="position-relative mt-3">
                                <div
                                    class="gallery-slider-wrapper"
                                    style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; scrollbar-width: thin; padding: 10px 0;"
                                >
                                    @foreach ($gallery->photos as $photo)
                                        <div
                                            class="d-inline-block"
                                            style="width: 200px; margin-right: 15px;"
                                        >
                                            <a
                                                href="{{ asset('storage/' . $photo->photo) }}"
                                                data-lightbox="gallery-{{ $gallery->id }}"
                                                data-title="{{ $photo->alt ?? $gallery->title }}"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $photo->photo) }}"
                                                    alt="{{ $photo->alt ?? $gallery->title }}"
                                                    class="gallery-photo-item"
                                                    style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px; cursor: pointer; display: block;"
                                                >
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($gallery->description)
                            <div class="mt-3 text-start">{!! $gallery->description !!}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a
                            href="/detail-gallery/{{ $gallery->id }}"
                            class="btn btn-primary w-100"
                        >Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Blog --}}
    <div class="site-section section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-12 title-section">
                    <h2 class="heading text-white">Blog</h2>
                </div>
            </div>
            <div class="carousel-swiper-wrapper">
                <div class="swiper blogSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($blogs_array as $blog)
                            <div class="swiper-slide">
                                <div
                                    class="post-card"
                                    data-toggle="modal"
                                    data-target="#modalBlog{{ $blog->id }}"
                                >
                                    <img
                                        src="{{ asset('storage/' . $blog->picture) }}"
                                        alt="{{ $blog->title }}"
                                        class="card-image-full"
                                    >
                                    <div class="card-overlay">
                                        <h3 class="card-title">{{ $blog->title }}</h3>
                                        <p class="card-meta">
                                            {{ strftime('%A, %e %B %Y', strtotime($blog->date)) }}
                                        </p>
                                        <span class="read-more-indicator">Read more →</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button
                    class="carousel-control-prev blog-prev"
                    type="button"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next blog-next"
                    type="button"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="see-more-container mt-4 text-right">
                <a
                    href="/blog"
                    class="see-more-link text-primary"
                >See More »</a>
            </div>
        </div>
    </div>

    {{-- Modals Blog --}}
    @foreach ($blogs_array as $blog)
        <div
            class="modal fade"
            id="modalBlog{{ $blog->id }}"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $blog->title }}</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img
                            src="{{ asset('storage/' . $blog->picture) }}"
                            alt="{{ $blog->title }}"
                            class="modal-image-full"
                        >
                        <div>{!! $blog->full_description !!}</div>
                    </div>
                    <div class="modal-footer">
                        <a
                            href="/detail-blog/{{ $blog->id }}"
                            class="btn btn-primary w-100"
                        >Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Swiper CSS --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    {{-- Swiper JS & Initialization --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // News Swiper
        var newsSwiper = new Swiper(".newsSwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".news-next",
                prevEl: ".news-prev",
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });

        // Gallery Swiper
        var gallerySwiper = new Swiper(".gallerySwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".gallery-next",
                prevEl: ".gallery-prev",
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });

        // Blog Swiper
        var blogSwiper = new Swiper(".blogSwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".blog-next",
                prevEl: ".blog-prev",
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });

        // Video Swiper
        var videoSwiper = new Swiper(".videoSwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".video-next",
                prevEl: ".video-prev",
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });
    </script>

    <style>
        /* GLOBAL SECTION */
        .section-spacing {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        /* === CONTAINER UNTUK MENJAGA JARAK ANTAR KARTU === */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(325px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* === CARD UNIVERSAL (News, Gallery, Blog, Videos) === */
        .post-card,
        .video-card {
            position: relative;
            background: #2d3a4c;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            height: auto;
            width: 100%;
            /* Diperbaiki dari 150% */
        }

        .post-card:hover,
        .video-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .post-card img.card-image-full,
        .video-card img {
            width: 100%;
            height: 385px;
            object-fit: cover;
            display: block;
            border-radius: 8px 8px 0 0;
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
            padding: 1rem;
            color: white;
            border-radius: 0 0 8px 8px;
        }

        .card-overlay .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .card-overlay .card-meta {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .card-overlay .read-more-indicator {
            font-size: 0.75rem;
            color: #1e90ff;
            font-weight: 600;
            display: block;
        }

        /* Carousel Wrapper */
        .carousel-swiper-wrapper {
            position: relative;
            padding: 20px 0 60px 0;
            width: 100%;
        }

        .newsSwiper,
        .gallerySwiper,
        .blogSwiper,
        .videoSwiper {
            overflow: hidden;
        }

        .swiper-slide {
            height: auto;
        }

        /* Navigation Buttons */
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 0;
            bottom: 60px;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
            padding: 0;
            color: #fff;
            background: none;
            border: 0;
            opacity: 0.5;
            transition: opacity 0.15s ease;
            cursor: pointer;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 0.9;
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            background-repeat: no-repeat;
            background-position: 50%;
            background-size: 100% 100%;
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e");
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        .visually-hidden {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }

        @media (min-width: 768px) {

            .carousel-control-prev,
            .carousel-control-next {
                width: 5%;
            }
        }

        /* MODAL */
        .modal-image-full {
            width: 70%;
            max-height: 400px;
            height: auto;
            object-fit: contain;
            object-position: center;
            border-radius: 12px 12px 0 0;
            padding: 12px;
            display: block;
            margin: 0 auto;
        }

        .modal-body {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-height: 75vh;
            overflow-y: auto;
            padding: 20px 24px;
            line-height: 1.6;
            color: #333;
        }

        .modal-footer .btn {
            font-weight: 600;
        }

        .modal-title {
            color: #000 !important;
        }

        /* SEE MORE */
        .see-more-link {
            font-weight: 600;
            text-decoration: none;
        }

        .see-more-link:hover {
            text-decoration: underline;
        }

        /* PHOTO MODAL */
        .gallery-photo-item {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .gallery-photo-item:hover {
            transform: scale(1.03);
        }

        /* VIDEO CARD */
        .play-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
            padding: 1rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .play-icon {
            background: #1e90ff;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .play-icon .icon-play {
            color: white;
            font-size: 1.1rem;
        }

        .play-caption h3 {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.3;
            color: white;
        }
    </style>
@endsection
