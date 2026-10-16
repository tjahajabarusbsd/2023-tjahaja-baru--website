$(document).ready(function () {
    // $('#myModal').modal('show');

    function closeModal() {
        $("#myModal").modal("hide");
        localStorage.removeItem("visited");
    }

    const swiperBanner = new Swiper(".banner-wrapper", {
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

    const swiperProductCategory = new Swiper(".grid-container", {
        slidesPerView: 1,
        spaceBetween: 12,
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 16 },
            768: { slidesPerView: 3, spaceBetween: 20 },
            1024: { slidesPerView: 4, spaceBetween: 24 },
        },
        pagination: {
            el: ".product-pagination",
            clickable: true,
        },
    });
});
