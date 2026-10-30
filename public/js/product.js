$(function () {
    // Bar kategori versi mobile: bisa di-swipe (status .active sekarang dari Blade)
    $(".icon-container .mobile").slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: false,
        responsive: [
            {
                breakpoint: 650,
                settings: { slidesToShow: 5, slidesToScroll: 1 },
            },
            {
                breakpoint: 500,
                settings: { slidesToShow: 4, slidesToScroll: 1 },
            },
            {
                breakpoint: 375,
                settings: { slidesToShow: 3, slidesToScroll: 1 },
            },
        ],
    });

    // Form pembelian: opsi kredit (DP + tenor) hanya muncul untuk metode "kredit".
    // Tidak ada di halaman kategori; dipertahankan karena file ini juga dimuat halaman lain.
    $("#payment-method").on("change", function () {
        const isKredit = $(this).val() === "kredit";

        $("#option-bayar, #option-tenor-pembelian").toggle(isKredit);

        if (!isKredit) {
            $("#down-payment, #tenor-pembelian").val("");
        }
    });
});
