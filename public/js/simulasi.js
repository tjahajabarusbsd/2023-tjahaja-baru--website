$(document).ready(function () {
    function formatCurrency(amount) {
        return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
    }

    $('#dana_dicairkan').on('input', function () {
        let inputVal = $(this).val();

        let num = inputVal.replace(/\D/g, '');

        let formattedNum = new Intl.NumberFormat('id-ID').format(num);

        $('#dana_dicairkan_label').text('Rp ' + formattedNum);
    });

    $('#harga_motor').on('input', function () {

        let inputVal = $(this).val();

        let num = inputVal.replace(/\D/g, '');

        let formattedNum = new Intl.NumberFormat('id-ID').format(num);

        $(this).val(formattedNum);
    });

    $('#tipe').click(function () {
        $('#error-tipe').hide();
    })

    $('#tipe-lain').click(function () {
        $('#error-tipe-lain').hide();
    })

    $('#unit_tahun').click(function () {
        $('#error_unit_tahun').hide();
    })

    $('#harga_motor').click(function () {
        $('#error_harga_motor').hide();
    })

    $('#tipe').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'other') {
            $('#input-tipe-lain').show();
        } else {
            $('#input-tipe-lain').hide();
            $('#tipe-lain').val('');
        }
    });

    $('#hitung').click(function () {
        let tipe = $('#tipe').val();
        let tipeLain = $('#tipe-lain').val();
        let tahun = $('#unit_tahun').val();
        let hargaMotor = $('#harga_motor').val();
        hargaMotor = hargaMotor.replace(/\./g, '');

        if (tipe === null) {
            $('#error-tipe').show();
            return;
        } else {
            $('#error-tipe').hide();
        }

        if (tipeLain === '' && tipe === 'other') {
            $('#error-tipe-lain').show();
            return;
        } else {
            $('#error-tipe-lain').hide();
        }

        if (tahun === null) {
            $('#error_unit_tahun').show();
            return;
        } else {
            $('#error_unit_tahun').hide();
        }

        if (hargaMotor === '') {
            $('#error_harga_motor').show();
            return;
        } else {
            $('#error_harga_motor').hide();
        }

        $.ajax({
            url: "/hitung-pinjaman",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'harga_motor': hargaMotor
            },
            success: function (response) {
                $('#hasil').text(`Maksimal Pinjaman Senilai ${formatCurrency(response.maksimal_pinjaman)}`).show();
                $('#input_dana').show();
                $('#dana_dicairkan').attr('max', response.maksimal_pinjaman);
                $('#dana_dicairkan_label').text(formatCurrency(response.maksimal_pinjaman));
                $('#dana_dicairkan').val(response.maksimal_pinjaman);
            }
        });
    });

    $('#hitung_angsuran').click(function () {
        let danaDicairkan = $('#dana_dicairkan').val();
        let tenor = $('#tenor').val();
        danaDicairkan = danaDicairkan.replace(/\./g, '');

        $.ajax({
            url: "/hitung-angsuran",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'dana_dicairkan': danaDicairkan,
                'tenor': tenor
            },
            success: function (response) {
                $('#angsuran-monthly').val(response.angsuran_per_bulan);
                $('#biaya-angsuran').text(formatCurrency(response.angsuran_per_bulan));
                $('#hasil-angsuran').show();
            }
        });
    });
});