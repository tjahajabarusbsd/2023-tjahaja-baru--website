/*
 * Form kontak: pesan, konsultasi motor, dan pengajuan dana.
 * Dipakai di contact.blade.php dan product/detail.blade.php.
 *
 * Kebutuhan di halaman:
 *  - const siteKey (script inline sebelum file ini)
 *  - RecaptchaV3::initJs() lewat @push('recaptcha')
 *  - jQuery, iziModal, dan meta csrf-token
 */
$(function () {
    "use strict";

    // Aturan input. Kalau mau dilonggarkan, samakan dulu dengan validasi di server.
    const NAME_PATTERN = /^[A-Za-z\s]+$/;
    const PHONE_PATTERN = /^\d+$/;
    const RECAPTCHA_TIMEOUT_MS = 10000;

    $("#myModal").iziModal({
        width: 325,
        onClosed: function () {
            if (window.shouldReload) {
                location.reload();
            }
        },
    });

    /* ====================================================================
       reCAPTCHA
       ==================================================================== */

    function getRecaptchaToken(action) {
        return new Promise(function (resolve, reject) {
            if (
                typeof grecaptcha === "undefined" ||
                typeof siteKey === "undefined"
            ) {
                reject(new Error("reCAPTCHA tidak termuat"));
                return;
            }

            const timer = setTimeout(function () {
                reject(new Error("reCAPTCHA timeout"));
            }, RECAPTCHA_TIMEOUT_MS);

            grecaptcha.ready(function () {
                grecaptcha
                    .execute(siteKey, { action: action || "contact" })
                    .then(
                        function (token) {
                            clearTimeout(timer);
                            resolve(token);
                        },
                        function (error) {
                            clearTimeout(timer);
                            reject(error);
                        }
                    );
            });
        });
    }

    /* ====================================================================
       Overlay, tombol, dan modal
       ==================================================================== */

    function showOverlay(show) {
        $("#overlay").toggle(show);
    }

    function lockButtons(lock) {
        $("button.btn-primary").prop("disabled", lock);
    }

    function enableButton() {
        lockButtons(false);
    }

    /*
     * nodes: array elemen jQuery yang dimasukkan ke body modal.
     * reload: true = halaman dimuat ulang saat modal ditutup.
     */
    function showModal(type, title, nodes, reload) {
        const isError = type === "error";
        const $modal = $("#myModal");
        const $body = $modal.find(".modal-body").empty();

        $modal.find(".icon-box").toggleClass("error", isError);
        $modal.find(".material-icons").text(isError ? "close" : "check");
        $modal.find(".modal-title").text(title);
        nodes.forEach(function (node) {
            $body.append(node);
        });

        window.shouldReload = reload;
        $modal.iziModal("open");
    }

    function showErrorModal(message, reload) {
        showModal("error", "Error!", [$("<p>").text(message)], reload);
    }

    /* ====================================================================
       Validasi
       ==================================================================== */

    function setErrorFor(input, message) {
        const $formControl = $(input).parent();
        $formControl.addClass("error").removeClass("success");

        let $errorElement = $formControl.find("small.field-error");
        if ($errorElement.length === 0) {
            $errorElement = $('<small class="field-error"></small>').appendTo(
                $formControl
            );
        }

        $errorElement.text(message);
    }

    function setSuccessFor(input) {
        $(input).parent().removeClass("error");
    }

    function clearErrors() {
        $(".main-form .error").removeClass("error");
        $(".main-form small.field-error").remove();
    }

    // Isi wajib: tandai error atau sukses, kembalikan true/false
    function requireValue(input, value, message) {
        if (!value) {
            setErrorFor(input, message);
            return false;
        }

        setSuccessFor(input);
        return true;
    }

    function readContact() {
        return {
            name: $.trim($("#name").val()),
            // spasi dan tanda hubung dibuang: "0812-3456 789" menjadi "08123456789"
            nohp: $.trim($("#nohp").val()).replace(/[\s-]/g, ""),
        };
    }

    function validateContact(contact) {
        let valid = true;

        if (!contact.name) {
            setErrorFor("#name", "Nama belum diisi");
            valid = false;
        } else if (!NAME_PATTERN.test(contact.name)) {
            setErrorFor("#name", "Gunakan huruf");
            valid = false;
        } else {
            setSuccessFor("#name");
        }

        if (!contact.nohp) {
            setErrorFor("#nohp", "No. Handphone belum diisi");
            valid = false;
        } else if (!PHONE_PATTERN.test(contact.nohp)) {
            setErrorFor("#nohp", "Gunakan angka");
            valid = false;
        } else {
            setSuccessFor("#nohp");
        }

        return valid;
    }

    function validateMotor(form) {
        // Semua dicek (tidak berhenti di yang pertama) supaya semua pesan error tampil sekaligus
        const checks = [
            requireValue(
                "#pilih-produk",
                form.produk,
                "Silakan pilih produk yang diminati."
            ),
            requireValue(
                "#payment-method",
                form.cara_bayar,
                "Silakan pilih cara bayar."
            ),
        ];

        if (form.cara_bayar === "kredit") {
            checks.push(
                requireValue(
                    "#down-payment",
                    form.dp,
                    "Silakan pilih down payment."
                ),
                requireValue(
                    "#tenor-pembelian",
                    form.tenor,
                    "Silakan pilih jumlah tenor."
                )
            );
        }

        checks.push(
            requireValue(
                "#label-checkbox",
                form.terms,
                "Kolom wajib dicentang."
            )
        );

        return checks.every(Boolean);
    }

    /* ====================================================================
       Kirim ke server
       ==================================================================== */

    function pageUrl() {
        return $.trim($('input[name="url"]').val() || "");
    }

    function clearQueryString() {
        const url = new URL(window.location.href);
        url.search = "";
        window.history.replaceState({}, document.title, url.toString());
    }

    function errorMessageFor(status) {
        if (status === 0) {
            return "Tidak dapat terhubung ke server. Periksa koneksi internet Anda lalu coba lagi.";
        }
        if (status === 419) {
            return "Sesi Anda telah berakhir. Halaman akan dimuat ulang, silakan coba lagi.";
        }
        if (status === 429) {
            return "Terlalu banyak percobaan. Silakan coba lagi beberapa saat lagi.";
        }
        return "Terjadi kesalahan pada server. Silakan coba lagi nanti.";
    }

    function handleSuccess(response, onSuccess) {
        showOverlay(false);

        if (onSuccess) {
            onSuccess();
        }

        // successMessage ditulis di backend, boleh memuat markup sederhana (jangan isi dengan input pengguna)
        showModal(
            "success",
            "Sukses!",
            [$("<p>").html(response.successMessage)],
            true
        );
    }

    function handleError(xhr) {
        const json = xhr.responseJSON || {};

        showOverlay(false);
        enableButton();

        if (json.errorMessage) {
            showModal(
                "error",
                "Error!",
                [$("<p>").html(json.errorMessage)],
                true
            );
            return;
        }

        if (json.errors) {
            const items = [];
            $.each(json.errors, function (key, messages) {
                $.each(messages, function (index, message) {
                    items.push($("<li>").text(message));
                });
            });
            showModal("error", "Error!", items, false);
            return;
        }

        // 419 (CSRF kedaluwarsa), 429, 500, atau koneksi putus: tidak ada JSON dari server
        showErrorModal(errorMessageFor(xhr.status), xhr.status === 419);
    }

    /*
     * Satu pintu untuk semua form: ambil token reCAPTCHA, kirim, lalu tampilkan hasilnya.
     * options.onSuccess dijalankan sebelum modal sukses tampil.
     */
    function submitForm(url, data, options) {
        const onSuccess = options && options.onSuccess;

        showOverlay(true);
        lockButtons(true);
        $("#myModal .icon-box").removeClass("error");
        $("#myModal .modal-body").empty();

        getRecaptchaToken("contact").then(
            function (token) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $.extend({}, data, { "g-recaptcha-response": token }),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                })
                    .done(function (response) {
                        handleSuccess(response, onSuccess);
                    })
                    .fail(handleError);
            },
            function () {
                showOverlay(false);
                enableButton();
                showErrorModal(
                    "Verifikasi keamanan gagal dimuat. Matikan pemblokir iklan atau muat ulang halaman, lalu coba lagi.",
                    false
                );
            }
        );
    }

    /* ====================================================================
       Tombol submit
       ==================================================================== */

    $("#submit-pesan").on("click", function (e) {
        e.preventDefault();
        clearErrors();

        const contact = readContact();
        const message = $.trim($("#tulis-pesan").val());

        const contactOk = validateContact(contact);
        const messageOk = requireValue(
            "#tulis-pesan",
            message,
            "Tulis pesan Anda."
        );

        if (!contactOk || !messageOk) {
            enableButton(); // tombol sudah dinonaktifkan oleh onclick="disableButton()" di Blade
            return;
        }

        submitForm("/submit-pesan-form", {
            name: contact.name,
            nohp: contact.nohp,
            message: message,
        });
    });

    $("#submit-motor").on("click", function (e) {
        e.preventDefault();
        clearErrors();

        const contact = readContact();
        const form = {
            produk: $("#pilih-produk").val(),
            cara_bayar: $("#payment-method").val(),
            dp: $("#down-payment").val(),
            tenor: $("#tenor-pembelian").val(),
            terms: $("#termsCheckbox").is(":checked"),
        };

        const contactOk = validateContact(contact);
        const motorOk = validateMotor(form);

        if (!contactOk || !motorOk) {
            enableButton();
            return;
        }

        submitForm(
            "/submit-consultation-form",
            {
                name: contact.name,
                nohp: contact.nohp,
                produk: form.produk,
                terms: form.terms,
                cara_bayar: form.cara_bayar,
                dp: form.dp,
                tenor: form.tenor,
                url: pageUrl(),
            },
            { onSuccess: clearQueryString }
        );
    });

    $("#submit-dana").on("click", function (e) {
        e.preventDefault();
        clearErrors();

        const contact = readContact();

        if (!validateContact(contact)) {
            enableButton();
            return;
        }

        submitForm("/ajukan-angsuran", {
            name: contact.name,
            nohp: contact.nohp,
            tipe: $("#tipe").val(),
            tipeLain: $("#tipe-lain").val(),
            unit_tahun: $("#unit_tahun").val(),
            harga_motor: ($("#harga_motor").val() || "").replace(/\./g, ""),
            dana_dicairkan: $("#dana_dicairkan").val(),
            tenor: $("#tenor").val(),
            angsuranMonthly: $("#angsuran-monthly").val(),
            url: pageUrl(),
        });
    });
});
