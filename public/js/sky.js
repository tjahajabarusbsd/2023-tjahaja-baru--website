$(document).ready(function () {
    $('#form-sky').on('submit', function (e) {
        e.preventDefault(); // Menghentikan submit form default

        let name = $('#sky-name').val();

        if (name === null) {
            $('#error-sky-name').show();
            return;
        } else {
            $('#error-sky-name').hide();
        }

        // Melakukan AJAX request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                // Logika jika request berhasil
                console.log(response);
                // Misalnya, tampilkan pesan sukses atau arahkan ke halaman lain
            },
            error: function (xhr, status, error) {
                // Logika jika terjadi kesalahan
                console.error(xhr.responseText);
                // Misalnya, tampilkan pesan error kepada pengguna
            }
        });
    });
});
