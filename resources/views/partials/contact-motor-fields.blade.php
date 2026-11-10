{{-- resources/views/partials/contact-motor-fields.blade.php --}}
{{-- Field form konsultasi motor di halaman contact (jalur cookie dan jalur #optionMotor). --}}
{{-- Variabel $lists otomatis tersedia dari view induk. --}}

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

@include('partials.consultation-purchase-fields')
