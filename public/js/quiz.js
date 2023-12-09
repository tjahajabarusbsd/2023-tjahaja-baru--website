$(document).ready(function () {
    let openingSection = $('.opening-section');
    let slides = $('.question-slide');
    let radioButtons = $('input[type=radio]');
    let currentSlide = 0;
    let maxPoints = 0;
    let result = '';

    // Objek untuk menyimpan asosiasi opsi jawaban dan poin
    const optionsPoints = {
        usage: {
            daily: { maxi: 4, classy: 4, matic: 4, moped: 4 },
            adventure: { maxi: 6, sport: 7, matic: 4, moped: 4 },
            hobby: { maxi: 4, classy: 4, sport: 4 }
        },
        riding_style: {
            relaxed: { classy: 4, matic: 3, moped: 4, maxi: 2 },
            adventurous: { maxi: 4, sport: 4, matic: 4 }
        },
        priority: {
            feature: { maxi: 2, classy: 4, matic: 3, },
            performance: { maxi: 4, sport: 5, moped: 4 }
        },
        age: {
            age_1: { maxi: 0, class: 0, matic: 0, sport: 0, moped: 0 },
            age_2: { maxi: 0, class: 0, matic: 0, sport: 0, moped: 0 },
            age_3: { maxi: 0, class: 0, matic: 0, sport: 0, moped: 0 }
        }
        // Tambahkan pertanyaan selanjutnya jika diperlukan
    };

    // Hasil motor berdasarkan poin tertinggi
    let results = {
        maxi: 0,
        classy: 0,
        matic: 0,
        sport: 0,
        moped: 0,
    };

    // Fungsi untuk menambahkan poin berdasarkan jawaban
    function addPoints(userQuestion, userAnswer) {
        const pointPairs = optionsPoints[userQuestion][userAnswer];

        // Iterasi melalui pasangan key-value dan tambahkan poin
        for (const [motor, points] of Object.entries(pointPairs)) {
            results[motor] += points;
        }

        return results;
    }

    // Fungsi untuk menghitung result berdasarkan poin tertinggi
    function calculateResult() {
        // Iterasi melalui hasil dan temukan poin tertinggi
        for (const [key, value] of Object.entries(results)) {
            if (value > maxPoints) {
                maxPoints = value;
                result = key;
            }
        }

        return result;
    }

    // Fungsi untuk menangani perubahan pada radio button
    function handleRadioChange() {

        let userAnswer = this.value;
        let userQuestion = this.name;

        // Memanggil fungsi untuk menambahkan poin berdasarkan jawaban
        addPoints(userQuestion, userAnswer);

        // Menonaktifkan radio button saat pilihan sudah dibuat
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

    $(".button-wrapper").click(function () {
        $(".quiz-wrapper").css("background-image", "url(/images/quiz/background.png)");
        openingSection.delay(100).fadeOut();
        $(".quiz-form").delay(500).fadeIn();
        showSlide(currentSlide);
    })

    // Fungsi untuk mengirim data hasil kuis ke controller dan menerima respons AJAX
    function submitForm() {
        let finalResult = calculateResult();

        // Mengirim data ke server melalui AJAX menggunakan $.ajax
        $.ajax({
            url: '/submit-quiz/',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                result: finalResult
            },
            success: function (data) {

                let resultMotor = data.features[0].motor;
                let resultImage = data.features[0].image;
                let resultTitle = data.features[0].title;

                setTimeout(function () {
                    $('.quiz-form').fadeOut();
                }, 200);

                setTimeout(function () {
                    // Menampilkan elemen hasil
                    $('.result').fadeIn();
                    $('.result h2').text(resultTitle);
                    $('.result img').attr('src', '/images/quiz/' + resultImage);
                    $('.result a').attr('href', '/products/category/' + resultMotor);
                }, 500);
            },
            error: function (error) {
                console.error('Error sending data to server:', error);
            }
        });
    }

    $('.submit-button').click(function () {
        $(this).attr("disabled", "disabled");
        submitForm();
    });
});