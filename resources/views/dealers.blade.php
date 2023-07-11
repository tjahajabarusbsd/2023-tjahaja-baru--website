@extends('layouts.master')

@section('title', 'Dealers | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Dealers | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'dealers')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/dealers.css') }}" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="dealer-header">
        <h1>Cari Dealer</h1>
        <div class="input-group">
            <input type="input" id="search-input" class="form-control rounded" placeholder="Cari dealer..." aria-label="Search" aria-describedby="search-addon" />
        </div>
    </div>
    <div class="dealer-list">
        <div class="dealer-card">
            <div class="card-body">
                <div class="box-header">
                    <h5 class="card-title">TB Sentral Yamaha</h5>
                    <div class="direction">
                        <a href="https://goo.gl/maps/vd9vQePLctcjNEp9A" target="_blank" class="link"><img src="{{ url("images/icons/location.png")}}" alt="" class="location-icon"></a>
                    </div>
                </div>
                <div class="address-container">
                    <p class="address">Jl. Damar No.59, Kota Padang, Sumatera Barat 25113</p>
                </div>
                <a href="tel:0811805898" class="btn btn-primary btn-tlpn"><img src="{{ url('/images/icons/phone.png')}}" alt="" class="phone">0811805898</a>
            </div>
        </div>
        <div class="dealer-card">
            <div class="card-body">
                <div class="box-header">
                    <h5 class="card-title">Yamaha TB Proklamasi</h5>
                    <div class="direction">
                        <a href="https://goo.gl/maps/cCnX8P83HB2erhu29" target="_blank" class="link"><img src="{{ url("images/icons/location.png")}}" alt="" class="location-icon"></a>
                    </div>
                </div>
                <div class="address-container">
                    <p class="address">Jl. Proklamasi No. 49, Kota Padang, Sumatera Barat 25133</p>
                </div>
                <a href="tel:08126739873" class="btn btn-primary btn-tlpn"><img src="{{ url('/images/icons/phone.png')}}" alt="" class="phone">08126739873</a>
            </div>
        </div>
        <div class="dealer-card">
            <div class="card-body">
                <div class="box-header">
                    <h5 class="card-title">Yamaha TB Tabing</h5>
                    <div class="direction">
                        <a href="https://goo.gl/maps/BSfSusE49tFkFees9" target="_blank" class="link"><img src="{{ url("images/icons/location.png")}}" alt="" class="location-icon"></a>
                    </div>
                </div>
                <div class="address-container">
                <p class="address">Jl. Prof. Dr. Hamka No.56, Kota Padang, Sumatera Barat 25173</p>
                </div>
                <a href="tel:085378417444" class="btn btn-primary btn-tlpn"><img src="{{ url('/images/icons/phone.png')}}" alt="" class="phone">085378417444</a>
            </div>
        </div>
    </div>
    <div class="product-list">
        <h2>Rekomendasi Produk<br/>Untuk Anda</h2>
        <div class="grid-container">
            @foreach ($products as $product)
            <div class="grid-content">
                <a class="product-link" href="/product/{{ $product->uri }}">
                    <div class="box-img">
                        <img src="{{ url($product->image) }}" alt="" class="product-unit-image">
                    </div>
                    <div class="box-text">
                        <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                        <p class="product-price">{{ $product->price }}</p>
                        <img class="tombol-biru" src="{{ url('/images/tombol1.png')}}" alt="">
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('additional_script')
    <script>
        $(document).ready(function() {
            // Event handler saat tombol pencarian diklik
            $("#search-input").keyup(function() {
                // Mendapatkan nilai input pencarian
                var searchTerm = $(this).val().toLowerCase();

                $(".dealer-card").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1)
                });

                // Menyembunyikan semua elemen dengan kelas "col-sm-4"
                // $(".dealer-card").hide();

                // Mencari dan menampilkan hanya elemen dengan nilai pencarian yang sesuai di card-title
                // $(".card-title:contains(" + searchTerm + ")").closest(".dealer-card").show();
            });
        });
    </script>
@endsection