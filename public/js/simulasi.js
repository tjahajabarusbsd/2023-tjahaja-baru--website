/*
 * Simulasi pinjaman dana tunai (contact.blade.php, mode "Pinjaman Dana Tunai").
 *
 * Alur:
 *   isi data motor -> Hitung (maksimal pinjaman)
 *   -> atur dana + tenor -> Hitung Angsuran
 *   -> Ajukan Pinjaman (dikirim oleh contact.js)
 *
 * Hasil hitung selalu dibersihkan saat input berubah, supaya "Ajukan Pinjaman"
 * tidak bisa dikirim dengan angsuran lama.
 */
$(function () {
    "use strict";

    const rupiah = new Intl.NumberFormat("id-ID");
    const MAX_PRICE_DIGITS = 12;
    const $dana = $("#dana_dicairkan");

    // Input -> elemen pesan error-nya (penamaan id di Blade tidak seragam)
    const FIELD_ERRORS = {
        "#tipe": "#error-tipe",
        "#tipe-lain": "#error-tipe-lain",
        "#unit_tahun": "#error_unit_tahun",
        "#harga_motor": "#error_harga_motor",
    };

    /* ====================================================================
       Util
       ==================================================================== */

    function digitsOnly(value) {
        return String(value || "").replace(/\D/g, "");
    }

    function formatCurrency(amount) {
        return "Rp " + rupiah.format(Number(amount) || 0);
    }

    function post(url, data) {
        return $.ajax({
            url: url,
            type: "POST",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    function requestErrorMessage(xhr) {
        const json = xhr.responseJSON || {};

        if (json.errorMessage) {
            return json.errorMessage;
        }

        if (json.errors) {
            // ambil pesan validasi pertama dari semua field
            const messages = $.map(json.errors, function (list) {
                return list;
            });
            if (messages.length) {
                return messages[0];
            }
        }

        if (xhr.status === 0) {
            return "Tidak dapat terhubung ke server. Periksa koneksi internet Anda lalu coba lagi.";
        }
        if (xhr.status === 419) {
            return "Sesi Anda telah berakhir. Muat ulang halaman lalu coba lagi.";
        }
        return "Perhitungan gagal. Silakan coba lagi.";
    }

    /* ====================================================================
       Menampilkan atau menghapus hasil
       ==================================================================== */

    // Pesan di bawah tombol "Hitung" (maksimal pinjaman atau error)
    function showLoanMessage(text, isError) {
        $("#hasil").text(text).toggleClass("text-danger", isError).show();
    }

    // Error di bawah tombol "Hitung Angsuran" (dibuat lewat JS, tidak perlu ubah Blade)
    function showInstallmentError(message) {
        let $error = $("#error-simulasi");

        if (!$error.length) {
            $error = $(
                '<div id="error-simulasi" class="text-danger mt-2" role="alert"></div>'
            ).insertBefore("#hasil-angsuran");
        }

        $error.text(message).show();
    }

    function resetInstallment() {
        $("#error-simulasi").hide();
        $("#hasil-angsuran").hide();
        $("#angsuran-monthly").val("");
        $("#biaya-angsuran").text("Rp -");
    }

    function resetLoanResult() {
        $("#hasil").hide().text("").removeClass("text-danger");
        $("#input_dana").hide();
        resetInstallment();
    }

    /* ====================================================================
       Input
       ==================================================================== */

    // Harga motor tampil dengan titik ribuan; posisi kursor dipertahankan saat mengetik di tengah angka
    function formatPriceInput(input) {
        const caret = input.selectionStart;
        const digitsBeforeCaret = digitsOnly(
            input.value.slice(0, caret)
        ).length;
        const digits = digitsOnly(input.value)
            .replace(/^0+/, "")
            .slice(0, MAX_PRICE_DIGITS);
        const formatted = digits ? rupiah.format(Number(digits)) : "";

        input.value = formatted;

        let position = 0;
        let seen = 0;
        while (position < formatted.length && seen < digitsBeforeCaret) {
            if (/\d/.test(formatted.charAt(position))) {
                seen++;
            }
            position++;
        }
        input.setSelectionRange(position, position);
    }

    $("#harga_motor").on("input", function () {
        formatPriceInput(this);
    });

    $("#tipe").on("change", function () {
        const isOther = $(this).val() === "other";

        $("#input-tipe-lain").toggle(isOther);
        if (!isOther) {
            $("#tipe-lain").val("");
        }
    });

    // Pesan error hilang saat field disentuh; hasil lama dibersihkan saat data motor berubah
    $.each(FIELD_ERRORS, function (field, error) {
        $(field).on("focus input change", function () {
            $(error).hide();
        });
        $(field).on("input change", resetLoanResult);
    });

    // Slider dana dan tenor: angsuran lama tidak berlaku lagi
    $dana.on("input", function () {
        $("#dana_dicairkan_label").text(
            formatCurrency(digitsOnly($(this).val()))
        );
        resetInstallment();
    });

    $("#tenor").on("change", resetInstallment);

    /* ====================================================================
       Hitung maksimal pinjaman
       ==================================================================== */

    function showErrorIf(condition, selector) {
        $(selector).toggle(condition);
        return !condition;
    }

    // Semua dicek supaya semua pesan error tampil sekaligus
    function validateLoanForm() {
        const tipe = $("#tipe").val();

        return [
            showErrorIf(!tipe, "#error-tipe"),
            showErrorIf(
                tipe === "other" && !$.trim($("#tipe-lain").val()),
                "#error-tipe-lain"
            ),
            showErrorIf(!$("#unit_tahun").val(), "#error_unit_tahun"),
            showErrorIf(
                Number(digitsOnly($("#harga_motor").val())) === 0,
                "#error_harga_motor"
            ),
        ].every(Boolean);
    }

    $("#hitung").on("click", function (e) {
        e.preventDefault();
        resetLoanResult();

        if (!validateLoanForm()) {
            return;
        }

        const $button = $(this).prop("disabled", true);

        post("/hitung-pinjaman", {
            harga_motor: digitsOnly($("#harga_motor").val()),
        })
            .done(function (response) {
                const maksimal = Number(response.maksimal_pinjaman) || 0;
                const minimum = parseInt($dana.attr("min"), 10) || 0;

                // Slider punya batas bawah tetap; kalau maksimal di bawahnya, pengajuan tidak bisa dilanjutkan
                if (maksimal < minimum) {
                    showLoanMessage(
                        "Maksimal pinjaman untuk motor ini (" +
                            formatCurrency(maksimal) +
                            ") di bawah batas minimum pengajuan (" +
                            formatCurrency(minimum) +
                            ").",
                        true
                    );
                    return;
                }

                showLoanMessage(
                    "Maksimal Pinjaman Senilai " + formatCurrency(maksimal),
                    false
                );

                // Browser membulatkan nilai slider ke kelipatan step terdekat di bawah batas,
                // jadi label diambil dari nilai slider yang sebenarnya, bukan dari respons server.
                $dana.attr("max", maksimal).val(maksimal);
                $("#dana_dicairkan_label").text(formatCurrency($dana.val()));
                $("#input_dana").show();
            })
            .fail(function (xhr) {
                showLoanMessage(requestErrorMessage(xhr), true);
            })
            .always(function () {
                $button.prop("disabled", false);
            });
    });

    /* ====================================================================
       Hitung angsuran
       ==================================================================== */

    $("#hitung_angsuran").on("click", function (e) {
        e.preventDefault();
        resetInstallment();

        const $button = $(this).prop("disabled", true);

        post("/hitung-angsuran", {
            dana_dicairkan: digitsOnly($dana.val()),
            tenor: $("#tenor").val(),
        })
            .done(function (response) {
                $("#angsuran-monthly").val(response.angsuran_per_bulan);
                $("#biaya-angsuran").text(
                    formatCurrency(response.angsuran_per_bulan)
                );
                $("#hasil-angsuran").show();
            })
            .fail(function (xhr) {
                showInstallmentError(requestErrorMessage(xhr));
            })
            .always(function () {
                $button.prop("disabled", false);
            });
    });
});
