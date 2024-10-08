<div class="container-simulasi">
    <h2 class="text-center mb-4 fw-bold">Kalkulator Simulasi Pinjaman</h2>

    <input name="url" type="text" hidden value="{{ Request::url() }}">
    
    <div class="form-group row">
        <label for="tipe" class="col-md-4 col-form-label text-md-right">Pilih tipe:</label>
        <div class="col-md-6">
            <select class="form-select" name="tipe" id="tipe">
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
            <span class="text-danger" id="error-tipe" style="display:none;">Tipe tidak boleh kosong.</span>
        </div>
    </div>
    
    <div id="input-tipe-lain" class="form-group row" style="display: none;">
        <label for="tipe-lain" class="col-md-4 col-form-label text-md-right">Masukkan tipe Yamaha lainnya:</label>
        <div class="col-md-6">
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
        <div class="col-md-6">
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

    <div id="hasil" style="display: none;"></div>                

    <div class="row">
        <div class="col-md-12" id="input_dana" style="display: none;">
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Dana yang Ingin Dicairkan (juta):</label>
                <div class="col-md-6">
                    <label for="dana_dicairkan" id="dana_dicairkan_label" class="col-form-label text-md-right">dana</label>
                    <input type="range" id="dana_dicairkan" name="dana_dicairkan" class="" min="3000000" step="1000000" max="7000000" style="width: 100%;">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="tenor" class="col-md-4 col-form-label text-md-right">Tenor:</label>
                <div class="col-md-6">
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
                        <div style="font-size: 25px; font-weight: 700">Estimasi Angsuran</div>
                        <div style="font-size:10px;">*sudah termasuk bunga dan biaya admin</div>
                        <div style="margin: 5px 0; font-size: 25px; font-weight: 700">
                            <input type="hidden" name="angsuran_monthly" id="angsuran-monthly" value="">
                            <span id="biaya-angsuran">Rp -</span>
                            <span>/bulan*</span>
                        </div>
                        <div style="font-size: 12px">*) Estimasi nilai pinjaman bukan merupakan persetujuan pinjaman dana, bersifat tidak mengikat, dan dapat disesuaikan berdasarkan penilaian lebih lanjut serta kebijakan BPR Tjahaja Baru.</div>
                    </div>
                    <div class="form-group">
                        {!! RecaptchaV3::field('ajukan_pinjaman') !!}
                        @error('g-recaptcha-response')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-ajukan">Ajukan Pinjaman</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>