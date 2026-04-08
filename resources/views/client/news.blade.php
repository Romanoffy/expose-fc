@extends('layouts.main')

@section('content')
    <div class="hero overlay" style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mx-auto text-center">
                    <h1 class="text-white">News</h1>
                    <p>Berita terbaru seputar sepakbola dan kegiatan kami di Bandung.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .post-card {
            position: relative;
            display: block;
            border-radius: 12px;
            overflow: hidden;
            background-color: #000;
            color: white;
            text-decoration: none;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .card-image-full {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
            padding: 1.25rem 1rem 1rem;
            color: white;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin: 0 0 0.5rem;
            line-height: 1.3;
            color: white;
        }

        .card-meta {
            font-size: 0.85rem;
            color: #ccc;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .read-more-indicator {
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            opacity: 0.9;
        }

        @media (max-width: 767px) {
            .card-image-full {
                height: 200px;
            }
        }
    </style>

    <div class="container site-section">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="heading">Latest News</h2>
            </div>
        </div>

        <div class="row">
            @forelse($news_array as $news)
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="/detail-news/{{ $news->id }}-{{ $news->slug }}" class="post-card" target="_blank">
                        <img src="{{ asset('storage/' . $news->picture) }}" alt="{{ $news->title }}" class="card-image-full" loading="lazy">
                        <div class="card-overlay">
                            <h3 class="card-title">{{ $news->title }}</h3>
                            <p class="card-meta">
                                {{ \Carbon\Carbon::parse($news->date)->translatedFormat('l, j F Y') }} &bullet;
                                {{ $news->news_category->name ?? 'Uncategorized' }}
                            </p>
                            <span class="read-more-indicator">Read more →</span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-white">
                    <p>Tidak ada berita tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-7 text-center">
                <div class="pagination_index">
                    {{ $news_array->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection