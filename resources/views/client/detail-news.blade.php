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
                            <h1 class="card-title text-white">{{ $news->title }}</h1>
                            <p class="text-muted mb-4">
                                {{ $news->author ?? 'Admin' }} – 
                                {{ strftime('%A, %e %B %Y', strtotime($news->date)) }}
                            </p>

                            @if($news->picture)
                                <div class="mb-4 text-center">
                                    <img src="{{ asset('storage/' . $news->picture) }}" 
                                         alt="{{ $news->title }}" 
                                         class="img-fluid rounded"
                                         style="max-height: 400px; width: auto; object-fit: cover;">
                                </div>
                            @endif

                            <div class="mt-3" style="word-break: break-word; color: #ffffff;">
                                {!! $news->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection