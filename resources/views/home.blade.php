@extends('layouts.master')

@section('title', 'Yamaha Sumatera Barat | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="Yamaha Sumatera Barat | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'home')

@section('additional_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection

@section('content')
    <section class="main-banner">
        <div class="swiper banner-wrapper">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                <div class="swiper-slide">
                    <picture>
                        <img src="{{ url($banner->image) }}" loading="lazy" class="banner-img">
                    </picture>
                </div>
                @endforeach
            </div>
        </div>
        <div class="banner-pagination text-center"></div>
    </section>    

    <section class="first-section container-fluid">
        <div class="caption-container">
            <p class="title">Product Category</p>
            <p class="price-area">Harga Area Sumatera Barat</p>
        </div>
        
        <div class="swiper grid-container">
            <div class="swiper-wrapper">
                @foreach ($latestVariants as $variant)
                <div class="swiper-slide">
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
                </div>
                @endforeach
            </div>
        </div>	
        <div class="swiper-pagination" style="bottom: -23px;"></div>
    </section>

    <section class="second-section container-fluid">
        <div class="top-container row">
            <div class="col-sm-6 mb-3">
                <div class="promo-container" style="background-color:#79dbc0;">
                    <div class="promo-title-container mb-3">
                        <p class="promo-title">Promo</p>
                    </div>
                    <div class="promo-banner-container row">
                        @foreach ($promos as $promo)
                            <div class="promo-banner-col col-sm-6 mb-3">
                                <div class="promo-banner-item" data-id={{ $promo->id }}>
                                    <img src="{{ url($promo->image) }}" alt="" data-bs-toggle="modal"
                                    data-bs-target="#promoModal{{ $promo->id }}">
                                    <div class="modal fade" id="promoModal{{ $promo->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true" data-id={{ $promo->id }}>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title w-100" id="exampleModalLabel">
                                                        {{ $promo->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!--Modal body with image-->
                                                <div class="modal-body">
                                                    <img src="{{ url($promo->image) }}" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <a href="https://www.yamaha-motor.co.id/part-accessories/ygp/" target="_blank" class="part-acc">
                    <img src="{{ url('/images/parts.jpg')}}" alt="">
                </a>
            </div>
        </div>

        <div class="bottom-container row">
            <div class="col-sm-6 mb-3">
                <a href="/myyamaha">
                    <img src="{{ url('/images/my_yamaha.jpg')}}" alt="">
                </a>
            </div>
            <div class="col-sm-6 mb-3">
                <a href="/dealers">
                    <img src="{{ url('/images/find_dealer.jpg')}}" alt="">
                </a>
            </div>
        </div>
    </section>

    <!-- Bootstrap Modal -->
    <div class="modal fade modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="text-align: center">
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
                    <img src="{{ url('/images/quiz_banner.jpeg')}}" alt="">
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
<script src="{{ asset('js/home.js') }}"></script>
@endsection