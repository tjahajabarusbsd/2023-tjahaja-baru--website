@extends('layouts.master')

@section('title', 'Promo | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="Promo | Tjahaja Baru">
    <meta property="og:description"
        content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
@endsection

@section('main_class', 'promo')

@section('additional_css')

@endsection

@section('content')
    <div class="promo-container py-5">
        {{-- Gambar Promo di Atas --}}
        <div class="text-center mb-4">
            <img src="{{ asset('images/promo_banner_semangat.jpeg') }}" alt="Promo September Tjahaja Baru"
                class="img-fluid">
        </div>

        {{-- Konten Promo --}}
        <div class="container">
            <h2 class="text-center fw-bold mb-4">Bikin motor impian jadi kenyataan itu nggak pernah semudah ini!</h2>

            <p>Buat kamu yang mendambakan motor sporty dan modern seperti <strong>Yamaha Aerox</strong> atau motor elegan
                dan nyaman seperti <strong>Yamaha Nmax</strong>, sekarang saatnya untuk meraihnya. Kami punya penawaran
                istimewa yang akan bikin kamu langsung tertarik!</p>

            <h3 class="mt-4">Promo Istimewa untuk Yamaha Aerox dan Nmax</h3>
            <p>Punya motor baru sekarang bukan lagi mimpi. Dengan promo <strong>"Bayar 1 Bulan Angsuran, Gratis 10 Bulan
                    Angsuran"</strong>, kamu bisa segera bawa pulang motor Yamaha Aerox atau Nmax idamanmu! Segera nikmati
                promo ini, dari bayar 35 bulan angsuran, cukup kamu bayar jadi 25 bulan saja. Ini kesempatan langka yang
                sangat sayang jika dilewatkan!</p>

            <h3 class="mt-4">Tukar Tambah Motor Lama dengan Proses Super Gampang</h3>
            <p>Punya motor lama dan ingin ganti yang baru? Manfaatkan program trade-in kami! Prosesnya sangat mudah, cepat,
                dan tidak ribet. Tim kami akan membantu setiap langkahnya, sehingga kamu bisa mendapatkan motor baru dengan
                harga yang lebih terjangkau. Tidak perlu pusing menjual motor lama, biar kami yang urus!</p>

            <h3 class="mt-4">Dapatkan Performa Motor Terbaik dengan Harga Hemat</h3>
            <p>Tak cuma motornya saja, kami juga punya promo khusus untuk perawatan. Setiap pembelian <strong>CVT
                    Kit</strong>, kamu akan langsung mendapatkan diskon sebesar <strong>Rp30.000</strong>. Dengan CVT Kit
                berkualitas, performa motor akan selalu optimal, tarikan makin responsif, dan konsumsi bahan bakar lebih
                efisien. Motor selalu prima, perjalanan pun makin nyaman dan aman.</p>

            <div class="mt-4">
                <p><strong>Jadi, tunggu apa lagi?</strong> Ini adalah waktu terbaik untuk memiliki Yamaha Aerox atau Nmax.
                    Gabungan promo angsuran, kemudahan tukar tambah, dan diskon perawatan ini bikin semuanya terasa lebih
                    ringan. Segera kunjungi dealer Yamaha terdekat dan rasakan sendiri kemudahannya.</p>
                <p><strong>Periode promo berlaku 16 - 30 September 2025.</strong></p>
                <p><em>*Syarat & ketentuan berlaku.</em></p>
                <p>Informasi lebih lanjut silahkan hubungi <strong>Customer Service</strong> kami.</p>
            </div>
        </div>
    </div>
@endsection