@extends('layouts.master')

@section('title', 'My Yamaha | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="My Yamaha | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'myyamaha')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/myyamaha.css') }}" />
@endsection

@section('content')
    <section class="section1">
        <div class="banner">
            <img src="{{ url('/images/myyamaha/banner.jpg')}}" alt="">
        </div>
        <div class="caption">
            <div class="text-wrapper">
                <h3>My Yamaha Motor Members</h3>
                <p>Program Yamaha untuk pengguna aplikasi <b>My Yamaha Motor</b> yang memberikan keistimewaan khusus untuk setiap transaksi atau pembelian di dealer resmi Yamaha. Kumpulkan poin dan dapatkan berbagai keuntungan dan manfaat sebagai Members.</p>
            </div>
        </div>
    </section>
    <section class="section2 animated-element">
        <div class="banner">
            <img src="{{ url('/images/myyamaha/banner.jpg')}}" alt="">
        </div>
        <div class="navpage">
            <a class="navdiv" href="#section3">
                <img src="{{ url('/images/myyamaha/icon-trophy.png') }}" alt="" class="navimg">
                <span class="navspan">Benefit</span>
            </a>
            <a class="navdiv" href="#section4">
                <img src="{{ url('/images/myyamaha/icon-point-duplicate.png') }}" alt="" class="navimg">
                <span class="navspan">Peringkat & Keuntungan</span>
            </a>
            <a class="navdiv" href="#section5">
                <img src="{{ url('/images/myyamaha/icon-medal.png') }}" alt="" class="navimg">
                <span class="navspan">Cara Mendapatkan Poin</span>
            </a>
            <a class="navdiv" href="#section6">
                <img src="{{ url('/images/myyamaha/icon-picture.png') }}" alt="" class="navimg">
                <span class="navspan">Download Apps</span>
            </a>
            <a class="navdiv" href="#section7">
                {{-- <img src="{{ url('/images/myyamaha/icon-trophy.png') }}" alt="" class="navimg"> --}}
                <span class="navspan">FAQ</span>
            </a>
        </div>
    </section>
    <section class="section3 animated-element" id="section3">
        <h3 class="title">Benefit</h3>
        <div class="items-container">
            <div class="item">
                <img src="{{ url('/images/myyamaha/Artboard1.png')}}" alt="">
                <span class="item-text">Voucher Dealer</span>
            </div>
            <div class="item">
                <img src="{{ url('/images/myyamaha/Artboard2.png')}}" alt="">
                <span class="item-text">Gratis SKY</span>
            </div>
            <div class="item">
                <img src="{{ url('/images/myyamaha/Artboard3.png')}}" alt="">
                <span class="item-text">Exclusive Merchandise</span>
            </div>
            <div class="item">
                <img src="{{ url('/images/myyamaha/Artboard4.png')}}" alt="">
                <span class="item-text">Perpanjangan KSG</span>
            </div>
        </div>
    </section>
    <section class="section4 animated-element" id="section4">
        <h3 class="title">Peringkat & Keuntungan</h3>
        <div class="tier-container">
            <div class="tier-content">
                <div class="top-content">
                    <img class="tier-badge" src="{{ url('/images/myyamaha/Blue.png')}}" alt="">
                    <p class="tier-title">Blue</p>
                    <p class="tier-point">< 999 Point</p>
                </div>
                <div class="bot-content">
                    <p>Yamaha Newsletter</p>
                </div>
            </div>
            <div class="tier-content">
                <div class="top-content">
                    <img class="tier-badge" src="{{ url('/images/myyamaha/Bronze.png')}}" alt="">
                    <p class="tier-title">Bronze</p>
                    <p class="tier-point">1,000-1,999Point</p>
                </div>
                <div class="bot-content">
                    <p>Yamaha Newsletter</p>
                    <p>Voucher</p>
                </div>
            </div>
            <div class="tier-content">
                <div class="top-content">
                    <img class="tier-badge" src="{{ url('/images/myyamaha/Silver.png')}}" alt="">
                    <p class="tier-title">Silver</p>
                    <p class="tier-point">2,000-7,499Point</p>
                </div>
                <div class="bot-content">
                    <p>Yamaha Newsletter</p>
                    <p>Voucher</p>
                    <p>SKY</p>
                </div>
            </div>
            <div class="tier-content">
                <div class="top-content">
                    <img class="tier-badge" src="{{ url('/images/myyamaha/Gold.png')}}" alt="">
                    <p class="tier-title">Gold</p>
                    <p class="tier-point">7,500-9,999Point</p>
                </div>
                <div class="bot-content">
                    <p>Yamaha Newsletter</p>
                    <p>Voucher</p>
                    <p>SKY</p>
                    <p>Exclusive Merchandise</p>
                    <p>Perpanjangan KSG</p>
                </div>
            </div>
            <div class="tier-content">
                <div class="top-content">
                    <img class="tier-badge" src="{{ url('/images/myyamaha/Platinum.png')}}" alt="">
                    <p class="tier-title">Platinum</p>
                    <p class="tier-point">10,000 > Point</p>
                </div>
                <div class="bot-content">
                    <p>Yamaha Newsletter</p>
                    <p>Voucher</p>
                    <p>SKY</p>
                    <p>Exclusive Merchandise</p>
                    <p>Perpanjangan KSG</p>
                    <p>Undangan Special Event</p>
                    <p>Perpanjangan Masa Garansi Motor</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section5 animated-element" id="section5">
        <h3 class="title">Cara Mendapatkan Poin</h3>
        <div class="poin-container">
            <div class="poin-desc poin-side-left">
                <p>Beli Motor Yamaha</p>
                <p>Beli Sparepart Yamaha</p>
                <p>Service KSG/KSB</p>
                <p>Berkendara (Connected*)</p>
                <p>Referral</p>
                <p>Dealer Rating</p>
                <p>Service Booking <br><span>(Melalui My Yamaha Motor App)</span></p>
            </div>
            <div class="poin-desc poin-side-right">
                <p>: 4,500 PT / Unit</p>
                <p>: 1 PT / RP 1000</p>
                <p>: 100 PT / Service</p>
                <p>: 2 PT / 25 KM</p>
                <p>: 50 PT / Referral</p>
                <p>: 50 PT / Rating</p>
                <p>: 50 PT / Booking</span></p>
            </div>
        </div>
    </section>
    <section class="section6 animated-element" id="section6">
        <h3 class="title title-mb">Download <img class="icon-apps" src="{{ url('/images/myyamaha/icon-picture.png') }}" alt=""><br>My Yamaha Motor App</h3>
        <div class="banner">
            <img src="{{ url('/images/myyamaha/iphone.png')}}" alt="">
        </div>
        <div class="caption">
            <div class="text-wrapper">
                <h3 class="title title-pc">Download <img class="icon-apps" src="{{ url('/images/myyamaha/icon-picture.png') }}" alt=""><br>My Yamaha Motor App</h3>
                <p>
                    "My Yamaha Motor" aplikasi yang dibuat untuk semua konsumen yang mempunyai dan mengendarai sepeda motor Yamaha. <br>
                    Aplikasi ini mendukung Anda untuk mendapatkan gaya hidup yang lebih menyenangkan dengan sepeda motor Yamaha.
                </p>
            </div>
            <div class="download-container">
                <a href=""><img src="{{ url('/images/myyamaha/8-apple.png')}}" alt=""></a>
                <a href=""><img src="{{ url('/images/myyamaha/8-android.png')}}" alt=""></a>
            </div>
        </div>
    </section>
    <section class="section7 animated-element" id="section7">
        <h3 class="title">FAQ</h3>
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1">
            <b>Q : Apa itu My Yamaha Motor Members?</b>
        </a>
        <div class="collapse" id="collapse-1">
            <div class="card card-body">
                My Yamaha Motor Members adalah Program loyalitas pelanggan Yamaha Motor Indonesia dengan tujuan untuk meningkatkan pengalaman pelanggan saat pelanggan membeli sepeda motor Yamaha, service di dealer resmi Yamaha dan berkendara dengan connected model. Pelanggan akan mendapatkan benefit dari Yamaha Motor Indonesia sesuai dengan Level/Tier.
            </div>
        </div>
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2">
            <b>Q : Bagaimana cara mengikuti / mendaftar My Yamaha Motor Members?</b>
        </a>
        <div class="collapse" id="collapse-2">
            <div class="card card-body">
                Download My Yamaha Motor App di google playstore atau Applestore otomatis akan menjadi anggota My Yamaha Motor Members.
            </div>
        </div>
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3">
            <b>Q : Bagaimana cara mendapatkan point?</b>
        </a>
        <div class="collapse" id="collapse-3">
            <div class="card card-body">
                Anda bisa mendapatkan point dengan cara :
                <ul>
                    <li>Pembelian Sepeda Motor di dealer resmi Yamaha</li>
                    <li>Melakukan Booking service dan memberikan evaluasi dealer melalui aplikasi My Yamaha Motor</li>
                    <li>Berkendara menggunakan Aplikasi Y-Connect (khusus connected model)</li>
                    <li>Perawatan sepeda motor Anda di dealer resmi Yamaha</li>
                    <li>Pembelian Sparepart atau aksesoris di dealer resmi Yamaha</li>
                    <li>Memberikan refrensi aplikasi My yamaha motor ke teman / kerabat dan keluarga Anda</li>
                </ul>
            </div>
        </div>
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4">
            <b>Q : Bagaimana cara mengetahui point dan benefit yang didapat?</b>
        </a>
        <div class="collapse" id="collapse-4">
            <div class="card card-body">
                Anda dapat mengetahui point dan benefit di Aplikasi My Yamaha Motor di menu Member/anggota.
            </div>
        </div>
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapse-5" role="button" aria-expanded="false" aria-controls="collapse-5">
            <b>Q : Bagaimana cara mengetahui point dan benefit yang didapat?</b>
        </a>
        <div class="collapse" id="collapse-5">
            <div class="card card-body">
                Anda dapat mengetahui point dan benefit di Aplikasi My Yamaha Motor di menu Member/anggota.
            </div>
        </div>
    </section>
@endsection

@section('additional_script')
<script>
    $(document).ready(function() {
        $(window).scroll(function() {
        var scroll = $(window).scrollTop();

            $('.animated-element').each(function() {
                var offset = $(this).offset().top;
                var animationTriggered = $(this).data('animated');

                if (scroll > offset - 400 && !animationTriggered) {
                    $(this).addClass('animate').data('animated', true);
                }
            });
        });
    });
  </script>
@endsection