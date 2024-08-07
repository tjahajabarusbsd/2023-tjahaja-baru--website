$(document).ready(function () {
    $('.btn-motor').click(function () {
        $('#overlay').show();
    });

    $('#edit-profile-btn').click(function () {
        $('#edit-profile').addClass('active');
        $('#data-profile').addClass('hide');
    });

    $('#cancel-edit-btn').click(function () {
        $('#edit-profile').removeClass('active');
        $('#data-profile').removeClass('hide');
        $('#error-messages').removeClass('show').text('');
    });

    $('.btn-tambah').click(function () {
        $('#tambah-nomor-rangka').slideToggle('active');
    });

    $('#profile-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: $(this).serialize(),
            success: function (response) {
                $('#name-field').text(response.name);
                $('#email-field span').text(response.email);
                $('#phone-field span').text(response.phone_number);

                $('#edit-profile').removeClass('active');
                $('#data-profile').removeClass('hide');
                $('#error-messages').removeClass('show').text('');
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
                $('#error-messages').html(errorMessage).addClass('show');
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
                $('#hasil').text(`Maksimal Pinjaman Senilai ${formatCurrency(response.maksimal_pinjaman)}`).show();
                $('#hasil').val(response.maksimal_pinjaman);
                $('#input_dana').show();
                $('#dana_dicairkan').attr('max', response.maksimal_pinjaman);
                $('#dana_dicairkan_label').text(formatCurrency(response.maksimal_pinjaman));
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
                $('#angsuran-monthly').val(formatCurrency(response.angsuran_per_bulan));
                $('#biaya-angsuran').text(formatCurrency(response.angsuran_per_bulan));
                $('#hasil-angsuran').show();
            }
        });
    });

    $('.btn-ajukan').click(function () {
        var tipe = $('#tipe').val();
        var unitTahun = $('#unit_tahun').val();
        var hargaMotor = $('#harga_motor').val();
        var danaDicairkan = $('#dana_dicairkan').val();
        var tenor = $('#tenor').val();
        var tipeLain = $('#tipe-lain').val();
        var angsuranMonthly = $('#angsuran-monthly').val();

        grecaptcha.execute(siteKey, { action: 'ajukan_pinjaman' }).then(function (token) {
            var data = {
                tipe: tipe,
                unit_tahun: unitTahun,
                harga_motor: 'Rp ' + hargaMotor,
                dana_dicairkan: formatCurrency(danaDicairkan),
                tenor: tenor,
                tipeLain: tipeLain,
                angsuranMonthly: angsuranMonthly,
                'g-recaptcha-response': token // Add reCAPTCHA token to data
            };

            $('#overlay').show();

            $.ajax({
                url: "/ajukan-angsuran",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (response) {
                    $('#overlay').hide();
                    alert(response.successMessage);

                    // Merefresh halaman
                    location.reload();
                },
                error: function (xhr, status, error) {
                    $('#overlay').hide();
                    alert(xhr.responseJSON.errorMessage);
                }
            });
        });
    });

    $('.menu-item').on('click', function () {
        var target = $(this).data('bs-target');
        var hash = $(this).attr('aria-controls');

        window.location.hash = hash;

        $('.menu-item').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
    });

    var hash = window.location.hash;
    if (hash) {
        hash = hash.substring(1);

        $('.menu-item').removeClass('active');
        $('[aria-controls="' + hash + '"]').addClass('active');
        $('.tab-pane').removeClass('show active');
        $('#' + hash).addClass('show active');
    }

    var rowsPerPage = 5;
    var totalRows = $('.accordion-item').length;
    var totalPages = Math.ceil(totalRows / rowsPerPage);
    var currentPage = 1;

    // hide all rows initially
    $('.accordion-item').hide();

    // show first page of rows
    showPage(1);

    // create pagination links
    for (var i = 1; i <= totalPages; i++) {
        $('#pagination ul').append('<li><a href="#" class="page-link" data-page="' + i + '">' + i + '</a></li>');
    }

    // add active class to first page link
    $('#pagination a:first').addClass('active');

    // pagination click event
    $('#pagination a').click(function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        showPage(page);
        // remove active class from all links
        $('#pagination a').removeClass('active');
        // add active class to current link
        $(this).addClass('active');
    });

    function showPage(page) {
        // hide all rows
        $('.accordion-item').hide();

        // show rows for current page
        var startRow = (page - 1) * rowsPerPage;
        var endRow = startRow + rowsPerPage;
        $('.accordion-item').slice(startRow, endRow).show();
    }
});

const currentUrl = window.location.pathname;

$('.btn-motor').each(function () {
    if ($(this).attr('href') === currentUrl) {
        $(this).addClass('active').css('pointer-events', 'none');
    }
});