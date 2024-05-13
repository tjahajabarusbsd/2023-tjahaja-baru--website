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
    
    <div class="menu" role="tablist">
        <button class="menu-item active" data-bs-toggle="tab" data-bs-target="#nav-riwayat-service" role="tab" aria-controls="nav-riwayat-service" aria-selected="true"><img width="96" height="96" src="https://img.icons8.com/ios/100/activity-history.png" alt="activity-history"/>Riwayat Servis</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-pinjaman-dana" role="tab" aria-controls="nav-pinjaman-dana" aria-selected="false"><img width="96" height="96" src="https://img.icons8.com/external-tanah-basah-basic-outline-tanah-basah/96/external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah.png" alt="external-payments-social-media-ui-tanah-basah-basic-outline-tanah-basah"/>Pinjaman Dana Tunai</button>
        <button class="menu-item" data-bs-toggle="tab" data-bs-target="#nav-sky" role="tab" aria-controls="nav-spec" aria-selected="false"><img src="{{ url('/images/Artboard2.png')}}" alt="sky-logo"/>SKY</button>
    </div>

    <div class="bottom-content tab-content">
        <div class="riwayat-servis-container tab-pane fade show active" id="nav-riwayat-service" role="tabpanel" aria-labelledby="nav-riwayat-service-tab">
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
        <div class="tab-pane fade" id="nav-pinjaman-dana" role="tabpanel" aria-labelledby="nav-pinjaman-dana-tab">
            <div class="container-simulasi">
                <h2 class="text-center mb-4">Kalkulator Simulasi Pinjaman</h2>

                <div class="form-group row">
                    <label for="cars" class="col-md-4 col-form-label text-md-right">Pilih tipe:</label>
                    <div class="col-md-6">
                        <select class="form-control" name="tipe" id="tipe">
                            <option selected disabled value=""> -- Pilih -- </option>
                            @if ($specList->isEmpty())
                                <option value="other"> -- Lainnya -- </option>
                            @else
                                @foreach ($specList as $list)
                                    <option value="{{ $list->name }}">{{ $list->name }}</option>
                                @endforeach
                                <option value="other"> -- Lainnya -- </option>
                            @endif
                        </select>
                        <span class="text-danger" id="error_tipe" style="display:none;">Tipe tidak boleh kosong.</span>
                    </div>
                </div>
                
                <div id="otherInput" class="form-group row" style="display: none;">
                    <label for="otherProduct" class="col-md-4 col-form-label text-md-right">Masukkan tipe lain:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="otherProduct" name="otherProduct">
                        <span class="text-danger" id="error_unit_name" style="display:none;">Tipe tidak boleh kosong</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cars" class="col-md-4 col-form-label text-md-right">Pilih tahun:</label>
                    <div class="col-md-6">
                        <input type="number" min="2000" max="2024" step="1" class="form-control" name="unit_tahun" id="unit_tahun" placeholder="Misal: 2021">
                        <span class="text-danger" id="error_unit_tahun" style="display:none;">Tahun tidak boleh kosong.</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="harga_motor" class="col-md-4 col-form-label text-md-right">Estimasi Harga Motor:</label>
                    <div class="col-md-6">
                        <input type="text" id="harga_motor" name="harga_motor" class="form-control">
                        <span class="text-danger" id="error_harga_motor" style="display:none;">Harga motor tidak boleh kosong.</span>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button id="hitung" class="btn btn-primary">Hitung</button>
                    </div>
                </div>

                <div id="hasil">Maksimal Pinjaman Senilai<br>Rp 2.000.000</div>                

                <div class="row">
                    <div class="col-md-12" id="input_dana">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Dana yang Ingin Dicairkan (juta):</label>
                            <div class="col-md-6">
                                <label for="dana_dicairkan" id="dana_dicairkan_label" class="col-form-label text-md-right">dana</label>
                                <input type="range" id="dana_dicairkan" name="dana_dicairkan" class="" min="3000000" step="1000000" max="7000000" style="width: 100%;">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="tenor" class="col-md-4 col-form-label text-md-right">Tenor (in months):</label>
                            <div class="col-md-6">
                                <input type="number" id="tenor" name="tenor" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="hitung_angsuran" class="btn btn-primary">Hitung Angsuran</button>
                            </div>
                        </div>
                        
                        <div id="hasil-angsuran">
                            <div class="break-line mt-5" style="
                                border-style: inset;
                                border-width: 1px;
                                border-color: #dadada;
                            "></div>
                            <div class="section-angsuran-result">
                                <div class="mt-3 col-md-8">
                                    <div style="font-size: 25px; font-weight: 700">Angsuran</div>
                                    <div style="font-size:10px;">*sudah termasuk bunga dan biaya admin</div>
                                    <div style="margin: 5px 0; font-size: 25px; font-weight: 700">
                                        <input type="hidden" name="angsuran_monthly" id="angsuran-monthly" value="">
                                        <span id="biaya-angsuran">Rp -</span>
                                        <span>/bulan*</span>
                                    </div>
                                    <div style="font-size: 12px">*) Estimasi nilai pinjaman bukan merupakan persetujuan pinjaman dana, bersifat tidak mengikat, dan dapat disesuaikan berdasarkan penilaian lebih lanjut serta kebijakan BPR.</div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-ajukan">Ajukan Pinjaman</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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