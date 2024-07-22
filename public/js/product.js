$(document).ready(function () {
    var currentUrl = window.location.pathname;
    var productLinks = document.querySelectorAll(".product-icon-box a");

    productLinks.forEach(link => {
        if (link.getAttribute('href') === currentUrl) {
            link.parentNode.classList.add('active');
        }
    });

    $('.icon-container .mobile').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: false,
        responsive: [
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 375,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

});	