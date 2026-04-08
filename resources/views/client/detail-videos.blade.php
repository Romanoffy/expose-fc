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
                                <h1 class="card-title text-white">{{ $video->title }}</h1>
                                <p class="text-muted mb-4">
                                    {{ strftime('%A, %e %B %Y', strtotime($video->created_at)) }}
                                </p>

                                <!-- Thumbnail opsional -->
                                @if($video->thumbnail)
                                    <div class="mb-4 text-center">
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                             alt="{{ $video->title }}" 
                                             class="img-fluid rounded"
                                             style="max-height: 400px; width: auto; object-fit: cover;">
                                    </div>
                                @endif

                                <!-- Embed YouTube -->
                                <div class="mb-4 text-center">
                                    <div class="ratio ratio-16x9">
                                        <iframe 
                                            src="https://www.youtube.com/embed/{{ trim($video->youtube_id) }}" 
                                            title="{{ $video->title }}" 
                                            frameborder="0" 
                                            allowfullscreen
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                @if($video->description)
                                    <div class="mt-3" style="word-break: break-word; color: #ffffff;">
                                        {!! $video->description !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection