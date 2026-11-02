@extends('layouts.master')

@section('title', 'Dealers | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="Dealers | Tjahaja Baru">
    <meta property="og:description"
        content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
@endsection

@section('main_class', 'dealers')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/dealers.css') }}?v={{ filemtime(public_path('css/dealers.css')) }}" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="dealer-header">
            <h1 class="title">Cari Dealer</h1>

            <p>Temukan dealer kami di map interaktif di bawah ini. Klik <span><img
                        src="{{ url('images/icons/map_open.png') }}" alt=""></span> untuk melihat daftar dealer.
                Atau bisa langsung klik <span><img class="location-icon" src="{{ url('images/icons/location.png') }}"
                        alt=""></span> untuk melihat detail dealer.</p>

        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1lrxDumVVEMR4hPrdKbX22nVCpTp2A9g&ehbc=2E312F"
                title="Peta lokasi dealer Yamaha Tjahaja Baru" loading="lazy" allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="product-list">
            <h2>Rekomendasi Produk<br />Untuk Anda</h2>
            <div class="grid-container">
                @foreach ($products as $product)
                    <div class="grid-content">
                        <a class="product-link" href="/product/{{ $product->uri }}">
                            <div class="box-img">
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="product-unit-image"
                                    loading="lazy">
                            </div>
                            <div class="box-text">
                                <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                                <p class="product-price">{{ $product->price }}</p>
                                <img class="tombol-biru" src="{{ url('/images/tombol1.png') }}" alt="">
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
