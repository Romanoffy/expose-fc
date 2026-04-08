@extends('layouts.main')

@section('content')
<div class="hero overlay" style="background-image: url('{{ asset('assets/client/images/bg_8.jpg') }}');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mx-auto text-center">
                <h1 class="text-white">Blog Posts</h1>
                <p class="text-white">Blog dimana semua artikel tentang Expose dan sepakbola di Bandung.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .blog-post-card {
        position: relative;
        display: block;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        height: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .blog-card-image {
        width: 100%;
        height: 240px;
        object-fit: cover;
        display: block;
    }

    .blog-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
        padding: 1.25rem 1rem 1rem;
        color: white;
    }

    .blog-card-title {
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

    .blog-card-meta {
        font-size: 0.85rem;
        color: #ccc;
        margin: 0 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .blog-read-more {
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        opacity: 0.9;
    }

    @media (max-width: 767px) {
        .blog-card-image {
            height: 200px;
        }
    }
</style>

<div class="container site-section">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="heading">Latest Blog</h2>
        </div>
    </div>

    <div class="row">
        @forelse($blog_array as $blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="/detail-blog/{{ $blog->id }}-{{ $blog->slug }}" class="blog-post-card" target="_blank">
                    @if($blog->picture)
                        <img src="{{ asset('storage/' . $blog->picture) }}" 
                             alt="{{ $blog->title }}" 
                             class="blog-card-image" 
                             loading="lazy">
                    @else
                        <div class="bg-secondary w-100" style="height: 240px; display: flex; align-items: center; justify-content: center;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif

                    <div class="blog-card-overlay">
                        <h3 class="blog-card-title">{{ $blog->title }}</h3>
                        <p class="blog-card-meta">
                            {{ \Carbon\Carbon::parse($blog->date)->translatedFormat('d M Y') }} &bullet;
                            {{ $blog->blog_category->name ?? 'Blog' }}
                        </p>
                        <span class="blog-read-more">Read more →</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-white">
                <p>Tidak ada blog tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-7 text-center">
            <div class="pagination_index">
                {{ $blog_array->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection