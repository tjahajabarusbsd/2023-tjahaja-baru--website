@extends('layouts.master')

@section('title', 'Komparasi Produk | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Komparasi Produk | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'compare')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/compare.css') }}" />       
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h1 class="title">Komparasi Produk</h1>
    </div>
    <div class="row">
        <div class="compare-spec table-responsive" id="specs-list">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="padding-bottom: 13px;">Spesifikasi</th>
                        <th>
                            <select class="form-select" aria-label="Default select example" name="produk1" id="produk1">
                                <option selected disabled value=""> - pilih produk 1 - </option>
                                @foreach ($specList as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select class="form-select" aria-label="Default select example" name="produk2" id="produk2">
                                <option selected disabled value=""> - pilih produk 2 - </option>
                                @foreach ($specList as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="width: 33%;min-width: 200px;">
                            <img id="thumbnailImage2" src="" alt="" class="img-responsive" style="width: 50%; height: auto;">
                        </td>
                        <td style="width: 33%;min-width: 200px;">
                            <img id="thumbnailImage3" src="" alt="" class="img-responsive" style="width: 50%; height: auto;">
                        </td>
                    </tr>
                    <tr>
                        <td>P x L x T</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Jarak Sumbu Roda</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Ground Clearence</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tinggi Tempat Duduk</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Berat Isi</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Volume Tangki BBM</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Volume Bagasi</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tipe Rangka</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Suspensi Depan</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Suspensi Belakang</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tipe Ban</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Ban Depan</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Ban Belakang</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Rem Depan</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Rem Belakang</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Rem ABS</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Kapasitas</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Pendingin</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Diameter x Langkah</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Rasio Kompresi</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Daya Maksimum</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Torsi Maksimum</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Sistem Starter</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Kapasitas Oli Mesin</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Sistem BBM</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tipe Kopling</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Tipe Transmisi</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Sistem Pengapian</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Baterai</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Busi</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <!-- <tr>
                        <td>Harga (OTR)</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
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
</div>
@endsection

@section('additional_script')
<script src="{{ asset('js/compare.js') }}"></script>
@endsection