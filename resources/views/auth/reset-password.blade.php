@extends('layouts.master')

@section('title', 'Reset Password | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="{{ __('Reset Password') }} | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'auth')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center mb-4">Reset Password</h3>

        <form method="POST" action="{{ route('reset.password.update') }}">
            @csrf

            {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

            <div class="form-group">
                <label for="password">{{ __('Password Baru') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Konfirmasi Password Baru') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
        </form>
    </div>
</div>
@endsection