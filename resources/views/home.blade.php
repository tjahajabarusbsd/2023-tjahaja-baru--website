@extends('layouts.master')

@section('title', 'Yamaha Sumatera Barat - Tjahaja Baru')

@section('meta_og')
<meta property="og:title" content="Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'home')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection

@section('content')
    <section class="main-banner">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            {{-- <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div> --}}
            <div class="carousel-inner">
                @foreach ($banners as $banner)
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="{{ url($banner->image) }}" class="d-block w-100" alt="...">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>    

    <section class="first-section container-fluid">
        <div class="caption-container">
            <p class="title">Product Category</p>
            <p class="price-area">Harga Area Sumatera Barat</p>
        </div>
        
        <div class="grid-container">
            @foreach ($latestVariants as $variant)
                <div class="grid-content">
                    <a class="product-link" href="/product/{{ $variant->group->uri }}">
                        <div class="box-img">
                            <img src="{{ url($variant->group->category->image) }}">
                        </div>
                        <div class="box-text">
                            <p class="product-name">{{ $variant->name }}</p>
                            <p class="product-price">{{ $variant->price }}</p>
                            <img class="tombol-biru" src="{{ url('/images/tombol.jpg')}}" alt="">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>	
    </section>

    <section class="second-section container-fluid">
        <div class="top-container row">
            <div class="top-container-col col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="promo-container" style="background-color:#79dbc0;">
                    <div class="promo-title-container">
                        <p class="promo-title">Promo</p>
                    </div>
                    <div class="promo-banner-container row">
                        <div class="promo-banner-col col-sm-6">
                            <div class="promo-banner-item ">
                                <a href="">
                                    <img class="img-fluid" src="{{ url('/images/promo_1.png')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="promo-banner-col col-sm-6">
                            <div class="promo-banner-item ">
                                <a href="">
                                    <img class="img-fluid" src="{{ url('/images/promo_2.png')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-container-col col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="">
                    <img class="img" src="{{ url('/images/parts.jpg')}}" alt="">
                </a>
            </div>
        </div>

        <div class="bottom-container row">
            <div class="sec2-myymh col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="/myyamaha">
                    <img src="{{ url('/images/my_yamaha.jpg')}}" alt="">
                </a>
            </div>
            <div class="sec2-find col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="">
                    <img src="{{ url('/images/find_dealer.jpg')}}" alt="">
                </a>
            </div>
        </div>
    </section>

    {{-- <section class="third-section container-fluid">
        <div class="caption-container">
            <h2 class="title">News Release</h2>
            <a href="{{ url('/news') }}"><p class="read-more">Read More ></p></a>
        </div>
        <div class="news-container row">
            @foreach ($articles as $article)
                <div class="news-item col-md-3">
                <a href="{{ url("news/$article->uri") }}">
                    <img src="{{ url($article->image_thumbnail) }}" alt="">
                    <span>{{ $article->title }}</span>
                </a>
                </div>
            @endforeach
        </div>
    </section> --}}
@endsection

@section('additional_script')
    
@endsection