@extends('layouts.main')

@section('content')
    {{-- <!-- Hero Section -->
    <div class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 220px; display: flex; align-items: center; background-size: cover; background-position: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="mb-2 text-white"
                        style="font-size: clamp(1.8rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: 0.5px; line-height: 1.2; text-shadow: 0 2px 6px rgba(0,0,0,0.4);">
                        Player Profile
                    </h1>
                    <p class="mt-2 text-white"
                        style="font-size: clamp(0.9rem, 3.5vw, 1.1rem); font-weight: 300; opacity: 0.9;">
                        Profil lengkap pemain
                    </p>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Profile Content -->
    <div class="profile-page">
        <div class="container">

            <!-- Profile Card -->
            <div class="profile-card-wrapper">
                <div class="profile-card">
                    <h2 class="section-title">
                        <i class="fas fa-user"></i> Profile
                    </h2>

                    <div class="profile-content">
                        <!-- Photo Section -->
                        <div class="profile-photo-section">
                            <div class="profile-photo-wrapper">
                                <img
                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                    alt="Player Photo"
                                    class="profile-photo"
                                >
                            </div>
                            <p class="player-number">
                                 No.10
                            </p>
                        </div>

                        <!-- Info Section -->
                        <div class="profile-info-section">
                            <div class="info-table">
                                <div class="info-row">
                                    <div class="info-label">Name</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">Sherli Oktavia Armena</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Gender</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">Female</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Age</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">23</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Height</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">155 cm</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Weight</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">40 kg</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Team</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">
                                        <a
                                            href="#"
                                            class="info-link"
                                        > Expose FC</a>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">City</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">Kota Bandung</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Province</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">Jawa Barat</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Instagram</div>
                                    <div class="info-separator">:</div>
                                    <div class="info-value">
                                        <a
                                            href="https://instagram.com/sherli.armen"
                                            target="_blank"
                                            class="instagram-link"
                                        >
                                             sherli.armen
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Competitions Table -->
            <div class="profile-card-wrapper">
                <div class="profile-card">
                    <h2 class="section-title">
                        <i class="fas fa-trophy"></i> Competitions
                    </h2>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Competition</th>
                                    <th>Team</th>
                                    <th>Position</th>
                                    <th>Achievement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Year">2019</td>
                                    <td data-label="Competition">Honda DBL West Sumatera Series 2019 (Basketball Girls)</td>
                                    <td data-label="Team">Expose FC</td>
                                    <td data-label="Position">Player</td>
                                    <td data-label="Achievement">Big Eight</td>
                                </tr>
                                <tr>
                                    <td data-label="Year">2018</td>
                                    <td data-label="Competition">Liga Pelajar Indonesia 2018</td>
                                    <td data-label="Team">Expose FC</td>
                                    <td data-label="Position">Player</td>
                                    <td data-label="Achievement">Runner Up</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Matches Table -->
            <div class="profile-card-wrapper">
                <div class="profile-card">
                    <h2 class="section-title">
                        <i class="fas fa-futbol"></i> Matches
                    </h2>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Match</th>
                                    <th>Team</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Year">2019</td>
                                    <td data-label="Match">
                                        <a
                                            href="#"
                                            class="match-link"
                                        >PSAK vs Expose FC</a>
                                    </td>
                                    <td data-label="Team">Expose FC</td>
                                    <td data-label="Position">Player</td>
                                    <td data-label="Date">2019-07-31</td>
                                </tr>
                                <tr>
                                    <td data-label="Year">2019</td>
                                    <td data-label="Match">
                                        <a
                                            href="#"
                                            class="match-link"
                                        >Manchester United vs Expose FC</a>
                                    </td>
                                    <td data-label="Team">Expose FC</td>
                                    <td data-label="Position">Player</td>
                                    <td data-label="Date">2019-07-30</td>
                                </tr>
                                <tr>
                                    <td data-label="Year">2019</td>
                                    <td data-label="Match">
                                        <a
                                            href="#"
                                            class="match-link"
                                        >Expose FC vs Barcelona FC</a>
                                    </td>
                                    <td data-label="Team">Expose FC</td>
                                    <td data-label="Position">Player</td>
                                    <td data-label="Date">2019-07-28</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        :root {
            --primary-color: #007bff;
            --dark-bg: rgb(10, 14, 24);
            --card-bg: rgba(35, 41, 49, 0.95);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        .profile-page {
            background: var(--dark-bg);
            min-height: 100vh;
            padding-top: 250px;
        }

        .profile-card-wrapper {
            margin-bottom: 30px;
        }

        .profile-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: clamp(20px, 4vw, 30px);
        }

        .section-title {
            color: var(--text-primary);
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: var(--primary-color);
        }

        /* Profile Content Layout */
        .profile-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (min-width: 768px) {
            .profile-content {
                grid-template-columns: 250px 1fr;
                gap: 40px;
            }
        }

        @media (min-width: 992px) {
            .profile-content {
                grid-template-columns: 300px 1fr;
                gap: 50px;
            }
        }

        /* Photo Section */
        .profile-photo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-photo-wrapper {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 3/4;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.3);
            margin-bottom: 15px;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .player-number {
            color: var(--text-secondary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .player-number i {
            color: var(--primary-color);
        }

        * Info Table */ .profile-info-section {
            width: 100%;
            height: 100%;
            /* Ambil full height untuk sejajar dengan foto */
            display: flex;
            flex-direction: column;
        }

        .info-table {
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Gap dikurangi agar lebih compact */
            flex: 1;
            /* Ambil sisa space yang ada */
        }

        .info-row {
            display: grid;
            grid-template-columns: 100px 20px 1fr;
            /* Label width dikurangi */
            gap: 10px;
            align-items: start;
            padding: 10px 12px;
            /* Padding vertikal dikurangi */
            background: rgba(45, 52, 64, 0.4);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .info-row:hover {
            background: rgba(45, 52, 64, 0.6);
            transform: translateX(3px);
        }

        .info-label {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            /* Font size dikurangi sedikit */
        }

        .info-separator {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .info-value {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
            /* Font size dikurangi sedikit */
            word-break: break-word;
        }

        .info-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .info-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .instagram-link {
            color: #E4405F;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .instagram-link:hover {
            color: #C13584;
            transform: translateX(3px);
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .data-table thead {
            background: rgba(0, 123, 255, 0.1);
            border-bottom: 2px solid rgba(0, 123, 255, 0.5);
        }

        .data-table th {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 1.8vw, 0.85rem);
            text-transform: uppercase;
            font-weight: 700;
            padding: clamp(12px, 2vw, 16px) clamp(10px, 2vw, 15px);
            text-align: left;
            white-space: nowrap;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .data-table tbody tr:hover {
            background: rgba(0, 123, 255, 0.05);
        }

        .data-table td {
            padding: clamp(12px, 2vw, 16px) clamp(10px, 2vw, 15px);
            color: var(--text-secondary);
            vertical-align: top;
        }

        .match-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .match-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-page {
                padding: 230px 0;
            }

            .profile-card {
                padding: 20px 15px;
            }

            .section-title {
                font-size: 1.1rem;
                margin-bottom: 20px;
                padding-bottom: 12px;
            }

            .info-row {
                grid-template-columns: 100px 15px 1fr;
                gap: 8px;
                padding: 10px;
            }

            .info-label {
                font-size: 0.8rem;
            }

            .info-value {
                font-size: 0.85rem;
            }

            /* Mobile Table View */
            .data-table {
                border: 0;
            }

            .data-table thead {
                display: none;
            }

            .data-table tbody tr {
                display: block;
                margin-bottom: 20px;
                background: rgba(45, 52, 64, 0.4);
                border-radius: 8px;
                padding: 15px;
                border: 1px solid var(--border-color);
            }

            .data-table td {
                display: grid;
                grid-template-columns: 100px 1fr;
                gap: 10px;
                padding: 8px 0;
                border-bottom: 1px solid var(--border-color);
                text-align: left;
            }

            .data-table td:last-child {
                border-bottom: none;
            }

            .data-table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-secondary);
                font-size: 0.8rem;
                text-transform: uppercase;
            }
        }

        @media (max-width: 576px) {
            .profile-photo-wrapper {
                max-width: 250px;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .info-separator {
                display: none;
            }

            .info-label {
                font-weight: 700;
                color: var(--text-primary);
            }

            .data-table td {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .data-table td::before {
                font-size: 0.75rem;
                margin-bottom: 2px;
            }
        }

        /* Print Styles */
        @media print {
            .profile-page {
                background: white;
            }

            .profile-card {
                border: 1px solid #ddd;
                box-shadow: none;
                page-break-inside: avoid;
            }

            .info-link,
            .match-link,
            .instagram-link {
                color: #007bff !important;
                text-decoration: none;
            }
        }
    </style>
@endsection
