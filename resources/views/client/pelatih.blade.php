@extends('layouts.main')

@section('content')

<div class="hero overlay" style="background-image: url('assets/client/images/bg_4.jpg');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mx-auto text-center">
                <h1 class="text-white">Coach</h1>
                <p>Para pelatih yang melatih serta membela atau membantu EXPOSE FC dalam semua kompetisi</p>
            </div>
        </div>
    </div>
</div>



<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-6 title-section">
                <h2 class="heading">List Coach</h2>
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
        @foreach($pelatih_array as $pelatih)
            <div class="item">
                <div class="video-media">
                    <img src="{{asset('storage/' . $pelatih->gambar)}}" alt="Image" class="img-fluid" style="height:450px; width:100%; object-fit: cover">
                    <div class="caption">
                        <span class="meta">{{ $pelatih->lisensi}}</span>
                        <h3 class="m-0">{{ $pelatih->nama_pelatih}}</h3>
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>


@endsection