@extends('layouts.main')

@section('content')
<!-- Hero Section -->
    <div
        class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 400px; display: flex; align-items: center;"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="container text-center py-5">
                    <h2 style="color: red;">Verifikasi Gagal</h2>
                    <p>Email verifikasi tidak valid atau sudah kadaluarsa.</p>
                    <a href="/login" class="btn btn-primary mt-3">
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
