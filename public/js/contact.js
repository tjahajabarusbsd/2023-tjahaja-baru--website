$(document).ready(function () {
    function handleInput() {
        var nameValue = $("#name").val().trim();
        var phoneNumberValue = $("#nohp").val().trim();

        if (nameValue === "") {
            setErrorFor($("#name"), "Nama wajib diisi.");
            enableButton();
        } else if (!/^[A-Za-z\s]+$/.test(nameValue)) {
            setErrorFor($("#name"), "Hanya diperbolehkan input huruf.");
            enableButton();
        } else {
            setSuccessFor($("#name"));
        }

        if (phoneNumberValue === "") {
            setErrorFor($("#nohp"), "No HP wajib diisi.");
            enableButton();
        } else if (!/^\d+$/.test(phoneNumberValue)) {
            setErrorFor($("#nohp"), "Hanya diperbolehkan input angka.");
            enableButton();
        } else {
            setSuccessFor($("#nohp"));
        }
    }

    $("#submit-pesan").click(function (e) {
        e.preventDefault();
        clearErrors();
        handleInput();

        var nameValue = $("#name").val().trim();
        var phoneNumberValue = $("#nohp").val().trim();
        var messageValue = $('textarea[name="message"]').val();
        var optionPesan = $('input[name="option"]:checked').val();

        if (!$('input[name="option"]:checked').length) {
            alert('Silakan pilih salah satu opsi.');
            return;
        }

        if (optionPesan === 'pesan' && !$.trim(messageValue)) {
            setErrorFor($("#tulis-pesan"), "Silakan isi pesan sebelum mengirim formulir.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#tulis-pesan"));
        }

        if (hasErrors()) {
            return;
        }

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('.error-msg-wrapper').hide();

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: nameValue,
                nohp: phoneNumberValue,
                option: optionPesan,
                message: messageValue,
                'g-recaptcha-response': token
            }

            $.ajax({
                url: "/submit-pesan-form",
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

                    $('form')[0].reset();
                    $('input[name="option"]').prop('checked', false);
                    $('#optionPesan').hide();
                    enableButton();
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body p').text(response.responseJSON.errorMessage);
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        let errorHtml = '';
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });
                        $('.error-msg-wrapper').find('ul').html(errorHtml);
                        $('.error-msg-wrapper').show();
                        enableButton();
                    }
                }
            });

            return false;
        });
    });

    $("#submit-motor").click(function (e) {
        e.preventDefault();
        clearErrors();
        handleInput();

        var nameValue = $("#name").val().trim();
        var phoneNumberValue = $("#nohp").val().trim();
        var produkValue = $("select[name='produk']").val();
        var termsChecked = $('#termsCheckbox').is(':checked');
        var urlValue = $('input[name="url"]').val().trim();

        if (!produkValue) {
            setErrorFor($("#pilih-produk"), "Silakan pilih produk yang diminati.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#pilih-produk"));
        }

        if (!termsChecked) {
            setErrorFor($("#label-checkbox"), "Kolom wajib dicentang.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#label-checkbox"));
        }

        if (hasErrors()) {
            return;
        }

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('.error-msg-wrapper').hide();

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: nameValue,
                nohp: phoneNumberValue,
                produk: produkValue,
                terms: termsChecked,
                url: urlValue,
                'g-recaptcha-response': token
            }

            $.ajax({
                url: "/submit-consultation-form",
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
                    setTimeout(function () {
                        var url = new URL(window.location.href);
                        url.search = ""; // Hapus semua query string
                        window.history.replaceState({}, document.title, url.toString());
                        // Reload halaman
                        location.reload();
                    }, 2000);
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body p').text(response.responseJSON.errorMessage);
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        let errorHtml = '';
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });
                        $('.error-msg-wrapper').find('ul').html(errorHtml);
                        $('.error-msg-wrapper').show();
                        enableButton();
                    }
                }
            });

            return false;
        });
    });

    $('#submit-dana').click(function (e) {
        e.preventDefault();
        clearErrors();
        handleInput();

        var nameValue = $("#name").val().trim();
        var phoneNumberValue = $("#nohp").val().trim();
        var tipe = $('#tipe').val();
        var tipeLain = $('#tipe-lain').val();
        var unitTahun = $('#unit_tahun').val();
        var hargaMotor = $('#harga_motor').val();
        hargaMotor = hargaMotor.replace(/\./g, '');
        var danaDicairkan = $('#dana_dicairkan').val();
        var tenor = $('#tenor').val();
        var angsuranMonthly = $('#angsuran-monthly').val();
        var urlValue = $('input[name="url"]').val().trim();

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('.error-msg-wrapper').hide();

        if (hasErrors()) {
            return;
        }

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: nameValue,
                nohp: phoneNumberValue,
                tipe: tipe,
                tipeLain: tipeLain,
                unit_tahun: unitTahun,
                harga_motor: hargaMotor,
                dana_dicairkan: danaDicairkan,
                tenor: tenor,
                angsuranMonthly: angsuranMonthly,
                url: urlValue,
                'g-recaptcha-response': token
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
                    $('#myModal .material-icons').text('check');
                    $('#myModal .modal-title').text('Sukses!');
                    $('#myModal .modal-body p').text(response.successMessage);
                    $("#myModal").iziModal('open');

                    $('form')[0].reset();
                    $('input[name="option"]').prop('checked', false);
                    $('#optionDana').hide();
                    enableButton();
                    alert('Sukses!');
                    location.reload();
                    // setTimeout(function () {
                    //     var url = new URL(window.location.href);
                    //     url.search = "";
                    //     window.history.replaceState({}, document.title, url.toString());
                    //     location.reload();
                    // }, 2000);
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body p').text(response.responseJSON.errorMessage);
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        let errorHtml = '';
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });
                        $('.error-msg-wrapper').find('ul').html(errorHtml);
                        $('.error-msg-wrapper').show();
                        enableButton();
                    }
                }
            });
        });
    });

    $("#myModal").iziModal({
        width: 400,
    });

    function enableButton() {
        $(".btn-primary").removeAttr("disabled");
    }

    function setErrorFor(input, message) {
        let $formControl = $(input).parent();
        $formControl.addClass("error").removeClass("success");

        let $errorElement = $formControl.find("small");
        if ($errorElement.length === 0) {
            $errorElement = $("<small></small>").appendTo($formControl);
        }

        $errorElement.text(message);
    }

    function setSuccessFor(input) {
        let $formControl = $(input).parent();
        if ($formControl) {
            $formControl.removeClass("error");
        }
    }

    function clearErrors() {
        $(".form-group").removeClass("error");
        $("small").remove();
    }

    function hasErrors() {
        return false;
    }
});