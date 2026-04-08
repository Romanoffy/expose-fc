@extends('layouts.main')

@section('content')
<div class="hero overlay" style="background-image: url('{{ asset('assets/client/images/bg_7.jpg') }}');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mx-auto text-center">
                <h1 class="text-white">Videos</h1>
                <p>Video terbaru seputar sepakbola dan kegiatan kami di Bandung.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .video-post-card {
        position: relative;
        display: block;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        height: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .video-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .video-card-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .video-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
        padding: 1.25rem 1rem 1rem;
        color: white;
    }

    .video-card-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0 0 0.5rem;
        line-height: 1.3;
        color: white;
    }

    .video-card-meta {
        font-size: 0.85rem;
        color: #ccc;
        margin: 0 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .video-read-more {
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        opacity: 0.9;
    }

    @media (max-width: 767px) {
        .video-card-image {
            height: 180px;
        }
    }
</style>

<div class="container site-section">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="heading">Latest Videos</h2>
        </div>
    </div>

    <div class="row">
        @forelse($video_array as $video)
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="/detail-video/{{ $video->id }}-{{ Str::slug($video->title) }}" class="video-post-card" target="_blank">
                    <img 
                        src="{{ 
                            $video->thumbnail 
                                ? asset('storage/' . $video->thumbnail) 
                                : 'https://img.youtube.com/vi/' . trim($video->youtube_id) . '/hqdefault.jpg' 
                        }}" 
                        alt="{{ $video->title }}" 
                        class="video-card-image" 
                        loading="lazy"
                    >
                    <div class="video-card-overlay">
                        <h3 class="video-card-title">{{ $video->title }}</h3>
                        <p class="video-card-meta">
                            {{ \Carbon\Carbon::parse($video->created_at)->translatedFormat('l, j F Y') }}
                        </p>
                        <span class="video-read-more">Watch now →</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-white">
                <p>Tidak ada video tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-7 text-center">
            <div class="pagination_index">
                {{ $video_array->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection