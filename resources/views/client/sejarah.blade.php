@extends('layouts.main')

@section('content')
    <div class="hero overlay" style="background-image: url('assets/client/images/bg_4.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mx-auto text-center">
                    <h1 class="text-white">Sejarah</h1>
                    <p>Sejarah Expose FC</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Sejarah --}}
    <div class="site-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 title-section">
                    <h2 class="heading">Sejarah</h2>
                </div>
                <!-- Kolom Teks -->
                <div class="col-lg-7">
                    <h2 class="heading mb-4">Expose FC</h2>
                    <p>
                        Expose FC adalah klub sepak bola yang berdiri pada tahun XXXX,
                        berawal dari komunitas pecinta sepak bola di [kota asal].
                        Klub ini dibentuk dengan semangat kebersamaan dan cita-cita
                        untuk mengembangkan bakat muda di daerah tersebut.
                    </p>
                    <p>
                        Pada tahun XXXX, Expose FC mulai mengikuti turnamen resmi tingkat daerah,
                        hingga akhirnya berhasil meraih prestasi di kompetisi nasional.
                        Dengan identitas warna khas dan dukungan suporter setia,
                        Expose FC terus berkembang menjadi klub yang disegani.
                    </p>
                    <p>
                        Saat ini Expose FC bertransformasi menjadi klub profesional
                        dengan manajemen modern, fasilitas pelatihan yang mumpuni,
                        dan visi untuk menembus level kompetisi lebih tinggi.
                    </p>
                </div>

                <!-- Kolom Gambar -->
                <div class="col-lg-5">
                    <img src="{{ asset('assets/client/images/bg_7.jpg') }}" alt="Foto sejarah Expose FC"
                        class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    {{-- Section List Coach --}}
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-6 title-section">
                    <h2 class="heading">Trophy Club</h2>
                </div>
                <div class="col-6 text-right">
                    <div class="custom-nav">
                        <a href="#" class="js-custom-prev-v2"><span class="icon-keyboard_arrow_left"></span></a>
                        <span></span>
                        <a href="#" class="js-custom-next-v2"><span class="icon-keyboard_arrow_right"></span></a>
                    </div>
                </div>
            </div>

            <div class="owl-4-slider owl-carousel">
                <!-- Trophy 1 -->
                @foreach ($sejarah_array as $sejarah)
                    <div class="item">
                        <div class="video-media">
                            <img src="{{ asset('storage/' . $sejarah->gambar) }}" alt="{{ $sejarah->judul }}"
                                class="img-fluid"
                                style="height:225px; width:100%; object-fit: contain; background:#f8f9fa; padding:20px;">
                            <div class="caption">
                                <span class="meta">{{ $sejarah->judul }}</span>
                                <h3 class="m-0">{{ $sejarah->sub_judul }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>

        </div>
    </div>
@endsection
