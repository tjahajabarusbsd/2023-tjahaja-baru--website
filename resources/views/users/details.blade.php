@extends('layouts.master')

@section('title')
    My Profile | Tjahaja Baru
@endsection

@section('meta_og')
  <meta property="og:title" content="My Profile | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'user-profile')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
@endsection

@section('content')
@php
function isDesktop() {
    $userAgent = request()->header('User-Agent');
    return !preg_match('/Mobile/i', $userAgent);
}
@endphp
<div class="container">
    <div class="top-bg"></div>
    <div class="top-content card-content-wrapper">
        <div id="data-profile">
            {{-- <div class="content-avatar">
                <img src="{{ url('/images/dummy-image.png') }}" alt="">
            </div> --}}
            <h1>Hello,</h1>
            <p id="name-field"><span>{{ $user->name ?? 'Belum ada nama' }}</span></p>
            
            <div class="content-contact">
                <p id="email-field">E-mail: <span>{{ $user->email ?? '-' }}</span></p>
                <p id="phone-field">No. HP: <span>{{ $user->phone_number ?? '-' }}</span></p>
            </div>

            <button id="edit-profile-btn" class="corner-button"><i class="fa-solid fa-pen-to-square"></i><span>Edit Profile</span></button>

            <a href="/logout" id="logout-btn" class="corner-button"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a>
        </div>

        <div id="edit-profile" >
            <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div id="error-messages"></div>
                <label for="name">Nama: <input type="text" id="name" class="form-control" name="name" required value="{{ $user->name ?? '' }}"></label>
                
                <label for="email">Email: <input type="email" id="email" class="form-control" name="email" required value="{{ $user->email ?? '' }}"></label>
                
                <label for="phone_number">No. HP: <input type="text" id="phone_number" class="form-control" name="phone_number" required value="{{ $user->phone_number ?? '' }}"></label>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" id="cancel-edit-btn" class="btn btn-primary">Cancel</button>
            </form>
        </div>
    </div>
    
    <div class="menu" role="tablist">
        <button class="menu-item active" data-bs-toggle="tab" data-bs-target="#nav-riwayat-service" role="tab" aria-controls="nav-riwayat-service" aria-selected="true"><img width="96" height="96" src="https://img.icons8.com/ios/100/activity-history.png" alt="activity-history"/>Riwayat Servis</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-pinjaman-dana" role="tab" aria-controls="nav-pinjaman-dana" aria-selected="false"><img width="96" height="96" src="https://img.icons8.com/external-tanah-basah-basic-outline-tanah-basah/96/external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah.png" alt="external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah"/>Pinjaman Dana Tunai</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-sky" role="tab" aria-controls="nav-spec" aria-selected="false"><img src="{{ url('/images/Artboard2.png')}}" alt="sky-logo"/>SKY</button>
    </div>

    <div class="bottom-content tab-content card-content-wrapper">
        <div class="riwayat-servis-container tab-pane fade show active" id="nav-riwayat-service" role="tabpanel" aria-labelledby="nav-riwayat-service-tab">
            @include('users/riwayat-servis-list')
        </div>
        <div class="tab-pane fade" id="nav-pinjaman-dana" role="tabpanel" aria-labelledby="nav-pinjaman-dana-tab">
            @include('users/simulasi-pinjaman-dana')
        </div>
    </div>
</div>
<div class="overlay" id="overlay">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>
@endsection

@section('additional_script')
<script src="{{ asset('js/user-profile.js') }}"></script>
@endsection