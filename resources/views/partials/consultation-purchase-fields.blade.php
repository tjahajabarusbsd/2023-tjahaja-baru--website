{{-- resources/views/partials/consultation-purchase-fields.blade.php --}}
{{-- Bagian form konsultasi motor setelah pilihan produk: rencana beli, pembayaran, DP, tenor, persetujuan, submit. --}}
{{-- Dipakai bersama oleh halaman contact dan halaman detail produk supaya keduanya selalu sama. --}}

<div class="form-group row">
    <label class="col-md-4">Rencana Beli</label>
    <div class="col-md-8">
        <div id="rencana-beli-group">
            @foreach (\App\Models\Consultation::RENCANA_BELI as $value => $label)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rencana_beli" id="rencana-{{ $value }}"
                        value="{{ $value }}">
                    <label class="form-check-label" for="rencana-{{ $value }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-md-4">Metode Pembayaran</label>
    <div class="col-md-8">
        <div id="payment-method-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_method" id="payment-cash" value="cash">
                <label class="form-check-label" for="payment-cash">Cash</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_method" id="payment-kredit" value="kredit">
                <label class="form-check-label" for="payment-kredit">Kredit</label>
            </div>
        </div>
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
        <span>Saya setuju bahwa informasi diatas mengizinkan TJAHAJA BARU untuk
            menghubungi Saya melalui telepon/WhatsApp.</span>
    </label>
</div>

<div class="form-group">
    <button id="submit-motor" type="submit" class="btn btn-primary">Submit</button>
</div>
