@extends('layouts.master')

@section('title','Yamaha ' . $group->name . ' | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="Yamaha {{ $group->name }} | Tjahaja Baru" />
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="{{ url($group->banner) }}">
  <meta property="og:image:width" content="1000" />
  <meta property="og:image:height" content="667" />
  <meta property="og:url" content="{{ Request::url() }}" />
@endsection

@section('main_class', 'product-detail')

@section('additional_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
    {{-- <style>
        .youtube-container {
            overflow: hidden;
            width: 100%;
            /* Keep it the right aspect-ratio */
            aspect-ratio: 16/9;
            /* No clicking/hover effects */
            pointer-events: none;
        } 

        .youtube-container iframe {
            /* Extend it beyond the viewport... */
            width: 300%;
            height: 100%;
            /* ...and bring it back again */
            margin-left: -100%;
        }
    </style> --}}
@endsection

@section('content')

<section class="first-section">
    <div class="container-fluid icon-container">
        <div class="row icon-row pc">
            <div class="product-icon-box">
                <a href="/products/category/maxi">
                    <img src="{{ url('images/products/icons/maxi_i.png')}}" alt="" class="icon">
                    <p class="text">MAXi</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/classy">
                    <img src="{{ url('images/products/icons/classy_i.png')}}" alt="" class="icon">
                    <p class="text">Classy</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/matic">
                    <img src="{{ url('images/products/icons/matic_i.png')}}" alt="" class="icon">
                    <p class="text">Matic</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/sport">
                    <img src="{{ url('images/products/icons/sport_i.png')}}" alt="" class="icon">
                    <p class="text">Sport</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/moped">
                    <img src="{{ url('images/products/icons/moped_i.png')}}" alt="" class="icon">
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
                    <img src="{{ url('images/products/icons/maxi_i.png')}}" alt="" class="icon">
                    <p class="text">MAXi</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/classy">
                    <img src="{{ url('images/products/icons/classy_i.png')}}" alt="" class="icon">
                    <p class="text">Classy</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/matic">
                    <img src="{{ url('images/products/icons/matic_i.png')}}" alt="" class="icon">
                    <p class="text">Matic</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/sport">
                    <img src="{{ url('images/products/icons/sport_i.png')}}" alt="" class="icon">
                    <p class="text">Sport</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/moped">
                    <img src="{{ url('images/products/icons/moped_i.png')}}" alt="" class="icon">
                    <p class="text">Moped</p>
                </a>
            </div>
            <div class="product-icon-box compare-menu">
                <a href="/compare_product">Compare Product</a>
            </div>
        </div>
    </div>
    @if(!empty($group->banner))
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
    {{-- <div class="youtube-container" style="pointer-events: none;">
        <span>
            <iframe class="delayed" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" title="2024 Yamaha MT-09: Unleash your Darkness" width="640" height="360" src="https://www.youtube.com/embed/6WNa658b8nw?autoplay=1&amp;controls=0&amp;mute=1&amp;keyboard=1&amp;autohide=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;disablekb=1&amp;rel=0&amp;host=https%3A%2F%2Fwww.youtube.com&amp;origin=https%3A%2F%2Fwww.yamaha-motor.eu&amp;enablejsapi=1&amp;loop=1&amp;playlist=6WNa658b8nw&amp;start=0&amp;widgetid=3" id="undefined" class="undefined"></iframe>
        </span>
    </div> --}}
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
                            // Memecah string berdasarkan spasi jika URL mengandung 'motor-A'
                            $parts = explode(' ', $item, 2); // 2 adalah jumlah maksimum elemen dalam array
                            $result = isset($parts[1]) ? $parts[1] : ''; // Mengambil elemen kedua jika ada
                        } else {
                            // Tidak memodifikasi string jika URL tidak mengandung 'nmax-turbo'
                            $result = $item;
                        }
                    @endphp
                    <li data-variant="{{ $item }}" class="variant-unit">{{ $result }}</li>
                @endforeach
            </ul>
        </div>

        <div class="product-card">
            <div class="swiper">
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
            <h2 class="title white">features</h2>
            <div class="features-wrapper">
                @foreach ($features as $feature)
                    <div class="features-content">
                        <img src="{{ url($feature->image) }}" loading="lazy" class="feature-img">
                        <p class="feature-title">{{$feature->title}}</p>
                        <p class="feature-body">{{$feature->body}}</p>
                    </div>
                @endforeach
                {{-- @php
                    $totalFeatures = count($features);
                    $columnSize = ceil($totalFeatures / 3); // Ukuran setiap kolom
                @endphp

                <div class="left-column">
                    @for ($i = 0; $i < $columnSize && $i < $totalFeatures; $i++)
                        <div class="features-content">
                            <img src="{{ url($features[$i]->image) }}" loading="lazy" class="feature-img">
                            <p class="feature-title">{{ $features[$i]->title }}</p>
                            <p class="feature-body">{{ $features[$i]->body }}</p>
                        </div>
                    @endfor
                </div>

                <div class="center-column">
                    @for ($i = $columnSize; $i < 2 * $columnSize && $i < $totalFeatures; $i++)
                        <div class="features-content">
                            <img src="{{ url($features[$i]->image) }}" loading="lazy" class="feature-img">
                            <p class="feature-title">{{ $features[$i]->title }}</p>
                            <p class="feature-body">{{ $features[$i]->body }}</p>
                        </div>
                    @endfor
                </div>

                <div class="right-column">
                    @for ($i = 2 * $columnSize; $i < $totalFeatures; $i++)
                        <div class="features-content">
                            <img src="{{ url($features[$i]->image) }}" loading="lazy" class="feature-img">
                            <p class="feature-title">{{ $features[$i]->title }}</p>
                            <p class="feature-body">{{ $features[$i]->body }}</p>
                        </div>
                    @endfor
                </div> --}}
            </div>
            
        </div>
    </div>
</section>

<section class="navtabs">
    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-spec-tab" data-bs-toggle="tab" data-bs-target="#nav-spec" type="button" role="tab" aria-controls="nav-spec" aria-selected="false">Spec View</button>
                <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="true">Review</button>
                {{-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> --}}
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
                <div class="spec-wrapper">
                    <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                        <div class="spec-part-title row">
                            <b>Mesin</b>
                        </div>
                    </a>
                    <div class="collapse row show" id="collapse-1">
                        @if ( $groupSpec != null )
                        <table>
                            <tr>
                                <td class="spec-part-td1">Tipe Mesin</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_mesin : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Jumlah/Posisi Silinder</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->jumlah_silinder : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Volume Silinder</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->volume_silinder : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Diameter x Langkah</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->diameter_x_langkah : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Perbandingan Kompresi</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->perbandingan_kompresi : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Daya Maksimum</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->daya_maksimum : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Torsi Maksimum</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->torsi_maksimum : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Sistem Starter</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->sistem_starter : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Sistem Pelumasan</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->sistem_pelumasan : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->kapasitas_oli : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->sistem_bahan_bakar : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Tipe Kopling</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_kopling : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Tipe Transmisi</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_transmisi : '-' }}</td>
                            </tr>
                            @if ( $groupSpec->pola_transmisi == !null )
                            <tr>
                                <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->pola_transmisi : '-' }}</td>
                            </tr>
                            @endif
                        </table>
                        @endif
                    </div>
                    <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                        <div class="spec-part-title row">
                            <b>Rangka</b>
                        </div>
                    </a>
                    <div class="collapse row" id="collapse-2">
                        @if ( $groupSpec != null )
                        <table>
                            <tr>
                                <td class="spec-part-td1">Tipe Rangka</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_rangka : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Suspensi Depan</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->suspensi_depan : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Suspensi Belakang</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->suspensi_belakang : '-' }}</td>
                            </tr>
                            @if ( $groupSpec->tipe_ban == !null )
                            <tr>
                                <td class="spec-part-td1">Tipe Ban</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_ban : '-' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="spec-part-td1">Ban Depan</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->ban_depan : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Ban Belakang</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->ban_belakang : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Rem Depan</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->rem_depan : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Rem Belakang</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->rem_belakang : '-' }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                    <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                        <div class="spec-part-title row">
                            <b>Dimensi</b>
                        </div>
                    </a>
                    <div class="collapse row" id="collapse-3">
                        @if ( $groupSpec != null )
                        <table>
                            <tr>
                                <td class="spec-part-td1">P x L x T</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->p_l_t : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->jarak_sumbu : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->jarak_terendah_ketanah : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tinggi_tempat_duduk : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Berat Isi</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->berat_isi : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->kapasitas_tangki : '-' }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                    <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                        <div class="spec-part-title row">
                            <b>Kelistrikan</b>
                        </div>
                    </a>
                    <div class="collapse row" id="collapse-4">
                        @if ( $groupSpec != null )
                        <table>
                            <tr>
                                <td class="spec-part-td1">Sistem pengapian</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->sistem_pengapian : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Battery</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->battery : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="spec-part-td1">Tipe Busi</td>
                                <td class="spec-part-td2">:</td>
                                <td class="spec-part-td3">{{ $groupSpec ? $groupSpec->tipe_busi : '-' }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                <div class="review-wrapper row">
                    @foreach ($reviews as $review)
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url($review->thumbnail) }}" alt="">
                            </picture>
                            <a href="{{$review->uri}}" target="_blank">
                                <p class="review-title">{{$review->title}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-form consultation-form">
    <div class="form-container">
        <h1>Konsultasi pembelian</h1>
        <p>Berminat dengan produk ini? Segera konsultasikan langsung dengan dealer kami.</p>

        @if (!empty($cookieSales))
            <input name="sales" type="text" hidden value="{{ $cookieSales }}">
        @endif
        <input name="url" type="text" hidden value="{{ Request::url() }}">

        <div class="form-group row">
            <label for="name" class="col-md-4">Nama</label>
            <div class="col-md-8">
                <input name="name" class="form-control" id="name" type="text" value="{{ old('name') }}"  placeholder="Nama Lengkap" maxlength="50" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="nohp" class="col-md-4">No Handphone</label>
            <div class="col-md-8">
                <input name="nohp" id="nohp" class="form-control" type="tel" value="{{ old('nohp') }}"  placeholder="08123456789" maxlength="15" required>
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
                <span>Saya setuju bahwa informasi diatas mengizinkan TJAHAJA BARU untuk menghubungi Saya melalui telepon/WhatsApp.</span>
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
<script>const siteKey = '{{ config('app.recaptcha_sitekey') }}';</script>
<script src="{{ asset('js/product.js') }}"></script>
<script src="{{ asset('js/contact.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.variant-unit').click(function () {
            var variant = $(this).attr('data-variant');
            var url = "/get-data/" + variant;

            $('.variant-unit').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    var productCard = $('.product-card');
                    productCard.empty();

                    var swiperDiv = $('<div>')
                        .addClass('swiper');
                    productCard.append(swiperDiv);

                    var swiperWrapper = $('<div>')
                        .addClass('swiper-wrapper');
                    swiperDiv.append(swiperWrapper);

                    response.forEach(function (item, index) {
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
                    captionBox.append('<div class="button-compare"><a href="/compare_product" class="btn btn-primary">Compare Product</a></div>');

                    const swiper = new Swiper('.swiper', {
                        slidesPerView: 1,
                        centeredSlides: true,
                        pagination: {
                            el: '.color-wrapper',
                            clickable: true,
                            renderBullet: function (index, className) {
                                return '<span class="' + className + '" style="background: ' + response[index].color + '"></span>';
                            }
                        },
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Terjadi kesalahan:", error);
                }
            });
        });
        const swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            centeredSlides: true,
            pagination: {
                el: '.color-wrapper',
                clickable: true,
                renderBullet: function (index, className) {
                    var colors = @json($data);

                    if (index >= 0 && index < colors.length) {
                        return '<span class="' + className + '" style="background: ' + colors[index].color + '"></span>';
                    }

                    return '';
                }
            },
        });
    });
</script>
@endsection