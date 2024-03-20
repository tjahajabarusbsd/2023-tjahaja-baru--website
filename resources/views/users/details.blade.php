@extends('layouts.master')

@section('title', 'User Profile | Tjahaja Baru')

@section('meta_og')
  <meta property="og:title" content="User Profile | Tjahaja Baru">
  <meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta property="og:type" content="website">
@endsection

@section('main_class', 'user-profile')

@section('additional_css')

    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="top-content">
        {{-- <h1>Welcome!</h1> --}}
        <div class="content-avatar">
            <img src="{{ url('/images/dummy-image.png') }}" alt="">
        </div>
        <div class="content-title">
            <p>{{ $user->name ?? 'Belum ada nama' }}</p>
        </div>
        
        <div class="content-contact">
            <p>Email: {{ $user->email ?? '-' }}</p>
            <p>No. HP: {{ $user->phone_number ?? '-' }}</p>
        </div>
        
    </div>
    <div class="bottom-content">
        @if(isset($message))
            <p>{{ $message }}</p>
            <p>Silakan masukkan Nomor rangka Anda untuk melihat riwayat servis</p>
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

            <div class="riwayat-wrapper">
                <div class="sortir">
                    <p>Urutkan berdasarkan:</p>
                    <div class="button-sortir">
                        <a href="">Tanggal</a>
                        <a href="">Total</a>
                    </div>
                </div>
            </div>
        @else
            <h1>Riwayat Servis</h1>
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
                                <td>{{ date("Y-m-d H:i", strtotime($item['event_walkin'])) }}</td>
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
                                                <dd>{{ $item['kode'] }}</dd>
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
                                                    @foreach ( $part_qty as $qty )
                                                    <ul>
                                                        {{ $qty }}
                                                    </ul>
                                                        
                                                    @endforeach
                                                </div>
                                                <div class="col">
                                                    @php 
                                                        $part_cost = json_decode($item['part_cost']);
                                                    @endphp
                                                    @foreach ( $part_cost as $cost )
                                                    <ul>
                                                        Rp. {{ number_format($cost,0,",",".") }}
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
        @endif
    </div>
</div>
@endsection

@section('additional_script')
    
@endsection
