<h2 class="text-center mb-4 fw-bold">Riwayat Servis Motor Yamaha</h2>
@if(!$nomorRangka)
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
    <p class="text-center">Klik pada nomor kendaraan Anda untuk melihat riwayat servis</p>
    <div class="list-motor">
        @foreach ( $getAllNomorRangka as $item )
            <a class="btn-motor btn-purple" href="/myprofile/{{ $item->nomor_rangka }}"><span>{{ $item->nomor_rangka }}<span></a>
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
    
    @if (!empty($data))
        @if(isDesktop())
            <div class="row" id="riwayat-servis-list">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <a href="/riwayatservis/cetak_pdf/{{ $nomorRangka }}" class="btn btn-primary btn-cetak" target="_blank">CETAK PDF</a>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($data as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button @php if($i != 1) echo 'collapsed'; else echo ''; @endphp" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="@php if($i == 1) echo 'true'; else echo 'false'; @endphp" aria-controls="collapse{{ $i }}" @php if($i == 1) echo 'class'; else echo 'class="collapsed"'; @endphp>
                                    <div class="w-100 d-flex justify-content-evenly">
                                        <div class="fw-semibold">{{ $i }}</div>
                                        <div class="fw-semibold">{{ date("d-m-Y", strtotime($item['event_walkin'])) }}</div>
                                        <div class="fw-semibold">Rp. {{ number_format($item['cost_total'],0,",",".") }}</div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $i }}" class="accordion-collapse collapse @php if($i == 1) echo 'show';@endphp" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-evenly">
                                    <dl>
                                        <dt>Tempat Servis</dt>
                                        <dd>{{ $item['nama_dealer'] }}</dd>
                                        <dt>Kategori Servis</dt>
                                        <dd>{{ $item['svc_cat'] }}</dd>
                                    </dl>
                                    <dl>
                                        <dt>Mekanik</dt>
                                        <dd>{{ $item['mechanic_name'] }}</dd>
                                        <dt>Unit</dt>
                                        <dd>{{ $item['prod_nm'] }}</dd>
                                    </dl>
                                </div>
                                <div>
                                    <h5>Paket Servis</h5>
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $j=1 @endphp
                                            @php 
                                                $svc_pac = json_decode($item['svc_pac']);
                                                $svc_cost = json_decode($item['svc_cost']);
                                            @endphp
                                            @foreach($svc_pac as $index => $paket_servis)
                                            <tr>
                                                <td>{{ $j++ }}</td>
                                                <td>{{ $paket_servis }}</td>
                                                <td>Rp. {{ number_format($svc_cost[$index], 0, ",", ".") }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <h5>Part Terpakai</h5>
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jumlah</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $k=1 @endphp
                                            @php 
                                                $part_name = $item['part_name'];
                                                $part_qty = json_decode($item['part_qty']);
                                                $part_cost = json_decode($item['part_cost']);
                                            @endphp
                                            @foreach($part_name as $key => $value)
                                            @php
                                                $total_cost = $part_qty[$key] * $part_cost[$key];
                                            @endphp
                                            <tr>
                                                <td>{{ $k++ }}</td>
                                                <td>{{ $value }}</td>
                                                <td>{{ $part_qty[$key] }}</td>
                                                <td>Rp. {{ number_format($total_cost, 0, ",", ".") }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <dl>
                                        <dt>Total Biaya</dt>
                                        <dd>Rp. {{ number_format($item['cost_total'],0,",",".") }}</dd>
                                    </dl>
                                </div>
                            </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="pagination" class="pagination">
                <ul>
                    
                </ul>
            </div>
        @else
            @php
                $i = 1;
            @endphp
            <div class="list-wrapper-mobile">
                <a href="/riwayatservis/cetak_pdf/{{ $nomorRangka }}" class="btn btn-primary btn-cetak" target="_blank">CETAK PDF</a>
                @foreach($data as $item)
                    <button type="button" class="list-clickable" data-bs-toggle="modal" data-bs-target="#{{ $item['invoice'] }}">
                        <div class="list-text-wrapper">
                            <span># {{ $i }}</span>
                            <span>{{ date("d-m-Y", strtotime($item['event_walkin'])) }}</span>
                            <span>Rp. {{ number_format($item['cost_total'],0,",",".") }}</span>
                        </div>
                    </button>
                    <div class="modal fade" id="{{ $item['invoice'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                @php
                    $i++;
                @endphp
                @endforeach
            </div>
        @endif
    @else
        <div class="alert bg-info bg-gradient info-wrapper no-data">
            <p>{{ $message }}</p>
        </div>
    @endif
@endif