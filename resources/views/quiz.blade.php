@extends('layouts.master')

@section('title', 'Personality Product | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="Yamaha Sumatera Barat | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'quiz')

@section('additional_css')
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<link rel="stylesheet" href="{{ asset('css/quiz.css') }}" />
@endsection

@section('content')
<div class="container-fluid quiz-wrapper">
    <section class="opening-section">
        <div class="title-wrapper aos-init" data-aos="zoom-in">
            <h1>Produk Personality Kuis</h1>
        </div>
        <h2 class="aos-init" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">Seperti apa motor yang cocok untuk kamu? Cari tau yuk!</h2>
        <button class="quiz-button quiz-start aos-init" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">mulai</button>
    </section>
    
    <section class="quiz-form">
        <div class="question-slide">
            <div class="question-image">
                <picture>
                    <img src="{{ url('/images/quiz/age.png')}}" alt="age" style="width:100%;">
                </picture>
            </div>
            <div class="question-content">
                <div class="question">
                    <label for="age">Berapa usiamu?</label>
                    <div class="answer-option">
                        <input type="radio" name="age" class="option" value="age_1" id="age_1"> <label for="age_1">18 - 25</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="age" class="option" value="age_2" id="age_2"> <label for="age_2">26 - 35</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="age" class="option" value="age_3" id="age_3"> <label for="age_3">Diatas 35</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="question-slide">
            <div class="question-image">
                <picture>
                    <img src="{{ url('/images/quiz/riding_usage.png')}}" alt="riding-usage" style="width:100%;">
                </picture>
            </div>
            <div class="question-content">
                <div class="question">
                    <label for="usage">Apa kebutuhan motor bagi kamu?</label>
                    <div class="answer-option">
                        <input type="radio" name="usage" class="option" value="daily" id="daily"> <label for="daily">Untuk Perjalanan Harian</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="usage" class="option" value="adventure" id="adventure"> <label for="adventure">Untuk Petualangan dan Perjalanan Jauh</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="usage" class="option" value="hobby" id="hobby"> <label for="hobby">Untuk Hobby dan Komunitas</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="question-slide">
            <div class="question-image">
                <picture>
                    <img src="{{ url('/images/quiz/riding_style.png')}}" alt="riding-style" style="width:100%;">
                </picture>
            </div>
            
            <div class="question-content">
                <div class="question">
                    <label for="riding_style">Kamu tipe pengendara motor seperti apa kalau di jalanan?</label>
                    <div class="answer-option">
                        <input type="radio" name="riding_style" class="option" value="relaxed" id="relaxed"> <label for="relaxed">Tipe santai dan tenang</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="riding_style" class="option" value="adventurous" id="adventurous"> <label for="adventurous">Tipe petualang dan penuh adrenalin</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="question-slide">
            <div class="question-image">
                <picture>
                    <img src="{{ url('/images/quiz/riding_priority.png')}}" alt="riding-priority" style="width:100%;">
                </picture>
            </div>
            <div class="question-content">
                <div class="question">
                    <label for="priority">Kamu lebih memilih motor yang mengutamakan Fitur Komplit atau Performa Tinggi?</label>
                    <div class="answer-option">
                        <input type="radio" name="priority" class="option" value="feature" id="feature"> <label for="feature">Fitur Komplit</label>
                    </div>
                    <div class="answer-option">
                        <input type="radio" name="priority" class="option" value="performance" id="performance"> <label for="performance">Performa dan Kecepatan Tinggi</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="question-slide">
            <div class="last-question">
                <div class="question-image">
                    <picture>
                        <img src="{{ url('/images/quiz/last_page.png')}}" alt="last-page" style="width:100%;">
                    </picture>
                </div>
                <div class="button-wrapper">
                    <button type="submit" class="quiz-button quiz-submit naik-turun">gaspoll</button>
                </div>
            </div>
        </div>
    </section>

    <section class="result">
        <div class="result-title">
            <h1>Motor Yang Cocok Dengan Kamu Adalah</h1>
            <h2>title</h3>
        </div>
        <div class="result-image">
            <picture>
                <img src="" alt="result-image" style="width:100%;">
            </picture>
        </div>
        <div class="result-cta">
            <div class="button-wrapper">
                <a href="" onClick="refreshPage()" class="quiz-button coba-lagi">Coba Lagi</a>
            </div>
            <div class="button-wrapper">
                <a href="" class="quiz-button view-product">Lihat Produk</a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('additional_script')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    $(document).ready(function() {
        AOS.init({
            easing: 'ease-out-back',
            duration: 1000,
        });
    });
</script>
<script src="{{ asset('js/quiz.js') }}"></script>
@endsection