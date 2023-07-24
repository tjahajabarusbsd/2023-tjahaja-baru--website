@extends('layouts.master')

@section('title', 'Contact Us | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Tjahaja Baru | Contact Us">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'contact')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}" />
@endsection

@section('content')
<section class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2754950747762!2d100.35193247418114!3d-0.9451397353467688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b935ce843e1d%3A0x210ffc7693c22340!2sYamaha%20Tjahaja%20Baru!5e0!3m2!1sen!2sid!4v1685333788371!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="contact-detail">
                    <h3>Kontak</h3>
                    <p>Jika Anda mempunyai pertanyaan, silahkan menggunakan kontak berikut.</p>
                    <ul>
                        <li>
                          <i class="fa fa-map-marker"></i>
                          <strong>address</strong> 
                          Jl. Damar No. 59 (25133) Padang - Sumatera Barat INDONESIA
                        </li>
                        <li>
                          <i class="fa fa-phone"></i>
                          <strong>phone</strong>
                          0811805898
                      </li>
                        <li>
                          <i class="fa fa-envelope"></i>
                          <strong>email</strong>ccs@tjahaja-baru.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="main-form contact-form">
                    <div class="form-container">
                        <h1>Kirim Pesan</h1>
                
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                        @endif
                
                        <form action="{{ route('contact.submit') }}" method="post" class="myForm" onsubmit="disableButton()">
                            @csrf
                            @if(isset($_GET["dealer"]))
                                <input name="dealer" type="text" hidden value="{{ $_GET["dealer"] }}">
                            @endif
                
                            <div class="form-group" id="form-group">
                                <label for="name">Nama</label>
                                <input name="name" class="form-control" id="name" type="text" value="{{ old('name') }}"  placeholder="Nama Lengkap" maxlength="50" required>
                                @error('name')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="nohp">No Handphone (WhatsApp)</label>
                                <input name="nohp" id="nohp" class="form-control" type="tel" value="{{ old('nohp') }}"  placeholder="08123456789" maxlength="15" required>
                                @error('nohp')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Tulis Pesan</label>
                                <textarea name="message" class="form-control" placeholder="Tulis pesan Anda disini" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <input id="submitButton" class="btn btn-primary" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('additional_script')
    <script src="{{ asset('js/contact.js') }}"></script>
    <script>
        function disableButton() {
            document.getElementById('submitButton').setAttribute('disabled', 'disabled');
        }
    </script>
@endsection