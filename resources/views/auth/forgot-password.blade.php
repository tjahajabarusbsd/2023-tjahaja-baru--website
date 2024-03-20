@extends('layouts.master')

@section('title', 'Forgot Password | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="{{ __('Forgot Password') }} | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'auth')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
<div class="container forgot-password">
    <div class="row">
        <h3 class="text-center mb-4">Lupa Password</h3>
            
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif

        <form method="POST" action="{{ route('send.link') }}">
            @csrf

            <div class="form-group">
                <label for="phone_number">No Handphone</label>
                <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required placeholder="Cth:0812345678">

                @error('phone_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
        </form>

        <div class="text-center mt-4">
            <a href="/login">Masuk</a>
            /
            <a href="/register">Daftar</a>
        </div>
                    
    </div>
</div>
@endsection