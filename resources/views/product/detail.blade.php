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
                        .attr('src', '{{ url("/") }}' + '/' + item.image)
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