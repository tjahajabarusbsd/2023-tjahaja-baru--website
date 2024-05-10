$(document).ready(function () {
    $('.btn-motor').click(function () {
        $('#overlay').show();
    });

    $('#editProfileBtn').click(function () {
        $('#editProfileForm').addClass('active');
        $('#dataProfile').addClass('hide');
    });

    $('#cancelEditBtn').click(function () {
        $('#editProfileForm').removeClass('active');
        $('#dataProfile').removeClass('hide');
        $('#errorMessages').removeClass('show').text('');
    });

    $('.btn-tambah').click(function () {
        $('#tambah-nomor-rangka').slideToggle('active');
    });

    $('#profileForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: $(this).serialize(),
            success: function (response) {
                $('#nameField').text(response.name);
                $('#emailField span').text(response.email);
                $('#phoneField span').text(response.phone_number);

                $('#editProfileForm').removeClass('active');
                $('#dataProfile').removeClass('hide');
                $('#errorMessages').removeClass('show').text('');
            },
            error: function (xhr, status, error) {
                var errors = xhr.responseJSON.errors;

                var errorMessage = '<ul>';
                $.each(errors, function (key, value) {
                    switch (key) {
                        case 'name':
                            $.each(value, function (index, errorValue) {
                                errorMessage += '<li>' + errorValue + '</li>';
                            });
                            break;
                        case 'email':
                            $.each(value, function (index, errorValue) {
                                errorMessage += '<li>' + errorValue + '</li>';
                            });
                            break;
                        case 'phone_number':
                            $.each(value, function (index, errorValue) {
                                errorMessage += '<li>' + errorValue + '</li>';
                            });
                            break;
                        default:
                            break;
                    }
                });
                errorMessage += '</ul>';
                $('#errorMessages').html(errorMessage).addClass('show');
            }
        });
    });

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
        $('#error_tipe').hide();
    })

    $('#unit_tahun').click(function () {
        $('#error_unit_tahun').hide();
    })

    $('#harga_motor').click(function () {
        $('#error_harga_motor').hide();
    })

    $('#hitung').click(function () {
        let hargaMotor = $('#harga_motor').val();
        let tipe = $('#tipe').val();
        let tahun = $('#unit_tahun').val();

        hargaMotor = hargaMotor.replace(/\./g, '');

        if (tipe === null) {
            $('#error_tipe').show();
            return;
        } else {
            $('#error_tipe').hide();
        }

        if (tahun === '') {
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
                $('#hasil').text('Maksimal Pinjaman Senilai ' + formatCurrency(response.maksimal_pinjaman)).show();
                $('#input_dana').show();
                $('#dana_dicairkan').attr('max', response.maksimal_pinjaman);
                $('#dana_dicairkan_label').text('Rp ' + response.maksimal_pinjaman);
                $('#dana_dicairkan').val('');
                $('#tenor').val('');
                $('#biaya-angsuran').text('Rp -');
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
                $('.break-line').show();
                $('#biaya-angsuran').text(formatCurrency(response.angsuran_per_bulan));
                $('#hasil_angsuran').show();
            }
        });
    });
});

const currentUrl = window.location.pathname;

$('.btn-motor').each(function () {
    if ($(this).attr('href') === currentUrl) {
        $(this).addClass('active').css('pointer-events', 'none');
    }
});