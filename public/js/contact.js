$(document).ready(function () {
    $('#myModal').iziModal({
        width: 325,
        onClosed: function () {
            if (window.shouldReload) {
                location.reload();
            }
        }
    });

    var name;
    var phoneNumber;

    function handleInput() {
        name = $("#name").val().trim();
        phoneNumber = $("#nohp").val().trim();

        if (!name) {
            setErrorFor($("#name"), "Nama belum diisi");
            enableButton();
            return;
        } else if (!/^[A-Za-z\s]+$/.test(name)) {
            setErrorFor($("#name"), "Gunakan huruf");
            enableButton();
            return;
        } else {
            setSuccessFor($("#name"));
        }

        if (!phoneNumber) {
            setErrorFor($("#nohp"), "No. Handphone belum diisi");
            enableButton();
            return;
        } else if (!/^\d+$/.test(phoneNumber)) {
            setErrorFor($("#nohp"), "Gunakan angka");
            enableButton();
            return;
        } else {
            setSuccessFor($("#nohp"));
        }
    }

    $("#submit-pesan").click(function (e) {
        e.preventDefault();
        clearErrors();
        handleInput();

        var message = $('#tulis-pesan').val();

        if (!message) {
            setErrorFor($("#tulis-pesan"), "Tulis pesan Anda.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#tulis-pesan"));
        }

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('#myModal .modal-body').html('');

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: name,
                nohp: phoneNumber,
                message: message,
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
                    $('#myModal .modal-body').append('<p>' + response.successMessage + '</p>');
                    window.shouldReload = true;
                    $("#myModal").iziModal('open');
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body').append('<p>' + response.responseJSON.errorMessage + '</p>');
                        window.shouldReload = true;
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                $('#myModal .modal-body').append('<li>' + message + '</li>');
                            });
                        });
                        window.shouldReload = false;
                        $("#myModal").iziModal('open');
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

        var produkValue = $("#pilih-produk").val();
        var termsChecked = $('#termsCheckbox').is(':checked');
        var urlValue = $('input[name="url"]').val().trim();
        var payment_method = $("#payment-method").val();
        var down_payment = $("#down-payment").val();
        var tenor_pembelian = $("#tenor-pembelian").val();

        if (!produkValue) {
            setErrorFor($("#pilih-produk"), "Silakan pilih produk yang diminati.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#pilih-produk"));
        }

        if (!payment_method) {
            setErrorFor($("#payment-method"), "Silakan pilih cara bayar.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#payment-method"));
        }

        if (payment_method === 'kredit') {
            if (!down_payment) {
                setErrorFor($("#down-payment"), "Silakan pilih down payment.");
                enableButton();
                return;
            } else {
                setSuccessFor($("#down-payment"));
            }

            if (!tenor_pembelian) {
                setErrorFor($("#tenor-pembelian"), "Silakan pilih jumlah tenor.");
                enableButton();
                return;
            } else {
                setSuccessFor($("#tenor-pembelian"));
            }
        }

        if (!termsChecked) {
            setErrorFor($("#label-checkbox"), "Kolom wajib dicentang.");
            enableButton();
            return;
        } else {
            setSuccessFor($("#label-checkbox"));
        }

        $('#myModal .icon-box').removeClass('error');
        $('#overlay').show();
        $('#myModal .modal-body').html('');

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: name,
                nohp: phoneNumber,
                produk: produkValue,
                terms: termsChecked,
                cara_bayar: payment_method,
                dp: down_payment,
                tenor: tenor_pembelian,
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
                    $('#myModal .modal-body').append('<p>' + response.successMessage + '</p>');
                    window.shouldReload = true;
                    $("#myModal").iziModal('open');
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body').append('<p>' + response.responseJSON.errorMessage + '</p>');
                        window.shouldReload = true;
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                $('#myModal .modal-body').append('<li>' + message + '</li>');
                            });
                        });
                        window.shouldReload = false;
                        $("#myModal").iziModal('open');
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
        $('#myModal .modal-body').html('');

        grecaptcha.execute(siteKey, { action: 'contact' }).then(function (token) {
            var data = {
                name: name,
                nohp: phoneNumber,
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
                    $('#myModal .modal-body').append('<p>' + response.successMessage + '</p>');
                    window.shouldReload = true;
                    $("#myModal").iziModal('open');
                },
                error: function (response) {
                    $('#overlay').hide();
                    if (response.responseJSON.errorMessage) {
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $('#myModal .modal-body').append('<p>' + response.responseJSON.errorMessage + '</p>');
                        window.shouldReload = true;
                        $("#myModal").iziModal('open');
                        enableButton();
                    } else {
                        let errors = response.responseJSON.errors;
                        $('#myModal .icon-box').addClass('error');
                        $('#myModal .material-icons').text('close');
                        $('#myModal .modal-title').text('Error!');
                        $.each(errors, function (key, messages) {
                            $.each(messages, function (index, message) {
                                $('#myModal .modal-body').append('<li>' + message + '</li>');
                            });
                        });
                        window.shouldReload = false;
                        $("#myModal").iziModal('open');
                        enableButton();
                    }
                }
            });
        });
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

});