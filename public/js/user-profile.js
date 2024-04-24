$(document).ready(function () {
    $('#editProfileBtn').click(function () {
        $('#editProfileForm').addClass('active');
        $('#dataProfile').addClass('hide');
    });

    $('#cancelEditBtn').click(function () {
        $('#editProfileForm').removeClass('active');
        $('#dataProfile').removeClass('hide');
        $('#errorMessages').removeClass('show').text('');
    });

    $('#profileForm').on('submit', function (e) {
        e.preventDefault(); // Mencegah pengiriman form bawaan browser

        // Mengirim data form menggunakan AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: $(this).serialize(),
            success: function (response) {
                // Menangani respons sukses dari server
                $('#nameField').text(response.name);
                $('#emailField span').text(response.email);
                $('#phoneField span').text(response.phone_number);

                // Menyembunyikan form Edit Profile setelah simpan berhasil
                $('#editProfileForm').removeClass('active');
                $('#dataProfile').removeClass('hide');
                $('#errorMessages').removeClass('show').text('');
            },
            error: function (xhr, status, error) {
                // Menangani respons error dari server

                var errors = xhr.responseJSON.errors;
                console.log(errors);
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
                // Tambahkan logika lain untuk menampilkan pesan error sesuai kebutuhan Anda
            }
        });
    });
});