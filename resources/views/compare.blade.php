@extends('layouts.master')

@section('title', 'Komparasi Produk | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="Komparasi Produk | Tjahaja Baru">
    <meta property="og:description"
        content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
@endsection

@section('main_class', 'compare')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/compare.css') }}?v={{ filemtime(public_path('css/compare.css')) }}" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="title">Komparasi Produk</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12 compare-spec table-responsive" id="specs-list" data-spec-url="{{ url('get_spec_details') }}">
                <div id="compare-error" class="alert alert-danger d-none" role="alert">
                    Gagal memuat spesifikasi. Silakan coba lagi.
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Spesifikasi</th>
                            @foreach ([1, 2] as $slot)
                                <th scope="col">
                                    <select class="form-select" name="produk{{ $slot }}"
                                        id="produk{{ $slot }}" data-slot="{{ $slot }}"
                                        aria-label="Pilih produk {{ $slot }}">
                                        <option selected disabled value="">- pilih produk {{ $slot }} -
                                        </option>
                                        @foreach ($specList as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody aria-live="polite">
                        <tr>
                            <td></td>
                            @foreach ([1, 2] as $slot)
                                <td class="compare-thumb" data-slot="{{ $slot }}">
                                    <img id="thumbnail{{ $slot }}" class="img-fluid d-none" alt="">
                                </td>
                            @endforeach
                        </tr>
                        @foreach ($specRows as $key => $label)
                            <tr>
                                <th scope="row" class="fw-normal">{{ $label }}</th>
                                @foreach ([1, 2] as $slot)
                                    <td data-spec="{{ $key }}" data-slot="{{ $slot }}">-</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12 product-list">
                <h2>Rekomendasi Produk<br />Untuk Anda</h2>
                <div class="grid-container">
                    @foreach ($products as $product)
                        <div class="grid-content">
                            <a class="product-link" href="/product/{{ $product->uri }}">
                                <div class="box-img">
                                    <img src="{{ url($product->image) }}" alt="{{ $product->name ?? '' }}"
                                        class="product-unit-image" loading="lazy">
                                </div>
                                <div class="box-text">
                                    <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                                    <p class="product-price">{{ $product->price }}</p>
                                    <img class="tombol-biru" src="{{ url('/images/tombol1.png') }}" alt=""
                                        aria-hidden="true">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script src="{{ asset('js/compare.js') }}?v={{ filemtime(public_path('js/compare.js')) }}"></script>
@endsection
