<div
    id="statistik"
    class="tab-content-section"
>
    <div class="stats-section">
        <div
            style="
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            text-align: center;
            gap: 1rem;
        ">
            <div
                style="
                font-size: clamp(3rem, 10vw, 5rem);
                opacity: 0.3;
                margin-bottom: 1rem;
            ">
                📊
            </div>

            <h2
                style="
                color: var(--text-primary);
                font-size: clamp(1.5rem, 5vw, 2.5rem);
                font-weight: 700;
                margin-bottom: 0.5rem;
            ">
                To Be Developed
            </h2>

            <p
                style="
                color: var(--text-secondary);
                font-size: clamp(0.9rem, 3vw, 1.1rem);
                font-weight: 400;
                max-width: 500px;
            ">
                Fitur statistik pertandingan akan segera hadir
            </p>
        </div>
    </div>
</div>



{{-- <div
                id="statistik"
                class="tab-content-section"
            >
                <!-- Match Statistics Section -->
                <div
                    class="stats-section"
                    style="--category-color: {{ $categoryColor }};"
                >
                    <h3
                        class="section-title"
                        style="border-bottom-color: {{ $categoryColor }};"
                    >
                        <i class="fas fa-chart-bar"></i> Statistik Pertandingan
                    </h3>

                    <!-- Stats Comparison -->
                    <div class="stats-comparison">
                        <!-- Possession -->
                        <div class="stat-row">
                            <div class="stat-team-value">52%</div>
                            <div class="stat-info">
                                <div class="stat-label">Penguasaan Bola</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 52%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 48%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">48%</div>
                        </div>

                        <!-- Shots -->
                        <div class="stat-row">
                            <div class="stat-team-value">15</div>
                            <div class="stat-info">
                                <div class="stat-label">Total Tembakan</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 60%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 40%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">10</div>
                        </div>

                        <!-- Shots on Target -->
                        <div class="stat-row">
                            <div class="stat-team-value">8</div>
                            <div class="stat-info">
                                <div class="stat-label">Tembakan Tepat Sasaran</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 57%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 43%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">6</div>
                        </div>

                        <!-- Corners -->
                        <div class="stat-row">
                            <div class="stat-team-value">7</div>
                            <div class="stat-info">
                                <div class="stat-label">Tendangan Sudut</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 54%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 46%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">6</div>
                        </div>

                        <!-- Fouls -->
                        <div class="stat-row">
                            <div class="stat-team-value">12</div>
                            <div class="stat-info">
                                <div class="stat-label">Pelanggaran</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 48%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 52%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">13</div>
                        </div>

                        <!-- Yellow Cards -->
                        <div class="stat-row">
                            <div class="stat-team-value">2</div>
                            <div class="stat-info">
                                <div class="stat-label">Kartu Kuning</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 40%; background: #fbbf24;"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 60%; background: #fbbf24;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">3</div>
                        </div>

                        <!-- Red Cards -->
                        <div class="stat-row">
                            <div class="stat-team-value">0</div>
                            <div class="stat-info">
                                <div class="stat-label">Kartu Merah</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 0%; background: #ef4444;"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 100%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">1</div>
                        </div>

                        <!-- Passes -->
                        <div class="stat-row">
                            <div class="stat-team-value">342</div>
                            <div class="stat-info">
                                <div class="stat-label">Total Passing</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 55%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 45%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">280</div>
                        </div>

                        <!-- Pass Accuracy -->
                        <div class="stat-row">
                            <div class="stat-team-value">85%</div>
                            <div class="stat-info">
                                <div class="stat-label">Akurasi Passing</div>
                                <div class="stat-bar">
                                    <div
                                        class="stat-bar-fill team1"
                                        style="width: 52%; background: {{ $categoryColor }};"
                                    ></div>
                                    <div
                                        class="stat-bar-fill team2"
                                        style="width: 48%; background: #ef4444;"
                                    ></div>
                                </div>
                            </div>
                            <div class="stat-team-value">78%</div>
                        </div>
                    </div>
                </div>

                <!-- Player Statistics Section -->
                <div
                    class="stats-section"
                    style="--category-color: {{ $categoryColor }};"
                >
                    <h3
                        class="section-title"
                        style="border-bottom-color: {{ $categoryColor }};"
                    >
                        <i class="fas fa-users"></i> Statistik Pemain
                    </h3>

                    <!-- Team Tabs -->
                    <div class="team-tabs">
                        <button
                            class="team-tab active"
                            onclick="switchTeamTab(event, 'team1-stats')"
                            style="background: {{ $categoryColor }}20; border-color: {{ $categoryColor }};"
                        >
                            {{ $match->teamname_1 }}
                        </button>
                        <button
                            class="team-tab"
                            onclick="switchTeamTab(event, 'team2-stats')"
                        >
                            {{ $match->teamname_2 }}
                        </button>
                    </div>

                    <!-- Team 1 Stats -->
                    <div
                        id="team1-stats"
                        class="team-stats-content active"
                    >
                        <div style="overflow-x: auto;">
                            <table class="player-stats-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">NO</th>
                                        <th style="text-align: left;">NAME</th>
                                        <th>POS</th>
                                        <th>MIN</th>
                                        <th>PTS</th>
                                        <th>AST</th>
                                        <th>REB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: {{ $categoryColor }};"
                                        >10</td>
                                        <td class="player-name-cell">
                                            <a
                                                href="/profile-testing"
                                                class="player-info-cell player-link"
                                            >
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Ahmad Fauzi</span>
                                            </a>
                                        </td>
                                        <td>Forward</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: {{ $categoryColor }};">2</td>
                                        <td>1</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: {{ $categoryColor }};"
                                        >7</td>
                                        <td class="player-name-cell">
                                            <a
                                                href="/profile/budi-santoso"
                                                class="player-info-cell player-link"
                                            >
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Budi Santoso</span>
                                            </a>
                                        </td>
                                        <td>Midfield</td>
                                        <td>85:00</td>
                                        <td style="font-weight: 700; color: {{ $categoryColor }};">0</td>
                                        <td>2</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: {{ $categoryColor }};"
                                        >5</td>
                                        <td class="player-name-cell">
                                            <a
                                                href="/profile/candra-wijaya"
                                                class="player-info-cell player-link"
                                            >
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Candra Wijaya</span>
                                            </a>
                                        </td>
                                        <td>Defender</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: {{ $categoryColor }};">0</td>
                                        <td>0</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: {{ $categoryColor }};"
                                        >1</td>
                                        <td class="player-name-cell">
                                            <a
                                                href="/profile/doni-kurniawan"
                                                class="player-info-cell player-link"
                                            >
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Doni Kurniawan</span>
                                            </a>
                                        </td>
                                        <td>Goalkeeper</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: {{ $categoryColor }};">0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: {{ $categoryColor }};"
                                        >9</td>
                                        <td class="player-name-cell">
                                            <a
                                                href="/profile/eko-prasetyo"
                                                class="player-info-cell player-link"
                                            >
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Eko Prasetyo</span>
                                            </a>
                                        </td>
                                        <td>Forward</td>
                                        <td>75:00</td>
                                        <td style="font-weight: 700; color: {{ $categoryColor }};">1</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: rgba(0, 123, 255, 0.1); font-weight: 700;">
                                        <td colspan="4">Total</td>
                                        <td style="color: {{ $categoryColor }};">3</td>
                                        <td>3</td>
                                        <td>1</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- player Info -->
                        <div class="player-info-box">
                            <div class="player-avatar">
                                <img
                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                    alt="player"
                                >
                            </div>
                            <div class="player-details">
                                <div class="player-role">Pelatih Kepala</div>
                                <div class="player-name">Bambang Pamungkas</div>
                            </div>
                        </div>
                    </div>

                    <!-- Team 2 Stats -->
                    <div
                        id="team2-stats"
                        class="team-stats-content"
                    >
                        <div style="overflow-x: auto;">
                            <table class="player-stats-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">NO</th>
                                        <th style="text-align: left;">NAME</th>
                                        <th>POS</th>
                                        <th>MIN</th>
                                        <th>PTS</th>
                                        <th>AST</th>
                                        <th>REB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: #ef4444;"
                                        >11</td>
                                        <td class="player-name-cell">
                                            <div class="player-info-cell">
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Fajar Nugraha</span>
                                            </div>
                                        </td>
                                        <td>Forward</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: #ef4444;">1</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: #ef4444;"
                                        >8</td>
                                        <td class="player-name-cell">
                                            <div class="player-info-cell">
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Gilang Ramadhan</span>
                                            </div>
                                        </td>
                                        <td>Midfield</td>
                                        <td>80:00</td>
                                        <td style="font-weight: 700; color: #ef4444;">0</td>
                                        <td>1</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: #ef4444;"
                                        >4</td>
                                        <td class="player-name-cell">
                                            <div class="player-info-cell">
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Hendra Setiawan</span>
                                            </div>
                                        </td>
                                        <td>Defender</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: #ef4444;">0</td>
                                        <td>0</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: #ef4444;"
                                        >1</td>
                                        <td class="player-name-cell">
                                            <div class="player-info-cell">
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Irfan Bachdim</span>
                                            </div>
                                        </td>
                                        <td>Goalkeeper</td>
                                        <td>90:00</td>
                                        <td style="font-weight: 700; color: #ef4444;">0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="player-number"
                                            style="color: #ef4444;"
                                        >10</td>
                                        <td class="player-name-cell">
                                            <div class="player-info-cell">
                                                <img
                                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                                    alt="Player"
                                                    class="player-avatar-small"
                                                >
                                                <span>Joko Susilo</span>
                                            </div>
                                        </td>
                                        <td>Midfield</td>
                                        <td>70:00</td>
                                        <td style="font-weight: 700; color: #ef4444;">1</td>
                                        <td>1</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: rgba(239, 68, 68, 0.1); font-weight: 700;">
                                        <td colspan="4">Total</td>
                                        <td style="color: #ef4444;">2</td>
                                        <td>2</td>
                                        <td>2</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- player Info -->
                        <div class="player-info-box">
                            <div class="player-avatar">
                                <img
                                    src="{{ asset('assets/client/images/default-profile.png') }}"
                                    alt="player"
                                >
                            </div>
                            <div class="player-details">
                                <div class="player-role">Pelatih Kepala</div>
                                <div class="player-name">Kurniawan Dwi Yulianto</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
