$(document).ready(function () {
    $("#myModal").iziModal({
        width: 400,
    });

    $('#form-sky').on('submit', function (e) {
        e.preventDefault();

        let sky_name = $('#sky-name').val();
        let sky_alamat = $('#sky-alamat').val();
        let sky_phone_number = $('#sky-phone-number').val();
        let sky_tipe = $('#sky-tipe').val();
        let sky_kendala = $('#sky-kendala').val();

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('#response').html('');

        grecaptcha.execute(siteKey, { action: 'send_sky' }).then(function (token) {
            var data = {
                sky_name: sky_name,
                sky_alamat: sky_alamat,
                sky_phone_number: sky_phone_number,
                sky_tipe: sky_tipe,
                sky_kendala: sky_kendala,
                'g-recaptcha-response': token
            }

            $.ajax({
                url: "/service-kunjung-yamaha",
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#overlay').hide();
                    $('#myModal .material-icons').text('check');
                    $('#myModal .modal-title').text('Sukses!');
                    $('#myModal .modal-body p').text(response.successMessage);
                    $("#myModal").iziModal('open');
                    $('#form-sky')[0].reset();
                },
                error: function (response) {
                    $('#overlay').hide();
                    let errors = response.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#response').html(errorHtml);
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body p').text(response.responseJSON.errorMessage);
                        $("#myModal").iziModal('open');
                        setTimeout(location.reload(), 2000);
                    }
                }
            });
        });
    });
});