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

    function disableButton() {
        $(".btn-primary").prop('disabled', true);
    }

    $('#payment-method').change(function () {
        var selectedValue = $(this).val();

        if (selectedValue === 'kredit') {
            $('#option-bayar').show();
            $('#option-tenor-pembelian').show();
        } else if (selectedValue === 'cash') {
            $('#option-bayar').hide();
            $('#option-tenor-pembelian').hide();
            $('#down-payment').val('');
            $('#tenor-pembelian').val('');
        } else {
            $('#option-bayar').hide();
            $('#option-tenor-pembelian').hide();
        }
    });

    $('.features-wrapper').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: true,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: true
                }
            },
            {
                breakpoint: 845,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 568,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false
                }
            }
        ]
    });

    // setTimeout(function() { 
    //     $('iframe.delayed').attr('src'); 
    // }, 20000);

    // $('.videos-wrapper').slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     dots: true,
    //     arrows: true,
    //     autoplay: false,
    //     responsive: [
    //         {
    //             breakpoint: 650,
    //             settings: {
    //                 slidesToShow: 1,
    //                 slidesToScroll: 1,
    //                 arrows: false,
    //                 dots: true
    //             }
    //         },
    //         {
    //             breakpoint: 375,
    //             settings: {
    //                 slidesToShow: 1,
    //                 slidesToScroll: 1,
    //                 arrows: false,
    //                 dots: true
    //             }
    //         }
    //     ]
    // }); 

});	