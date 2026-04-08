@extends('layouts.main')

@section('content')
<div class="container">
    <div class="site-section">
        <div class="container mt-5">
            <div class="container mt-40" style="margin-top: 120px;">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card bg-dark text-white border-0 shadow">
                            <div class="card-body p-4 p-md-5">
                                <h1 class="card-title text-white">{{ $gallery->title }}</h1>
                                <p class="text-muted mb-4">
                                    {{ $gallery->author ?? 'Admin' }} – 
                                    {{ strftime('%A, %e %B %Y', strtotime($gallery->date ?? now())) }}
                                </p>

                                <!-- Tampilkan gambar utama (thumbnail atau foto pertama) -->
                                @php
                                    $mainImage = null;
                                    if ($gallery->thumbnail) {
                                        $mainImage = $gallery->thumbnail;
                                    } elseif ($gallery->photos && $gallery->photos->isNotEmpty()) {
                                        $mainImage = $gallery->photos->first()->image;
                                    }
                                @endphp

                                @if($mainImage)
                                    <div class="mb-4 text-center">
                                        <img src="{{ asset('storage/' . $mainImage) }}" 
                                             alt="{{ $gallery->title }}" 
                                             class="img-fluid rounded"
                                             style="max-height: 400px; width: auto; object-fit: cover;">
                                    </div>
                                @endif

                                <!-- Opsional: Tampilkan semua foto galeri -->
                                @if($gallery->photos && $gallery->photos->count() > 1)
                                    <hr class="my-4" style="border-color: #444;">

                                    <h5 class="text-white mt-4">Foto Lainnya:</h5>
                                    <div class="position-relative mt-3">
                                        <div class="gallery-slider-wrapper" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; scrollbar-width: thin; padding: 10px 0;">
                                            @foreach($gallery->photos as $photo)
                                                <div class="d-inline-block" style="width: 200px; margin-right: 15px;">
                                                    <a href="{{ asset('storage/' . $photo->photo) }}" 
                                                       target="_blank"
                                                       data-lightbox="gallery-detail"
                                                       data-title="{{ $gallery->title }}">
                                                        <img src="{{ asset('storage/' . $photo->photo) }}" 
                                                             alt="Gallery photo"
                                                             class="gallery-photo-item"
                                                             style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px; cursor: pointer; display: block;">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if($gallery->description)
                                        <div class="mt-4" style="word-break: break-word; color: #ffffff;">
                                            {!! $gallery->description !!}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-slider-wrapper::-webkit-scrollbar {
    height: 8px;
}

.gallery-slider-wrapper::-webkit-scrollbar-track {
    background: #444;
    border-radius: 10px;
}

.gallery-slider-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.gallery-slider-wrapper::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}
</style>
@endsection

detail-gallery