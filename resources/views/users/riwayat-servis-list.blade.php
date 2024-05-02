@if (!empty($data))
    @if(isDesktop())
        <div class="row" id="riwayat-servis-list">
            <div class="col-md-12">
                <div class="table-wrap">
                    <a href="/riwayatservis/cetak_pdf/{{ $getOneNomorRangka }}" class="btn btn-primary btn-cetak" target="_blank">CETAK PDF</a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Total Biaya</th>
                            <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="list-riwayat-desktop">
                        @php
                            $i = 1;
                        @endphp
                        @foreach($data as $item)
                            <tr data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="@php if($i == 1) echo 'true'; else echo 'false'; @endphp" aria-controls="collapse{{ $i }}" @php if($i == 1) echo 'class'; else echo 'class="collapsed"'; @endphp>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ date("d-m-Y", strtotime($item['event_walkin'])) }}</td>
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
                                        </dl>
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
        @php
            $i = 1;
        @endphp
        <div class="list-wrapper-mobile">
            <a href="/riwayatservis/cetak_pdf/{{ $getOneNomorRangka }}" class="btn btn-primary btn-cetak" target="_blank">CETAK PDF</a>
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
        <p>Saat ini belum ada riwayat servis.</p>
    </div>
@endif