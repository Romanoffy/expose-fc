@extends('layouts.main')

@section('content')
    <!-- Hero Section -->
    <div
        class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 400px; display: flex; align-items: center;"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="container mt-5 text-center">
                    <div class="card p-5 shadow-lg">
                        <h2 class="text-success mb-3">
                            {{ isset($already) && $already ? 'Email Anda sudah terverifikasi.' : 'Verifikasi Berhasil!' }}
                        </h2>
                        <p>
                            {{ isset($already) && $already ? 'Anda sudah dapat login menggunakan akun ini.' : 'Akun Anda telah aktif dan siap digunakan.' }}
                        </p>
                        <a
                            href="{{ url('/login') }}"
                            class="btn btn-primary mt-3"
                        >Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
