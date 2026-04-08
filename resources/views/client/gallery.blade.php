@extends('layouts.main')

@section('content')
<div class="hero overlay" style="background-image: url('{{ asset('assets/client/images/bg_9.jpg') }}');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mx-auto text-center">
                <h1 class="text-white">Gallery</h1>
                <p>Dokumentasi terbaru kegiatan sepakbola dan acara kami di Bandung.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .gallery-post-card {
        position: relative;
        display: block;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        height: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .gallery-card-image {
        width: 100%;
        height: 240px; /* Sesuaikan tinggi sesuai kebutuhan */
        object-fit: cover;
        display: block;
    }

    .gallery-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
        padding: 1.25rem 1rem 1rem;
        color: white;
    }

    .gallery-card-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0 0 0.5rem;
        line-height: 1.3;
        color: white;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .gallery-card-meta {
        font-size: 0.85rem;
        color: #ccc;
        margin: 0 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gallery-read-more {
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        opacity: 0.9;
    }

    @media (max-width: 767px) {
        .gallery-card-image {
            height: 200px;
        }
    }
</style>

<div class="container site-section">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="heading">Latest Galleries</h2>
        </div>
    </div>

    <div class="row">
        @forelse($gallery_array as $gallery)
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="/detail-gallery/{{ $gallery->id }}-{{ $gallery->slug }}" class="gallery-post-card" target="_blank">
                    @php
                        $imageUrl = null;
                        if ($gallery->thumbnail) {
                            $imageUrl = asset('storage/' . $gallery->thumbnail);
                        } elseif ($gallery->photos && $gallery->photos->isNotEmpty()) {
                            $imageUrl = asset('storage/' . $gallery->photos->first()->image);
                        }
                    @endphp

                    @if($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $gallery->title }}" class="gallery-card-image" loading="lazy">
                    @else
                        <div class="bg-secondary w-100" style="height: 240px; display: flex; align-items: center; justify-content: center;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif

                    <div class="gallery-card-overlay">
                        <h3 class="gallery-card-title">{{ $gallery->title }}</h3>
                        <p class="gallery-card-meta">
                            {{ $gallery->gallery_category->name ?? 'Gallery' }}
                        </p>
                        <span class="gallery-read-more">View gallery →</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-white">
                <p>Tidak ada galeri tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-7 text-center">
            <div class="pagination_index">
                {{ $gallery_array->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection