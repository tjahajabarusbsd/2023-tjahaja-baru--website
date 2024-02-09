$(document).ready(function () {
    let openingSection = $('.opening-section');
    let slides = $('.question-slide');
    let radioButtons = $('input[type=radio]');
    let currentSlide = 0;
    let result = '';

    // Fungsi untuk menangani perubahan pada radio button
    function handleRadioChange() {
        const userAnswer = this.value;
        const usageClasses = {
            'matic': 'matic-usage',
            'moped': 'moped-usage',
            'sport': 'sport-usage',
        };

        if (usageClasses[userAnswer]) {
            $(`.${usageClasses[userAnswer]}`).addClass('show');
        }

        result = userAnswer;

        radioButtons.prop('disabled', true);
        currentSlide++;
        showSlide(currentSlide);
    }

    // Menambahkan event listener ke radio button
    radioButtons.on('change', handleRadioChange);

    function showSlide(slideIndex) {
        slides.each(function (index) {
            if (index === slideIndex) {
                radioButtons.prop('disabled', false);
                $(this).delay(500).fadeIn();
            } else {
                $(this).delay(100).fadeOut();
            }
        });
    }

    $(".quiz-button").click(function () {
        $(".quiz-wrapper").addClass("bg-ripples");
        openingSection.delay(100).fadeOut();
        $(".quiz-form").delay(500).fadeIn();
        showSlide(currentSlide);
    })

    // Fungsi untuk mengirim data hasil kuis ke controller dan menerima respons AJAX
    function submitForm() {
        // Mengirim data ke server melalui AJAX menggunakan $.ajax
        $.ajax({
            url: '/submit-quiz',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                result: result
            },
            success: function (data) {

                let resultImage = data.features[0].image;
                let resultTitle = data.features[0].title;

                setTimeout(function () {
                    $('.quiz-form').fadeOut();
                    slides.fadeOut();
                    radioButtons.prop("checked", false);
                }, 200);

                setTimeout(function () {
                    // Menampilkan elemen hasil
                    $('.result').fadeIn();
                    $('.result h2').text(resultTitle);
                    $('.result .grid-container').html(data.html);
                    $('.result-image img').attr('src', '/images/quiz/' + resultImage);
                }, 500);
            },
            error: function (error) {
                console.error('Error sending data to server:', error);
            }
        });
    }

    $('.last-question .quiz-button').click(function () {
        $(this).attr("disabled", "disabled");
        submitForm();
    });

    function refreshPage() {
        window.location.reload();
    }
});