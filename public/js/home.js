$(document).ready(function () {
    // $('#myModal').modal('show');

    function closeModal() {
        $('#myModal').modal('hide');
        localStorage.removeItem('visited');
    }

    const swiperBanner = new Swiper('.banner-wrapper', {
        slidesPerView: 1,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        loop: true,
        pagination: {
            el: '.banner-pagination',
            clickable: true,
        },
    });

    const swiperProductCategory = new Swiper('.grid-container', {
        slidesPerView: 1,
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
            1280: { slidesPerView: 5 },
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});
