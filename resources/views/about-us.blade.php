@extends('layouts.master')

@section('title', 'Profile | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="Profile | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'about-us')

@section('additional_css')
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.0/dist/aos.css" />
<link rel="stylesheet" href="{{ asset('css/about-us.css') }}" />
@endsection

@section('content')
    <section class="headline">
        <div class="headline-wrapper">
            <h1 class="display-4 fw-bold">Company Profile<br>Tjahaja Baru</h1>
            <p class="lead">"Merajut Sejarah dan Kualitas di Dunia Otomotif Sejak 1971: Tjahaja Baru, Partner Utama Anda dalam Berkendara Bersama Yamaha"</p>
        </div>
    </section>

    <section class="section-bg about">
        <div class="container">
            <h2 class="fw-bold">Tentang Tjahaja Baru</h2>
            <p class="lh-base">Selamat datang di Tjahaja Baru, penyedia terkemuka di industri otomotif sejak didirikan pada tanggal 5 Mei 1971. Dengan bangga kami menjadi dealer resmi produk motor Yamaha, memberikan pengalaman berkendara yang unggul dan pilihan terbaik untuk setiap perjalanan Anda.</p>
            <p class="lh-base">Tjahaja Baru, membangun lebih dari sekadar bisnis. Merajut kisah panjang keberhasilan sepanjang empat dekade, menjadi bagian tak terpisahkan dari perjalanan berkendara Anda. Dengan dedikasi kepada kualitas, inovasi, dan kepuasan pelanggan, telah tumbuh menjadi sebuah keluarga otomotif yang memiliki 34 cabang di seluruh Sumatera Barat, memberikan akses mudah bagi pelanggan setia kami.</p>
        </div>
    </section>

    <section class="section-bg visi-misi text-center aos-init aos-animate" data-aos="fade-in">
        <div class="container">
            <h2 class="fw-bold">Visi dan Misi</h2>
            <div class="row">
                <div class="col-md-6 d-flex aos-init aos-animate" data-aos="fade-right">
                    <div class="card">
                        <div class="card-image">
                            <img src="/images/visi.jpg" alt="">
                        </div>
                        <div class="card-body">
                            <p>Memberikan pelayanan terbaik kepada pelanggan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex aos-init aos-animate" data-aos="fade-left">
                    <div class="card">
                        <div class="card-image">
                            <img src="/images/misi.jpg" alt="">
                        </div>
                        <div class="card-body">
                            <p>Meningkatkan kualitas hidup pelanggan dengan menyediakan produk dan layanan berkualitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   

    <section class="section-bg nilai-nilai text-center aos-init aos-animate" data-aos="fade-in">
        <div class="container">
            <h2 class="fw-bold">Nilai - Nilai</h2>
            <div class="row">
                <div class="col-md-12 col-lg-4 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up">
                    <div class="icon-box">
                        <h3>Pelanggan</h3>
                        <p>Pelanggan adalah jantung usaha kita</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex align-items-stretch mt-4 mt-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box">
                        <h3>Inovasi</h3>
                        <p>Berani menjadi hebat dengan mendorong batasan</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex align-items-stretch mt-4 mt-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box">
                        <h3>Penciptaan Nilai</h3>
                        <p>Ciptakan nilai lebih, dalam semua hal yang dilakukan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('additional_script')
<script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
<script>
    AOS.init({
        easing: 'ease',
        duration: 1000,
    });   
</script>
@endsection