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
            @elseif (Request::is('product/vega-force'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/VELG.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Velg Balap Modern</p>
                        <p class="feature-body">Velg balap bernuansa modern membuat penampilan semakin sporty.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/SPEEDO.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Speedometer Modern</p>
                        <p class="feature-body">Desain speedometer baru dengan indikator perpindahan gigi dan mesin.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/Lampu Depan Modern.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Lampu Depan Modern</p>
                        <p class="feature-body">Desain lampu depan dan sein yang tegas dan terang.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/Lampu Belakang Sporty.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Lampu Belakang Sporty</p>
                        <p class="feature-body">Desain Sporty membuat penampilan lebih gaya.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/KUNCI.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Kunci Pengaman</p>
                        <p class="feature-body">Kunci starter yang dilengkapi pengaman dan tombol penutup.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/FUEL INJECTION.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Fuel Injection</p>
                        <p class="feature-body">Mesin legenda yamaha dengan teknologi FI dan Euro 3, IRIT. Kapasitas mesin 114 CC dengan Forged Piston membuat lebih BERTENAGA dan BANDEL.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/Desain Sporty.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Desain Sporty</p>
                        <p class="feature-body">Tampil lebih sporty dengan desain striping baru berkarakter tegas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/vega/BAGASI SERBAGUNA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Bagasi Serbaguna 9.2 L</p>
                        <p class="feature-body">Bagasi dengan kapasitas 9,2 Liter adalah yang terbesar di kelasnya, mampu menyimpan barang bawaan lebih banyak.</p>
                    </div>
                </div>
            @elseif (Request::is('product/wr-155'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Aluminium Rims.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Dual Purpose Tire With Aluminium Rims</p>
                        <p class="feature-body">Dirancang berkendara diberbagai kondisi jalan untuk mendukung aktifitas adventure ataupun rutinitas berkendara sehari-hari.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Big Diameter & Long Suspension.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Diameter & Long Suspension</p>
                        <p class="feature-body">Suspensi depan dengan diameter 41mm dan panjang 899.1mm yang kokoh sehingga memberikan pengendalian yang lebih maksimal disetiap aktifitas adventure.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Big Fuel Tank 8,1L.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Fuel Tank 8,1L</p>
                        <p class="feature-body">Kapasitas tanki besar untuk persiapan adventure yang lebih jauh.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Frame.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Semi Double Cradle Frame</p>
                        <p class="feature-body">Rangka Motor yang kokoh sehingga memberikan pengendalian yang lebih maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Hazard Lamp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/LCD Multifunction Speedometer.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LCD Multifunction Speedometer</p>
                        <p class="feature-body">LCD Speedometer yang memberikan berbagai macam informasi yang sangat bermanfaat untuk aktifitas adventure seperti Odometer, Trip meter, Rata-rata konsumsi bahan bakar, Indikator transmisi, Jam dan lain-lain.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Linked-Type Monocross.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Linked-Type Monocross With Gas, Oil & Adjustable Pre Load</p>
                        <p class="feature-body">Suspensi belakang dengan tingkat kekerasan yang dapat diatur sesuai kebutuhan pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Powerfull 155cc Engine with VVA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Powerfull 155cc Engine with VVA</p>
                        <p class="feature-body">Mesin 155cc, Liquid cooled, 4 langkah dengan VVA yang memberikan pengalaman adventure yang luar biasa.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/Wave Double Disc Brake.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Wave Double Disc Brake</p>
                        <p class="feature-body">Rem cakram ganda memberikan pengereman lebih maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/wr/YZ Stylish Seat.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">YZ Stylish Seat</p>
                        <p class="feature-body">Desain jok yang lebih stylish dan rata yang memudahkan pengendara mengatur posisi berkendara di segala medan.</p>
                    </div>
                </div>
            @elseif (Request::is('product/r15'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/ABS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Dual Channel Anti-Lock Braking System (ABS)</p>
                        <p class="feature-body">Sistem ABS (Anti-Lock Braking System) dual channel membuat kontrol pengereman semakin optimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/BIG BIKE SWITCH.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Bike Engine Switch Off</p>
                        <p class="feature-body">Tombol starter ciri khas "Big Bike". terdiri dari tombo l3in1 cut off/on dan Starter Engine.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/LED Projector Headlight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Twin Eyes LED Position Lights</p>
                        <p class="feature-body">Tampilan dua lampu "Day Time Running Light" yang semakin mempertegas karakter agresif dari generasi terbaru R Series. YZR-M1 Styled Triple Clamp Fitur yang berfungsi untuk memberikan keseimbangan kekuatan dan kekakuan yang tidak hanya menciptakan handling yang sangat baik namun desainnya seperti yang digunakan pada MotoGP YZR-M1. YZF-R1 Styled Full Digital Speedometer Speedometer bergaya YZF-M1.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/Powerfull155cc Engine With VVA.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Powerfull155cc Engine With VVA</p>
                        <p class="feature-body">155 cc engine, Liquid Cooled, SOHC, 4 -Valves, Fuel Injection with VVA mesin bertenaga yang memberikan sensasi berkendara yang luar biasa.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/QUICK SHIFTER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Quick Shifter</p>
                        <p class="feature-body">Fitur yang dapat membuat pengendara melakukan perpindahan gigi keatas tanpa menarik tuas kopling sehingga mempercepat dan mendapatkan akselerasi yang maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/REAR ARM.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Alumunium Rear Arm</p>
                        <p class="feature-body">Aluminium Banana Swing Arm yang kokoh dan memiliki bobot yang ringan, memberikan pengendalian sepeda motor yang lebih maksimal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/SEAT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Special Seat Carbon Motif</p>
                        <p class="feature-body">Cover bangku bermotif carbon yang memberikan kesan eksklusif kepada pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/SPEEDO.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">YZF-R1 Styled Full Digital Speedometer</p>
                        <p class="feature-body">Speedometer bergayaYZF-R1 dengan instrument LCD dan 2 display pilihan "Track Mode" & "Street Mode" yang dapat memberikan informasi lengkap kepada pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/Traction Control System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Traction Control System</p>
                        <p class="feature-body">Teknologi yang dirancang untuk mengurangi risiko ban belakang selip disegala situasi permukaan jalan pada saat akselerasi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/Upside Down.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Upside Down Suspension</p>
                        <p class="feature-body">Handling lebih baik, pengendalian lebih maksimal, dan terlihat semakin gagah saat berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/r15/Y-Connect.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Teknologi Comunication Control Unit (CCU) merupakan pertama di motor buatan Indonesia dan terkoneksi dengan aplikasi Y-Connect (Yamaha Motorcycle Connect) berbasis bluetooth.</p>
                    </div>
                </div>
            @elseif (Request::is('product/xsr-155'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/ENGINE.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">155cc LC4V With VVA Engine</p>
                        <p class="feature-body">Engine 155cc, liquid cooled, SOHC, 4-valves, Fuel Injection with VVA. Mesin bertenaga untuk sensasi berkendara yang luar biasa.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/LED Head Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LED Head Light</p>
                        <p class="feature-body">Desain lampu bergaya klasik dengan teknologi modern.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/LED TAIL.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LED Tail Light</p>
                        <p class="feature-body">Desain lampu bergaya klasik dengan teknologi modern.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/SEAT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Single Seat Heritage</p>
                        <p class="feature-body">Desain jok begaya klasik mempertegas karakter “Sport Heritage” XSR 155.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/Speedo.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Full LCD Digital Speedometer</p>
                        <p class="feature-body">Design bergaya klasik dengan layar full LCD yang dilengkapi dengan indikator transmisi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/Timeless Quality Impression.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Timeless Quality Impression</p>
                        <p class="feature-body">Tanki dengan model drip shaped memberikan kesan klasik yang tak lekang oleh waktu.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xsr/TIRE.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Dual Purpose Tire</p>
                        <p class="feature-body">Ban dual purpose tubeless yang dirancang untuk berkendara dalam berbagai kondisi jalan.</p>
                    </div>
                </div>
            @elseif (Request::is('product/fazzio'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/BAGASI.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Luggage 17.8L</p>
                        <p class="feature-body">Bagasi luas 17.8L yang dapat memuat berbagai perlengkapan berkendara berikut fashion item-mu!</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Big Tire & Tubeless.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Tire & Tubeless</p>
                        <p class="feature-body">Ukuran ban depan dan ban belakang 110/70 - 12" untuk memberikan pengalaman berkendara yang lebih nyaman pada saat bermanuver.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Blue Core Hybrid.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core Hybrid</p>
                        <p class="feature-body">Mesin Blue Core 125cc generasi terbaru yang memberikan pengalaman berkendara lebih bertenaga, ramah lingkungan dan handal. Dilengkapi dengan Electric Power Assist Start yang membuat akselerasi awal lebih bertenaga dan halus khususnya di tanjakan dan saat berboncengan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/EPS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Semakin praktis untuk mengisi daya gadget pengendara sehingga connection always on!</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Fresh, Simple & Modern Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Fresh, Simple & Modern Design</p>
                        <p class="feature-body">Ekspresikan dirimu dengan keunikan desain FAZZIO yang menjadikan style-mu semakin berkelas!</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Fuel Tank Capacity 5.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Fuel Tank Capacity 5.1L</p>
                        <p class="feature-body">Perjalanan semakin menyenangkan dengan daya jelajah yang semakin jauh berkat kapasitas tanki bensin yang besar.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Hazard Lamp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/HOOK CARABINER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Double Hook Carabiner</p>
                        <p class="feature-body">Gantungan barang ganda dengan sistem pengunci model carabiner sehingga lebih praktis saat membawa banyak barang.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Pocket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Lidded & Open Pocket</p>
                        <p class="feature-body">Semakin praktis membawa barang dengan pilihan ruang penyimpanan tertutup dan terbuka.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Roomy Footspace & Light Weight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Roomy Footspace & Light Weight</p>
                        <p class="feature-body">Nyaman digunakan oleh siapa saja dengan pijakan kaki yang luas, posisi berkendara yang rileks dan juga ringan dikendarai.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/SKS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System</p>
                        <p class="feature-body">Sistem kunci canggih tanpa anak kunci (keyless), dilengkapi fitur Answer Back System, memudahkan pengendara mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/SPEEDOMETER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Full Digital Speedometer</p>
                        <p class="feature-body">Full digital speedometer dengan desain modern yang informatif, dengan indikator Electric Power Assist Start, baterai smartphone, notifikasi pesan & telepon, serta jam digital.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Unique LED Headlight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Unique LED Headlight</p>
                        <p class="feature-body">Dilengkapi lampu depan LED dengan desain unik dan stylish yang menghasilkan cahaya lebih terang.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fazzio/Y-CONNECT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Connection always on dengan teknologi Comunication Control Unit (CCU), menghubungkan sepeda motor dengan smartphone melalui aplikasi Y-Connect.</p>
                    </div>
                </div>
            @elseif (Request::is('product/gear-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/ANSWER BACK SYSTEM.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Answer Back System</p>
                        <p class="feature-body">Fitur yang membantu menemukan lokasi motor mu saat diparkiran. Tekan 1x pada remote, motor akan berbunyi dan lampu sein akan berkedip.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Bagasi Luas.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Bagasi Luas</p>
                        <p class="feature-body">Bagasi yang luas dan lega cocok untuk harimu yang penuh aktivitas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Ban Tubeless.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Ban Tubeless dengan Tapak Lebar</p>
                        <p class="feature-body">Ukuran ban depan 80/80 - 14", Ukuran ban belakang 100/70 - 14" memberikan pengalaman berkendara yang nyaman saat bermanuver.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Blue Core 125cc.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core 125cc dengan SMG</p>
                        <p class="feature-body">Generasi baru Mesin bluecore 125 cc dengan Teknologi SMG (Smart Motor Generator) sehingga suara mesin lebih halus ketika dinyalakan dan memberikan pengalaman berkendara IRIT, Bertenaga & Handal, yang juga dilengkapi dengan eco indicator.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Desain Tangguh.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Desain Tangguh</p>
                        <p class="feature-body">Bersama Desain Baru Yamaha GEAR, Nikmati Berkendara dengan Sensasi Berbeda yang Membuat Tampilanmu Terlihat Tangguh.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/DOUBLE HOOK.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Double Hook</p>
                        <p class="feature-body">Tambahan Hook yang memudahkan membawa banyak barang bawaan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Electric Power Socket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Semakin praktis dengan “Electric Power Socket” untuk mengisi daya gadget pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Lampu LED & Hazard.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Lampu LED & Hazard</p>
                        <p class="feature-body">Lampu LED Lebih Terang dan Awet. Lampu Hazard untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/PIJAKAN KAKI UNTUK ANAK.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Pijakan Kaki Untuk Anak</p>
                        <p class="feature-body">Tambahan Pijakan Kaki untuk anak kecil yang memberikan kenyamanan saat berboncengan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Side Stand Switch.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Side Stand Switch</p>
                        <p class="feature-body">Mesin tidak dapat dinyalakan ketika standard samping digunakan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/gear/Stop & Start System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stop & Start System</p>
                        <p class="feature-body">Fitur canggih dengan sistem otomatis yang membuat mesin stop atau mati saat berhenti lebih dari 5 detik dan Start atau menyala kembali saat tuas gas diputar.</p>
                    </div>
                </div>
            @elseif (Request::is('product/grand-filano'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/BAGASI.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Luggage 27L with LED Lamp</p>
                        <p class="feature-body">Bagasi luas 27L yang dilengkapi dengan lampu LED untuk memuat berbagai perlengkapan berkendara serta fashion item-mu!</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Blue Core Hybrid.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core Hybrid 125cc</p>
                        <p class="feature-body">Mesin Blue Core 125cc generasi terbaru yang memberikan pengalaman berkendara lebih bertenaga, ramah lingkungan dan handal. Dilengkapi dengan Electric Power Assist Start yang membuat akselerasi awal lebih bertenaga dan halus khususnya di tanjakan dan saat berboncengan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Convenience Footstepp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Convenience Footstep</p>
                        <p class="feature-body">Desain footstep yang lebih luas untuk kenyamanan saat berboncengan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Electric Power Socket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Komunikasi yang selalu terhubung melalui fitur pengisian daya pada gadget pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Hazard Lamp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/LED.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">All New LED Lighting System</p>
                        <p class="feature-body">Seluruh sistem pencahayaan sudah menggunakan LED seperti Diamond Shaped LED Headlight, Unique LED Position Light, Front & Rear LED Turn Signals, LED Tailight & LED Lamp pada bagasi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Luxury & Premium Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Luxury & Premium Design</p>
                        <p class="feature-body">Tampil semakin berkelas dengan desain mewah dan elegan!</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Premium Seat with Embroidery Style.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Premium Seat with Embroidery Style</p>
                        <p class="feature-body">Desain jok yang semakin berkelas dengan warna premium dan tekstur bordir yang unik.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Smart Front Refuel.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Front Refuel</p>
                        <p class="feature-body">Pengisian bensin lebih praktis tanpa membuka jok.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Smart Key System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System</p>
                        <p class="feature-body">Berkendara semakin praktis dengan sistem kunci canggih tanpa anak kunci (keyless), dilengkapi dengan fitur Answer Back System untuk memudahkan pengendara mencari lokasi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Spacious Front Pocket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Front Pocket</p>
                        <p class="feature-body">Semakin praktis membawa barang dengan pilihan ruang penyimpanan besar.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/SPEDDO METER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Digital Speedometer with TFT Sub Display</p>
                        <p class="feature-body">Pertama dikelasnya! Digital speedometer yang semakin informatif dengan tampilan berwarna dan animasi seperti Welcome-Goodbye Message, Odometer, Fuel Consumption, & Power Assist Indicator.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Wide Tire & Tubeless.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Wide Tire & Tubeless</p>
                        <p class="feature-body">Ukuran ban depan dan ban belakang 110/70 - 12" untuk memberikan kenyamanan berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/grand_filano/Y-CONNECT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Connection always on dengan teknologi Comunication Control Unit (CCU), menghubungkan sepeda motor dengan smartphone melalui aplikasi Y-Connect.</p>
                    </div>
                </div>
            @elseif (Request::is('product/freego-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Active & Elegant Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Active & Elegant Design</p>
                        <p class="feature-body">Semakin percaya diri saat berkendara dengan desain yang semakin sporty dan berkelas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Bagasi Besar 25L.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Bagasi Besar 25L</p>
                        <p class="feature-body">Bagasi luas seperti NMAX, untuk menampung barang bawaan termasuk Helm Full Face Standar Yamaha.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Blue Core 125cc.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core 125CC with SMG</p>
                        <p class="feature-body">Mesin Blue Core 125 yang membuat akselerasi semakin bertenaga, serta dilengkapi Smart Motor Generator (SMG) yang menjadikan suara mesin lebih halus saat dinyalakan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Electric Power Socket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Komunikasi selalu terhubung melalui fitur pengisian daya pada gadget pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Hazard Lamp.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Lamp</p>
                        <p class="feature-body">Memberi tanda dalam situasi darurat (sesuai UU No. 22 Tahun 2009 peraturan berlalu lintas pasal 121 ayat1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Jok Yang Lapang.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Jok Yang Lapang</p>
                        <p class="feature-body">Semakin nyaman saat berboncengan dengan jok yang luas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Roomy Footspace.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Roomy Footspace</p>
                        <p class="feature-body">Ruang pijakan kaki yang luas sehingga membuat berkendara semakin nyaman.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Smart Front Refuel.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Front Refuel</p>
                        <p class="feature-body">Pengisian bensin lebih praktis tanpa membuka jok.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Smart Key System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System</p>
                        <p class="feature-body">Sistem kunci canggih tanpa anak kunci (keyless), dilengkapi fitur Answer Back System, memudahkan pengendara mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Spacious Front Pocket.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Spacious Front Pocket</p>
                        <p class="feature-body">Semakin praktis membawa barang dengan adanya tambahan ruang penyimpanan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Speedometer.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Digital Speedometer With Connected Function</p>
                        <p class="feature-body">Digital speedometer dengan desain modern dan informatif yang dapat terhubung dengan aplikasi Y-Connect untuk mengetahui indikator notifikasi pesan & telepon, baterai smartphone, serta jam digital.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Sporty LED Headlight.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sporty LED Headlight</p>
                        <p class="feature-body">Lampu depan LED dengan tampilan desain baru yang lebih sporty, dilengkapi dengan "Blue Inner Lens" pada LED Position Light yang membuat tampilan semakin berkelas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Stop & Start System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stop & Start System</p>
                        <p class="feature-body">Fitur canggih dengan sistem otomatis yang membuat mesin stop atau mati saat berhenti lebih dari 5 detik dan Start atau menyala kembali saat tuas gas diputar.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Wide Tubeless Tire.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Wide Tubeless Tire</p>
                        <p class="feature-body">Semakin stabil saat berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/freego/Y-CONNECT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Teknologi pertama dikelasnya yang menghubungkan sepeda motor dengan smartphone melalui aplikasi Y-Connect untuk menginformasikan notifikasi pesan & telepon, konsumsi bahan bakar, rekomendasi perawatan, rincian berkendara serta lokasi parkir.</p>
                    </div>
                </div>
            @elseif (Request::is('product/x-ride-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/ANSWER BACK.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Answer Back System</p>
                        <p class="feature-body">Fitur canggih untuk menemukan lokasi motor kamu.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/Ban Tubeless.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Ban Tubeless Tapak Lebar</p>
                        <p class="feature-body">Lebih gagah dan stabil saat berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/Big Luggage.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Big Luggage</p>
                        <p class="feature-body">Menampung lebih banyak barang bawaan di perjalanan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/Blue Core 125cc.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core Engine 125cc</p>
                        <p class="feature-body">Lebih Efisien, Bertenaga, dan Handal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/Hazard Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Hazard Light</p>
                        <p class="feature-body">Untuk memberi tanda dalam situasi darurat (sesuai UU no 22 tahun 2009 peraturan berlalulintas pasal 121 ayat 1).</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/LED Head Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">LED Head Light With Day Running Light</p>
                        <p class="feature-body">Kombinasi lampu depan LED & Daytime Running Light dengan image Armored Case membuat tampilan lebih tangguh, stylish, terang dan awet.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/SEAT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Adventure Style Seat</p>
                        <p class="feature-body">Jok dengan desain rata memudahkan mengatur posisi duduk saat berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/SPEEDOMETER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Speedometer With Eco Indicator</p>
                        <p class="feature-body">Indikator irit untuk berkendara lebih ekonomis dan efisien.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/STANG.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Adventure Handle Style</p>
                        <p class="feature-body">Dengan dimensi lebih lebar, semakin mantap dan kokoh di segala kondisi jalan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/SUB-TANK.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Sub-Tank Suspension</p>
                        <p class="feature-body">Untuk performa berkendara lebih nyaman di berbagai kondisi jalan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xride/Teknologi DiASil.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Teknologi DiASil Cylinder & Forged Piston</p>
                        <p class="feature-body">Mesin lebih Ringan, Kuat, dan Awet.</p>
                    </div>
                </div>
            @elseif (Request::is('product/fino-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Advance Key System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Advance Key System (AKS)</p>
                        <p class="feature-body">Fitur canggih dengan fungsi ganda untuk menemukan lokasi dan membuka penutup kunci.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Ban Lebar.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Ban Lebar & Tubeless</p>
                        <p class="feature-body">Membuat lebih nyaman saat berkendara. Ukuran Ban Depan : 80/80 - 14M/C 43P , 100/70 - 14M/C 51P.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Blue Core 125cc.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core 125cc</p>
                        <p class="feature-body">Mesin 125cc dengan teknologi Blue Core yang membuat motor Irit, Halus, dan Nyaman.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Eco Indicator.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Eco Indicator</p>
                        <p class="feature-body">Indikator irit untuk berkendara lebih ekonomis dan efisien.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Helm Retro Stylish.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Helm Retro Stylish</p>
                        <p class="feature-body">Helm berdesain retro stylish yang in line dengan warna motor untuk setiap pembelian New Fino 125 Blue Core.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Led Head Light.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Led Head Light</p>
                        <p class="feature-body">Dilengkapi lampu depan LED dengan desain elegan yang memberikan cahaya lebih terang dan fokus.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Matte Color.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Matte Color</p>
                        <p class="feature-body">Trend warna baru yang memberikan nuansa eksklusif.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Smart Lock System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Lock System</p>
                        <p class="feature-body">Praktis ketika harus mengunci rem saat berhenti di tanjakan atau turunan. Praktis, cukup dengan 1 jari.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Smart Stand Side Switch.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Stand Side Switch</p>
                        <p class="feature-body">Lebih informatif menghindari pengendara lupa menaikan standard samping saat motor diparkirkan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Stop & Start System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stop & Start System</p>
                        <p class="feature-body">Semakin Irit dengan system otomatis yang membuat mesin STOP/Mati saat berhenti lebih dari 5 detik dan START/Menyala kembali saat tuas gas diputar.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/fino/Stylish Double Seat.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Stylish Double Seat</p>
                        <p class="feature-body">Jok dengan desain berkelas untuk memberikan kenyamanan saat berkendara.</p>
                    </div>
                </div>
            @elseif (Request::is('product/mio-m3-125'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Bagasi.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Bagasi Luas & Lega</p>
                        <p class="feature-body">Bagasi yang luas dan lega cocok untuk harimu yang penuh aktivitas.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Blue Core 125cc.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core</p>
                        <p class="feature-body">Mesin Blue Core 125cc yang Efisien, Bertenaga & Handal.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Eco Indicator.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Eco Indicator</p>
                        <p class="feature-body">Indikator irit untuk berkendara lebih ekonomis.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Multifunction Key.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Multifunction Key</p>
                        <p class="feature-body">1 kunci dengan 3 fungsi untuk menyalakan motor, mengunci motor, dan membuka bagasi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Slim Body Design.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Slim Body Design</p>
                        <p class="feature-body">Bodi yang ramping akan memudahkan mobilitas keseharian kamu.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Smart Lock System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Lock System</p>
                        <p class="feature-body">Untuk mengunci rem saat berhenti di tanjakan atau turunan. Praktis, cukup dengan satu jari.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/SPEEDOMETER.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Speedometer Trendy</p>
                        <p class="feature-body">Desain speedometer baru yang tampil lebih trendy.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/SSS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Stand Side Switch</p>
                        <p class="feature-body">Lebih informatif menghindari pengendara lupa menaikan standart samping saat motor diparkir.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/mio/Tangki 4.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Tangki 4.2 L</p>
                        <p class="feature-body">Kapasitas tangki bahan bakar yang besar.</p>
                    </div>
                </div>
            @elseif (Request::is('product/xmax-250'))
                <div class="features-wrapper">
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/ABS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Anti-Lock Braking System</p>
                        <p class="feature-body">Kontrol pengereman semakin optimal dengan Anti-Lock Braking System.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/LED & HAZARD.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">All New Led Lightning System With Hazard Lamp</p>
                        <p class="feature-body">Seluruh sistem pencahayaan lampu sudah menggunakan LED. Desain lampu depan berkarakter "X" yang terlihat sangat ikonik, modern dan sporty. Serta dilengkapi Lampu Hazard sebagai tanda keadaan darurat yang dialami pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/MAXI Riding Style.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">MAXI Riding Style</p>
                        <p class="feature-body">Posisi berkendara yang nyaman dengan ruang kaki yang luas serta memiliki 2 posisi pijakan kaki pengendara yang membuat posisi berkendara lebih rileks untuk jarak dekat dan jarak jauh.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/EPS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Electric Power Socket</p>
                        <p class="feature-body">Komunikasi yang selalu terhubung dengan dukungan electric power socket untuk mengisi daya gadget pengendara selama perjalanan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/HANDLE BAR.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Adjustable Windshield & Handlebars</p>
                        <p class="feature-body">Posisi Windshield dan Handlebars yang dapat disesuaikan secara manual untuk memberikan kenyamanan yang optimal ketika berkendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/LCD SPEEDO.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Full LCD Speedometer</p>
                        <p class="feature-body">Full LCD Speedometer yang informatif untuk pengendara.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/NAVIGATION SYSTEM.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Navigation System</p>
                        <p class="feature-body">Jelajahi tempat-tempat baru dengan bantuan sistem navigasi yang didukung oleh aplikasi Garmin Street Cross yang ditampilkan di TFT Infotainment Display.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/TFT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">TFT Infotainment Display</p>
                        <p class="feature-body">Hadirnya sistem TFT Infotainment Display canggih yang dapat terhubung dengan smartphone untuk memberikan beragam informasi dan hiburan seperti: Informasi prakiraan cuaca, kondisi sepeda motor, notifikasi telepon & pesan, serta kontrol untuk memainkan musik favorit sehingga perjalanan Anda menjadi semakin menyenangkan.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/Smart Key System.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Smart Key System</p>
                        <p class="feature-body">Sistem kunci canggih tanpa anak kunci (keyless), dilengkapi fitur Answer Back System, memudahkan pengendara mencari posisi parkir motor.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/BAGASI.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Large Underseat Storage With Led Light</p>
                        <p class="feature-body">Bagasi yang luas (44.9 L) dan dilengkapi dengan lampu LED untuk mendukung aktifitas berkendara harian maupun touring jarak jauh.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/TCS.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Traction Control System</p>
                        <p class="feature-body">Sistem yang dirancang untuk mengurangi resiko ban belakang selip di segala situasi permukaan jalan pada saat akselerasi.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/Y-CONNECT.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Motorcycle Connect</p>
                        <p class="feature-body">Teknologi modern dan informatif yang menghubungkan antara motor dengan smartphone untuk menginformasikan rekomendasi perawatan, konsumsi BBM, Lokasi parkir terakhir, notifikasi malfungsi, dan lain-lain.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/Yamaha Executive Service 24 Hours.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Yamaha Executive Service 24 Hours</p>
                        <p class="feature-body">Konsumen dapat menghubungi Call Center 1-500-552 jika membutuhkan bantuan/dalam kondisi darurat, lalu akan dikonfirmasi dari YES24. Layanan 24 jam yang diberikan yaitu derek, pengantaran bensin, pengecasan aki, & penanganan ban kempes. Rescuer YES24 akan menuju lokasi & membawa sepeda motor ke Yamaha Premium Shop terdekat.</p>
                    </div>
                    <div class="features-content">
                        <img src="{{ url('/images/features/xmax/BLUECORE.jpg')}}" loading="lazy" class="feature-img">
                        <p class="feature-title">Blue Core 250 CC</p>
                        <p class="feature-body">Mesin BLUE CORE berkapasitas 250 cc yang dilengkapi dengan Liquid Cooled, SOHC, 4 Valves untuk performa dan akselerasi yang bertenaga sehingga berkendara menjadi lebih menyenangkan.</p>
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

<section class="navtabs">
    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-spec-tab" data-bs-toggle="tab" data-bs-target="#nav-spec" type="button" role="tab" aria-controls="nav-spec" aria-selected="false">Spec View</button>
                <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="true">Review</button>
                {{-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> --}}
            </div>
        </nav>
        @if (Request::is('product/nmax-155'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/thumbnail1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/XPRnLBhEU8k" target="_blank">
                                <p class="review-title">REVIEW MOTOR TERLARIS DI SUMATERA BARAT! | ALL NEW NMAX 155 ABS</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/thumbnail2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/tsOIxAvNob4" target="_blank">
                                <p class="review-title">PERBANDINGAN ANTAR TIPE YAMAHA ALL NEW NMAX 155</p>
                            </a>
                        </div>
                        {{-- <div class="review-left col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <picture>
                                <img class="review-img" src="{{ url('/images/thumbnail1.jpg') }}" alt="">
                            </picture>
                        </div>
                        <div class="review-right col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <a href="https://youtu.be/XPRnLBhEU8k">
                                <p class="review-title">REVIEW MOTOR TERLARIS DI SUMATERA BARAT! | ALL NEW NMAX 155 ABS</p>
                            </a>
                        </div> --}}
                        {{-- <h2 class="title blue">videos</h2> --}}
                        {{-- @if (Request::is('product/nmax-155'))
                        <div class="videos-wrapper">
                            <div id="carouselVideo" class="carousel carousel-dark slide" data-bs-interval="false">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselVideo" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselVideo" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                    <iframe class="video-item" width="560" height="315" src="https://www.youtube.com/embed/ammWRb4dd7E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                    <div class="carousel-item">
                                    <iframe class="video-item" width="560" height="315" src="https://www.youtube.com/embed/lfrHE-yQgs8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselVideo" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselVideo" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        @endif --}}
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
            </div>
        @elseif (Request::is('product/xmax-250'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxmax.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/WUi9KXqvLB0" target="_blank">
                                <p class="review-title">Product Explanation - XMAX Connected</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxmax1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/2_S7StYu0OU" target="_blank">
                                <p class="review-title">PERTAMA di INDONESIA..!!! NGEGAS NEW XMAX 250 CONNECTED 2023, BEGINI RASANYA l Otomotif TV</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/aerox-155'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewaerox.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/gf1PcJrNZhc" target="_blank">
                                <p class="review-title">Selalu MAXImal with ALL NEW AEROX 155 CONNECTED - ft ADITIAABUMARYAM</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewaerox1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/3OFqCLiDOvQ" target="_blank">
                                <p class="review-title">All New Aerox 155 Connected - Sport Scooter dengan Performa Terbaik</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/lexi-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewlexi.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/lniG6OaN9ZE" target="_blank">
                                <p class="review-title">Review Yamaha Lexi With Affan</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewlexi1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/hOBJw-Pe73I" target="_blank">
                                <p class="review-title">Review Yamaha Lexi Bersama Olivia</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewlexi2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/jp98LpdrU8k" target="_blank">
                                <p class="review-title">Review Yamaha Lexi bersama Razor</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewlexi3.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/tT3GD9nZ94Q" target="_blank">
                                <p class="review-title">Review Yamaha Lexi bersama Tasya</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/grand-filano'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfilano.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/QSuJYwLKzBw" target="_blank">
                                <p class="review-title">MEWAH & ELEGAN - REVIEW YAMAHA GRAND FILANO</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/fazzio'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfazzio.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/BhY4hdnVDUg" target="_blank">
                                <p class="review-title">Fitur-fitur dari Yamaha Fazzio Hybrid-Connected</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/freego-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfreego.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/YlI2XdGjNYs" target="_blank">
                                <p class="review-title">Review & Test Ride Yamaha FreeGo with Zakila Angel Mizia</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfreego1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/CEcXefc61xs" target="_blank">
                                <p class="review-title">APA SIH BEDA FREEGO TERBARU DENGAN YANG LAMA???</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfreego2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/8GQLLx9MkPQ" target="_blank">
                                <p class="review-title">Cara Menghubungkan Smartphone ke Yamaha FreeGo 125 Connected</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfreego3.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/LAuKVA7wZT0" target="_blank">
                                <p class="review-title">YAMAHA FreeGo buat kalian yang sat set</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/gear-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewgear.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/mwUXntI2-LI" target="_blank">
                                <p class="review-title">Review Gear 125 - Fiturnya Banyak !</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewgear1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/kR4NXZzPBEg" target="_blank">
                                <p class="review-title">BONGKAR Keunggulan & Kekurangan YAMAHA GEAR 125 2021 Buat Harian l Otomotif TV</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewgear2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/zi-mlFjrWtY" target="_blank">
                                <p class="review-title">Yamaha GEAR 125</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/fino-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfino.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/U6TvmmC6ubw" target="_blank">
                                <p class="review-title">MAKIN IMUT MAKIN RETRO - Review Yamaha New Fino Premium 125</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfino1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/TEkO691GDvM" target="_blank">
                                <p class="review-title">Jalan Bareng Tasya Bersama Fino Grande</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfino2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/f5Yc6d3RBzg" target="_blank">
                                <p class="review-title">Review Yamaha Fino Sporty Bersama Ebbyas</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewfino3.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/UN-_yllPeDk" target="_blank">
                                <p class="review-title">Yamaha Fino</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/x-ride-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxride.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/w0mczd4LZPA" target="_blank">
                                <p class="review-title">Ekspresikan Kebebasan Bersama All New X-Ride 125</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxride1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/38O6L4iEXf0" target="_blank">
                                <p class="review-title">Yamaha X-Ride 125 l Test Ride Review l GridOto</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxride2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/A9yhgB7ov9Y" target="_blank">
                                <p class="review-title">MENOLAK PUNAH ‼️ INILAH NEW YAMAHA X-RIDE 125 VERSI 2022 🔥 | LAWAN ADV ⁉️🤔</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxride3.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/_VXqI5dqYTc" target="_blank">
                                <p class="review-title">TAMPIL BEDA‼️NEW YAMAHA XRIDE 125 2022</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/mio-m3-125'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewmio.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/-nvMxbYhdYY" target="_blank">
                                <p class="review-title">Product Knowledge New Mio M3 125 (Official)</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewmio1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/uLciBk7DOMU" target="_blank">
                                <p class="review-title">THE LEGEND IS BACK ‼️ NEW MIO M3 2023 | LHO, KOK KEREN ⁉️😱</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewmio2.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/b75QLtDwNes" target="_blank">
                                <p class="review-title">YAMAHA MIO M3 TERBARU 2023</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/r15'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        {{-- <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewmio.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/-nvMxbYhdYY" target="_blank">
                                <p class="review-title">Product Knowledge New Mio M3 125 (Official)</p>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/xsr-155'))
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                    <div class="review-wrapper row">
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxsr.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/hNAoZpJ7h6E" target="_blank">
                                <p class="review-title">YAMAHA XSR 155 2023..!!! LEBIH CANGGIH dan KENCANG DIBANDING W175 | Otomotif TV</p>
                            </a>
                        </div>
                        <div class="review-item">
                            <picture>
                                <img class="review-img" src="{{ url('/images/reviewxsr1.jpg') }}" alt="">
                            </picture>
                            <a href="https://youtu.be/Or4jOLWAqwo" target="_blank">
                                <p class="review-title">GARANG‼️YAMAHA XSR 155 2023 FULL BLACK</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Request::is('product/wr-155'))
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-spec" role="tabpanel" aria-labelledby="nav-spec-tab">
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
                                <td class="spec-part-td3">Monoshock/td>
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
            </div>
            <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                <div class="review-wrapper row">
                    <div class="review-item">
                        <picture>
                            <img class="review-img" src="{{ url('/images/reviewwr.jpg') }}" alt="">
                        </picture>
                        <a href="https://youtu.be/2uOc_-nXnlI" target="_blank">
                            <p class="review-title">TRABAS LANUD WILDTRACK - Tes Ride WR 155</p>
                        </a>
                    </div>
                    <div class="review-item">
                        <picture>
                            <img class="review-img" src="{{ url('/images/reviewwr1.jpg') }}" alt="">
                        </picture>
                        <a href="https://youtu.be/VuOyXWhrNvU" target="_blank">
                            <p class="review-title">YAMAHA WR 155R 2023, TENAGA MASIH PALING BESAR..!!! | Otomotif TV</p>
                        </a>
                    </div>
                    <div class="review-item">
                        <picture>
                            <img class="review-img" src="{{ url('/images/reviewwr2.jpg') }}" alt="">
                        </picture>
                        <a href="https://youtu.be/MuOM6ttJ6bI" target="_blank">
                            <p class="review-title">GANTENG PARAH ‼️ NEW YAMAHA WR-155 BLACK CYAN 2023 🔥 | GOKILL TAMPANGNYA 😱</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
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

        introCarousel.children(".carousel-item:first").addClass('active');
        introCarouselIndicators.children(".sign:first").addClass('active');

        var variantUnit = $(".variant-unit:first").addClass('active');
        
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