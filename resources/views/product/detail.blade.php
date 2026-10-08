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
    <link rel="stylesheet" href="{{ asset('css/page-toc.css') }}" />
@endsection

@section('content')
    @php
        $tocItems = [
            'variant' => 'Variant & Price',
            'features' => 'Features',
            'spesifikasi' => 'Spesifikasi',
        ];
        if ($reviews->isNotEmpty()) {
            $tocItems['video'] = 'Video Review';
        }
        $tocItems['konsultasi'] = 'Konsultasi Pembelian';
    @endphp
    @include('partials.page-toc', ['items' => $tocItems])
    <section class="first-section">
        @php
            $categories = [
                'maxi' => 'MAXi',
                'classy' => 'Classy',
                'matic' => 'Matic',
                'sport' => 'Sport',
                'moped' => 'Moped',
            ];
        @endphp
        <div class="container-fluid icon-container">
            @foreach (['pc', 'mobile'] as $device)
                <div class="row icon-row {{ $device }}">
                    @foreach ($categories as $slug => $name)
                        <div class="product-icon-box">
                            <a href="/products/category/{{ $slug }}">
                                <img src="{{ url("images/products/icons/{$slug}_i.png") }}" alt="{{ $name }}"
                                    class="icon">
                                <p class="text">{{ $name }}</p>
                            </a>
                        </div>
                    @endforeach
                    <div class="product-icon-box compare-menu">
                        <a href="/compare_product">Compare Product</a>
                    </div>
                </div>
            @endforeach
        </div>
        @if (!empty($group->banner))
            <div class="banner">
                <picture>
                    <img src="{{ url($group->banner) }}" alt="">
                </picture>
            </div>
        @else
            <div class="features">
                <h1>Banner</h1>
            </div>
        @endif
    </section>

    <section class="second-section" id="variant" data-toc-section>
        <div class="background-wrapper">
            <div class="background"></div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <h2 class="title blue">variant & price</h2>
            </div>
            <div class="row version-row">
                <ul class="variant-wrapper">
                    @foreach ($variantLabels as $variantName => $label)
                        <li data-variant="{{ $variantName }}" class="variant-unit">{{ $label }}</li>
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
                    <p class="text-muted disclaimer text-center">
                        *Harga dapat berubah sewaktu-waktu
                    </p>
                    <div class="button-compare">
                        <a href="/compare_product" class="btn btn-primary">Compare Product</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="third-section" id="features" data-toc-section>
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

    <section class="navtabs" id="spesifikasi" data-toc-section>
        <h2 class="title blue">spesifikasi</h2>
        <div class="container-fluid">
            @php
                $specTabs = [
                    'mesin' => 'Mesin',
                    'rangka' => 'Rangka',
                    'dimensi' => 'Dimensi',
                    'kelistrikan' => 'Kelistrikan',
                ];
            @endphp
            <!-- Nav Tabs -->
            <ul class="nav nav-tabs" id="specTabs" role="tablist">
                @foreach ($specTabs as $key => $label)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab"
                            data-bs-toggle="tab" href="#{{ $key }}" role="tab"
                            aria-controls="{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="specTabsContent">
                @foreach ($specTabs as $key => $label)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}"
                        role="tabpanel" aria-labelledby="{{ $key }}-tab">
                        @if (!empty($specifications[$key]))
                            <table class="table">
                                @foreach ($specifications[$key] as $spec)
                                    <tr>
                                        <td><strong>{{ $spec['label'] }}</strong></td>
                                        <td>{{ $spec['value'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>Spesifikasi {{ strtolower($label) }} tidak tersedia.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section Video Review -->
    @if ($reviews->isNotEmpty())
        <section class="container my-5" id="video" data-toc-section>
            <h2 class="title blue">Video Review Produk</h2>
            <div class="row">
                @foreach ($reviews as $review)
                    <div class="col-md-4 mb-4">
                        <!-- Embed YouTube Video -->
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="100%" height="315" src="{{ $review->uri }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="main-form consultation-form" id="konsultasi" data-toc-section>
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
                    <input name="name" class="form-control" id="name" type="text"
                        value="{{ old('name') }}" placeholder="Nama Lengkap" maxlength="50" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nohp" class="col-md-4">No Handphone</label>
                <div class="col-md-8">
                    <input name="nohp" id="nohp" class="form-control" type="tel"
                        value="{{ old('nohp') }}" placeholder="08123456789" maxlength="15" required>
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
                    <input type="checkbox" name="terms" id="termsCheckbox"
                        style="margin-top: 5px; margin-right: 10px;">
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
        const siteKey = '{{ config('app.recaptcha_sitekey') }}';
    </script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/contact.js') }}"></script>
    <script src="{{ asset('js/page-toc.js') }}"></script>
    <script>
        $(function() {
            const baseUrl = @json(url('/'));
            const variants = @json($variantsByName);
            let productSwiper;

            const imgUrl = (path) => `${baseUrl}/${path}`;

            // Preload semua gambar di awal supaya saat klik tidak ada jeda
            Object.values(variants).flat().forEach(item => {
                new Image().src = imgUrl(item.image);
            });

            /* ---------- Product slider ---------- */
            function initProductSwiper(colors) {
                productSwiper?.destroy(true, true);
                productSwiper = new Swiper('.product-slider', {
                    slidesPerView: 1,
                    centeredSlides: true,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    pagination: {
                        el: '.color-wrapper',
                        clickable: true,
                        renderBullet: (index, className) =>
                            `<span class="${className}" style="background:${colors[index] ?? 'transparent'}"></span>`,
                    },
                });
            }

            function renderProduct(items) {
                if (!items?.length) return;

                const first = items[0];
                const $card = $('.product-card');

                // kunci tinggi kartu supaya halaman tidak melompat saat isi diganti
                $card.css('min-height', $card.outerHeight());

                const slides = items.map(item =>
                    `<div class="swiper-slide"><img src="${imgUrl(item.image)}" alt=""></div>`
                ).join('');

                productSwiper?.destroy(true, true);

                $card.html(`
                    <div class="swiper product-slider">
                        <div class="swiper-wrapper">${slides}</div>
                    </div>
                    <div class="caption-box">
                        <div class="color-wrapper text-center"></div>
                        <p class="price">${first.price}</p>
                        <p class="price">${first.name}</p>
                        <p class="area-price">Harga OTR Sumatera Barat</p>
                        <p class="text-muted disclaimer text-center">*Harga dapat berubah sewaktu-waktu</p>
                        <div class="button-compare">
                            <a href="/compare_product" class="btn btn-primary">Compare Product</a>
                        </div>
                    </div>
                `);

                initProductSwiper(items.map(i => i.color));
            }

            /* ---------- Variant switcher ---------- */
            $('.variant-unit').first().addClass('active');
            initProductSwiper(@json($data->pluck('color')));

            $('.variant-unit').on('click', function() {
                const $el = $(this);
                if ($el.hasClass('active')) return; // klik varian yang sama: abaikan

                $('.variant-unit').removeClass('active');
                $el.addClass('active');

                renderProduct(variants[$el.attr('data-variant')]);
            });

            /* ---------- Features slider ---------- */
            new Swiper('.features-slider', {
                slidesPerView: 1,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
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
        });
    </script>
@endsection
