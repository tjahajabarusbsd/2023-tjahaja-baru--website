@extends('layouts.master')

@section('title', 'Yamaha ' . $group->name . ' | Tjahaja Baru')

@section('meta_og')
<meta property="og:title" content="Yamaha {{ $group->name }} | Tjahaja Baru" />
<meta property="og:description"
    content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia." />
<meta property="og:type" content="website" />
<meta property="og:image" content="{{ url($group->banner) }}">
<meta property="og:image:width" content="1000" />
<meta property="og:image:height" content="667" />
<meta property="og:url" content="{{ Request::url() }}" />
@endsection

@section('main_class', 'product-detail')

@section('additional_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}" />
<link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
<link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
@endsection

@section('content')
<section class="first-section">
    <div class="container-fluid icon-container">
        <div class="row icon-row pc">
            <div class="product-icon-box">
                <a href="/products/category/maxi">
                    <img src="{{ url('images/products/icons/maxi_i.png') }}" alt="" class="icon">
                    <p class="text">MAXi</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/classy">
                    <img src="{{ url('images/products/icons/classy_i.png') }}" alt="" class="icon">
                    <p class="text">Classy</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/matic">
                    <img src="{{ url('images/products/icons/matic_i.png') }}" alt="" class="icon">
                    <p class="text">Matic</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/sport">
                    <img src="{{ url('images/products/icons/sport_i.png') }}" alt="" class="icon">
                    <p class="text">Sport</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/moped">
                    <img src="{{ url('images/products/icons/moped_i.png') }}" alt="" class="icon">
                    <p class="text">Moped</p>
                </a>
            </div>
            <div class="product-icon-box compare-menu">
                <a href="/compare_product">Compare Product</a>
            </div>
        </div>
        <div class="row icon-row mobile">
            <div class="product-icon-box">
                <a href="/products/category/maxi">
                    <img src="{{ url('images/products/icons/maxi_i.png') }}" alt="" class="icon">
                    <p class="text">MAXi</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/classy">
                    <img src="{{ url('images/products/icons/classy_i.png') }}" alt="" class="icon">
                    <p class="text">Classy</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/matic">
                    <img src="{{ url('images/products/icons/matic_i.png') }}" alt="" class="icon">
                    <p class="text">Matic</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/sport">
                    <img src="{{ url('images/products/icons/sport_i.png') }}" alt="" class="icon">
                    <p class="text">Sport</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/moped">
                    <img src="{{ url('images/products/icons/moped_i.png') }}" alt="" class="icon">
                    <p class="text">Moped</p>
                </a>
            </div>
            <div class="product-icon-box compare-menu">
                <a href="/compare_product">Compare Product</a>
            </div>
        </div>
    </div>
    @if (!empty($group->banner))
    <div class="banner">
        <picture>
            <img src="{{ url($group->banner) }}" alt="">
        </picture>
    </div>
    @else
    <div class="features">
        <picture>
            <img src="" alt="">
        </picture>
        <h1>Banner</h2>
    </div>
    @endif
</section>

<section class="second-section">
    <div class="background-wrapper">
        <div class="background"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <h2 class="title blue">variant & price</h2>
        </div>
        <div class="row version-row">
            <ul class="variant-wrapper">
                @php
                $currentUrl = url()->current();
                $nmaxTurbo = strpos($currentUrl, 'nmax-turbo') !== false;
                @endphp
                @foreach ($variantNames as $item)
                @php
                if ($nmaxTurbo) {
                $parts = explode(' ', $item, 2);
                $result = isset($parts[1]) ? $parts[1] : '';
                } else {
                $result = $item;
                }
                @endphp
                <li data-variant="{{ $item }}" class="variant-unit">{{ $result }}</li>
                @endforeach
            </ul>
        </div>

        <div class="product-card">
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @foreach ($data as $item)
                    <div class="swiper-slide">
                        <img src="{{ url($item->image) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="caption-box">
                <div class="color-wrapper text-center"></div>
                <p class="price">{{ $data[0]->price }}</p>
                <p class="price">{{ $data[0]->name }}</p>
                <p class="area-price">Harga OTR Sumatera Barat</p>
                <div class="button-compare">
                    <a href="/compare_product" class="btn btn-primary">Compare Product</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="third-section">
    <div class="container-fluid">
        <div class="features row">
            <div class="features-wrapper">
                <h2 class="title blue">features</h2>
                <div class="swiper features-slider">
                    <div class="swiper-wrapper">
                        @foreach ($features as $feature)
                        <div class="swiper-slide">
                            <div class="features-slide">
                                <img src="{{ url($feature->image) }}" loading="lazy" class="feature-img">
                                <p class="feature-title">{{ $feature->title }}</p>
                                <p class="feature-body">{{ $feature->body }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination mt-8"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="navtabs">
    <h2 class="title blue">spesifikasi</h2>
    <div class="container-fluid">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="specTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="mesin-tab" data-bs-toggle="tab" href="#mesin" role="tab"
                    aria-controls="mesin" aria-selected="true">Mesin</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="rangka-tab" data-bs-toggle="tab" href="#rangka" role="tab"
                    aria-controls="rangka" aria-selected="false">Rangka</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="dimensi-tab" data-bs-toggle="tab" href="#dimensi" role="tab"
                    aria-controls="dimensi" aria-selected="false">Dimensi</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="kelistrikan-tab" data-bs-toggle="tab" href="#kelistrikan" role="tab"
                    aria-controls="kelistrikan" aria-selected="false">Kelistrikan</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="specTabsContent">
            <div class="tab-pane fade show active" id="mesin" role="tabpanel" aria-labelledby="mesin-tab">
                @if (isset($specifications['mesin']))
                <table class="table">
                    @foreach ($specifications['mesin'] as $spec)
                    <tr>
                        <td><strong>{{ $spec['label'] }}</strong></td>
                        <td>{{ $spec['value'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <p>Spesifikasi mesin tidak tersedia.</p>
                @endif
            </div>
            <div class="tab-pane fade" id="rangka" role="tabpanel" aria-labelledby="rangka-tab">
                @if (isset($specifications['rangka']))
                <table class="table">
                    @foreach ($specifications['rangka'] as $spec)
                    <tr>
                        <td><strong>{{ $spec['label'] }}</strong></td>
                        <td>{{ $spec['value'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <p>Spesifikasi rangka tidak tersedia.</p>
                @endif
            </div>
            <div class="tab-pane fade" id="dimensi" role="tabpanel" aria-labelledby="dimensi-tab">
                @if (isset($specifications['dimensi']))
                <table class="table">
                    @foreach ($specifications['dimensi'] as $spec)
                    <tr>
                        <td><strong>{{ $spec['label'] }}</strong></td>
                        <td>{{ $spec['value'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <p>Spesifikasi dimensi tidak tersedia.</p>
                @endif
            </div>
            <div class="tab-pane fade" id="kelistrikan" role="tabpanel" aria-labelledby="kelistrikan-tab">
                @if (isset($specifications['kelistrikan']))
                <table class="table">
                    @foreach ($specifications['kelistrikan'] as $spec)
                    <tr>
                        <td><strong>{{ $spec['label'] }}</strong></td>
                        <td>{{ $spec['value'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
                @else
                <p>Spesifikasi kelistrikan tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Section Video Review -->
<section class="container my-5">
    <h2 class="title blue">Video Review Produk</h2>
    <div class="row">
        @foreach ($reviews as $review)
        <div class="col-md-4 mb-4">
            <!-- Embed YouTube Video -->
            <div class="embed-responsive embed-responsive-16by9">
                <iframe width="100%" height="315" src="{{ $review->uri }}" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="main-form consultation-form">
    <div class="form-container">
        <h2 class="title blue">Konsultasi pembelian</h2>
        <p>Berminat dengan produk ini? Segera konsultasikan langsung dengan dealer kami.</p>

        @if (!empty($cookieSales))
        <input name="sales" type="text" hidden value="{{ $cookieSales }}">
        @endif
        <input name="url" type="text" hidden value="{{ Request::url() }}">

        <div class="form-group row">
            <label for="name" class="col-md-4">Nama</label>
            <div class="col-md-8">
                <input name="name" class="form-control" id="name" type="text" value="{{ old('name') }}"
                    placeholder="Nama Lengkap" maxlength="50" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="nohp" class="col-md-4">No Handphone</label>
            <div class="col-md-8">
                <input name="nohp" id="nohp" class="form-control" type="tel" value="{{ old('nohp') }}"
                    placeholder="08123456789" maxlength="15" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4">Motor yang diminati</label>
            <div class="col-md-8">
                <select name="produk" id="pilih-produk" class="form-select" aria-label="Default select example">
                    @foreach ($variantNames as $variantName)
                    <option value="{{ $variantName }}">{{ $variantName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4">Metode Pembayaran</label>
            <div class="col-md-8">
                <select id="payment-method" name="payment_method" class="form-select">
                    <option selected disabled value=""> - pilih cara bayar - </option>
                    <option value="cash">Cash</option>
                    <option value="kredit">Kredit</option>
                </select>
            </div>
        </div>

        <div id="option-bayar" class="form-group row" style="display: none;">
            <label for="down-payment" class="col-md-4">Down Payment</label>
            <div class="col-md-8">
                <select id="down-payment" name="down_payment" class="form-select">
                    <option selected disabled value=""> - pilih down payment - </option>
                    <option value="dp-0">Rp 1 Juta - Rp 5 juta</option>
                    <option value="dp-1">Rp 5 juta - Rp 10 juta</option>
                    <option value="dp-2">Rp 10 juta - Rp 15 juta</option>
                    <option value="dp-3">Diatas Rp 15 juta</option>
                </select>
            </div>
        </div>

        <div id="option-tenor-pembelian" class="form-group row" style="display: none;">
            <label for="tenor-pembelian" class="col-md-4">Jumlah Tenor</label>
            <div class="col-md-8">
                <select id="tenor-pembelian" name="tenor_pembelian" class="form-select">
                    <option selected disabled value=""> - pilih jumlah tenor - </option>
                    <option value="11">11 bulan</option>
                    <option value="17">17 bulan</option>
                    <option value="23">23 bulan</option>
                    <option value="29">29 bulan</option>
                    <option value="35">35 bulan</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label id="label-checkbox" class="d-flex align-items-start">
                <input type="checkbox" name="terms" id="termsCheckbox" style="margin-top: 5px; margin-right: 10px;">
                <span>Saya setuju bahwa informasi diatas mengizinkan TJAHAJA BARU untuk menghubungi Saya melalui
                    telepon/WhatsApp.</span>
            </label>
        </div>

        <div class="form-group">
            {!! RecaptchaV3::field('contact') !!}
            @error('g-recaptcha-response')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button id="submit-motor" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</section>
<div class="overlay" id="overlay">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">close</i>
                </div>
                <h4 class="modal-title w-100">Success!</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
@endsection

@section('additional_script')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const siteKey = '{{ config("app.recaptcha_sitekey") }}';
</script>
<script src="{{ asset('js/product.js') }}"></script>
<script src="{{ asset('js/contact.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.variant-unit').click(function() {
            var variant = $(this).attr('data-variant');
            var url = "/get-data/" + variant;

            $('.variant-unit').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var productCard = $('.product-card');
                    productCard.empty();

                    var swiperDiv = $('<div>')
                        .addClass('swiper product-slider');
                    productCard.append(swiperDiv);

                    var swiperWrapper = $('<div>')
                        .addClass('swiper-wrapper');
                    swiperDiv.append(swiperWrapper);

                    response.forEach(function(item, index) {
                        var swiperSlide = $('<div>')
                            .addClass('swiper-slide');

                        var itemImage = $('<img>')
                            .attr('src', '{{ url("/") }}' + '/' + item.image)
                            .attr('alt', '...');
                        swiperSlide.append(itemImage);
                        swiperWrapper.append(swiperSlide);
                    });

                    var captionBox = $('<div>')
                        .addClass('caption-box');
                    productCard.append(captionBox);

                    var colorWrapper = $('<div>')
                        .addClass('color-wrapper text-center');
                    captionBox.append(colorWrapper);

                    captionBox.append('<p class="price">' + response[0].price + '</p>');
                    captionBox.append('<p class="price">' + response[0].name + '</p>');
                    captionBox.append('<p class="area-price">Harga OTR Sumatera Barat</p>');
                    captionBox.append(
                        '<div class="button-compare"><a href="/compare_product" class="btn btn-primary">Compare Product</a></div>'
                    );

                    const swiper = new Swiper('.product-slider', {
                        slidesPerView: 1,
                        centeredSlides: true,
                        pagination: {
                            el: '.color-wrapper',
                            clickable: true,
                            renderBullet: function(index, className) {
                                return '<span class="' + className +
                                    '" style="background: ' + response[index]
                                    .color + '"></span>';
                            }
                        },
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan:", error);
                }
            });
        });
        const swiper = new Swiper(".product-slider", {
            slidesPerView: 1,
            centeredSlides: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.color-wrapper',
                clickable: true,
                renderBullet: function(index, className) {
                    var colors = @json($data);

                    if (index >= 0 && index < colors.length) {
                        return '<span class="' + className + '" style="background: ' + colors[index]
                            .color + '"></span>';
                    }

                    return '';
                },
            },
        });
    });

    var swiper = new Swiper(".features-slider", {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
            dynamicMainBullets: 1
        },
        breakpoints: {
            600: {
                slidesPerView: 1.2,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 2.3,
                spaceBetween: 30
            }
        },
        grabCursor: true
    });
</script>
@endsection