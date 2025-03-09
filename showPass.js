document.addEventListener("DOMContentLoaded", function () {
    let passwordField = document.getElementById("password");
    let toggleCheckbox = document.getElementById("togglePasswordCheckbox");
    let eyeOpen = document.getElementById("eyeOpen");
    let eyeClosed = document.getElementById("eyeClosed");

    if (toggleCheckbox.checked) {
        passwordField.type = "password";
        eyeOpen.style.display = "none";
        eyeClosed.style.display = "inline";
    } else {
        passwordField.type = "text";
        eyeOpen.style.display = "inline";
        eyeClosed.style.display = "none";
    }

    toggleCheckbox.addEventListener("change", function () {
        if (this.checked) {
            passwordField.type = "password";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "inline";
        } else {
            passwordField.type = "text"; 
            eyeOpen.style.display = "inline";
            eyeClosed.style.display = "none";
        }
    });

    let rpasswordField = document.getElementById("repeatpassword");
    let rtoggleCheckbox = document.getElementById("togglePasswordCheckbox2");
    let reyeOpen = document.getElementById("eyeOpen2");
    let reyeClosed = document.getElementById("eyeClosed2");

    if (rtoggleCheckbox.checked) {
        rpasswordField.type = "password";
        reyeOpen.style.display = "none";
        reyeClosed.style.display = "inline";
    } else {
        rpasswordField.type = "text";
        reyeOpen.style.display = "inline";
        reyeClosed.style.display = "none";
    }

    rtoggleCheckbox.addEventListener("change", function () {
        if (this.checked) {
            rpasswordField.type = "password";
            reyeOpen.style.display = "none";
            reyeClosed.style.display = "inline";
        } else {
            rpasswordField.type = "text"; 
            reyeOpen.style.display = "inline";
            reyeClosed.style.display = "none";
        }
    });

});
