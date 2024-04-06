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
<div class="container">
    <div class="bg"></div>
    <div class="top-content">
        <div id="dataProfile">
            {{-- <div class="content-avatar">
                <img src="{{ url('/images/dummy-image.png') }}" alt="">
            </div> --}}
            <h1>My Profile</h1>
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
    <div class="bottom-content">
        @if(!$getNomor)
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
                
                <input type="text" name="nomor_rangka" id="" class="form-control @error('nomor_rangka') is-invalid @enderror" placeholder="Nomor Rangka" required>
                
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
            <h2>Riwayat Servis Motor Yamaha</h2>
            <dl>
                <dt>Nomor Rangka</dt>
                <dd>{{ $getNomor->nomor_rangka }}</dd>
            </dl>
            @php
            function isDesktop() {
                $userAgent = request()->header('User-Agent');
                return !preg_match('/Mobile/i', $userAgent);
            }
            @endphp
            
            @if (!empty($data))
                <a href="/riwayatservis/cetak_pdf" class="btn btn-primary" style="width:150px;" target="_blank">CETAK PDF</a>
                @if(isDesktop())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-wrap">
                                <table class="table  table-hover" id="">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Invoice</th>
                                        <th>Kategori Servis</th>
                                        <th>Total Biaya</th>
                                        <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($data as $item)
                                        <tr data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="@php if($i == 1) echo 'true'; else echo 'false'; @endphp" aria-controls="collapse{{ $i }}" @php if($i == 1) echo 'class'; else echo 'class="collapsed"'; @endphp>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ date("d-m-Y H:i", strtotime($item['event_walkin'])) }}</td>
                                        <td>{{ $item['invoice'] }}</td>
                                        <td>{{ $item['svc_cat'] }}</td>
                                        <td>Rp. {{ number_format($item['cost_total'],0,",",".") }}</td>
                                        <td>
                                            <i class="fa" aria-hidden="@php if($i == 1) echo 'true'; else echo 'false'; @endphp"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" id="collapse{{ $i }}" class="accordion-collapse collapse acc @php if($i == 1) echo 'show'; else echo ''; @endphp" data-bs-parent="#accordion">
                                                <div class="detail-wrapper">
                                                    <dl>
                                                        <dt>Tempat Servis</dt>
                                                        <dd>{{ $item['nama_dealer'] }}</dd>
                                                        <dt>Kategori Servis</dt>
                                                        <dd>{{ $item['svc_cat'] }}</dd>
                                                        <dt>Mekanik</dt>
                                                        <dd>{{ $item['mechanic_name'] }}</dd>
                                                        <dt>Unit</dt>
                                                        <dd>{{ $item['prod_nm'] }}</dd>
                                                    </dl>
                                                    <div class="row detail-cost">
                                                        <div class="col col-md-2">Paket Servis</div>
                                                        <div class="col col-md-5">
                                                            @php 
                                                                $svc_pac = json_decode($item['svc_pac']);
                                                            @endphp
                                                            @foreach( $svc_pac as $paket_servis)
                                                                <ul>
                                                                    <li>{{ $paket_servis }}</li>
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            @php 
                                                                $svc_cost = json_decode($item['svc_cost']);
                                                            @endphp
                                                            @foreach( $svc_cost as $servis_cost)
                                                                <ul>
                                                                    Rp. {{ number_format($servis_cost,0,",",".") }}
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row detail-cost">
                                                        <div class="col col-md-2">Part Terpakai</div>
                                                        <div class="col col-md-5">
                                                            @foreach( $item['part_name'] as $nama_part)
                                                                <ul>
                                                                    <li>{{ $nama_part }}</li>
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                        <div class="col">
                                                            @php 
                                                                $part_qty = json_decode($item['part_qty']);
                                                            @endphp
                                                            @foreach ($part_qty as $qty)
                                                                <ul>
                                                                    {{ $qty }}
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                        <div class="col">
                                                            @php 
                                                                $part_cost = json_decode($item['part_cost']);
                                                            @endphp
                                                            @foreach ($part_qty as $index => $qty)
                                                            @php
                                                                $total_cost = $qty * $part_cost[$index];
                                                            @endphp
                                                            <ul>
                                                                Rp. {{ number_format($total_cost,0,",",".") }}
                                                            </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row detail-cost">
                                                        <div class="col col-md-2">Total Biaya</div>
                                                        <div class="col col-md-5"></div>
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            <ul>
                                                                Rp. {{ number_format($item['cost_total'],0,",",".") }}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                <style>
                    dl {
                        text-align: left;
                    }

                    dt,
                    dd {
                        font-size: 12px;
                    }
                </style>
                    @foreach($data as $item)
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tanggal Servis {{ date("d-m-Y H:i", strtotime($item['event_walkin'])) }}
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <dl>
                                            <dt>Tempat Servis</dt>
                                            <dd>{{ $item['nama_dealer'] }}</dd>
                                            <dt>Kategori Servis</dt>
                                            <dd>{{ $item['svc_cat'] }}</dd>
                                            <dt>Mekanik</dt>
                                            <dd>{{ $item['mechanic_name'] }}</dd>
                                            <dt>Unit</dt>
                                            <dd>{{ $item['prod_nm'] }}</dd>
                                            <dt>Paket Servis</dt>
                                            @php
                                                $svc_pac = json_decode($item['svc_pac']);
                                                $svc_cost = json_decode($item['svc_cost']);
                                            @endphp    
                                            @foreach($svc_pac as $index => $paket_servis)
                                                <dd>{{ $paket_servis }}; Rp. {{ number_format($svc_cost[$index], 0, ",", ".") }}</dd>
                                            @endforeach
                                            <dt>Part Terpakai</dt>
                                            @php 
                                                $part_name = $item['part_name'];
                                                $part_qty = json_decode($item['part_qty']);
                                                $part_cost = json_decode($item['part_cost']);
                                            @endphp
                                            @foreach($part_name as $key => $value)
                                            @php
                                                $total_cost = $part_qty[$key] * $part_cost[$key];
                                            @endphp
                                                <dd>{{ $value }}, Qty: {{ $part_qty[$key] }}, Rp. {{ number_format($total_cost, 0, ",", ".") }}</dd>
                                            @endforeach
                                            <dt>Total Biaya Servis</dt>
                                            <dd>Rp. {{ number_format($item['cost_total'],0,",",".") }}</dd>  
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                @endif
            @else
                <div class="alert bg-info bg-gradient info-wrapper">
                    <p>Riwayat Servis tidak ditemukan. Mohon coba beberapa saat lagi.</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@section('additional_script')
