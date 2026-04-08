@extends('layouts.main')

@section('content')

{{-- HERO tetap sama --}}
<div class="hero overlay position-relative"
    style="background-image: url('{{ asset('assets/client/images/bg_8.jpg') }}');
           background-size: cover;
           background-position: center;
           height: 100vh;">
    <div class="overlay position-absolute top-0 start-0 end-0 bottom-0" style="background: rgba(0,0,0,0.1);"></div>
    <div class="container position-relative text-center d-flex flex-column justify-content-center h-100">
        <h1 class="text-white fw-bold mb-2">Detail Teams</h1>
        <p class="text-light fs-5">Lihat informasi lengkap setiap tim yang tergabung di Expose FC.</p>
    </div>
</div>
{{-- TEAM DETAIL MODERN FULL REMAKE --}}
<div class="container py-5">
    <div class="team-detail-wrapper">
        <div class="team-glass-card">
            <div class="team-info-layout row align-items-center gx-4 gy-4">
                {{-- Logo Tim --}}
                <div class="col-md-4 text-center">
                    <div class="team-logo-frame">
                        <img src="{{ asset('storage/' . $team->logo) }}"
                            alt="{{ $team->name }}"
                            class="team-logo-modern">
                    </div>
                </div>

                {{-- Info Tim --}}
                <div class="col-md-8">
                    <div class="team-meta-modern">
                        <h2 class="team-name-modern">{{ $team->name }}</h2>
                        <div class="team-divider"></div>
                        <p class="team-description-modern">
                            {{ $team->descriptions ?? 'Deskripsi belum tersedia' }}
                        </p>
                        <a href="{{ route('client.teams') }}" class="btn team-btn-back mt-4">← Kembali ke Teams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
   /* ===========================================
   TEAM DETAIL MODERN STYLING - GLASS UI
   Author: ChatGPT Ultra UI - Full Responsive
   Version: Final
   Last Updated: 2025-10-22
   =========================================== */

:root {
    --main-blue: #002fff;
    --dark-blue: #03185c;
    --gradient-primary: linear-gradient(135deg, #002fff, #03185c);
    --glass-bg: rgba(255, 255, 255, 0.05);
    --glass-border: rgba(255, 255, 255, 0.08);
    --white: #ffffff;
    --light-text: #cfd8ff;
    --scrollbar-thumb: rgba(0, 47, 255, 0.4);
    --shadow-blue: rgba(0, 47, 255, 0.3);
    --shadow-strong: rgba(0, 47, 255, 0.6);
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #0b0f1a;
    margin: 0;
    padding: 0;
}

/* ================================
   MAIN WRAPPER
   ================================ */
.team-detail-wrapper {
    max-width: 1100px;
    margin: auto;
    padding: 2rem;
}

/* ================================
   GLASS CARD
   ================================ */
.team-glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(14px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 2.5rem 2rem;
    box-shadow: 0 20px 40px var(--shadow-blue);
    transition: all 0.3s ease;
}

.team-glass-card:hover {
    box-shadow: 0 30px 60px var(--shadow-blue);
    transform: translateY(-3px);
}

/* ================================
   LOGO FRAME
   ================================ */
.team-logo-frame {
    background: var(--gradient-primary);
    border-radius: 50%;
    padding: 6px;
    display: inline-block;
    box-shadow: 0 0 12px var(--shadow-blue);
}

.team-logo-modern {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--white);
    transition: transform 0.4s ease;
}

.team-logo-modern:hover {
    transform: scale(1.08);
}

/* ================================
   TEAM META
   ================================ */
.team-meta-modern {
    color: var(--white);
    text-align: left;
}

.team-name-modern {
    font-size: 2.5rem;
    font-weight: 900;
    letter-spacing: 1px;
    text-shadow: 0 0 8px var(--shadow-blue);
    margin-bottom: 1rem;
}

.team-divider {
    height: 4px;
    width: 60px;
    background: linear-gradient(90deg, #002fff, #00f2ff);
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

/* ================================
   DESCRIPTION SECTION
   ================================ */
.team-description-modern {
    font-size: 1.05rem;
    line-height: 1.8;
    color: var(--light-text);
    text-align: justify;
    max-height: 240px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.team-description-modern::-webkit-scrollbar {
    width: 6px;
}
.team-description-modern::-webkit-scrollbar-thumb {
    background: var(--scrollbar-thumb);
    border-radius: 3px;
}

/* ================================
   BACK BUTTON
   ================================ */
.team-btn-back {
    display: inline-block;
    background: var(--gradient-primary);
    color: var(--white);
    font-weight: 600;
    padding: 0.65rem 1.4rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 0 15px var(--shadow-blue);
}

.team-btn-back:hover {
    background: linear-gradient(135deg, #1a30ff 0%, #0026a3 100%);
    box-shadow: 0 0 25px var(--shadow-strong);
    transform: translateY(-2px);
}

/* ================================
   RESPONSIVE BREAKPOINTS
   ================================ */
@media (max-width: 992px) {
    .team-logo-modern {
        width: 140px;
        height: 140px;
    }

    .team-name-modern {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .team-logo-modern {
        width: 120px;
        height: 120px;
    }

    .team-name-modern {
        font-size: 1.8rem;
        text-align: center;
    }

    .team-description-modern {
        font-size: 0.95rem;
        max-height: 200px;
    }

    .team-meta-modern {
        text-align: center;
    }

    .team-btn-back {
        width: 100%;
    }
}


</style>
@endsection