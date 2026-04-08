<!DOCTYPE html>
<html lang="en">

<head>
    <title>Expose FC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{ asset('assets/client/images/logo.png') }}">

    <!-- Font Combinations untuk Website Sepak Bola -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Bebas+Neue&family=Roboto:wght@300;400;500;700&family=Oswald:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/client/fonts/icomoon/style.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/bootstrap/bootstrap.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/jquery-ui.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/owl.carousel.min.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/owl.theme.default.min.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/jquery.fancybox.min.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/bootstrap-datepicker.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/fonts/flaticon/font/flaticon.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/aos.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('assets/client/css/style.css') }}"
    >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            important: true, // 🔥 semua utilitas Tailwind pakai !important
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    

    <!-- Custom CSS untuk konsistensi dan responsivitas -->
    <style>
        /* Responsivitas untuk gambar */
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .tw-container {
            @apply container mx-auto px-6;
        }

        .modal {
            z-index: 2000 !important;
        }

        .modal-backdrop {
            z-index: 1990 !important;
        }

        .modal-modern {
            backdrop-filter: blur(8px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content-modern {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .modal-header-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: none;
            padding: 1.5rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1050;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-header-modern .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        .modal-close-btn {
            background: #f1f5f9;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
            font-size: 1.5rem;
            color: #64748b;
        }

        .modal-close-btn:hover {
            background: #e2e8f0;
            transform: rotate(90deg);
            color: #334155;
        }

        .modal-subheader-modern {
            padding: 1rem 2rem;
            background: rgba(248, 249, 250, 0.8);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: #64748b;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-subheader-modern .ms-writer {
            font-weight: 500;
            color: #475569;
            margin: 0;
        }

        .modal-subheader-modern p {
            margin: 0;
        }

        .modal-subheader-modern span {
            color: #cbd5e1;
        }

        .modal-body-modern {
            padding: 2rem;
            max-height: 60vh;
            overflow-y: auto;
        }

        .modal-body-modern::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body-modern::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .modal-body-modern::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .modal-body-modern::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .event-card-modern {
            background: #232931;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .event-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .event-card-modern .card-body {
            padding: 1.5rem;
        }

        .event-card-modern .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: white margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .event-card-modern .card-text {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .event-card-modern .text-muted {
            font-size: 0.85rem;
            color: #94a3b8 !important;
        }

        .countdown-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            background: #000efe;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .countdown-started {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-modern-primary {
            background: #000efe;
            border: none;
            border-radius: 12px;
            padding: 1rem 2.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .event-image-modern {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
        }

        .venue-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.85rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .modal-header-modern,
            .modal-subheader-modern,
            .modal-body-modern {
                padding: 1rem 1.25rem;
            }

            .modal-content-modern {
                border-radius: 16px;
                margin: 0.5rem;
            }

            .event-card-modern .card-body {
                padding: 1.25rem;
            }

            .btn-modern-primary {
                padding: 0.875rem 2rem;
            }
        }

        .countdown {
            gap: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .countdown .time-box {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 15px;
            border-radius: 8px;
            text-align: center;
            min-width: 60px;
        }

        .countdown .time-box span {
            display: block;
            font-size: 0.75rem;
            font-weight: normal;
            margin-top: 4px;
        }

        .countdown .ended {
            color: #ff6b6b;
            font-weight: bold;
        }

        .countdown .not-started {
            color: #ffd93d;
            font-weight: bold;
        }

        /* Konsistensi ukuran gambar tim */
        .team-details img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* Konsistensi untuk gambar blog*/
        .custom-card-image-blogs {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .post-entry-blogs .img img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        /* Konsistensi untuk video thumbnail */
        .video-media img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Perbaikan dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }


        /* Perbaikan navigasi mobile */
        @media (max-width: 991px) {
            .site-navigation ul {
                flex-direction: column;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                background-color: transparent;
                border: none;
                padding-left: 20px;
            }
        }

        /* Konsistensi spacing */
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }


        .modal-body-custom {
            color: #000 !important;
            /* paksa hitam */
        }

        .modal-body-custom p,
        .modal-body-custom h1,
        .modal-body-custom h2,
        .modal-body-custom span,
        .modal-body-custom li {
            color: #000 !important;
            /* paksa semua teks di dalam */
        }

        .modal-body-custom b,
        .modal-body-custom strong {
            font-weight: bold !important;
        }

        .modal-body-custom i,
        .modal-body-custom em {
            font-style: italic !important;
        }

        .modal-body-custom blockquote {
            border-left: 4px solid #007bff;
            /* garis biru di kiri */
            padding-left: 1rem;
            /* jarak teks ke garis */
            margin: 1rem 0;
            /* jarak atas-bawah */
            color: #333;
            /* teks lebih gelap */
            font-style: italic;
            /* biar italic */
            background-color: #f8f9fa;
            /* optional, biar ada background */
        }

        .blog-content .text,
        .blog-content .text h1,
        .blog-content .text h2,
        .blog-content .text h3,
        .blog-content .text h4,
        .blog-content .text h5,
        .blog-content .text h6,
        .blog-content .text p,
        .blog-content .text blockquote {
            color: white !important;
        }



        .text {
            color: #333;
            line-height: 1.6;
            font-size: 1rem;
        }

        .text {
            color: #333;
            line-height: 1.6;
            font-size: 1rem;
        }

        .text blockquote {
            border-left: 4px solid #007bff;
            padding-left: 1rem;
            margin: 1rem 0;
        }

        .text blockquote {
            border-left: 4px solid #007bff;
            padding-left: 1rem;
            margin: 1rem 0;
        }

        .text strong,
        .text b {
            font-weight: bold;
        }

        .text strong,
        .text b {
            font-weight: bold;
        }

        .text em,
        .text i {
            font-style: italic;
        }

        .text em,
        .text i {
            font-style: italic;
        }

        .text ul,
        .text ol {
            padding-left: 1.5rem;
        }

        .text ul,
        .text ol {
            padding-left: 1.5rem;
        }

        .text a {
            color: #007bff;
            text-decoration: underline;
        }

        .text a {
            color: #007bff;
            text-decoration: underline;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7P5ZF81GCQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-7P5ZF81GCQ');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WMFTJG5X');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WMFTJG5X" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include('layouts.components.navbar')

    <div id='container'>
        @yield('content')
    </div>

    @include('layouts.components.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="{{ asset('assets/client/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/client/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/client/js/aos.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.mb.YTPlayer.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/main.js') }}"></script>

    <!-- Teams Logo Infinite Scroll Script -->
    <script>
        (function() {
            'use strict';

            // Initialize infinite scroll for team logos
            function initTeamsInfiniteScroll() {
                const teamsTrack = document.querySelector('.teams-track');

                if (!teamsTrack) {
                    console.warn('Teams track not found');
                    return;
                }

                // Get original content
                const originalContent = teamsTrack.innerHTML;

                // Check if content exists
                if (!originalContent.trim()) {
                    console.warn('No team logos found');
                    return;
                }

                // Duplicate content 5 times for seamless infinite scroll
                teamsTrack.innerHTML = originalContent + originalContent + originalContent + originalContent +
                    originalContent;

                console.log('Teams infinite scroll initialized successfully');

                // Add hover pause functionality
                initHoverPause(teamsTrack);
            }

            // Pause animation on hover for better UX
            function initHoverPause(teamsTrack) {
                const teamsScroller = document.querySelector('.teams-scroller-top');

                if (!teamsScroller) return;

                teamsScroller.addEventListener('mouseenter', function() {
                    teamsTrack.style.animationPlayState = 'paused';
                }, {
                    passive: true
                });

                teamsScroller.addEventListener('mouseleave', function() {
                    teamsTrack.style.animationPlayState = 'running';
                }, {
                    passive: true
                });

                // Pause on touch for mobile devices
                teamsScroller.addEventListener('touchstart', function() {
                    teamsTrack.style.animationPlayState = 'paused';
                }, {
                    passive: true
                });

                teamsScroller.addEventListener('touchend', function() {
                    teamsTrack.style.animationPlayState = 'running';
                }, {
                    passive: true
                });
            }

            // Wait for DOM to be fully loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTeamsInfiniteScroll);
            } else {
                // DOM already loaded
                initTeamsInfiniteScroll();
            }
        })();
        // Perbaikan event listener untuk modal tracking
        $(document).ready(function() {
            $('.modal-card').on('click', function() {
                // Track modal open dengan Google Analytics
                gtag('event', 'modal_open', {
                    'event_category': 'Modal',
                    'event_label': 'Popup Modal Opened'
                });
            });

            // Smooth scrolling untuk anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top
                    }, 1000);
                }
            });

            // Lazy loading untuk gambar
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
</body>

</html>
