<div class="site-wrap">


    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav
        class="site-navbar py-4"
        role="banner"
    >
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="site-logo">
                    <a href="/">
                        <img
                            src="{{ asset('assets/client/images/logo.png') }}"
                            alt="Expose FC Logo"
                            class="img-fluid"
                        >
                    </a>
                </div>
                <div class="ml-auto">
                    <nav
                        class="site-navigation position-relative text-right"
                        role="navigation"
                    >
                        <ul class="site-menu main-menu js-clone-nav d-none d-lg-block mr-auto">
                            <!-- SCROLLER DI BAWAH NAVBAR -->
                            <div class="teams-scroller">
                                <div class="teams-track">
                                    @foreach ($teams as $team)
                                        <div class="team-logo-scroller-wrapper">
                                            <a href="{{ route('client.team.detail', $team->id) }}">
                                                <img
                                                    src="{{ asset('storage/' . $team->logo) }}"
                                                    alt="{{ $team->name }}"
                                                    class="team-logo-scroller"
                                                >
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <li class="{{ Request::is('/') ? 'nav-item nav-link active' : 'nav-item nav-link' }}">
                                <a
                                    href="/"
                                    class="nav-link"
                                >
                                    <i class="fa fa- me-2"></i>Home
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="clubDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fa fa- me-2"></i>Club
                                </a>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="clubDropdown"
                                >
                                    <a
                                        href="/matches"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa- me-2"></i>Matches
                                    </a>
                                    <a
                                        href="/players"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa- me-2"></i>Players
                                    </a>
                                    <a
                                        href="/pelatih"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa- me-2"></i>Pelatih
                                    </a>
                                    <a
                                        href="/sejarah"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa--teacher me-2"></i>Sejarah
                                    </a>
                                    <a
                                        href="/our-tournament"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa--teacher me-2"></i>Our Tournament
                                    </a>
                                    <a
                                        href="/standings"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa--teacher me-2"></i>Standings
                                    </a>
                                    <a
                                        href="/teams"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa--teacher me-2"></i>Teams
                                    </a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="mediaDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fa fa- me-2"></i>Media
                                </a>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="mediaDropdown"
                                >
                                    <a
                                        href="/blog"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa- me-2"></i>Blog
                                    </a>
                                    <a
                                        href="/merchandise"
                                        class="dropdown-item"
                                    >
                                        <i class="fa fa--cart me-2"></i>Merchandise
                                    </a>
                                </div>
                            </li>

                            <li class="{{ Request::is('contact') ? 'nav-item nav-link active' : 'nav-item nav-link' }}">
                                <a
                                    class="nav-link"
                                    href="/contact"
                                >
                                    <i class="fa fa- me-2"></i>Contact
                                </a>
                            </li>

                            {{-- @php
                                        $cartCount = \App\Models\Cart::where('id_user', Auth::id())->count();
                                    @endphp

                            <li class="{{ Request::is('cart') ? 'nav-item nav-link active' : 'nav-item nav-link' }}">
                                <a class="nav-link position-relative" href="/cart">
                                    <i class="fa fa-shopping-cart fa-xl"></i> [{{ $cartCount }}]
                                    <span id="cart-badge"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="display: none;">0</span>
                                </a>
                            </li>
                           --}}


                            {{-- User dropdown / Sign In --}}
                            @auth
                                <li class="nav-item dropdown">
                                    <a
                                        class="nav-link dropdown-toggle d-flex align-items-center"
                                        href="#"
                                        id="userDropdown"
                                        role="button"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        style="position: relative; top: 12px;"
                                    >
                                        <img
                                            src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/client/images/default-profile.png') }}"
                                            alt="Profile"
                                            class="mr-2"
                                            style="width: 35px; height: 35px; object-fit: cover;"
                                        >
                                        <span>{{ \Illuminate\Support\Str::limit(Auth::user()->name, 6, '') }}</span>
                                    </a>

                                    <div
                                        class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="userDropdown"
                                    >
                                        {{-- Dashboard hanya muncul untuk admin --}}
                                        @if (Auth::user()->is_active)
                                            <a
                                                class="dropdown-item"
                                                href="/admin/blogs"
                                            >
                                                <i class="fa fa- me-2"></i>Dashboard
                                            </a>
                                        @endif

                                        <a
                                            class="dropdown-item"
                                            href="/profile"
                                        >
                                            <i class="fa fa- me-2"></i>My Profile
                                        </a>
                                        {{-- <a class="dropdown-item" href="/history-pesanan">
                                            <i class="fa fa- me-2"></i>Order History --}}

                                        @auth
                                            <a
                                                href="/logout"
                                                class="dropdown-item text-danger"
                                            >
                                                <i class="fas fa-"></i>
                                                Log Out
                                            </a>
                                        @endauth
                                    </div>
                                </li>
                            @else
                                <li class="{{ Request::is('login') ? 'nav-item nav-link active' : 'nav-item nav-link' }}">
                                    <a
                                        class="nav-link"
                                        href="/login"
                                    >
                                        <i class="fa fa-sign-in-alt me-2"></i>Sign In
                                    </a>
                                </li>
                            @endauth


                        </ul>
                    </nav>

                    <a
                        href="#"
                        class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle float-right text-black text-white"
                    >
                        <span class="icon-menu h3 text-white"></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<style>
    /* ================== TEAMS SCROLLER ================== */
    .teams-scroller {
        overflow: hidden;
        width: 590px;
        /* lebih lebar agar tidak mentok */
        margin-left: 40px;
        /* jarak dari Home */
        margin-right: 20px;
        /* beri jarak ke kanan */
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
        animation: scroll-infinite 20s linear infinite;
        /* infinite scroll tanpa alternate */
    }

    /* Wrapper tiap logo */
    .team-logo-scroller-wrapper {
        flex: 0 0 auto;
        /* jangan mengecil */
        margin: 0 var(--teams-logo-gap, 8px);
        /* jarak antar logo */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Logo tim */
    .team-logo-scroller {
        width: var(--teams-logo-size, 26px);
        /* ukuran logo */
        height: var(--teams-logo-size, 28px);
        /* transparan */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover efek logo */
    .team-logo-scroller-wrapper:hover .team-logo {
        transform: scale(1.4) rotate(5deg);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    }

    /* Animasi geser infinite */
    @keyframes scroll-infinite {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-10%);
            /* mundur separuh karena konten digandakan */
        }
    }
</style>
