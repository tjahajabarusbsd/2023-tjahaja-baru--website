@extends('layouts.master')

@section('title', 'Consultation | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Consultation | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'consultation')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/consultation.css') }}" />
@endsection

@section('content')
<div class="consultation-wrapper container">
    <div class="banner">
        <img src="{{ url('/images/support.avif') }}" alt="" class="image">
        <div class="text">
            Konsultasi<br />
            Pembelian
        </div>
    </div>
    <div class="main-form consultation-form">
        <div class="form-container">
            {{-- <h1>Konsultasi pembelian</h1> --}}
            <p>Silakan konsultasikan minat produk Yamaha impian Anda langsung dengan dealer kami.</p>
    
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
    
            <form action="/send_message" method="post">
                @csrf
                @if (!empty($value))
                    <input name="sales" type="text" hidden value="{{ $value }}">
                @endif
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input name="name" class="form-control" type="text" value="{{ old('name') }}"  placeholder="Nama Lengkap" maxlength="50">
                    @error('name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="nohp">No. Handphone (WhatsApp)</label>
                    <input name="nohp" class="form-control" type="tel" value="{{ old('nohp') }}"  placeholder="08123456789" maxlength="15">
                    @error('nohp')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="lists">Produk yang diminati</label>
                    <select name="produk" class="form-select" aria-label="Default select example" >
                        <option selected disabled value=""> - pilih produk - </option>
                        @foreach ($lists as $list)
                            <option value="{{ $list->name }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
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
                    <input class="btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('additional_script')

@endsection