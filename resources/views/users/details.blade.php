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
@endsection

@section('content')
@php
function isDesktop() {
    $userAgent = request()->header('User-Agent');
    return !preg_match('/Mobile/i', $userAgent);
}
@endphp
<div class="container">
    <div class="bg"></div>
    <div class="top-content">
        <div id="dataProfile">
            {{-- <div class="content-avatar">
                <img src="{{ url('/images/dummy-image.png') }}" alt="">
            </div> --}}
            <h1>Hello,</h1>
            <div class="content-title">
                <p id="nameField"><span>{{ $user->name ?? 'Belum ada nama' }}</span></p>
            </div>
            
            <div class="content-contact">
                <p id="emailField">E-mail: <span>{{ $user->email ?? '-' }}</span></p>
                <p id="phoneField">No. HP: <span>{{ $user->phone_number ?? '-' }}</span></p>
            </div>

            <button id="editProfileBtn" class="corner-button"><i class="fa-solid fa-pen-to-square"></i><span>Edit Profile</span></button>

            <a href="/logout" id="logoutBtn" class="corner-button"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a>
        </div>

        <div id="editProfileForm" >
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div id="errorMessages"></div>
                <label for="name">Nama: <input type="text" id="name" class="form-control" name="name" required value="{{ $user->name ?? '' }}"></label>
                
                <label for="email">Email: <input type="email" id="email" class="form-control" name="email" required value="{{ $user->email ?? '' }}"></label>
                
                <label for="phone_number">No. HP: <input type="text" id="phone_number" class="form-control" name="phone_number" required value="{{ $user->phone_number ?? '' }}"></label>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" id="cancelEditBtn" class="btn btn-primary">Cancel</button>
            </form>
        </div>
    </div>
    
    <div class="menu">
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-riwayat-service" role="tab" aria-controls="nav-spec" aria-selected="false"><img width="96" height="96" src="https://img.icons8.com/ios/100/activity-history.png" alt="activity-history"/>Riwayat Servis</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-pinjaman-dana" role="tab" aria-controls="nav-spec" aria-selected="true"><img width="96" height="96" src="https://img.icons8.com/external-tanah-basah-basic-outline-tanah-basah/96/external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah.png" alt="external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah"/>Pinjaman Dana Tunai</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-spec"><img src="{{ url('/images/Artboard2.png')}}" alt="sky-logo"/>SKY</button>
    </div>
    
    <div class="bottom-content">
        <div class="riwayat-servis-container tab-pane fade show active" id="nav-riwayat-service" role="tabpanel" aria-labelledby="nav-spec-tab">
            <h2>Riwayat Servis Motor Yamaha</h2>

            @if(!$getOneNomorRangka)
                <div class="alert bg-info bg-gradient info-wrapper">
                    <h4>Nomor Rangka tidak ditemukan.</h4>
                    <p>Silakan masukkan Nomor Rangka motor Anda untuk melihat Riwayat Servis.</p>
                    <dl>
                        <dt>Nomor Rangka</dt>
                        <dd>Contohnya: MH39A9999AA123456</dd>
                    </dl>
                </div>

                <form method="post" class="form-container" action="{{ route('user.profile.saveNoRangka') }}">
                    @csrf
                    
                    <input type="text" name="nomor_rangka" class="form-control @error('nomor_rangka') is-invalid @enderror" placeholder="Nomor Rangka" required>
                    
                    @error('nomor_rangka')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            
                    <div class="form-group">
                        <input id="submitButton" class="btn btn-primary" type="submit" value="Submit">
                    </div>
                </form>
            @else
                <div class="have-data">
                    <p>Klik pada nomor kendaraan Anda untuk melihat riwayat servis</p>
                    <div class="list-motor">
                        @foreach ( $getAllNomorRangka as $item )
                            <a class="btn-motor" href="/user-profile/{{ $item->nomor_rangka }}"><span>{{ $item->nomor_rangka }}<span></a>
                        @endforeach
                        <button class="btn-tambah"><i class="fa-solid fa-plus"></i> Tambah</button>
                    </div>

                    <div id="tambah-nomor-rangka" style="margin-top:50px; display:none">
                        <form method="post" class="form-container" action="{{ route('user.profile.saveNoRangka') }}">
                            @csrf
                            
                            <input type="text" name="nomor_rangka" class="form-control @error('nomor_rangka') is-invalid @enderror" placeholder="Nomor Rangka" required>
                            
                            @error('nomor_rangka')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    
                            <div class="form-group">
                                <input id="submitButton" class="btn btn-primary" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                    
                    @include('users/riwayat-servis-list')
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="nav-pinjaman-dana" role="tabpanel" aria-labelledby="nav-spec-tab"></div>
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