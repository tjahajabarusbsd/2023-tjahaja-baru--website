$(document).ready(function () {
    let form = document.querySelector("form");
    let userName = document.querySelector("#name");
    let phoneNumber = document.querySelector("#nohp");

    // Event listener to submit form
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        clearErrors();
        handleInput();
    });

    function enableButton() {
        var submitButton = document.getElementById('submitButton');
        submitButton.removeAttribute('disabled');
    }

    // What to do with inputs ?
    function handleInput() {
        // Values from dom elements ( input )
        let userNameValue = userName.value.trim();
        let phoneNumberValue = phoneNumber.value.trim();

        //  Checking for username
        if (userNameValue === "") {
            setErrorFor(userName, "Kolom wajib diisi.");
            enableButton()
        } else {
            setSuccessFor(userName);
        }

        // Checking for phone number
        if (phoneNumberValue === "") {
            setErrorFor(phoneNumber, "Kolom wajib diisi.");
            enableButton()
        } else if (!/^\d+$/.test(phoneNumberValue)) {
            setErrorFor(phoneNumber, "Kolom wajib menggunakan angka saja.");
            enableButton()
        } else {
            setSuccessFor(phoneNumber);
        }

        // If there are no errors, submit the form
        if (!hasErrors()) {
            submitForm();
        }
    }

    // If there is an error, what to do with input?
    function setErrorFor(input, message) {
        let formControl = input.parentElement;
        formControl.classList.add("error");
        formControl.classList.remove("success");

        // Check if error element already exists
        let errorElement = formControl.querySelector("small");
        if (!errorElement) {
            // Create and append the error message element
            errorElement = document.createElement("small");
            formControl.appendChild(errorElement);
        }

        errorElement.innerText = message;
    }

    // If there is no error, than what we want to do with input ?
    function setSuccessFor(input) {
        let formControl = input.parentElement;
        if (formControl) {
            formControl.classList.remove("error");
        }
    }

    // Clear all error classes
    function clearErrors() {
        let errorInputs = document.querySelectorAll(".form-group");
        let findErrorBe = document.querySelectorAll('small');
        if (findErrorBe) {
            findErrorBe.forEach(i => {
                i.remove();
            });
        }
    }

    // Check if there are any input fields with errors
    function hasErrors() {
        let errorInputs = document.querySelectorAll(".form-group.error");
        return errorInputs.length > 0;
    }

    // Submit the form
    function submitForm() {
        form.submit();
    }

});