@extends('layouts.master')

@section('title', 'Login | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="{{ __('Login') }} | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'auth')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="form-container">
            <form method="POST" action="{{ route('login') }}" id="authForm">
                @csrf

                <h1 class="roboto-regular">Selamat Datang</h1>
                <p class="roboto-regular">Lorem, ipsum dolor sit amet consectetur adipisicing elit.<br />Eligendi nulla tempore repellendus sapiente natus.</p>

                <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror roboto-regular" name="phone_number" value="{{ old('phone_number') }}" placeholder="No Handphone" required>

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror roboto-regular" name="password" placeholder="Password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <a class="text-end roboto-regular" href="/forgot-password">Lupa Password?</a>

                <button type="submit" class="btn roboto-regular auth-button"><span class="submit-text">Masuk</span></button>

                <div class="separator roboto-regular">
                    <div class="line"></div>
                    <p>Or</p>
                    <div class="line"></div>
                </div>

                <div class="social-buttons">
                    <a class="roboto-regular" href="{{ '/auth/redirect'}}"><img width="28" height="28" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo"/> Continue with Google</a>
                    {{-- <a class="roboto-regular" href="#"><img width="28" height="28" src="https://img.icons8.com/fluency/48/facebook-new.png" alt="facebook-new"/> Continue with Facebook</a> --}}
                </div>

                <div class="sign-in-and-up roboto-regular">
                    <p>Belum punya akun?<a href="/register"> Daftar</a></p>
                </div>
            </form>
        </div>
        <div class="banner">
            <img src="{{ url('/images/login-banner.png') }}" alt="" class="image">
        </div>
    </div>
@endsection

@section('additional_script')
<script>
    $(document).ready(function() {
        $('#authForm').submit(function() {
            $('.submit-text').hide();
            $('.auth-button').prop('disabled', true);
            $('.auth-button').addClass('loading');
        });

        @if ($errors->any())
            $('.submit-text').show();
            $('.auth-button').prop('disabled', false);
            $('.auth-button').removeClass('loading');
        @endif
    });
</script>
@endsection