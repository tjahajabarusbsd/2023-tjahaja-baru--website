$(document).ready(function () {
    $("#submitButton").click(function (e) {
        e.preventDefault();
        clearErrors();
        handleInput();
    });

    function enableButton() {
        $("#submitButton").removeAttr("disabled");
    }

    function handleInput() {
        let userNameValue = $("#name").val().trim();
        let phoneNumberValue = $("#nohp").val().trim();

        if (userNameValue === "") {
            setErrorFor($("#name"), "Kolom wajib diisi.");
            enableButton();
        } else if (!/^[A-Za-z\s]+$/.test(userNameValue)) {
            setErrorFor($("#name"), "Hanya diperbolehkan input huruf.");
            enableButton();
        } else {
            setSuccessFor($("#name"));
        }

        if (phoneNumberValue === "") {
            setErrorFor($("#nohp"), "Kolom wajib diisi.");
            enableButton();
        } else if (!/^\d+$/.test(phoneNumberValue)) {
            setErrorFor($("#nohp"), "Hanya diperbolehkan input angka.");
            enableButton();
        } else {
            setSuccessFor($("#nohp"));
        }
        if (hasErrors() == false) {
            $("form").submit();
        }
    }

    function setErrorFor(input, message) {
        let $formControl = $(input).parent();
        $formControl.addClass("error").removeClass("success");

        let $errorElement = $formControl.find("small");
        if ($errorElement.length === 0) {
            $errorElement = $("<small></small>").appendTo($formControl);
        }

        $errorElement.text(message);
    }

    function setSuccessFor(input) {
        let $formControl = $(input).parent();
        if ($formControl) {
            $formControl.removeClass("error");
        }
    }

    function clearErrors() {
        $(".form-group").removeClass("error");
        $("small").remove();
    }

    function hasErrors() {
        return $(".form-group.error").length > 0;
    }
});