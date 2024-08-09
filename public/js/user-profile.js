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

    $('.btn-ajukan').click(function () {
        var tipe = $('#tipe').val();
        var unitTahun = $('#unit_tahun').val();
        var hargaMotor = $('#harga_motor').val();
        hargaMotor = hargaMotor.replace(/\./g, '');
        var danaDicairkan = $('#dana_dicairkan').val();
        var tenor = $('#tenor').val();
        var tipeLain = $('#tipe-lain').val();
        var angsuranMonthly = $('#angsuran-monthly').val();
        var urlValue = $('input[name="url"]').val().trim();

        grecaptcha.execute(siteKey, { action: 'ajukan_pinjaman' }).then(function (token) {
            var data = {
                tipe: tipe,
                unit_tahun: unitTahun,
                harga_motor: hargaMotor,
                dana_dicairkan: danaDicairkan,
                tenor: tenor,
                tipeLain: tipeLain,
                angsuranMonthly: angsuranMonthly,
                url: urlValue,
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