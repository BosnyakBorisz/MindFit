function loginCheck() {

    let email = document.getElementById("email").value.trim();
    let emailError = document.getElementById("emailError");
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "") {
        valid = false;
        emailError.textContent = "Email cím megadása kötelező!";
        document.getElementById("email").style.border = "2px solid red";
    } 
    else if (!emailRegex.test(email)) { 
        valid = false;
        emailError.textContent = "Érvénytelen email formátum!";
        document.getElementById("email").style.border = "2px solid red";
    } 
    else {
        document.getElementById("email").style.border = "";
        emailError.textContent = "";
    }


    let password = document.getElementById("password").value.trim();
    let passwordError = document.getElementById("passwordError");


    if (password === ""){
        document.getElementById("password").style.border = "2px solid red";  
        passwordError.textContent = "Jelszó megadása kötelező!"; 
    }

    else {
        document.getElementById("password").style.border = "";
        passwordError.textContent = ""; 
    }
}