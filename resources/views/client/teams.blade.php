@extends('layouts.main')

@section('content')
{{-- HERO --}}
<div class="hero overlay position-relative"
    style="background-image: url('{{ asset('assets/client/images/bg_8.jpg') }}');
           background-size: cover;
           background-position: center;
           height: 100vh;">
    <div class="overlay position-absolute top-0 start-0 end-0 bottom-0" style="background: rgba(0,0,0,0.1);"></div>
    <div class="container position-relative text-center d-flex flex-column justify-content-center h-100">
        <h1 class="text-white fw-bold mb-2">All Teams</h1>
        <p class="text-light fs-5">Temukan semua tim yang tergabung di Expose FC!</p>
    </div>
</div>

{{-- TEAMS LIST --}}
<div class="site-section py-5" style="background: rgb(10, 14, 24);">
    <div class="container">
        @if($teams->count() > 0)
            <div class="mb-4 d-flex justify-content-between align-items-center text-white">
                <h4 class="section-header fw-bold">Teams <span class="text-gradient-strong">List</span></h4>
                <span class="text-muted small">{{ $teams->count() }} Teams</span>
            </div>

            <div class="row g-3">
                @foreach($teams as $team)
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <div class="team-card-horizontal d-flex align-items-center p-3">
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="team-card-logo me-3">
                            <div class="team-info flex-grow-1">
                                <h5 class="fw-bold text-white mb-1">{{ $team->name }}</h5>
                                
                            </div>
                            <a href="{{ route('client.team.detail', $team->id) }}" class="btn btn-detail ms-3">Detail</a>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-white">
                <div style="font-size: 4rem; opacity: 0.5;">⚽</div>
                <h5 class="mt-3 fw-semibold" style="color: #cbd5e1;">No Teams Found</h5>
                <p class="text-muted" style="font-size: 1rem;">Add teams to the database first</p>
            </div>
        @endif
    </div>
</div>

<style>
   :root {
  --blue-primary-start: #0051ff;
  --blue-primary-end: #0039b3;
  --blue-glow: rgba(0, 81, 255, 0.6);
  --bg-card-glass: rgba(255, 255, 255, 0.07);
  --bg-page: #0b0f1a;
  --text-primary: #e0e6ff;
  --text-secondary: #aab6ff;
  --border-glass: rgba(255, 255, 255, 0.12);
  --font-main: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  --shadow-light: rgba(0, 81, 255, 0.3);
  --shadow-strong: rgba(0, 81, 255, 0.7);
}

/* Reset & Base */
*,
*::before,
*::after {
  box-sizing: border-box;
}

body {
  margin: 0;
  background-color: var(--bg-page);
  font-family: var(--font-main);
  color: var(--text-primary);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  line-height: 1.5;
}

/* Gradient Text for Titles */
.text-gradient-strong {
  background: linear-gradient(90deg, var(--blue-primary-start), var(--blue-primary-end));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 900;
  user-select: none;
}

/* CARD: Glassmorphism style horizontal */
.team-card-horizontal {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  padding: 1.25rem 1.75rem;
  background: var(--bg-card-glass);
  backdrop-filter: blur(15px);
  border-radius: 16px;
  border: 1.5px solid var(--border-glass);
  box-shadow: 0 4px 15px var(--shadow-light);
  transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.35s ease;
  cursor: pointer;
  user-select: none;
}

.team-card-horizontal:hover,
.team-card-horizontal:focus-within {
  transform: translateY(-7px);
  box-shadow: 0 10px 30px var(--shadow-strong);
  outline: none;
}

/* Team Logo */
.team-card-logo {
  flex-shrink: 0;
  width: 75px;
  height: 75px;
  border-radius: 50%;
  border: 3px solid var(--text-primary);
  object-fit: cover;
  box-shadow: 0 0 12px var(--blue-glow);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card-logo:hover,
.team-card-logo:focus {
  transform: scale(1.2);
  box-shadow: 0 0 25px var(--shadow-strong);
  outline: none;
}

/* Team Info */
.team-info {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* Team Name */
.team-info h5 {
  font-weight: 800;
  font-size: 1.3rem;
  margin: 0;
  color: var(--text-primary);
  letter-spacing: 0.05em;
  text-shadow: 0 0 8px var(--blue-glow);
  user-select: text;
}

/* Button Detail */
.btn-detail {
  background: linear-gradient(90deg, var(--blue-primary-start), var(--blue-primary-end));
  color: #fff;
  padding: 0.6rem 1.4rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 0 15px var(--blue-glow);
  transition: background 0.4s ease, box-shadow 0.4s ease, transform 0.3s ease;
  user-select: none;
  flex-shrink: 0;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-detail:hover,
.btn-detail:focus {
  background: linear-gradient(135deg, #0073ff 0%, #001f7d 100%);
  box-shadow: 0 0 35px var(--shadow-strong);
  transform: translateY(-4px);
  outline: none;
}

/* RESPONSIVE */

/* Medium devices (tablet) */
@media (max-width: 768px) {
  .team-card-horizontal {
    padding: 1rem 1.25rem;
    gap: 1rem;
  }

  .team-card-logo {
    width: 65px;
    height: 65px;
  }

  .team-info h5 {
    font-size: 1.1rem;
  }

  .btn-detail {
    padding: 0.5rem 1.1rem;
    font-size: 0.85rem;
  }
}

/* Small devices (phones) */
@media (max-width: 480px) {
  .team-card-horizontal {
    gap: 0.8rem;
    padding: 0.85rem 1rem;
    flex-wrap: wrap; /* allow wrap but keep horizontal-ish */
    justify-content: flex-start;
  }

  .team-card-logo {
    width: 55px;
    height: 55px;
  }

  .team-info {
    flex-basis: 65%;
  }

  .team-info h5 {
    font-size: 1rem;
  }

  .btn-detail {
    flex-basis: auto;
    font-size: 0.8rem;
    padding: 0.45rem 1rem;
  }
}

/* Empty State Styling */
.text-center.py-5 {
  color: var(--text-secondary);
  user-select: none;
  font-weight: 600;
}

.text-center.py-5 div {
  font-size: 5rem;
  opacity: 0.3;
  margin-bottom: 1rem;
}

</style>

@endsection
