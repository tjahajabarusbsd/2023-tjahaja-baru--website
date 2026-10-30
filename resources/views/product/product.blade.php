@extends('layouts.master')

@php
    $categories = config('product_categories');

    // /products = halaman indeks (isinya MAXi), /products/category/{slug} = halaman kategori
    $isIndex = request()->is('products');
    $slug = $isIndex ? 'maxi' : request()->segment(3);
    $category = $categories[$slug] ?? null;

    // Judul beda per kategori -> terbaca di Google Analytics (Page title)
    $pageTitle =
        $category && !$isIndex
            ? "Motor Yamaha {$category['name']} | Tjahaja Baru"
            : 'Produk Motor Yamaha | Tjahaja Baru';

    $pageDescription =
        $category && !$isIndex
            ? "Daftar motor Yamaha {$category['name']} beserta harga OTR Sumatera Barat di Tjahaja Baru."
            : 'Daftar motor Yamaha beserta harga OTR Sumatera Barat di Tjahaja Baru.';

    // /products memakai $maxis, halaman kategori memakai $groups (field-nya sama)
    $items = $isIndex ? $maxis : $groups;
@endphp

@section('title', $pageTitle)

@section('meta_description', $pageDescription)

@section('meta_og')
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
@endsection

@section('main_class', 'product')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}" />
@endsection

@section('content')
    <section class="first-section">
        <div class="container-fluid icon-container">
            {{-- Dua baris sengaja: .pc untuk desktop, .mobile untuk slider slick (lihat product.js / product.css) --}}
            <div class="row icon-row pc">
                @include('partials.category_icons')
            </div>
            <div class="row icon-row mobile">
                @include('partials.category_icons')
            </div>
        </div>
    </section>

    <section class="second-section">
        <div class="container-fluid">
            <div class="row product-logo-container">
                <h1 class="visually-hidden">
                    {{ $category && !$isIndex ? "Motor Yamaha {$category['name']}" : 'Produk Motor Yamaha' }}
                </h1>
                @if ($category && $category['logo'])
                    <img src="{{ url('images/products/logos/' . $category['logo']) }}" alt="Yamaha {{ $category['name'] }}"
                        class="logo">
                @elseif ($category)
                    <p class="logo" aria-hidden="true">{{ strtoupper($category['name']) }}</p>
                @endif
            </div>

            <div class="grid-container">
                @forelse ($items as $item)
                    <div class="grid-content">
                        <a class="product-link" href="/product/{{ $item->uri }}">
                            <div class="box-img">
                                {{-- Nama produk hanya ada di dalam gambar, jadi alt wajib terisi --}}
                                <img src="{{ url($item->image) }}" alt="{{ $item->name ?? '' }}" class="product-unit-image"
                                    @if ($loop->index > 3) loading="lazy" @endif>
                            </div>
                            <div class="box-text">
                                <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                                <p class="product-price">{{ $item->price }}</p>
                                <img class="tombol-biru" src="{{ url('/images/tombol1.png') }}" alt="">
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center w-100">Belum ada produk pada kategori ini.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@section('additional_script')
    <script src="{{ asset('js/product.js') }}"></script>
@endsection
