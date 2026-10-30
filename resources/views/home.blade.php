@extends('layouts.master')

@section('title', 'Yamaha Sumatera Barat | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="Yamaha Sumatera Barat | Tjahaja Baru">
    <meta property="og:description"
        content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ url('/images/og-default.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('main_class', 'home')

@section('additional_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}" />
@endsection

@section('content')
    <section class="main-banner">
        <div class="swiper banner-wrapper">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ $banner->link }}" class="banner-link">
                            <picture>
                                <img src="{{ url($banner->image) }}" loading="lazy" class="banner-img">
                            </picture>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="banner-pagination text-center"></div>
    </section>

    <section class="first-section container-fluid">
        <div class="caption-container">
            <p class="title">Product Recommendation</p>
            <p class="price-area">Harga Area Sumatera Barat</p>
        </div>

        @if ($recommendedVariants->isNotEmpty())
            <div class="product-slider">
                <div class="swiper grid-container">
                    <div class="swiper-wrapper">
                        @foreach ($recommendedVariants as $variant)
                            <div class="swiper-slide">
                                <a class="product-link" href="/product/{{ $variant->group->uri }}">
                                    <div class="box-img">
                                        <img src="{{ url($variant->image) }}" alt="{{ $variant->name }}">
                                    </div>
                                    <div class="box-text">
                                        <p class="product-name">{{ $variant->name }}</p>
                                        <p class="product-price">{{ $variant->price }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="product-pagination"></div>
            </div>
        @endif
    </section>

    <section class="second-section container-fluid">
        <div class="caption-container">
            <p class="title">Promo Sales dan After Sales</p>
        </div>
        @if ($promos->isNotEmpty())
            <div class="promo-slider">
                <div class="swiper promo-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($promos as $promo)
                            <div class="swiper-slide">
                                {{-- <a class="promo-card" href="{{ url('/promo/' . $promo->uri) }}">
                                    <img src="{{ url($promo->image) }}" alt="{{ $promo->name }}" loading="lazy">
                                </a> --}}
                                <div class="promo-card">
                                    <img src="{{ url($promo->image) }}" alt="{{ $promo->name }}" loading="lazy">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="promo-pagination"></div>
            </div>
        @else
            <p class="promo-empty">Belum ada promo saat ini.</p>
        @endif

    </section>

    <section class="second-section container-fluid">
        <div class="caption-container">
            <p class="title">Berita</p>
        </div>
        <p class="empty-section">Belum ada berita saat ini.</p>
    </section>

    <!-- Bootstrap Modal -->
    <div class="modal fade modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="text-align: center">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <div class="modal-header">
                <h5 class="modal-title w-100" id="exampleModalLabel">
                    Kuis Minat Motor Yamaha
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
                <div class="modal-body">
                    <a href="/kuis" class="link-banner-quiz">
                        <img src="{{ url('/images/quiz_banner.jpeg') }}" alt="">
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}?v={{ filemtime(public_path('js/home.js')) }}"></script>
@endsection
