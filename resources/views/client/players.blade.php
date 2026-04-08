@extends('layouts.main')

@section('content')
    <div
        class="hero overlay"
        style="background-image: url('assets/client/images/bg_4.jpg');"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mx-auto text-center">
                    <h1 class="text-white">Players</h1>
                    <p>Para pemain yang sedang membela atau membantu EXPOSE FC dalam semua kompetisi</p>
                </div>
            </div>
        </div>
    </div>



    <div class="site-section">
        <div
            class="container"
            style="background: rgb(10, 14, 24)"
        >
            <div class="row">
                <div class="col-6 title-section">
                    <h2 class="heading">List Players</h2>
                </div>
                <div class="col-6 text-right">
                    <div class="custom-nav">
                        <a
                            href="#"
                            class="js-custom-prev-v2"
                        ><span class="icon-keyboard_arrow_left"></span></a>
                        <span></span>
                        <a
                            href="#"
                            class="js-custom-next-v2"
                        ><span class="icon-keyboard_arrow_right"></span></a>
                    </div>
                </div>
            </div>


            <div class="owl-4-slider owl-carousel">
                @foreach ($player_array as $player)
                    <div class="item">
                        <div class="video-media">
                            <img
                                src="{{ asset('storage/' . $player->photo) }}"
                                alt="Image"
                                class="img-fluid"
                            >
                            <div class="caption">
                                <span class="meta">{{ $player->team_name }}</span>
                                <h3 class="m-0">{{ $player->name }}</h3>
                            </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>


    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-6 title-section">
                    <h2 class="heading">Blog</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($blog_array as $blog)
                    <div class="col-lg-6">
                        <div class="custom-media d-flex">
                            <div class="img mr-4">
                                <img
                                    src="{{ asset('storage/' . $blog->picture) }}"
                                    alt="Image"
                                    class="img-fluid"
                                >
                            </div>
                            <div class="text">
                                <span class="meta">{{ $blog->date }}</span>
                                <h3 class="mb-4"><a href="#">{{ $blog->title }}</a></h3>
                                <p>{{ $blog->mini_description }}.</p>
                                <p><a href="#">Read more</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
