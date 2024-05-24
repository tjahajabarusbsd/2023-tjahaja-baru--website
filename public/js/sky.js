$(document).ready(function () {
    $('#form-sky').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "/service-kunjung-yamaha",
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#response').html('<p>' + response.message + '</p>');
            },
            error: function (response) {
                let errors = response.responseJSON.errors;
                let errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#response').html(errorHtml);
            }
        });
    });
});