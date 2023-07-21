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
    </div>
</section>

<section class="third-section">
    <div class="container-fluid">
        <div class="features row">
            <h2 class="title white">features</h2>
            @if (Request::is('product/nmax-155'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/EPS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Semakin praktis dengan "Electric Power Socket" untuk mengisi daya gadget pengendara. (Handphone dan Kabel Charger tidak termasuk dalam paket pembelian)</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/KEYLESS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">KEYLESS (Smart Key System)</p>
                        <p class="feature-body">Sistem Kunci Canggih Tanpa Anak Kunci (Keyless), dilengkapi fitur Answer Back System yang memudahkan mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SPEEDO.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Multifunction Full Digital Speedometer</p>
                        <p class="feature-body">Modern dan informatif bagi pengendara. Kini dilengkapi dengan indikator Y-Connect Apps, Pesan & Telepon, TCS*, VVA dan Temperatur Mesin. *Hanya tersedia di Connected/ABS Version.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/ABS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Dual Channel Anti-Lock Braking System (ABS)</p>
                        <p class="feature-body">Kontrol pengereman yang optimal dengan Dual Channel Anti-Lock Braking System.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/BAGASI.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Multifunction Big Luggage</p>
                        <p class="feature-body">Bagasi luas dengan akses yang mudah dan fungsional yang dapat menyimpan helm full face ukuran XL.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/BLU CORE & VVA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core & VVA</p>
                        <p class="feature-body">Teknologi Blue Core & VVA menjaga mesin 155 cc tetap efisien bahan bakar dan tenaga serta torsi maksimum di setiap putaran mesin.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/FRONT & REAR DISC BRAKE.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Front & Rear Disc Brake</p>
                        <p class="feature-body">Dengan sistem pengereman ganda dan cengkraman cakram yang kuat dan kokoh membuat pengalaman berkendara lebih maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/LED.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LED Head & Tail Light with Hazard Lamp</p>
                        <p class="feature-body">Desain lampu depan dan belakang mewarisi MAX Series DNA. Dilengkapi dengan lampu hazard untuk memberi tanda dalam situasi darurat.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/RAK KANAN.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Front Compartment</p>
                        <p class="feature-body">Lebih mewah dan praktis dengan kompartemen tertutup.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/RELAX RIDING.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Relax Riding Position</p>
                        <p class="feature-body">Posisi berkendara yang nyaman dengan ruang kaki yang luas, membuat posisi berkendara lebih rileks untuk jarak dekat atau jarak jauh.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SEAT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">MAXi Seat Design</p>
                        <p class="feature-body">Jok dengan kontur ganda membuat pengendara lebih nyaman dan tampilan motor menjadi lebih berkelas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SHOCK.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sub-tank Suspension</p>
                        <p class="feature-body">Untuk mendukung performa berkendara yang lebih nyaman diberbagai kondisi jalan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SSS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stop & Start System</p>
                        <p class="feature-body">Mengurangi konsumsi bahan bakar yang tidak perlu pada saat motor sedang berhenti.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SWITCH.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Handlebar Switch Control</p>
                        <p class="feature-body">Memilih tampilan informasi dan setting pada speedometer menjadi lebih mudah dengan tombol pengatur yang berada di handle sebelah kiri.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/TCS (Traction Control System).jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">TCS (Traction Control System)</p>
                        <p class="feature-body">Sistem yang dirancang untuk mengurangi resiko ban belakang selip di segala situasi permukaan jalan pada saat akselerasi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/nmax/SMG.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Motor Generator</p>
                        <p class="feature-body">Membuat suara motor lebih halus saat dinyalakan.</p>
                    </div>
                </div>
            @elseif (Request::is('product/aerox-155'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/5,5L Fuel Tank.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">5.5L Fuel Tank Capacity</p>
                        <p class="feature-body">Kapasitas tangki bahan bakar lebih besar memberikan pengalaman berkendara yang lebih lama.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/ABS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Anti-Lock Braking System</p>
                        <p class="feature-body">Kontrol pengereman yang lebih maksimal dengan ABS.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/EPS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Semakin praktis dengan "Electric Power Socket" untuk mengisi daya gadget pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Fully Faired Aerodynamic Look.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Fully Faired Aerodynamic Look</p>
                        <p class="feature-body">Desain aerodinamis dengan full fairing yang merupakan ciri khas dari motor sport.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/HANDLE BAR.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Handle Bar Switch Control</p>
                        <p class="feature-body">Memilih tampilan informasi dan setting pada speedometer menjadi lebih mudah dengan tombol pengatur yang berada di handle sebelah kiri.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/BLUECORE & VVA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core & VVA</p>
                        <p class="feature-body">Teknologi Blue Core & VVA menjaga mesin 155 cc tetap efisien bahan bakar dan tenaga serta torsi maksimum di setiap putaran mesin.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/HAZARD LAMP.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/LED TAIL.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sporty-Integrated Rear Handle Grip</p>
                        <p class="feature-body">Desain pegangan bagian belakang yang menyatu dengan body motor, memberikan kesan yang sporty.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/SEAT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Comfortable Tandem Seat</p>
                        <p class="feature-body">Jok dengan desain sporty berkontur ganda membuat pengendara lebih nyaman.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Smart Key System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System</p>
                        <p class="feature-body">Sistem kunci canggih tanpa anak kunci (keyless), dilengkapi fitur Answer Back System, memudahkan pengendara mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Spacious Baggage.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Baggage</p>
                        <p class="feature-body">Desain bagasi yang luas dapat memuat berbagai perlengkapan berkendara Anda.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Super Wide Tubeless Tire.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Super Wide Tubeless Tire</p>
                        <p class="feature-body">Ukuran ban depan 110/80-14", Ukuran ban belakang 140/70-14", Menjadikan tampilan lebih sporty serta memberikan pengalaman berkendara yang lebih nyaman dan maksimal saat bermanuver.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Twin Sub-Tank Suspension.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Twin Sub-Tank Suspension</p>
                        <p class="feature-body">Untuk mendukung performa berkendara yang lebih nyaman diberbagai kondisi jalan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/Y CONNECT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Teknologi modern dan informatif yang menghubungkan antara motor dengan smartphone untuk menginformasikan rekomendasi perawatan, konsumsi BBM, Lokasi parkir terakhir, notifikasi malfungsi, dan lain-lain.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/aerox/SMG.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Motor Generator</p>
                        <p class="feature-body">Membuat suara motor lebih halus saat dinyalakan.</p>
                    </div>
                </div>
            @elseif (Request::is('product/lexi-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/ABS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Anti-Lock Braking System (ABS)</p>
                        <p class="feature-body">Kontrol pengereman lebih optimal dengan ABS, membuat berkendara semakin nyaman.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Grand LED Headlight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Grand LED Headlight</p>
                        <p class="feature-body">Lampu depan menggunakan sistem pencahayaan LED sehingga lebih terang serta didesain dengan ukuran besar memberikan kesan mewah dan elegan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Full Digital Speedometer.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Full Digital Speedometer</p>
                        <p class="feature-body">Full digital speedometer yang modern dan informatif bagi pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Spacious Flat Foot Board.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Flat Foot Board</p>
                        <p class="feature-body">Ruang pijakan kaki yang luas dan nyaman dengan dua posisi kaki berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Long Seat.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Long Seat</p>
                        <p class="feature-body">Seat dengan ukuran lebih panjang dengan desain yang elegan mendukung kenyamanan berkendara baik individu maupun sharing</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Sub-Tank Suspension.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sub-Tank Suspension</p>
                        <p class="feature-body">Untuk mendukung performa berkendara yang lebih nyaman diberbagai kondisi jalan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Bagasi.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Luggage Capacity</p>
                        <p class="feature-body">Bagasi yang luas dan lega untuk menampung barang bawaan lebih banyak.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Tubeless Wide Tire.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Tubeless Wide Tire</p>
                        <p class="feature-body">Ukuran ban depan 90/90 - 14", Ukuran ban belakang 100/90 - 14" memberikan pengalaman berkendara yang nyaman saat bermanuver.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Electric Power Socket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Semakin praktis dengan "Electric Power Socket" untuk mengisi daya gadget pengendara *Handphone dan kabel charger tidak termasuk dalam paket pembelian.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/SMART KEY.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System (Keyless)</p>
                        <p class="feature-body">Sistem kunci canggih tanpa anak kunci (keyless), dilengkapi fitur Answer Back System, memudahkan pengendara mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Grand LED Headlight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/BLUECORE & VVA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">New Liquid Cooled 125cc Blue Core Engine With VVA</p>
                        <p class="feature-body">Mesin generasi baru Blue Core 125cc yang dilengkapi dengan Liquid Cooled dan Variable Valve Actuation (VVA) yang menjaga tenaga dan torsi maksimum di setiap putaran mesin sehingga lebih efisien, bertenaga, dan Handal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/SSS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stop & Start System (SSS)</p>
                        <p class="feature-body">Stop & Start System (SSS) yang berfungsi untuk mengurangi konsumsi bahan bakar yang tidak perlu pada saat motor sedang berhenti.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/Cylinder.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">DiASil Cylinder & Forged Piston</p>
                        <p class="feature-body">Diasil Cylinder berbahan aluminium silicon, diproses dengan teknologi modern. Membuatnya cepat melepas panas. Piston dengan proses tempa sehingga lebih padat dibanding piston cetak.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/lexi/smg.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Motor Generator (SMG)</p>
                        <p class="feature-body">Membuat suara motor lebih halus saat dinyalakan.</p>
                    </div>
                </div>
            @elseif (Request::is('product/jupiter-z1'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Aerodynamic Air Flow.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Aerodynamic Air Flow</p>
                        <p class="feature-body">Memberikan sirkulasi udara pada mesin agar tetap pada suhu optimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Arrow Tail Shaped Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Arrow Tail Shaped Light</p>
                        <p class="feature-body">Design lampu belakang yang aerodinamis dan futuristik.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Double Head Lamp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Double Head Lamp</p>
                        <p class="feature-body">Lampu ganda futuristik yang memberikan penerangan lebih maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Forged Piston.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Forged Piston</p>
                        <p class="feature-body">Teknologi Yamaha yang membuat mesin lebih awet dan kuat.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Fuel Injection.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Fuel Injection Yamaha</p>
                        <p class="feature-body">Teknologi injeksi Yamaha yang membuat mesin lebih bertenaga dan irit.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/New Striping Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">New Striping Design</p>
                        <p class="feature-body">Striping bergaya racing memberikan kesan Sporty.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/jupiter/Sporty Casting.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sporty Casting WheelSPORTY CASTING WHEEL</p>
                        <p class="feature-body">Velg dengan striping yang Sporty.</p>
                    </div>
                </div>
            @elseif (Request::is('product/mx-king-150'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/Engine.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">150cc FI, Engine Liquid Cooled System</p>
                        <p class="feature-body">Teknologi mesin balap yang memaksimalkan perfoma dengan mesin 4 valve 150cc Fuel Injection dilengkapi dengan Forged Piston, DiAsil Cylinder serta Liquid Cooled System.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/LED Head Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LED Head Light</p>
                        <p class="feature-body">Sporty style design 3 LED ( 2 Low Beam, 1 High Beam ) Head Light memberikan penerangan maksimal saat berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/Master Desain MX KING.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberikan tanda dalam situasi darurat, sesuai UU no 22 tahun 2009 peraturan berlalu lintas pasal 121 ayat 1.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/New Graphic Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">New Graphic Design</p>
                        <p class="feature-body">Memiliki desain grafis yang simetris dan semakin sporty dengan garis yang tebal dan terinspirasi dari konsep downforce berwarna bold yang dipadukan aksen cerah untuk kesan speedy yang merupakan ciri khas kuat MX King 150.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/Rangka.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Light Frame Design</p>
                        <p class="feature-body">Semakin lincah dengan Light Frame Design . Hadir dengan posisi berkendara sporty yang dilengkapi dengan suspensi Mono Shock dibagian belakang dan Pijakan kaki pengendara yang bisa dilipat membuat semakin nyaman dalam bermanuver & cornering.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/Speedo.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Full Digital Speedometer</p>
                        <p class="feature-body">Tampil dengan teknologi yang baru dengan full LCD speedometer yang modern dan informatif bagi pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mx-king/Wide Tubeless Tire.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Wide Tubeless Tire</p>
                        <p class="feature-body">Dengan ban tubeless yang lebar dikelasnya dilengkapi dengan Desain Velg ring 17 inch membuat tampilan MX KING semakin sporty dan memiliki Double Disk Brake yang memaksimalkan pengereman dan keamanan dalam berkendara.</p>
                    </div>
                </div>
            @else
            <div>
                <h1>coming soon</h1>
            </div>
            @endif
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

        <form action="/send_message" method="post" onsubmit="disableButton()">
            @csrf
            @if (!empty($value))
                <input name="sales" type="text" hidden value="{{ $value }}">
            @endif
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
    var introCarousel = $(".carousel");
    var introCarouselIndicators = $(".carousel-indicators");

    introCarousel.find(".carousel-inner").children(".carousel-item:first").addClass('active');
    introCarouselIndicators.children(".sign:first").addClass('active');

    var variantUnit = $(".variant-unit:first").addClass('active');
    
    $('.variant-unit').click(function() {
        var variant = $(this).attr('data-variant');
        var url = "/get-data/" + variant;

        $('.variant-unit').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                var carouselIndicators = $('<div>').addClass('carousel-indicators');
                var carouselInner = $('<div>').addClass('carousel-inner');
                
                response.forEach(function(item, index) {
                // Buat elemen indicator untuk setiap item
                var indicatorButton = $('<button>')
                    .attr('type', 'button')
                    .attr('data-bs-target', '#carouselExampleDark')
                    .attr('data-bs-slide-to', index)
                    .addClass('sign')
                    .css('background', item.color);
                carouselIndicators.append(indicatorButton);

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

                var carouselControlPrev = $('<button>').addClass('carousel-control-prev').attr('type', 'button').attr('data-bs-target', '#carouselExampleDark').attr('data-bs-slide', 'prev');
                var carouselControlPrevIcon = $('<span>').addClass('carousel-control-prev-icon').attr('aria-hidden', 'true');
                var carouselControlPrevText = $('<span>').addClass('visually-hidden').text('Previous');
                carouselControlPrev.append(carouselControlPrevIcon, carouselControlPrevText);
                var carouselControlNext = $('<button>').addClass('carousel-control-next').attr('type', 'button').attr('data-bs-target', '#carouselExampleDark').attr('data-bs-slide', 'next');
                var carouselControlNextIcon = $('<span>').addClass('carousel-control-next-icon').attr('aria-hidden', 'true');
                var carouselControlNextText = $('<span>').addClass('visually-hidden').text('Next');
                carouselControlNext.append(carouselControlNextIcon, carouselControlNextText);

                // Append 
                $('#carouselExampleDark').empty().append(carouselIndicators, carouselInner, carouselControlPrev, carouselControlNext);

                var introCarousel = $(".carousel");
                var introCarouselIndicators = $(".carousel-indicators");

                introCarousel.find(".carousel-inner").children(".carousel-item:first").addClass('active');
                introCarouselIndicators.children(".sign:first").addClass('active');
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
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
</script>
@endsection