<script>
    $(document).ready(function() {
        $('#editProfileBtn').click(function() {
            $('#editProfileForm').addClass('active');
            $('#dataProfile').addClass('hide');
            
        });

        $('#cancelEditBtn').click(function() {
            $('#editProfileForm').removeClass('active');
            $('#dataProfile').removeClass('hide');
            $('#errorMessages').removeClass('show').text('');
        });

        $('#profileForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form bawaan browser

            // Mengirim data form menggunakan AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                data: $(this).serialize(),
                success: function(response) {
                    // Menangani respons sukses dari server
                    $('#nameField').text(response.name);
                    $('#emailField span').text(response.email);
                    $('#phoneField span').text(response.phone_number);

                    // Menyembunyikan form Edit Profile setelah simpan berhasil
                    $('#editProfileForm').removeClass('active');
                    $('#dataProfile').removeClass('hide');
                    $('#errorMessages').removeClass('show').text('');
                },
                error: function(xhr, status, error) {
                    // Menangani respons error dari server
                    
                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    var errorMessage = '<ul>';
                    $.each(errors, function(key, value) {
                        switch (key) {
                            case 'name':
                                $.each(value, function(index, errorValue) {
                                    errorMessage += '<li>' + errorValue + '</li>';
                                });
                                break;
                            case 'email':
                                $.each(value, function(index, errorValue) {
                                    errorMessage += '<li>' + errorValue + '</li>';
                                });
                                break;
                            case 'phone_number':
                                $.each(value, function(index, errorValue) {
                                    errorMessage += '<li>' + errorValue + '</li>';
                                });
                                break;
                            default:
                                break;
                        }
                    });
                    errorMessage += '</ul>';
                    $('#errorMessages').html(errorMessage).addClass('show');
                    // Tambahkan logika lain untuk menampilkan pesan error sesuai kebutuhan Anda
                }
            });
        });
    });
</script>
@endsection
