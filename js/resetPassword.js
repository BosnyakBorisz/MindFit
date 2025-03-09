function restPasswordCheck() {

    let password = document.getElementById("password").value.trim();
    let passwordError = document.getElementById("passwordError");

    const lower = /^(?=.*[a-z])/;
    const upper = /(?=.*[A-Z])/;
    const digit = /(?=.*\d)/;
    const special = /(?=.*[@$!%*?&])/;

    if (password === ""){
        passwordError.textContent = "Jelszó megadása kötelező!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else if (8 > password.length || password.length > 15){
        passwordError.textContent = "A jelszónak 8 és 15 karakter között kell lennie!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else if (!lower.test(password)){
        passwordError.textContent = "A jelszónak tartalmaznia kell kis karaktert!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else if (!upper.test(password)){
        passwordError.textContent = "A jelszónak tartalmaznia kell nagy karaktert!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else if (!digit.test(password)){
        passwordError.textContent = "A jelszónak tartalmaznia kell szám karaktert!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else if (!special.test(password)){
        passwordError.textContent = "A jelszónak tartalmaznia kell speciális karaktert!";
        document.getElementById("password").style.border = "2px solid red";
        valid = false;
    }
    else {
        passwordError.textContent = "";
        document.getElementById("password").style.border = "";
    }

    let repeatPassword = document.getElementById("repeatpassword").value.trim();
    let repeatPasswordError = document.getElementById("repeatPasswordError");

    if (repeatPassword !== password){
        repeatPasswordError.textContent = "A jelszavak nem egyeznek!";
        document.getElementById("repeatpassword").style.border = "2px solid red";
        valid = false;
    }
    else {
        document.getElementById("repeatpassword").style.border = "";
        repeatPasswordError.textContent = "";
    }
}