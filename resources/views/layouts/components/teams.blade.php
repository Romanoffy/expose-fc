                   {{-- <div class="teams-scroller">
    <div class="teams-track">
        @foreach($teams as $team)
        <div class="team-logo-wrapper">
            <a href="{{ route('client.team.detail', $team->id) }}">
                <img src="{{ asset('storage/' . $team->logo) }}" 
                     alt="{{ $team->name }}" 
                     class="team-logo">
            </a>
        </div>
        @endforeach
    </div>
</div>
<style>
    /* ================== TEAMS SCROLLER ================== */
    .teams-scroller {
        overflow: hidden;
        width: 415px;
        /* panjang area scroll */
        margin-left: 40px;
        /* jarak dari Home */
        margin-right: 0px;
        /* bebas di kanan */
        padding: 8px 0;
        /* jarak ke atas & bawah */
        position: relative;
        top: 10px;
        /* jarak ke bawah dari navbar */
    }

    /* Track logo yang bergerak */
    .teams-track {
        display: flex;
        width: max-content;
        /* panjang track sesuai jumlah logo */
        animation: scroll-back-forth var(--teams-scroll-speed, 5s) linear infinite alternate;
    }

    /* Wrapper tiap logo */
    .team-logo-wrapper {
        flex: 0 0 auto;
        /* jangan mengecil */
        margin: 0 var(--teams-logo-gap, 8px);
        /* jarak antar logo */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Logo tim */
    .team-logo {
        width: var(--teams-logo-size, 28px);
        /* ukuran logo */
        height: var(--teams-logo-size, 28px);
        border-radius: 50%;
        /* bentuk bulat */
        object-fit: cover;
        /* cover gambar */
        border: 2px solid transparent;
        /* transparan */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover efek logo */
    .team-logo-wrapper:hover .team-logo {
        transform: scale(1.4) rotate(5deg);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    }

    /* Animasi geser bolak-balik */
    @keyframes scroll-back-forth {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(calc(-1 * (70% - 60%)));
        }

        /* otomatis mentok track */
    }

    /* Responsive */
    @media (max-width: 768px) {
        .teams-scroller {
            width: calc(100% - 20px);
            top: 12px;
            padding: 6px 0;
        }

        .team-logo {
            width: 22px;
            height: 22px;
        }

        .team-logo-wrapper {
            margin: 0 6px;
        }
    }
</style> --}}