@extends('layouts.main')

@section('content')
    @php
        // Calculate category color and label at the top level
        $categoryCode = $competition->category ?? 'internal';
        $categoryColor = match ($categoryCode) {
            'internal' => '#007bff',
            'external' => '#f59e0b',
            'friendly' => '#10b981',
            default => '#6b7280',
        };
        $categoryLabel = match ($categoryCode) {
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly',
            default => ucfirst($categoryCode),
        };
    @endphp

    <!-- Hero Section -->
    <div
        class="hero overlay"
        style="
        background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}');
        min-height: 220px;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
    "
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1
                        class="mb-2 text-white"
                        style="
                        font-size: clamp(1.8rem, 5vw, 3.5rem);
                        font-weight: 800;
                        letter-spacing: 0.5px;
                        line-height: 1.2;
                        text-shadow: 0 2px 6px rgba(0,0,0,0.4);
                    "
                    >
                        {{ $match->teamname_1 }}
                        <span style="color: {{ $categoryColor }};">VS</span>
                        {{ $match->teamname_2 }}
                    </h1>
                    <p
                        class="mt-2 text-white"
                        style="
                        font-size: clamp(0.9rem, 3.5vw, 1.1rem);
                        font-weight: 300;
                        opacity: 0.9;
                    "
                    >
                        {{ $competition->event_type ?? 'Event' }} • {{ $categoryLabel }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: {{ $categoryColor }};
            --dark-bg: rgb(10, 14, 24);
            --card-bg: rgba(35, 41, 49, 0.95);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Hero Section */
        .hero-section {
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            position: relative;
            margin-bottom: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 14, 24, 0.7) 0%, rgba(10, 14, 24, 0.5) 100%);
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-content {
            text-align: center;
        }

        .hero-title {
            font-size: clamp(1.5rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .team-vs {
            display: block;
        }

        .vs-badge {
            display: inline-block;
            font-weight: 900;
        }

        .hero-subtitle {
            font-size: clamp(0.85rem, 3vw, 1.1rem);
            font-weight: 300;
            color: var(--text-primary);
            letter-spacing: 0.5px;
        }

        /* Sub Navbar Section */
        .sub-navbar-section {
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(10, 14, 24, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .sub-nav-links {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            flex: 1;
        }

        .sub-nav-link {
            color: white !important;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            white-space: nowrap;
            flex: 1;
            text-align: center;
            min-width: 120px;
        }

        .sub-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 123, 255, 0.2), transparent);
            transition: left 0.5s ease;
            z-index: -1;
        }

        .sub-nav-link:hover::before {
            left: 100%;
        }

        .sub-nav-link:hover {
            color: var(--text-primary);
            background: rgba(0, 123, 255, 0.1);
            transform: translateY(-2px);
        }

        .sub-nav-link.active {
            color: var(--text-primary);
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .back-button {
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 12px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: clamp(0.7rem, 2vw, 0.9rem);
            white-space: nowrap;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
            color: white;
        }

        /* Main Content */
        .match-detail-page {
            background: var(--dark-bg);
            min-height: 100vh;
            padding: 20px 0 40px;
        }

        .tab-content-section {
            display: none;
            animation: fadeIn 0.3s ease-in;
        }

        .tab-content-section.active {
            display: block;
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

        /* Match Card */
        .match-card {
            background: var(--card-bg) !important;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .match-card-header {
            border-top: 4px solid var(--primary-color);
            padding: clamp(15px, 5vw, 30px);
        }

        /* Team Section */
        .team-section {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: clamp(15px, 5vw, 30px);
            align-items: flex-start;
        }

        .team-column {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .team-logo-section {
            width: clamp(70px, 20vw, 120px);
            height: clamp(70px, 20vw, 120px);
            margin: 0 auto clamp(12px, 3vw, 20px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .team-logo-section img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(0, 123, 255, 0.3));
            transition: transform 0.3s ease;
        }

        .team-column:hover .team-logo-section img {
            transform: scale(1.05);
        }

        .team-name-large {
            color: var(--text-primary);
            font-size: clamp(0.9rem, 4vw, 1.5rem);
            font-weight: 700;
            margin-bottom: clamp(15px, 3vw, 25px);
            line-height: 1.3;
            word-break: break-word;
            text-align: center;
        }

        /* Goal Items */
        .goal-item {
            background: rgba(45, 52, 64, 0.6);
            border-radius: 10px;
            padding: clamp(10px, 3vw, 15px);
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .goal-item:hover {
            background: rgba(45, 52, 64, 0.9);
            transform: translateX(3px);
        }

        .player-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            flex-shrink: 0;
        }

        .goal-info {
            flex: 1;
            text-align: left;
            min-width: 0;
        }

        .goal-info p {
            margin: 0;
        }

        .player-name {
            color: var(--text-primary);
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .goal-time {
            color: var(--text-secondary);
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
        }

        /* Match Center */
        .match-center {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 100px;
        }

        .match-score {
            font-size: clamp(2rem, 8vw, 4rem);
            font-weight: 900;
            color: var(--text-primary);
            margin: clamp(15px, 3vw, 25px) 0;
            letter-spacing: -2px;
            line-height: 1;
        }

        .match-badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color)dd 100%);
            color: white;
            padding: clamp(6px, 2vw, 10px) clamp(12px, 3vw, 18px);
            border-radius: 16px;
            font-size: clamp(0.65rem, 1.8vw, 0.85rem);
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: clamp(10px, 2vw, 15px);
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            white-space: nowrap;
        }

        .match-status {
            background: #10b981;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: clamp(0.7rem, 1.8vw, 0.8rem);
            display: inline-block;
            margin-top: clamp(10px, 2vw, 15px);
        }

        .match-status.upcoming {
            background: #fbbf24;
            color: #000;
        }

        .match-info-grid {
            margin-top: clamp(15px, 3vw, 20px);
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .match-info-item {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 2vw, 0.85rem);
        }

        /* Stats Section */
        .stats-section {
            background: rgba(45, 52, 64, 0.5);
            border-radius: 12px;
            padding: clamp(15px, 4vw, 25px);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .section-title {
            color: var(--text-primary);
            font-size: clamp(1rem, 4vw, 1.3rem);
            font-weight: 700;
            margin-bottom: clamp(15px, 3vw, 20px);
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary-color);
        }

        /* H2H Grid */
        .h2h-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .h2h-stat {
            text-align: center;
            padding: clamp(15px, 3vw, 20px);
            border-radius: 10px;
            border: 2px solid;
            background: rgba(0, 123, 255, 0.05);
            transition: all 0.3s ease;
        }

        .h2h-stat:hover {
            background: rgba(0, 123, 255, 0.1);
            transform: translateY(-2px);
        }

        .h2h-stat-number {
            font-size: clamp(1.8rem, 6vw, 2.8rem);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .h2h-stat-label {
            font-size: clamp(0.6rem, 1.5vw, 0.7rem);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
        }

        /* H2H Match */
        .h2h-match {
            background: rgba(55, 62, 74, 0.5);
            border-radius: 10px;
            padding: clamp(15px, 3vw, 25px);
            margin-bottom: 12px;
            border: 1px solid var(--border-color);
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: clamp(12px, 3vw, 20px);
            align-items: center;
            transition: all 0.3s ease;
        }

        .h2h-match:hover {
            background: rgba(55, 62, 74, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .h2h-team {
            text-align: center;
        }

        .h2h-team img {
            width: clamp(45px, 15vw, 70px);
            height: clamp(45px, 15vw, 70px);
            margin: 0 auto clamp(8px, 2vw, 12px);
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
        }

        .h2h-team:hover img {
            transform: scale(1.1);
        }

        .h2h-team-name {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            font-weight: 500;
        }

        .h2h-score {
            text-align: center;
            font-weight: 900;
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            letter-spacing: -1px;
            color: var(--primary-color);
        }

        .h2h-date {
            color: var(--text-secondary);
            font-size: clamp(0.7rem, 1.8vw, 0.8rem);
            text-align: center;
            grid-column: 2;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .detail-item {
            background: rgba(45, 52, 64, 0.4);
            border-radius: 10px;
            padding: clamp(12px, 3vw, 15px);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: rgba(45, 52, 64, 0.6);
        }

        .detail-label {
            color: var(--text-secondary);
            font-size: clamp(0.6rem, 1.5vw, 0.7rem);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .detail-value {
            color: var(--text-primary);
            font-size: clamp(0.85rem, 2.5vw, 1rem);
            font-weight: 600;
        }

        .no-goals {
            background: rgba(45, 52, 64, 0.3);
            border-radius: 10px;
            padding: clamp(15px, 3vw, 20px);
            border: 1px dashed var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        /* Standings Table */
        .standings-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        }

        .standings-table thead {
            background: rgba(0, 123, 255, 0.1);
            border-bottom: 2px solid rgba(0, 123, 255, 0.5);
        }

        .standings-table th {
            color: var(--text-secondary);
            font-size: clamp(0.65rem, 1.5vw, 0.75rem);
            text-transform: uppercase;
            font-weight: 700;
            padding: clamp(10px, 2vw, 15px) clamp(5px, 1.5vw, 10px);
            text-align: center;
        }

        .standings-table th:first-child {
            text-align: left;
            padding-left: clamp(8px, 2vw, 20px);
        }

        .standings-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .standings-table tbody tr:hover {
            background: rgba(0, 123, 255, 0.05);
        }

        .standings-table td {
            padding: clamp(10px, 2vw, 15px) clamp(5px, 1.5vw, 10px);
            text-align: center;
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        }

        .standings-table td:first-child {
            text-align: left;
        }

        .position-cell {
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            color: var(--text-primary);
            padding-left: clamp(8px, 2vw, 20px) !important;
        }

        .team-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-start;
        }

        .team-logo-small {
            width: clamp(25px, 5vw, 30px);
            height: clamp(25px, 5vw, 30px);
            object-fit: contain;
            flex-shrink: 0;
        }

        .team-name-standings {
            color: var(--text-primary);
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
        }

        .champion-badge {
            background: rgb(13, 18, 107);
            color: white;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: clamp(0.6rem, 1.5vw, 0.7rem);
            font-weight: 700;
            margin-left: 5px;
        }

        .qualification-badge {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .qual-champion {
            background: #fbbf24;
        }

        .qual-playoff {
            background: #10b981;
        }

        .btn-get-tickets {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color)dd);
            color: white;
            padding: clamp(10px, 2vw, 12px) clamp(16px, 4vw, 24px);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: clamp(15px, 3vw, 20px);
            transition: all 0.3s ease;
            text-align: center;
            border: none;
            cursor: pointer;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .btn-get-tickets:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            color: white;
        }

        /* Match Statistics Styles */
        .stats-comparison {
            display: flex;
            flex-direction: column;
            gap: clamp(15px, 3vw, 20px);
        }

        .stat-row {
            display: grid;
            grid-template-columns: 60px 1fr 60px;
            gap: clamp(10px, 2vw, 15px);
            align-items: center;
            background: rgba(45, 52, 64, 0.4);
            padding: clamp(12px, 2.5vw, 15px);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .stat-row:hover {
            background: rgba(45, 52, 64, 0.6);
            transform: translateX(3px);
        }

        .stat-team-value {
            color: var(--text-primary);
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            text-align: center;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            font-weight: 600;
            text-align: center;
        }

        .stat-bar {
            height: 8px;
            background: rgba(100, 116, 139, 0.2);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
        }

        .stat-bar-fill {
            height: 100%;
            transition: width 0.6s ease;
        }

        .stat-bar-fill.team1 {
            border-radius: 10px 0 0 10px;
        }

        .stat-bar-fill.team2 {
            border-radius: 0 10px 10px 0;
        }

        /* Team Tabs */
        .team-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .team-tab {
            flex: 1;
            min-width: 150px;
            padding: clamp(10px, 2vw, 12px) clamp(15px, 3vw, 20px);
            background: rgba(45, 52, 64, 0.4);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .team-tab:hover {
            background: rgba(45, 52, 64, 0.6);
            transform: translateY(-2px);
        }

        .team-tab.active {
            background: rgba(0, 123, 255, 0.2);
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        .team-stats-content {
            display: none;
        }

        .team-stats-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in;
        }

        /* Player Stats Table */
        .player-stats-table {
            width: 100%;
            border-collapse: collapse;
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
            margin-bottom: 20px;
        }

        .player-stats-table thead {
            background: rgba(0, 123, 255, 0.1);
            border-bottom: 2px solid rgba(0, 123, 255, 0.5);
        }

        .player-stats-table th {
            color: var(--text-secondary);
            font-size: clamp(0.65rem, 1.5vw, 0.75rem);
            text-transform: uppercase;
            font-weight: 700;
            padding: clamp(10px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
        }

        .player-stats-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .player-stats-table tbody tr:hover {
            background: rgba(0, 123, 255, 0.05);
        }

        .player-stats-table td {
            padding: clamp(10px, 2vw, 15px) clamp(8px, 1.5vw, 12px);
            text-align: center;
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 1.8vw, 0.9rem);
        }

        .player-number {
            font-weight: 700;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            text-align: center;
        }

        .player-name-cell {
            text-align: left !important;
        }

        .player-info-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .player-avatar-small {
            width: clamp(30px, 6vw, 35px);
            height: clamp(30px, 6vw, 35px);
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            flex-shrink: 0;
        }

        .player-info-cell span {
            color: var(--text-primary);
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
        }

        /* player Info Box */
        .player-info-box {
            background: rgba(45, 52, 64, 0.4);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: clamp(15px, 3vw, 20px);
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
        }

        .player-avatar {
            width: clamp(50px, 10vw, 60px);
            height: clamp(50px, 10vw, 60px);
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            flex-shrink: 0;
        }

        .player-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .player-details {
            flex: 1;
        }

        .player-role {
            color: var(--text-secondary);
            font-size: clamp(0.7rem, 1.8vw, 0.8rem);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .player-name {
            color: var(--text-primary);
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            font-weight: 700;
        }

        /* Container Responsive */
        .container {
            padding-left: clamp(12px, 3vw, 15px);
            padding-right: clamp(12px, 3vw, 15px);
        }

        /* ========================================
                                                                                                                                           MOBILE RESPONSIVE OPTIMIZATIONS
                                                                                                                                           Target: Consistent layout across all devices
                                                                                                                                           ======================================== */

        /* Base Mobile Styles (up to 576px) */
        @media (max-width: 576px) {

            body {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
            }

            /* Hero Section */
            .hero {
                min-height: 200px !important;
                padding: 15px 0 !important;
            }

            .hero h1 {
                font-size: clamp(1.3rem, 4.5vw, 1.8rem) !important;
                margin-bottom: 0.5rem !important;
                line-height: 1.3 !important;
            }

            .hero p {
                font-size: clamp(0.75rem, 2.5vw, 0.9rem) !important;
                margin-top: 0.3rem !important;
            }

            /* Sub Navbar */
            .sub-navbar-section {
                padding: 10px 0 !important;
                position: sticky;
                top: 0;
            }

            .nav-content {
                flex-direction: column;
                gap: 8px;
            }

            .sub-nav-links {
                width: 100%;
                justify-content: space-between;
            }

            .sub-nav-link {
                min-width: auto;
                flex: 1;
                padding: 8px 10px !important;
                font-size: 0.7rem !important;
                white-space: nowrap;
            }

            .back-button {
                width: 100%;
                justify-content: center;
                padding: 8px 12px !important;
                font-size: 0.75rem !important;
            }

            /* Container Padding */
            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Match Card */
            .match-card {
                margin-bottom: 15px !important;
                border-radius: 12px !important;
            }

            .match-card-header {
                padding: 15px 10px !important;
            }

            /* Team Section - Maintain 3 Column Grid */
            .team-section {
                grid-template-columns: 1fr auto 1fr !important;
                gap: 10px !important;
                align-items: center !important;
            }

            /* Team Columns */
            .team-column {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            /* Team Logos - Consistent Size */
            .team-logo-section {
                width: 70px !important;
                height: 70px !important;
                margin: 0 auto 8px !important;
                flex-shrink: 0;
            }

            .team-logo-section img {
                width: 60px !important;
                height: 60px !important;
                max-width: 100%;
                max-height: 100%;
            }

            /* Team Names */
            .team-name-large {
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                margin-bottom: 10px !important;
                line-height: 1.2 !important;
                text-align: center;
                word-break: break-word;
                hyphens: auto;
            }

            /* Match Center - Middle Column */
            .match-center {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-width: 100px;
                padding: 0 5px;
            }

            .match-badge {
                font-size: 0.55rem !important;
                padding: 4px 8px !important;
                margin-bottom: 6px !important;
                border-radius: 10px !important;
                white-space: nowrap;
            }

            .match-center p {
                font-size: 0.7rem !important;
                margin-bottom: 6px !important;
                line-height: 1.2;
            }

            .match-score {
                font-size: 1.8rem !important;
                margin: 8px 0 !important;
                line-height: 1;
                letter-spacing: -1px;
            }

            .match-status {
                font-size: 0.65rem !important;
                padding: 3px 8px !important;
                margin-top: 6px !important;
            }

            .match-info-grid {
                margin-top: 10px !important;
                gap: 4px !important;
            }

            .match-info-item {
                font-size: 0.65rem !important;
                line-height: 1.3;
            }

            /* Goal Items */
            .goal-item {
                padding: 8px !important;
                margin-bottom: 6px !important;
                gap: 6px !important;
                border-radius: 8px !important;
            }

            .player-avatar {
                width: 28px !important;
                height: 28px !important;
                border-width: 1.5px !important;
            }

            .goal-info {
                flex: 1;
                min-width: 0;
            }

            .player-name {
                font-size: 0.7rem !important;
                line-height: 1.2;
            }

            .goal-time {
                font-size: 0.6rem !important;
                line-height: 1.2;
            }

            .no-goals {
                padding: 10px !important;
                font-size: 0.7rem !important;
            }

            /* Stats Section */
            .stats-section {
                padding: 15px 10px !important;
                margin-bottom: 15px !important;
                border-radius: 10px !important;
            }

            .section-title {
                font-size: 0.95rem !important;
                margin-bottom: 12px !important;
                padding-bottom: 8px !important;
                border-bottom-width: 2px !important;
            }

            /* H2H Grid */
            .h2h-grid {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .h2h-stat {
                padding: 12px 10px !important;
                border-radius: 8px !important;
            }

            .h2h-stat-number {
                font-size: 1.5rem !important;
                margin-bottom: 4px !important;
            }

            .h2h-stat-label {
                font-size: 0.6rem !important;
            }

            .h2h-stat div:last-child {
                font-size: 0.65rem !important;
                margin-top: 4px !important;
            }

            /* H2H Match */
            .h2h-match {
                padding: 12px 8px !important;
                margin-bottom: 8px !important;
                gap: 8px !important;
                grid-template-columns: 1fr auto 1fr !important;
            }

            .h2h-team img {
                width: 45px !important;
                height: 45px !important;
                margin-bottom: 6px !important;
            }

            .h2h-team-name {
                font-size: 0.7rem !important;
                line-height: 1.2;
            }

            .h2h-score {
                font-size: 1.2rem !important;
            }

            .h2h-date {
                font-size: 0.65rem !important;
                margin-top: 4px;
            }

            /* Details Grid */
            .details-grid {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .detail-item {
                padding: 10px 12px !important;
                border-radius: 8px !important;
            }

            .detail-label {
                font-size: 0.6rem !important;
                margin-bottom: 4px !important;
            }

            .detail-value {
                font-size: 0.8rem !important;
            }

            /* Standings Table */
            .standings-table {
                font-size: 0.7rem !important;
            }

            .standings-table th,
            .standings-table td {
                padding: 8px 4px !important;
            }

            .standings-table th {
                font-size: 0.6rem !important;
            }

            .position-cell {
                font-size: 0.75rem !important;
                padding-left: 8px !important;
            }

            .team-logo-small {
                width: 22px !important;
                height: 22px !important;
            }

            .team-name-standings {
                font-size: 0.7rem !important;
            }

            .champion-badge {
                font-size: 0.55rem !important;
                padding: 1px 4px !important;
            }

            .qualification-badge {
                width: 4px !important;
                height: 4px !important;
            }

            /* Button */
            .btn-get-tickets {
                padding: 8px 16px !important;
                font-size: 0.75rem !important;
                margin-top: 12px !important;
            }

            /* Match Detail Page */
            .match-detail-page {
                padding: 15px 0 30px !important;
            }

            .stat-row {
                grid-template-columns: 50px 1fr 50px;
                gap: 8px;
                padding: 10px;
            }

            .stat-team-value {
                font-size: 0.85rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .stat-bar {
                height: 6px;
            }

            .team-tab {
                min-width: 120px;
                padding: 8px 12px;
                font-size: 0.75rem;
            }

            .player-stats-table th,
            .player-stats-table td {
                padding: 8px 4px;
                font-size: 0.7rem;
            }

            .player-avatar-small {
                width: 25px;
                height: 25px;
            }

            .player-info-cell {
                gap: 6px;
            }

            .player-info-cell span {
                font-size: 0.7rem;
            }

            .player-info-box {
                padding: 12px;
                gap: 10px;
            }

            .player-avatar {
                width: 45px;
                height: 45px;
            }

            .player-role {
                font-size: 0.65rem;
            }

            .player-name {
                font-size: 0.8rem;
            }
        }

        /* Small Mobile (320px - 375px) */
        @media (max-width: 375px) {
            .hero h1 {
                font-size: 1.2rem !important;
            }

            .team-logo-section {
                width: 60px !important;
                height: 60px !important;
            }

            .team-logo-section img {
                width: 50px !important;
                height: 50px !important;
            }

            .team-name-large {
                font-size: 0.7rem !important;
            }

            .match-score {
                font-size: 1.5rem !important;
            }

            .match-badge {
                font-size: 0.5rem !important;
                padding: 3px 6px !important;
            }

            .stat-row {
                grid-template-columns: 45px 1fr 45px;
            }

            .player-stats-table {
                font-size: 0.65rem;
            }
        }

        /* Tablet Portrait (577px - 767px) */
        @media (min-width: 577px) and (max-width: 767px) {
            .team-logo-section {
                width: 85px !important;
                height: 85px !important;
            }

            .team-logo-section img {
                width: 72px !important;
                height: 72px !important;
            }

            .team-name-large {
                font-size: 0.85rem !important;
            }

            .match-score {
                font-size: 2.2rem !important;
            }

            .h2h-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .details-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        /* Tablet Landscape (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .team-logo-section {
                width: 100px !important;
                height: 100px !important;
            }

            .team-logo-section img {
                width: 85px !important;
                height: 85px !important;
            }

            .h2h-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }

            .details-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        /* Desktop (992px+) */
        @media (min-width: 992px) {
            .team-section {
                gap: 25px !important;
            }

            .h2h-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }

            .details-grid {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }

        /* Landscape Orientation Fix */
        @media (max-height: 500px) and (orientation: landscape) {
            .hero {
                min-height: 150px !important;
            }

            .sub-navbar-section {
                position: relative !important;
            }
        }

        /* High DPI Screens */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {

            .team-logo-section img,
            .h2h-team img,
            .team-logo-small {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Print Styles */
        @media print {

            .sub-navbar-section,
            .back-button,
            .btn-get-tickets {
                display: none !important;
            }

            .match-card,
            .stats-section {
                page-break-inside: avoid;
            }
        }

        /* Additional Mobile Optimizations */

        /* Fix for very small screens */
        @media (max-width: 320px) {
            .container {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            .team-section {
                gap: 6px !important;
            }

            .team-logo-section {
                width: 55px !important;
                height: 55px !important;
            }

            .team-logo-section img {
                width: 45px !important;
                height: 45px !important;
            }

            .team-name-large {
                font-size: 0.65rem !important;
            }

            .match-score {
                font-size: 1.3rem !important;
            }
        }

        /* Smooth Transitions */
        .team-logo-section,
        .goal-item,
        .h2h-stat,
        .detail-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Touch-Friendly Interactions */
        @media (hover: none) and (pointer: coarse) {

            .sub-nav-link,
            .back-button,
            .view-details-btn,
            .btn-get-tickets {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .goal-item,
            .h2h-match,
            .detail-item {
                -webkit-tap-highlight-color: rgba(0, 123, 255, 0.1);
            }
        }

        /* Prevent Text Selection on Interactive Elements */
        .sub-nav-link,
        .back-button,
        .match-badge {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>

    <!-- sub navbar Section -->
    <div class="sub-navbar-section">
        <div class="container">
            <div class="nav-content">
                <a
                    href="/"
                    class="back-button"
                >
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
                <a
                    href="{{ route('tournament.index') }}"
                    class="back-button"
                >
                    <i class="fas fa-arrow-left"></i> Back to Tournaments
                </a>
                <div class="sub-nav-links">
                    <a
                        class="sub-nav-link active"
                        onclick="switchTab(event, 'match-details')"
                    >
                        <i>⚽ </i> Detail Pertandingan
                    </a>
                    <a
                        class="sub-nav-link"
                        onclick="switchTab(event, 'standings')"
                    >
                        <i>🏆 </i> Klasemen
                    </a>
                    <a
                        class="sub-nav-link"
                        onclick="switchTab(event, 'statistik')"
                    >
                        <i> </i> Statistik
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="match-detail-page">
        <div class="container">
            <!-- Match Details Tab Content -->
            @include('client.our-tournament.partials.match-detail')

            <!-- Standings Tab Content -->
            @include('client.our-tournament.partials.klasemen-detail')

            <!-- Statistik Tab Content -->
            @include('client.our-tournament.partials.statistik')
        </div>
    </div>

    <script>
        function switchTab(event, tabId) {
            event.preventDefault();

            // Remove active class from all nav links
            document.querySelectorAll('.sub-nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Add active class to clicked link
            event.currentTarget.classList.add('active');

            // Hide all tab content sections
            document.querySelectorAll('.tab-content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabId).classList.add('active');

            // Scroll to top smoothly
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
@endsection
