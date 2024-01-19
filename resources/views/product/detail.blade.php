@extends('layouts.custom')

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
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
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
                    <p class="text">bLUcRU</p>
                </a>
            </div>
            <div class="product-icon-box">
                <a href="/products/category/moped">
                    <img src="{{ url('images/products/icons/moped_i.png')}}" alt="" class="icon">
                    <p class="text">Moped</p>
                </a>
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
                @foreach ($variantNames as $item)
                    {{-- @php
                        $name = explode(" ", $item);   
                        $name = end($name);
                    @endphp --}}
                    <li data-variant="{{ $item }}" class="variant-unit">{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-interval="false">
            <div class="carousel-indicators">
                @php
                    $i = 0;
                @endphp
                @foreach ($data as $item)
                <button type='button' data-bs-target='#carouselExampleDark' data-bs-slide-to='{{$i}}' class='sign' style="background: {{$item->color}}"></button>
                @php
                    $i++
                @endphp
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($data as $item)
                    <div class="carousel-item">
                        <img src="{{ url($item->image) }}" class="d-block w-100" alt="...">
                        <div class="caption-box carousel-caption">
                            <p class="price">{{ $item->price }}</p>
                            <p class="price">{{ $item->name }}</p>
                        </div>
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
        <div class="row caption-box">
            <p class="area-price">Harga OTR Sumatera Barat</p>
        </div>
        <div class="button-compare">
            <a href="/compare_product" class="btn btn-primary">Compare Product</a>
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
                @if (Request::is('product/nmax-155'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid cooled 4-stroke, SOHC , VVA</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jumlah/Posisi Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155.09 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58 mm x 58.7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.6 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.3 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">13.9 Nm / 6500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">0,9 L (Periodical Change)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Dry Clucth</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70 - 13 M/C 48P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">130/70 - 13 M/C 63P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Hydraulic Single Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Hydraulic Single Disc Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1935 x 740 x 1160 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1340 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">765 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">130 kg (Standard & Connected Version), 132 kg (Connected/ABS Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7.1 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V/YTZ7V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CPR8EA-9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/xmax-250'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid Cooled, 4-Stroke, SOHC, 4 Valves</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jumlah/Posisi Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">249.8 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">70.0 mm X 64.9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">10.5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">16.8kW / 7000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">24.3 Nm / 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1.7 L ; Berkala = 1.5 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Dry, Centrifugal Automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Backbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic Fork</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">120/70-15M/C 56P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">140/70-14M/C 62P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">2180 mm x 795 mm x 1460 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1540 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">795 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">181</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">13 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">GTZ8V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/ LMAR8A-9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/aerox-155'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid cooled 4-stroke, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jumlah/Posisi Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58,0 mm x 58.7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.6 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.3 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">13.9Nm / 6500rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,00 L ; Berkala 0,90 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Dry, Centrifugal Automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/80-14M/C 53P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">140/70-14M/C 62P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1980mm X 700mm X 1150mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1350 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">143 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">790 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">125 kg (ABS Version), 122 Kg (Standard Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">5.5 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ7V (ABS Version), NTZ6V (Standard Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CPR8EA-9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/lexi-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid cooled 4-stroke, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jumlah/Posisi Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124.7 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52 x 58.7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.2±0.4</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">8.75 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.3 Nm / 7000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1.00 L ; Berkala = 0.90 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Dry, Centrifugal Automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic Fork</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Ban</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">90/90-14M/C 46P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/90-14M/C 57P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc ABS (S ABS Version), Disc (S & Standard Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1970 mm x 720 mm x 1135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1350 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">133 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">785 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">114 kg (S ABS, S Version), 112 Kg (Standard Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ7V (ABS Version), NTZ6V (Standard Version)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CPR8EA-9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/grand-filano'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pendingin Udara, 4-Langkah, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124,86 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,0 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">6,1 kW / 6.500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">10,4 Nm / 5.000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 0,84 L; Berkala = 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Kopling Sentrifugal, Kering</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Ban</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70-12 47L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70-12 47L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Tromol</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1820 x 685 x 1155 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1280 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">125 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">790 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100 Kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,4 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/fazzio'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pendingin Udara, 4-Langkah, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124.86 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52.4 mm x 57.9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.0: 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">6.2 kW / 6500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">10.6 Nm / 4500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total : 0.84 L ; Berkala : 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Kopling Sentrifugal, Kering</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Otomatis</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Ban</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70-12 47L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70-12 47L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Tromol</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1820 x 685 x 1125 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1280 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">750 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">95 Kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">5.1 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/freego-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Air Cooled 4-Stroke,SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">125 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,0 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 Nm/ 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 0,84 L ; Berkala = 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Dry, Centrifugal Automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic Fork</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/90 - 12M/C 59J - Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/90-12M/C 64L - Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1905 x 690 x 1115 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1275 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">780 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">101 Kg (FreeGo 125), 102 Kg (FreeGo 125 Connected)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V, GTZ4V, NTZ4V (FreeGo 125), YTZ6V (FreeGo 125 Connected)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/ CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div> 
                @elseif (Request::is('product/gear-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Berpendingin udara, 4 Langkah, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124.96 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,0 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 Nm/ 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pelumasan Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Assembly = 0,84L ; Berkala = 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Kopling Sentrifugal, Kering</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-Belt Otomatis</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/80-14M/C (43P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/70-14M/C (51P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Tromol</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1870 mm X 685 mm X 1060 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1260 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">750 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">96 Kg (Tipe S) ; 95 Kg (Tipe Standard)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V (Tipe S) ; YTZ4V/GTZ4V/NTZ4V (Tipe Standard)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>  
                @elseif (Request::is('product/fino-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Berpendingin udara, 4 Langkah, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">124.96 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,0 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 Nm/ 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pelumasan Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Assembly = 0,84L ; Berkala = 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Kopling Sentrifugal, Kering</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-Belt Otomatis</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/80-14M/C (43P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/70-14M/C (51P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Tromol</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1870 mm X 685 mm X 1060 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1260 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">750 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">96 Kg (Tipe S) ; 95 Kg (Tipe Standard)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V (Tipe S) ; YTZ4V/GTZ4V/NTZ4V (Tipe Standard)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/x-ride-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4 Langkah, 2 Valve SOHC, Berpendingin Angin, Bluecore</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Cylinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">125 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,0 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,6 Nm/ 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pelumasan Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total : 0,84 L ; Berkala : 0,80 L ; Ganti Filter Oli : 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Kopling Sentrifugal, Kering</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Full Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/80-14M/C 43P Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/70-14M/C 51P Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Tromol</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1860 mm x 740 mm x 1070 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1260 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">760 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">98 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V / GTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>  
                @elseif (Request::is('product/mio-m3-125'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Air cooled 4-stroke, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Cylinder Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">125 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">52,4 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,5 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,0 kW / 8000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,6 Nm/ 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Electric & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Pelumasan Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 0,84 L ; Berkala = 0,80 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Dry, Centrifugal Automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">V-Belt Automatic</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">70/90-14M/C (34P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/90-14M/C (40P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Hydraulic Single Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1870mm X 685mm X 1035mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1260 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">750 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">92 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V/GTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>  
                @elseif (Request::is('product/r15'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid Cooled, 4-Stroke, SOHC, 4 Valve, VVA</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155.09 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58.0 x 58.7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11.6 ± 0.4 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14.2 kW / 10000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14.7 Nm / 8500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total =1.15L; Berkala = 0.85L; Ganti Filter Oli = 0.95L L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Multi Wet Clutch</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Manual</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5-6</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Deltabox</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic Fork (Inverted)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Link Monoshock</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/80-17M/C 52P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">140/70-17M/C 66S</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1990 x 725 x 1135 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1325 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">170 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">815 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">137 Kg (All New R15), 140 Kg (All New R15M)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">GTZ4V/YTZ4V (All New R15), YTZ6V (All New R15M)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">MR8E9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/xsr-155'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid cooled, 4-Stroke, SOHC, 4 Valves, VVA</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58,0 x 58,7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,6 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14.2 kW / 10000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14.7 Nm / 8500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,50 L ; Berkala = 0,85 L ; Ganti Filter oli = 0,95 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Type Multi-Plate Clutch; Assist & Slipper Clutch</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Manual</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5-6</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Deltabox</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic Fork (Inverted)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Link Monoshock</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">110/70-17M/C (54S)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">140/70-17M/C (66S)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">2007 X 804 X 1080 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1330 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">170 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">810 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">134 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">10.4 Liter</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI/Transistor</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">MR8E9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/wr-155'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Liquid cooled, 4-Stroke, SOHC, 4 Valves, VVA</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58,0 x 58,7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,6 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">12,3 KW/10.000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14,3 Nm/ 6500 rpm </td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,50 L ; Berkala = 0,85 L ; Ganti Filter oli = 0,95 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Type Multi-plat</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Manual</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5-6</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Semi Double Cradle</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic 41 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Monoshock</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">2,75-21 45P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,10-18 59P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">240 mm Wave disc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">220 mm Wave disc</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">2007 X 804 X 1080 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1430 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">245 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">880 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">134 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">8.1 Liter</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI/Transistor</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">MR8E9</td>
                                </tr>
                            </table>
                        </div>
                    </div>    
                @elseif (Request::is('product/jupiter-z1'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Air cooled 4-stroke, SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Cylinder / Mendatar</td>
                                </tr>
                                {{-- <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">149,79 cc</td>
                                </tr> --}}
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">50,0 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,3 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">7,4 kW / 7750 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,8 Nm / 6750 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,00 L ; Berkala = 0,80 L ; Ganti filter oli = 0,85 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah, Multiplat, Centrifugal automatic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Constant mesh, 4-kecepatan</td>
                                </tr>
                                {{-- <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5</td>
                                </tr> --}}
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Backbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Swing Arm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">70/90-17 M/C (38P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/90-17 M/C (44P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1935mm x 680mm x 1065mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1240 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">150 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">765 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">101 kg (Spoke wheel) ; 102 kg (Cast wheel)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,1 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ4V/GTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/mx-king-150'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Berpendingin cairan, 4 langkah, SOHC, 4 Klep</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal/ Tegak</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">149,79 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">57,0 x 58,7 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">10,4 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,3 kW / 8500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">13,8 Nm / 7000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,15 L ; Berkala = 0,95 L ; Ganti filter oli = 1,00 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah, Kopling Manual , Multiplat</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Constant Mesh, 5-kecepatan</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Backbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Monoshock</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">90/80-17M/C (46P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">120/70-17M/C (58P)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Rem Cakram</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1985 mm X 670 mm X 1100 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1290 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">795 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">118 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">GTZ4V / YTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR8E</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/vega-force'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4 Langkah, SOHC, Berpendingin Udara</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Silinder Tunggal / Mendatar</td>
                                </tr>
                                {{-- <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">149,79 cc</td>
                                </tr> --}}
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">50,0 x 57,9 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,3 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">6,41 kW / 7000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">9,53 Nm / 5500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter & Kick Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total = 1,0 Liter ; Penggantian Berkala : 0,80 Liter ; Ganti Filter Oli : 0.85 Liter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Fuel Injection System (FI)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Basah, Kopling Otomatis, Multiplat</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Constant Mesh, 4 Kecepatan</td>
                                </tr>
                                {{-- <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5</td>
                                </tr> --}}
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Backbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Teleskopik</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Swing Arm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">70/90-17MC 38P (CW+Fr.Disc Brake) ; 70/90-17MC 38L (SW+Fr.Disc Brake)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">80/90-17MC 44P (CW+Fr.Disc Brake) ; 80/90-17MC 44L (SW+Fr.Disc Brake)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1940 x 715 x 1075mm (CW/SW+Fr.Disc Brake)</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1235 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">775 mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">96 kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,0 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">GTZ4V / YTZ4V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CR6HSA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @elseif (Request::is('product/lexi-lx'))
                    <div class="spec-wrapper">
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
                            <div class="spec-part-title row">
                                <b>Mesin</b>
                            </div>
                        </a>
                        <div class="collapse row show" id="collapse-1">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">SOHC</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Susunan Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1/ Tunggal</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Volume Silinder</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">155,09 cc</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Diameter x Langkah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">58,0mm x 58,7mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Perbandingan Kompresi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,6 : 1</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Daya Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">11,3 kW / 8.000 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Torsi Maksimum</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">14,2 Nm / 6.500 rpm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Starter</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Elektrik Starter</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Pelumasan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Wet Sump</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Oli Mesin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Total: 1 L ; Berkala: 0,9 L</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Sistem Bahan Bakar</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Injeksi</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Kopling</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Single Dry Clucth</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Automatic</td>
                                </tr>
                                {{-- <tr>
                                    <td class="spec-part-td1">Pola Pengoperasian Transmisi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1-N-2-3-4-5</td>
                                </tr> --}}
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
                            <div class="spec-part-title row">
                                <b>Rangka</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-2">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Tipe Rangka</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Underbone</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Telescopic</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Suspensi Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Unit Swing</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">90/90-14M/C 46P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Ban Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">100/90-14M/C 57P</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Ban</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Tubeless</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Depan</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Disc Brake</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Rem Belakang</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Drum Brake</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
                            <div class="spec-part-title row">
                                <b>Dimensi</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-3">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">P x L x T</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1970mm x 720mm x 1135mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Sumbu Roda</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">1350mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Jarak Terendah Ke Tanah</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">135mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tinggi Tempat Duduk</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">770mm</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Berat Isi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">Standard: 116kg ; S Version: 117kg ; Connected/ABS: 118kg</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Kapasitas Tangki Bensin</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">4,2 L</td>
                                </tr>
                            </table>
                        </div>
                        <a class="spec-part" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
                            <div class="spec-part-title row">
                                <b>Kelistrikan</b>
                            </div>
                        </a>
                        <div class="collapse row" id="collapse-4">
                            <table>
                                <tr>
                                    <td class="spec-part-td1">Sistem pengapian</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">TCI/ Transistor</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Battery</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">YTZ6V</td>
                                </tr>
                                <tr>
                                    <td class="spec-part-td1">Tipe Busi</td>
                                    <td class="spec-part-td2">:</td>
                                    <td class="spec-part-td3">NGK/CPR8EA-9</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
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

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif

        <form action="/send_message" method="post" onsubmit="disableButton()" id="detail-product-forms">
            @csrf
            @if (!empty($sales))
                <input name="sales" type="text" hidden value="{{ $sales }}">
            @endif
            <input name="url" type="text" hidden value="{{ Request::url() }}">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input name="name" id="name" class="form-control" type="text" value="{{ old('name') }}"  placeholder="Nama Lengkap" maxlength="50" required>
                @error('name')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="nohp">No. Handphone (WhatsApp)</label>
                <input name="nohp" id="nohp" class="form-control" type="tel" value="{{ old('nohp') }}" placeholder="08123456789" maxlength="15" required>
                @error('nohp')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="lists">Produk yang diminati</label>
                <select name="produk" class="form-select" aria-label="Default select example" required>
                    <option selected disabled value=""> - pilih produk - </option>
                    @foreach ($variantNames as $variantName)
                        <option value="{{ $variantName }}">{{ $variantName }}</option>
                    @endforeach
                </select>
                {{-- <input name="produk" class="form-control" type="input" value="{{ $item->name }}" readonly="true"> --}}
                @error('produk')
                    <small>{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                {!! RecaptchaV3::field('consultation') !!}
                @error('g-recaptcha-response')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <input id="submitButton" class="btn btn-primary" type="submit" value="Submit">
            </div>
        </form>
    </div>
</section>
@endsection

@section('additional_script')
<script src="{{ asset('js/product.js') }}"></script>
<script src="{{ asset('js/contact.js') }}"></script>
<script>
    $(document).ready(function() {
        
        var introCarousel = $(".carousel-inner");
        var introCarouselIndicators = $(".carousel-indicators");
        var introlCarouselPrevNext = $(".carousel-control-prev, .carousel-control-next");

        introCarousel.children(".carousel-item:first").addClass('active');
        introCarouselIndicators.children(".sign:first").addClass('active');

        var variantUnit = $(".variant-unit:first").addClass('active');

        if ( introCarousel.find(".carousel-item").length == 1 ) {
            introlCarouselPrevNext.hide();
        }
        
        $('.variant-unit').click(function() {
            $('#carouselExampleDark').carousel();
            var variant = $(this).attr('data-variant');
            var url = "/get-data/" + variant;

            $('.variant-unit').removeClass('active');
            $(this).addClass('active');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var carouselExampleDark = $('#carouselExampleDark');
                    if (carouselExampleDark.length === 0) {
                        console.error("#carouselExampleDark element not found.");
                        return;
                    }

                    var carouselIndicators = $(".carousel-indicators");
                    var carouselInner = $(".carousel-inner");
                    var carouselControlPrev = $(".carousel-control-prev");
                    var carouselControlNext = $(".carousel-control-next");

                    carouselIndicators.empty();
                    carouselInner.empty();
                    $('#carouselExampleDark').empty(carouselControlPrev);
                    $('#carouselExampleDark').empty(carouselControlNext);
                    
                    response.forEach(function(item, index) {
                    // Buat elemen indicator untuk setiap item
                    var indicatorButton = $('<button>')
                        .attr('type', 'button')
                        .attr('data-bs-target', '#carouselExampleDark')
                        .attr('data-bs-slide-to', index)
                        .addClass('sign')
                        .css('background', item.color);
                    carouselIndicators.append(indicatorButton);
                    if (index === 0) {
                        carouselIndicators.children(".sign:first").addClass('active');
                    }
                    
                    // Buat elemen item carousel untuk setiap item
                    var carouselItem = $('<div>')
                        .addClass('carousel-item');
                    if (index === 0) {
                        carouselItem.addClass('active');
                    }

                    var itemImage = $('<img>')
                        .attr('src', '{{ url('/') }}' + '/' + item.image)
                        .addClass('d-block w-100')
                        .attr('alt', '...');
                    carouselItem.append(itemImage);

                    var captionBox = $('<div>')
                        .addClass('caption-box carousel-caption');
                    var priceParagraph = $('<p>')
                        .addClass('price')
                        .text(item.price);
                    var nameParagraph = $('<p>')
                        .addClass('price')
                        .text(item.name);
                    captionBox.append(priceParagraph, nameParagraph);
                    carouselItem.append(captionBox);

                    carouselInner.append(carouselItem);
                    });

                    if ( carouselInner.find(".carousel-item").length > 1) {
                        var carouselControlPrev = $('<button>').addClass('carousel-control-prev').attr('type', 'button').attr('data-bs-target', '#carouselExampleDark').attr('data-bs-slide', 'prev');
                        var carouselControlPrevIcon = $('<span>').addClass('carousel-control-prev-icon').attr('aria-hidden', 'true');
                        var carouselControlPrevText = $('<span>').addClass('visually-hidden').text('Previous');
                        carouselControlPrev.append(carouselControlPrevIcon, carouselControlPrevText);
                        var carouselControlNext = $('<button>').addClass('carousel-control-next').attr('type', 'button').attr('data-bs-target', '#carouselExampleDark').attr('data-bs-slide', 'next');
                        var carouselControlNextIcon = $('<span>').addClass('carousel-control-next-icon').attr('aria-hidden', 'true');
                        var carouselControlNextText = $('<span>').addClass('visually-hidden').text('Next');
                        carouselControlNext.append(carouselControlNextIcon, carouselControlNextText);

                        // Append 
                        $('#carouselExampleDark').append(carouselIndicators, carouselInner, carouselControlPrev, carouselControlNext);
                    } else {
                        // Append 
                        $('#carouselExampleDark').append(carouselIndicators, carouselInner);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });

    function disableButton() {
        document.getElementById('submitButton').setAttribute('disabled', 'disabled');
    };

    $('.features-wrapper').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: true,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: true
                }
            },
            {
                breakpoint: 845,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 568,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false
                }
            }
        ]
    });

    // $('.videos-wrapper').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     dots: true,
    //     arrows: true,
    //     autoplay: false,
    //     responsive: [
    //         {
    //             breakpoint: 650,
    //             settings: {
    //                 slidesToShow: 1,
    //                 slidesToScroll: 1,
    //                 arrows: false,
    //                 dots: true
    //             }
    //         },
    //         {
    //             breakpoint: 375,
    //             settings: {
    //                 slidesToShow: 1,
    //                 slidesToScroll: 1,
    //                 arrows: false,
    //                 dots: true
    //             }
    //         }
    //     ]
    // }); 
</script>
@endsection