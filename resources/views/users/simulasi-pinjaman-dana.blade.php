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
            <span class="text-danger" id="error-tipe" style="display:none;">Tipe tidak boleh kosong.</span>
        </div>
    </div>
    
    <div id="input-tipe-lain" class="form-group row" style="display: none;">
        <label for="tipe-lain" class="col-md-4 col-form-label text-md-right">Masukkan tipe Yamaha lainnya:</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="tipe-lain" name=""tipe-lain">
            <span class="text-danger" id="error-tipe-lain" style="display:none;">Nama tipe tidak boleh kosong</span>
        </div>
    </div>

    <div class="form-group row">
        <label for="unit_tahun" class="col-md-4 col-form-label text-md-right">Pilih tahun:</label>
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
            
            <div id="hasil-angsuran" style="display: none;">
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