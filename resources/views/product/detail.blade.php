@extends('layouts.custom')

@section('title', $group->name . ' | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="{{ $group->name }} | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
	{{-- <meta property="og:image" content="{{ url($image) }}"> --}}
	<meta property="og:image:width" content="1000" />
	<meta property="og:image:height" content="667" />
	<meta property="og:url" content="{{ Request::url() }}">
@endsection

@section('main_class', 'product-detail')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
@endsection

@section('content')
<section class="first-section">
    <div class="container-fluid icon-container">
        <div class="row icon-row">
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
    <div class="banner">
        <picture>
            <img src="" alt="">
        </picture>
        <h1>Banner</h1>
    </div>
</section>

<section class="second-section">
    <div class="background-wrapper">
        <div class="background"></div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <h2 class="title">variant & price</h2>
        </div>
        {{-- <div class="row version-row">
            <div class="version active">
                <h3 class="text">neo</h3>
            </div>
            <div class="version">
                <h3 class="text">lux</h3>
            </div>
        </div> --}}
        
        
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-interval="false">
            <div class="carousel-indicators">
                {{-- <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button> --}}
                @php
                    $i = 0;
                @endphp
                @foreach ($data as $item)
                <button type='button' data-bs-target='#carouselExampleDark' data-bs-slide-to='{{$i}}' class='sign'></button>
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
            {{-- <p class="price">{{ $item->price }}</p>
            <p class="price">{{ $item->name }}</p> --}}
            <p class="area-price">Harga OTR Sumatera Barat</p>
        </div>
    </div>
</section>

<section class="section3">
    <div class="banner">
        <picture>
            <img src="" alt="">
        </picture>
        <h2>Features</h2>
    </div>
</section>

<section class="main-form consultation-form">
    <div class="form-container">
        <h1>Konsultasi pembelian</h1>
        {{-- <p>Silakan konsultasikan minat produk Yamaha impian Anda langsung dengan dealer kami.</p> --}}
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

        <form action="/send_message" method="post">
            @csrf
            @if (!empty($_GET['sales']))
                <input name="sales" type="text" hidden value="{{ $_GET['sales'] }}">
            @endif
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input name="name" class="form-control" type="text"  required placeholder="Nama Lengkap" maxlength="50">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="nohp">No. Handphone (WhatsApp)</label>
                <input name="nohp" class="form-control" type="tel" value="{{ old('nohp') }}" required placeholder="08123456789" maxlength="15">
                @error('nohp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="lists">Produk yang diminati</label>
                <select name="produk" class="form-select" aria-label="Default select example" >
                    <option selected disabled value=""> - pilih produk - </option>
                    @foreach ($variantNames as $variantName)
                        <option value="{{ $variantName }}">{{ $variantName }}</option>
                    @endforeach
                </select>
                {{-- <input name="produk" class="form-control" type="input" value="{{ $item->name }}" readonly="true"> --}}
                @error('produk')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                {!! RecaptchaV3::field('consultation') !!}
                @error('g-recaptcha-response')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </form>
    </div>
</section>
@endsection

@section('additional_script')
<script>
    var introCarousel = $(".carousel");
    var introCarouselIndicators = $(".carousel-indicators");

    introCarousel.find(".carousel-inner").children(".carousel-item:first").addClass('active');
    introCarouselIndicators.children(".sign:first").addClass('active');
</script>
@endsection