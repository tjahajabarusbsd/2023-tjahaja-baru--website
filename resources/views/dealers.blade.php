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
        <h1 class="title">Cari Dealer</h1>

        <p>Temukan dealer kami di map interaktif di bawah ini. Klik <span><img src="{{ url("images/icons/map_open.png")}}" alt=""></span> untuk melihat daftar dealer. Atau bisa langsung klik <span><img class="location-icon" src="{{ url("images/icons/location.png")}}" alt=""></span> untuk melihat detail dealer.</p>
        {{-- <form id="searchForm">
            <div class="input-group">
                <input type="text" name="search" id="searchInput" class="form-control" value="{{ $search }}" placeholder="Cari dealer..."  />
                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-outline-secondary" type="button" onclick="resetSearch()">Reset</button>
            </div>
        </form> --}}
    </div>
    <div class="map-container">
        <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1lrxDumVVEMR4hPrdKbX22nVCpTp2A9g&ehbc=2E312F" width="100%" height="600"></iframe>
    </div>
    {{-- <div class="dealer-list">
        @foreach ($dealers as $dealer)
        <div class="dealer-card">
            <div class="card-body">
                <div class="box-header">
                    <h5 class="card-title">{{ $dealer->name_dealer}}</h5>
                    <div class="direction">
                        <a href="https://www.google.co.id/maps?q={{ $dealer->latitude }},{{ $dealer->longitude }}" target="_blank" class="link"><img src="{{ url("images/icons/location.png")}}" alt="" class="location-icon"></a>
                    </div>
                </div>
                <div class="address-container">
                    <p class="address">{{ $dealer->address }}</p>
                </div>
                <a href="tel:{{ $dealer->nohp }}" class="btn btn-primary btn-tlpn"><img src="{{ url('/images/icons/phone.png')}}" alt="" class="phone">{{ $dealer->nohp }}</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination-wrapper">
        <!-- Tampilkan tautan navigasi halaman -->
        {{ $dealers->appends(['search' => $search])->links() }}
    </div> --}}
    
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
        function resetSearch() {
            var searchForm = document.getElementById('searchForm');
            var searchInput = searchForm.querySelector('input[name="search"]');
            searchInput.value = '';
            searchForm.submit();
        }
    </script>
@endsection