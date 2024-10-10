@extends('layouts.master')

@section('title', 'Contact Us | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Tjahaja Baru | Contact Us">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'contact')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/main-form.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
@endsection

@section('content')
<section class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2754950747762!2d100.35193247418114!3d-0.9451397353467688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b935ce843e1d%3A0x210ffc7693c22340!2sYamaha%20Tjahaja%20Baru!5e0!3m2!1sen!2sid!4v1685333788371!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="mx-auto">
                <div class="main-form contact-form">
                    <div class="form-container">
                        <h1>Contact Us</h1>
                        @if ( request()->hasCookie('sales') || request()->hasCookie('utm_campaign'))
                        <div class="form-group now">
                            <label>Berminat dengan motor Yamaha? Segera konsultasikan langsung dengan dealer kami.</label>
                        </div>
                        @endif
                        <input name="url" type="text" hidden value="{{ Request::fullUrl() }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4">Nama</label>
                            <div class="col-md-8">
                                <input name="name" class="form-control" id="name" type="text" value="{{ old('name') }}"  placeholder="Nama Lengkap" maxlength="50" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="nohp" class="col-md-4">No Handphone</label>
                            <div class="col-md-8">
                                <input name="nohp" id="nohp" class="form-control" type="tel" value="{{ old('nohp') }}"  placeholder="08123456789" maxlength="15" required>
                            </div>
                        </div>
                        
                        @if ( request()->hasCookie('sales') || request()->hasCookie('utm_campaign'))
                            <div class="form-group">
                                <div class="form-group row">
                                    <label class="col-md-4">Motor yang diminati</label>
                                    <div class="col-md-8">
                                        <select name="produk" id="pilih-produk" class="form-select" aria-label="Default select example">
                                            <option selected disabled value=""> - pilih motor - </option>
                                            @foreach ($lists as $list)
                                                <option value="{{ $list->name }}">{{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4">Metode Pembayaran</label>
                                    <div class="col-md-8">
                                        <select id="payment-method" name="payment_method" class="form-select">
                                            <option selected disabled value=""> - pilih cara bayar - </option>
                                            <option value="cash">Cash</option>
                                            <option value="kredit">Kredit</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="option-bayar" class="form-group row" style="display: none;">
                                    <label for="down-payment" class="col-md-4">Down Payment</label>
                                    <div class="col-md-8">
                                        <select id="down-payment" name="down_payment" class="form-select">
                                            <option selected disabled value=""> - pilih down payment - </option>
                                            <option value="dp-0">Rp 1 Juta - Rp 5 juta</option>
                                            <option value="dp-1">Rp 5 juta - Rp 10 juta</option>
                                            <option value="dp-2">Rp 10 juta - Rp 15 juta</option>
                                            <option value="dp-3">Diatas Rp 15 juta</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="option-tenor-pembelian" class="form-group row" style="display: none;">
                                    <label for="tenor-pembelian" class="col-md-4">Jumlah Tenor</label>
                                    <div class="col-md-8">
                                        <select id="tenor-pembelian" name="tenor_pembelian" class="form-select">
                                            <option selected disabled value=""> - pilih jumlah tenor - </option>
                                            <option value="11">11 bulan</option>
                                            <option value="17">17 bulan</option>
                                            <option value="23">23 bulan</option>
                                            <option value="29">29 bulan</option>
                                            <option value="35">35 bulan</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="margin-top: 20px;">
                                    <label id="label-checkbox" class="d-flex align-items-start">
                                        <input type="checkbox" name="terms" id="termsCheckbox" style="margin-top: 5px; margin-right: 10px;">
                                        <span>Saya setuju bahwa informasi diatas mengizinkan TJAHAJA BARU untuk menghubungi Saya melalui telepon/WhatsApp.</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button id="submit-motor" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        @else
                            <div class="form-group ">
                                <label>Pilih Topik</label>
                                <div class="choose-option">
                                    <label class="card">
                                        <input type="radio" name="option" class="radio" value="pesan" required> 
                                        <span class="card-body">
                                            <span class="topik-type">Tulis Pesan</span>
                                        </span>
                                    </label>
                                    <label class="card">
                                        <input type="radio" name="option" class="radio" value="motor" required>
                                        <span class="card-body">
                                            <span class="topik-type">Konsultasi Motor</span>
                                        </span>
                                    </label>
                                    <label class="card">
                                        <input type="radio" name="option" class="radio" value="dana" required>
                                        <span class="card-body">
                                            <span class="topik-type">Pinjaman Dana Tunai</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div id="optionPesan" style="display: none;" class="form-group">
                                <div class="form-group">
                                    <label for="message">Tulis Pesan</label>
                                    <textarea id="tulis-pesan" name="message" class="form-control" placeholder="Tulis pesan Anda disini">{{ old('message') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <button id="submit-pesan" class="btn btn-primary" onclick="disableButton()">Submit</button>
                                </div>
                            </div>

                            <div id="optionMotor" style="display: none;" class="form-group">
                                @if (!empty($value))
                                    <input name="sales" type="text" hidden value="{{ $value }}">
                                @endif
                                <div class="form-group now">
                                    <label>Berminat dengan motor Yamaha? Segera konsultasikan langsung dengan dealer kami.</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Motor yang diminati</label>
                                    <div class="col-md-8">
                                        <select name="produk" id="pilih-produk" class="form-select" aria-label="Default select example">
                                            <option selected disabled value=""> - pilih motor - </option>
                                            @foreach ($lists as $list)
                                                <option value="{{ $list->name }}">{{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4">Metode Pembayaran</label>
                                    <div class="col-md-8">
                                        <select id="payment-method" name="payment_method" class="form-select">
                                            <option selected disabled value=""> - pilih cara bayar - </option>
                                            <option value="cash">Cash</option>
                                            <option value="kredit">Kredit</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="option-bayar" class="form-group row" style="display: none;">
                                    <label for="down-payment" class="col-md-4">Down Payment</label>
                                    <div class="col-md-8">
                                        <select id="down-payment" name="down_payment" class="form-select">
                                            <option selected disabled value=""> - pilih down payment - </option>
                                            <option value="dp-0">Rp 1 Juta - Rp 5 juta</option>
                                            <option value="dp-1">Rp 5 juta - Rp 10 juta</option>
                                            <option value="dp-2">Rp 10 juta - Rp 15 juta</option>
                                            <option value="dp-3">Diatas Rp 15 juta</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="option-tenor-pembelian" class="form-group row" style="display: none;">
                                    <label for="tenor-pembelian" class="col-md-4">Jumlah Tenor</label>
                                    <div class="col-md-8">
                                        <select id="tenor-pembelian" name="tenor_pembelian" class="form-select">
                                            <option selected disabled value=""> - pilih jumlah tenor - </option>
                                            <option value="11">11 bulan</option>
                                            <option value="17">17 bulan</option>
                                            <option value="23">23 bulan</option>
                                            <option value="29">29 bulan</option>
                                            <option value="35">35 bulan</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="margin-top: 20px;">
                                    <label id="label-checkbox" class="d-flex align-items-start">
                                        <input type="checkbox" name="terms" id="termsCheckbox" style="margin-top: 5px; margin-right: 10px;">
                                        <span>Saya setuju bahwa informasi diatas mengizinkan TJAHAJA BARU untuk menghubungi Saya melalui telepon/WhatsApp.</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button id="submit-motor" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                            <div id="optionDana" style="display: none;" class="form-group">
                                <div class="form-group row">
                                    <label for="tipe" class="col-md-4 col-form-label text-md-right">Pilih tipe:</label>
                                    <div class="col-md-8">
                                        <select class="form-select" name="tipe" id="tipe">
                                            <option selected disabled value=""> -- Pilih -- </option>
                                            @foreach ($lists as $list)
                                                <option value="{{ $list->name }}">{{ $list->name }}</option>
                                            @endforeach
                                            <option value="other"> -- Lainnya -- </option>
                                        </select>
                                        <span class="text-danger" id="error-tipe" style="display:none;">Tipe tidak boleh kosong.</span>
                                    </div>
                                </div>

                                <div id="input-tipe-lain" class="form-group row" style="display: none;">
                                    <label for="tipe-lain" class="col-md-4 col-form-label text-md-right">Masukkan tipe Yamaha lainnya:</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="tipe-lain" name="tipe-lain">
                                        <span class="text-danger" id="error-tipe-lain" style="display:none;">Nama tipe tidak boleh kosong</span>
                                    </div>
                                </div>

                                @php
                                    $currentYear = date('Y'); 
                                    $startYear = 2000;
                                @endphp
                            
                                <div class="form-group row">
                                    <label for="unit_tahun" class="col-md-4 col-form-label text-md-right">Pilih tahun:</label>
                                    <div class="col-md-8">
                                        <select name="unit_tahun" id="unit_tahun" class="form-select">
                                            <option selected disabled value=""> -- Pilih -- </option>
                                            <?php for ($year = $startYear; $year <= $currentYear; $year++): ?>
                                                <option value="<?= $year ?>"><?= $year ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <span class="text-danger" id="error_unit_tahun" style="display:none;">Tahun tidak boleh kosong.</span>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="harga_motor" class="col-md-4 col-form-label text-md-right">Estimasi Harga Motor:</label>
                                    <div class="col-md-8">
                                        <input type="text" id="harga_motor" name="harga_motor" class="form-control">
                                        <span class="text-danger" id="error_harga_motor" style="display:none;">Harga motor tidak boleh kosong.</span>
                                    </div>
                                </div>
                            
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button id="hitung" class="btn btn-primary">Hitung</button>
                                    </div>
                                </div>
                            
                                <div id="hasil" style="display: none;"></div>                
                            
                                <div class="row">
                                    <div class="col-md-12" id="input_dana" style="display: none;">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label text-md-right">Dana yang Ingin Dicairkan (juta):</label>
                                            <div class="col-md-8">
                                                <label for="dana_dicairkan" id="dana_dicairkan_label" class="col-form-label text-md-right">dana</label>
                                                <input type="range" id="dana_dicairkan" name="dana_dicairkan" class="" min="3000000" step="1000000" max="7000000" style="width: 100%;">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="tenor" class="col-md-4 col-form-label text-md-right">Tenor:</label>
                                            <div class="col-md-8">
                                                <select id="tenor" name="tenor" class="form-select">
                                                    <option selected value="11">11 bulan</option>
                                                    <option value="24">24 bulan</option>
                                                    <option value="35">35 bulan</option>
                                                </select>
                                            </div>
                                        </div>
                            
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button id="hitung_angsuran" class="btn btn-primary">Hitung Angsuran</button>
                                            </div>
                                        </div>
                                        
                                        <div id="hasil-angsuran" style="display: none;">
                                            <div class="break-line mt-5" style="
                                                border-style: inset;
                                                border-width: 1px;
                                                border-color: #dadada;
                                            "></div>
                                            <div class="section-angsuran-result">
                                                <div class="mt-3 col-md-8">
                                                    <div style="font-size: 25px; font-weight: 700">Estimasi Angsuran:</div>
                                                    <div style="font-size:10px;">*sudah termasuk bunga dan biaya admin</div>
                                                    <div style="margin: 5px 0; font-size: 25px; font-weight: 700">
                                                        <input type="hidden" name="angsuran_monthly" id="angsuran-monthly" value="">
                                                        <span id="biaya-angsuran">Rp -</span>
                                                        <span>/bulan*</span>
                                                    </div>
                                                    <div style="font-size: 12px">*) Estimasi nilai pinjaman bukan merupakan persetujuan pinjaman dana, bersifat tidak mengikat, dan dapat disesuaikan berdasarkan penilaian lebih lanjut serta kebijakan BPR Tjahaja Baru.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button id="submit-dana" type="submit" class="btn btn-primary btn-ajukan">Ajukan Pinjaman</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            {!! RecaptchaV3::field('contact') !!}
                            @error('g-recaptcha-response')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="error-msg-wrapper" style="display: none">
                            <div class="validation-error">
                                <div class="side-bg-error" ></div>
                                <img src="{{ url('/images/error.png') }}" alt="error">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="overlay" id="overlay">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">close</i>
				</div>
                <h4 class="modal-title w-100">Success!</h4>	
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
@endsection

@section('additional_script')
    <script src="{{ asset('js/contact.js') }}"></script>
    <script src="{{ asset('js/simulasi.js') }}"></script>
    <script>const siteKey = '{{ config('app.recaptcha_sitekey') }}';</script>
    <script>
        function disableButton() {
            $(".btn-primary").prop('disabled', true);
        }

        $(document).ready(function() {
            $('input[name="option"]').change(function() {
                var selectedOption = $(this).val();

                $('#optionPesan, #optionMotor, #optionDana').hide();

                if (selectedOption === 'pesan') {
                    $('#optionPesan').show();
                } else if (selectedOption === 'motor') {
                    $('#optionMotor').show();
                } else if (selectedOption === 'dana') {
                    $('#optionDana').show();
                }
            });

            $('#payment-method').change(function() {
                var selectedValue = $(this).val();
                
                if (selectedValue === 'kredit') {
                    $('#option-bayar').show();
                    $('#option-tenor-pembelian').show();
                } else if (selectedValue === 'cash') {
                    $('#option-bayar').hide();
                    $('#option-tenor-pembelian').hide();
                    $('#down-payment').val('');
                    $('#tenor-pembelian').val('');
                } else {
                    $('#option-bayar').hide();
                    $('#option-tenor-pembelian').hide();
                }
            });
        });
    </script>
@endsection