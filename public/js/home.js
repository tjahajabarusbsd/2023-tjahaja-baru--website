$(document).ready(function () {
    // $('#myModal').modal('show');

    function closeModal() {
        $("#myModal").modal("hide");
        localStorage.removeItem("visited");
    }

    new Swiper(".banner-wrapper", {
        slidesPerView: 1,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        loop: true,
        pagination: {
            el: ".banner-pagination",
            clickable: true,
        },
    });

    new Swiper(".grid-container", {
        slidesPerView: 1.15,
        spaceBetween: 12,
        centerInsufficientSlides: true,
        breakpoints: {
            640: { slidesPerView: 2.15, spaceBetween: 16 },
            768: { slidesPerView: 3.15, spaceBetween: 20 },
            1024: { slidesPerView: 4.15, spaceBetween: 24 },
        },
        pagination: {
            el: ".product-pagination",
            clickable: true,
        },
    });

    new Swiper(".promo-swiper", {
        slidesPerView: 1.15,
        spaceBetween: 12,
        centerInsufficientSlides: true,
        watchOverflow: true,
        breakpoints: {
            640: { slidesPerView: 2.15, spaceBetween: 16 },
            768: { slidesPerView: 3.15, spaceBetween: 20 },
            1024: { slidesPerView: 4.15, spaceBetween: 24 },
        },
        pagination: {
            el: ".promo-pagination",
            clickable: true,
        },
    });
});
