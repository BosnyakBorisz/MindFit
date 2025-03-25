// Form client validálás
async function nextStep1() {
    let valid = true;

    const regex = /^[a-zA-Z0-9]+$/;

    let username = document.getElementById("username").value.trim();
    let usernameError =  document.getElementById("usernameError");

    if (username === ""){
        usernameError.textContent = "Felhasználónév megadása kötelező!";
        document.getElementById("username").style.border = "2px solid red";
        valid = false;
    }
    else if (username.length < 5){
        usernameError.textContent = "Felhasználónévnek minimum 5 karakterből kell állnia!";
        document.getElementById("username").style.border = "2px solid red";
        valid = false;
    }
    else if (username.length > 20){
        usernameError.textContent = "Felhasználónév maximum 20 karakterből állhat!";
        document.getElementById("username").style.border = "2px solid red";
        valid = false;
    }
    else if (!regex.test(username)){
        usernameError.textContent = "Felhasználónév csak betűket és számokat tartalmazhat!";
        document.getElementById("username").style.border = "2px solid red";
        valid = false;
    }
    else {
        usernameError.textContent = "";
        document.getElementById("username").style.border = "";
    }

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
        try {
            let response = await fetch("check_email.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "email=" + encodeURIComponent(email)
            });

            let data = await response.text();

            if (data === "exists") {
                valid = false;
                emailError.textContent = "Az email cím már használatban van!";
                document.getElementById("email").style.border = "2px solid red";
            } else {
                emailError.textContent = "";
            }
        } catch (error) {
            console.error("Hiba történt:", error);
        }
    }

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

    return valid;
}


function nextStep2(){

    let valid = true;

    let sex = document.getElementById("sex").value;
    let sexError = document.getElementById("sexError");
    let age = document.getElementById("age").value;
    let ageError = document.getElementById("ageError");
    let weight = document.getElementById("weight").value;
    let weightError =  document.getElementById("weightError");
    let height = document.getElementById("height").value;
    let heightError = document.getElementById("heightError");

    if (sex === ""){
        sexError.textContent = "Válassz nemet!";
        document.getElementById("sex").style.border = "2px solid red";
        valid = false;
    }
    else {
        sexError.textContent = "";
        document.getElementById("sex").style.border = "";
    }

    if (age === ""){
        ageError.textContent = "Add meg az életkorodat!";
        document.getElementById("age").style.border = "2px solid red";
        valid = false;
    }
    else if( 14 > age || age > 100){
        ageError.textContent = "14 és 100 év közötti értéket adj meg!";
        document.getElementById("age").style.border = "2px solid red";
        valid = false;
    }
    else {
        ageError.textContent = "";
        document.getElementById("age").style.border = "";
    }

    if (weight === ""){
        weightError.textContent = "Add meg a testsúlyod!";
        document.getElementById("weight").style.border = "2px solid red";
        valid = false;
    }
    else if (40 > weight || weight > 150){
        weightError.textContent = "40 és 150kg közötti értéket adj meg!";
        document.getElementById("weight").style.border = "2px solid red";
        valid = false;
    }
    else {
        weightError.textContent = "";
        document.getElementById("weight").style.border = "";
    }

    if (height === ""){
        heightError.textContent = "Add meg a magasságod!";
        document.getElementById("height").style.border = "2px solid red";
        valid = false;
    }
    else if (120 > height || height > 250) {
        heightError.textContent = "120 és 250cm közötti értéket adj meg!";
        document.getElementById("height").style.border = "2px solid red";
        valid = false;
    }
    else {
        heightError.textContent = "";
        document.getElementById("height").style.border = "";
    }

    let ecto = document.getElementById("ectomorph-img");
    let meso = document.getElementById("mesomorph-img");
    let endo = document.getElementById("endomorph-img");

    if (sex === "man"){
        ecto.src = "img/ectomorph-ferfi.jpg"
        ecto.alt = "Ectomorph férfi";
        meso.src =  "img/mesomorph-ferfi.jpg"
        meso.alt = "Mesomorph férfi"
        endo.src = "img/endomorph-ferfi.jpg";
        endo.alt = "Endomorph férfi"
    }
    else if (sex === "woman"){
        ecto.src = "img/ectomorph-no.jpg"
        ecto.alt = "Mesomorph nő";
        meso.src =  "img/mesomorph-no.jpg"
        meso.alt = "Mesomorph nő"
        endo.src = "img/endomorph-no.jpg";
        endo.alt = "Endomorph nő"
    }
    else {
        ecto.src = "img/ectomorph-ferfi.jpg"
        ecto.alt = "Ectomorph férfi";
        meso.src =  "img/mesomorph-ferfi.jpg"
        meso.alt = "Mesomorph férfi"
        endo.src = "img/endomorph-ferfi.jpg";
        endo.alt = "Endomorph férfi"
    }

    //A testzsírszázalékcsúszka
    const rangeInput = document.getElementById('bodyfat-range');
    const image = document.getElementById('bodyfat-image');
    const valueText = document.getElementById('bodyfat-text');

    const rangeInput2 = document.getElementById('bodyfat-range2');
    const image2 = document.getElementById('bodyfat-image2');
    const valueText2 = document.getElementById('bodyfat-text2');

    if (sex === "man") {
        image.src = `img/man-15-bodyfat.jpeg`;
        rangeInput.addEventListener('input', function() {
            const value = rangeInput.value * 5;
            valueText.textContent = value + "%";
            image.src = `img/man-${value}-bodyfat.jpeg`;
        });
        
        image2.src = `img/man-15-bodyfat.jpeg`;
        rangeInput2.addEventListener('input', function() {
            const value = rangeInput2.value * 5;
            valueText2.textContent = value + "%";
            image2.src = `img/man-${value}-bodyfat.jpeg`;
        });
        
    }
    else if (sex === "woman")
    {
        image.src = `img/woman-20-bodyfat.jpeg`;
        valueText.textContent = "20%";
        rangeInput.addEventListener('input', function() {
            const value = (rangeInput.value * 5) + 5;
            valueText.textContent = value + "%";
            image.src = `img/woman-${value}-bodyfat.jpeg`;
        });
        
        image2.src = `img/woman-20-bodyfat.jpeg`;
        valueText2.textContent = "20%";
        rangeInput2.addEventListener('input', function() {
            const value = (rangeInput2.value * 5) + 5;
            valueText2.textContent = value + "%";
            image2.src = `img/woman-${value}-bodyfat.jpeg`;
        });
        
    }
    else {
        image.src = `img/man-15-bodyfat.jpeg`;
        rangeInput.addEventListener('input', function() {
            const value = rangeInput.value * 5;
            valueText.textContent = value + "%";
            image.src = `img/man-${value}-bodyfat.jpeg`;
        });
        
        image2.src = `img/man-15-bodyfat.jpeg`;
        rangeInput2.addEventListener('input', function() {
            const value = rangeInput2.value * 5;
            valueText2.textContent = value + "%";
            image2.src = `img/man-${value}-bodyfat.jpeg`;
        });    
    }


    return valid;
}

function nextStep3() {
    let valid = true;

    let goal = document.getElementById("goal").value;
    let goalError = document.getElementById("goalError");

    if (goal === ""){
        goalError.textContent = "Válassz célt!";
        document.getElementById("goal").style.border = "2px solid red";
        valid = false;
    }
    else {
        goalError.textContent = "";
        document.getElementById("goal").style.border = "";
    }

    return valid;
}

function nextStep4() {

    let valid = true;

    let ecto = document.getElementById("bodytype-ecto");
    let meso = document.getElementById("bodytype-meso");
    let endo = document.getElementById("bodytype-endo");

    if (!ecto.checked && !meso.checked && !endo.checked) {
        document.getElementById("bodytypeError").textContent = "Válassz testalkatot!";
        let elements = document.getElementsByClassName("testalkat");
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.border = "2px solid red";
        }
        valid = false;
    }
    else {
        document.getElementById("bodytypeError").textContent = "";
        let elements = document.getElementsByClassName("testalkat");
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.border = "";
        }
    }

    let ectoImg = document.getElementById("ectomorph-img");
    let mesoImg = document.getElementById("mesomorph-img");
    let endoImg= document.getElementById("endomorph-img");

    ecto.addEventListener("change", function() {
    if (ecto.checked) {
        ectoImg.style.border = "";
        mesoImg.style.border = "";
        endoImg.style.border = "";
        document.getElementById("bodytypeError").textContent = "";
    }
    });

    meso.addEventListener("change", function() {
    if (meso.checked) {
        ectoImg.style.border = "";
        mesoImg.style.border = "";
        endoImg.style.border = "";
        document.getElementById("bodytypeError").textContent = "";
    }
    });

    endo.addEventListener("change", function() {
    if (endo.checked) {
        ectoImg.style.border = "";
        mesoImg.style.border = "";
        endoImg.style.border = "";
        document.getElementById("bodytypeError").textContent = "";
    }
    });

    return valid;
}

function nextStep5() {
    let valid = true;
    return valid;
}

function nextStep6() {
    let valid = true;
    return valid;
}

function nextStep7() {

    let valid = true;

    const freqq1 = document.getElementById('workout-frequency1');
    const freqq2 = document.getElementById('workout-frequency2');
    const freqq3 = document.getElementById('workout-frequency3');
    const freqq4 = document.getElementById('workout-frequency4');
    const freqqError = document.getElementById('workoutError');

    if (!freqq1.checked && !freqq2.checked && !freqq3.checked && !freqq4.checked) {
        freqqError.textContent = "Válassz egy értéket!";
        document.getElementById("workout-frequency1-label").style.border = "2px solid red";
        document.getElementById("workout-frequency2-label").style.border = "2px solid red";
        document.getElementById("workout-frequency3-label").style.border = "2px solid red";
        document.getElementById("workout-frequency4-label").style.border = "2px solid red";
        valid = false;
    }
    else {
        freqqError.textContent = "";
    }

    return valid;
}


const freq1 = document.getElementById('workout-frequency1');
const freq2 = document.getElementById('workout-frequency2');
const freq3 = document.getElementById('workout-frequency3');
const freq4 = document.getElementById('workout-frequency4');
const freqError = document.getElementById('workoutError');

freq1.addEventListener("change", function() {
    if (freq1.checked) {
        document.getElementById("workout-frequency1-label").style.border = "3px solid var(--c)";
        document.getElementById("workout-frequency2-label").style.border = "";
        document.getElementById("workout-frequency3-label").style.border = "";
        document.getElementById("workout-frequency4-label").style.border = "";
        document.getElementById("workoutError").textContent = "";
    }
});

freq2.addEventListener("change", function() {
    if (freq2.checked) {
        document.getElementById("workout-frequency1-label").style.border = "";
        document.getElementById("workout-frequency2-label").style.border = "3px solid var(--c)";
        document.getElementById("workout-frequency3-label").style.border = "";
        document.getElementById("workout-frequency4-label").style.border = "";
        document.getElementById("workoutError").textContent = "";
    }
});

freq3.addEventListener("change", function() {
    if (freq3.checked) {
        document.getElementById("workout-frequency1-label").style.border = "";
        document.getElementById("workout-frequency2-label").style.border = "";
        document.getElementById("workout-frequency3-label").style.border = "3px solid var(--c)";
        document.getElementById("workout-frequency4-label").style.border = "";
        document.getElementById("workoutError").textContent = "";
    }
});

freq4.addEventListener("change", function() {
    if (freq4.checked) {
        document.getElementById("workout-frequency1-label").style.border = "";
        document.getElementById("workout-frequency2-label").style.border = "";
        document.getElementById("workout-frequency3-label").style.border = "";
        document.getElementById("workout-frequency4-label").style.border = "3px solid var(--c)";
        document.getElementById("workoutError").textContent = "";
    }
});



function nextStep8() {

    let valid = true;

    const wfreqq1 = document.getElementById('wanted-workout-frequency1');
    const wfreqq2 = document.getElementById('wanted-workout-frequency2');
    const wfreqq3 = document.getElementById('wanted-workout-frequency3');
    const wfreqq4 = document.getElementById('wanted-workout-frequency4');
    const wfreqq5 = document.getElementById('wanted-workout-frequency5');
    const wfreqq6 = document.getElementById('wanted-workout-frequency6');
    const wfreqq7 = document.getElementById('wanted-workout-frequency7');
    const wfreqError = document.getElementById('wantedWorkoutError');


    if (!wfreqq1.checked && !wfreqq2.checked && !wfreqq3.checked && !wfreqq4.checked && !wfreqq5.checked && !wfreqq6.checked && !wfreqq7.checked) {
        wfreqError.textContent = "Válassz egy értéket!";
        document.getElementById("wanted-workout-frequency1-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency2-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency3-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency4-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency5-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency6-label").style.border = "2px solid red";
        document.getElementById("wanted-workout-frequency7-label").style.border = "2px solid red";
        valid = false;
    }
    else {
        wfreqError.textContent = "";
    }
    return valid;
}

const wfreq1 = document.getElementById('wanted-workout-frequency1');
const wfreq2 = document.getElementById('wanted-workout-frequency2');
const wfreq3 = document.getElementById('wanted-workout-frequency3');
const wfreq4 = document.getElementById('wanted-workout-frequency4');
const wfreq5 = document.getElementById('wanted-workout-frequency5');
const wfreq6 = document.getElementById('wanted-workout-frequency6');
const wfreq7 = document.getElementById('wanted-workout-frequency7');
const wfreqError = document.getElementById('wantedWorkoutError');

wfreq1.addEventListener("change", function() {
    if (wfreq1.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});

wfreq2.addEventListener("change", function() {
    if (wfreq2.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});
wfreq3.addEventListener("change", function() {
    if (wfreq3.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});
wfreq4.addEventListener("change", function() {
    if (wfreq4.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});
wfreq5.addEventListener("change", function() {
    if (wfreq5.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});
wfreq6.addEventListener("change", function() {
    if (wfreq6.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "3px solid var(--c)";
        document.getElementById("wanted-workout-frequency7-label").style.border = "";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});

wfreq7.addEventListener("change", function() {
    if (wfreq7.checked) {
        document.getElementById("wanted-workout-frequency1-label").style.border = "";
        document.getElementById("wanted-workout-frequency2-label").style.border = "";
        document.getElementById("wanted-workout-frequency3-label").style.border = "";
        document.getElementById("wanted-workout-frequency4-label").style.border = "";
        document.getElementById("wanted-workout-frequency5-label").style.border = "";
        document.getElementById("wanted-workout-frequency6-label").style.border = "";
        document.getElementById("wanted-workout-frequency7-label").style.border = "3px solid var(--c)";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
});

function nextStep9() {

    let valid = true;

    const ttime1 = document.getElementById('wanted-workout-time1');
    const ttime2 = document.getElementById('wanted-workout-time2');
    const ttime3 = document.getElementById('wanted-workout-time3');
    const ttime4 = document.getElementById('wanted-workout-time4');
    const ttime5 = document.getElementById('wanted-workout-time5');
    const ttime6 = document.getElementById('wanted-workout-time6');
    const ttimeError = document.getElementById("wantedTimeError");


    if (!ttime1.checked && !ttime2.checked && !ttime3.checked && !ttime4.checked && !ttime5.checked && !ttime6.checked) {
        ttimeError.textContent = "Válassz egy értéket!";
        document.getElementById("w-time1-label").style.border = "2px solid red";
        document.getElementById("w-time2-label").style.border = "2px solid red";
        document.getElementById("w-time3-label").style.border = "2px solid red";
        document.getElementById("w-time4-label").style.border = "2px solid red";
        document.getElementById("w-time5-label").style.border = "2px solid red";
        document.getElementById("w-time6-label").style.border = "2px solid red";
        valid = false;
    }
    else {
        ttimeError.textContent = "";
    }
    return valid;
}

const time1 = document.getElementById('wanted-workout-time1');
const time2 = document.getElementById('wanted-workout-time2');
const time3 = document.getElementById('wanted-workout-time3');
const time4 = document.getElementById('wanted-workout-time4');
const time5 = document.getElementById('wanted-workout-time5');
const time6 = document.getElementById('wanted-workout-time6');


time1.addEventListener("change", function() {
    if (time1.checked) {
        document.getElementById("w-time1-label").style.border = "3px solid var(--c)";
        document.getElementById("w-time2-label").style.border = "";
        document.getElementById("w-time3-label").style.border = "";
        document.getElementById("w-time4-label").style.border = "";
        document.getElementById("w-time5-label").style.border = "";
        document.getElementById("w-time6-label").style.border = "";
        document.getElementById("wantedTimeError").textContent = "";
    }
});

time2.addEventListener("change", function() {
    if (time2.checked) {
        document.getElementById("w-time1-label").style.border = "";
        document.getElementById("w-time2-label").style.border = "3px solid var(--c)";
        document.getElementById("w-time3-label").style.border = "";
        document.getElementById("w-time4-label").style.border = "";
        document.getElementById("w-time5-label").style.border = "";
        document.getElementById("w-time6-label").style.border = "";
        document.getElementById("wantedTimeError").textContent = "";
    }
});

time3.addEventListener("change", function() {
    if (time3.checked) {
        document.getElementById("w-time1-label").style.border = "";
        document.getElementById("w-time2-label").style.border = "";
        document.getElementById("w-time3-label").style.border = "3px solid var(--c)";
        document.getElementById("w-time4-label").style.border = "";
        document.getElementById("w-time5-label").style.border = "";
        document.getElementById("w-time6-label").style.border = "";
        document.getElementById("wantedTimeError").textContent = "";
    }
});

time4.addEventListener("change", function() {
    if (time4.checked) {
        document.getElementById("w-time1-label").style.border = "";
        document.getElementById("w-time2-label").style.border = "";
        document.getElementById("w-time3-label").style.border = "";
        document.getElementById("w-time4-label").style.border = "3px solid var(--c)";
        document.getElementById("w-time5-label").style.border = "";
        document.getElementById("w-time6-label").style.border = "";
        document.getElementById("wantedTimeError").textContent = "";
    }
});

time5.addEventListener("change", function() {
    if (time5.checked) {
        document.getElementById("w-time1-label").style.border = "";
        document.getElementById("w-time2-label").style.border = "";
        document.getElementById("w-time3-label").style.border = "";
        document.getElementById("w-time4-label").style.border = "";
        document.getElementById("w-time5-label").style.border = "3px solid var(--c)";
        document.getElementById("w-time6-label").style.border = "";
        document.getElementById("wantedTimeError").textContent = "";
    }
});

time6.addEventListener("change", function() {
    if (time6.checked) {
        document.getElementById("w-time1-label").style.border = "";
        document.getElementById("w-time2-label").style.border = "";
        document.getElementById("w-time3-label").style.border = "";
        document.getElementById("w-time4-label").style.border = "";
        document.getElementById("w-time5-label").style.border = "";
        document.getElementById("w-time6-label").style.border = "3px solid var(--c)";
        document.getElementById("wantedTimeError").textContent = "";
    }
});


function nextStep10() {

    let valid = true;

    const pplace1 = document.getElementById('workoutplace1');
    const pplace2 = document.getElementById('workoutplace2');
    const pplace3 = document.getElementById('workoutplace3');
    pplaceError = document.getElementById("placeError");

    if (!pplace1.checked && !pplace2.checked && !pplace3.checked) {
        placeError.textContent = "Válassz egy értéket!";
        document.getElementById("place1-label").style.border = "2px solid red";
        document.getElementById("place2-label").style.border = "2px solid red";
        document.getElementById("place3-label").style.border = "2px solid red";
        valid = false;
    }
    else {
        document.getElementById("placeError").textContent = "";
    }
    return valid;
}

const place1 = document.getElementById('workoutplace1');
const place2 = document.getElementById('workoutplace2');
const place3 = document.getElementById('workoutplace3');
placeError = document.getElementById("placeError");

place1.addEventListener("change", function() {
    if (place1.checked) {
        document.getElementById("place1-label").style.border = "3px solid var(--c)";
        document.getElementById("place2-label").style.border = "";
        document.getElementById("place3-label").style.border = "";
        placeError.textContent = "";
    }
});

place2.addEventListener("change", function() {
    if (place2.checked) {
        document.getElementById("place1-label").style.border = "";
        document.getElementById("place2-label").style.border = "3px solid var(--c)";
        document.getElementById("place3-label").style.border = "";
        placeError.textContent = "";
    }
});

place3.addEventListener("change", function() {
    if (place3.checked) {
        document.getElementById("place1-label").style.border = "";
        document.getElementById("place2-label").style.border = "";
        document.getElementById("place3-label").style.border = "3px solid var(--c)";
        placeError.textContent = "";
    }
});


function nextStep11() {

    let valid = true;

    const eqqu1 = document.getElementById('equipment1');
    const eqqu2 = document.getElementById('equipment2');
    const eqqu3 = document.getElementById('equipment3');
    const eqquError =  document.getElementById("felszereltsegError")

    if (!eqqu1.checked && !eqqu2.checked && !eqqu3.checked) {
        eqquError.textContent = "Válassz egy értéket!";
        document.getElementById("equipment1-label").style.border = "2px solid red";
        document.getElementById("equipment2-label").style.border = "2px solid red";
        document.getElementById("equipment3-label").style.border = "2px solid red";
        valid = false;
    }
    else {
        document.getElementById("felszereltsegError").textContent = "";
    }
    return valid;
}

const equ1 = document.getElementById('equipment1');
const equ2 = document.getElementById('equipment2');
const equ3 = document.getElementById('equipment3');
const equError =  document.getElementById("felszereltsegError")

equ1.addEventListener("change", function() {
    if (equ1.checked) {
        document.getElementById("equipment1-label").style.border = "3px solid var(--c)";
        document.getElementById("equipment2-label").style.border = "";
        document.getElementById("equipment3-label").style.border = "";
        equError.textContent = "";
    }
});

equ2.addEventListener("change", function() {
    if (equ2.checked) {
        document.getElementById("equipment1-label").style.border = "";
        document.getElementById("equipment2-label").style.border = "3px solid var(--c)";
        document.getElementById("equipment3-label").style.border = "";
        equError.textContent = "";
    }
});

equ3.addEventListener("change", function() {
    if (equ3.checked) {
        document.getElementById("equipment1-label").style.border = "";
        document.getElementById("equipment2-label").style.border = "";
        document.getElementById("equipment3-label").style.border = "3px solid var(--c)";
        equError.textContent = "";
    }
});


function nextStep12() {
    let valid = true;
    return valid;
}

const muscle1 = document.getElementById("focusmuscle1");
const muscle2 = document.getElementById("focusmuscle2");
const muscle3 = document.getElementById("focusmuscle3");
const muscle4 = document.getElementById("focusmuscle4");
const muscle5 = document.getElementById("focusmuscle5");
const muscle6 = document.getElementById("focusmuscle6");
const muscle7 = document.getElementById("focusmuscle7");
const muscle8 = document.getElementById("focusmuscle8");

muscle1.addEventListener("change", function() {
    if (muscle1.checked) {
        document.getElementById("focusmuscle1-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle1-label").style.border = "";
    }
});

muscle2.addEventListener("change", function() {
    if (muscle2.checked) {
        document.getElementById("focusmuscle2-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle2-label").style.border = "";
    }
});

muscle3.addEventListener("change", function() {
    if (muscle3.checked) {
        document.getElementById("focusmuscle3-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle3-label").style.border = "";
    }
});

muscle4.addEventListener("change", function() {
    if (muscle4.checked) {
        document.getElementById("focusmuscle4-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle4-label").style.border = "";
    }
});

muscle5.addEventListener("change", function() {
    if (muscle5.checked) {
        document.getElementById("focusmuscle5-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle5-label").style.border = "";
    }
});

muscle6.addEventListener("change", function() {
    if (muscle6.checked) {
        document.getElementById("focusmuscle6-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle6-label").style.border = "";
    }
});

muscle7.addEventListener("change", function() {
    if (muscle7.checked) {
        document.getElementById("focusmuscle7-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle7-label").style.border = "";
    }
});

muscle8.addEventListener("change", function() {
    if (muscle8.checked) {
        document.getElementById("focusmuscle8-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("focusmuscle8-label").style.border = "";
    }
});

const serult1 = document.getElementById("serult1");
const serult2 = document.getElementById("serult2");
const serult3 = document.getElementById("serult3");
const serult4 = document.getElementById("serult4");
const serult5 = document.getElementById("serult5");
const serult6 = document.getElementById("serult6");

serult1.addEventListener("change", function() {
    if (serult1.checked) {
        document.getElementById("serult1-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult1-label").style.border = "";
    }
});

serult2.addEventListener("change", function() {
    if (serult2.checked) {
        document.getElementById("serult2-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult2-label").style.border = "";
    }
});

serult3.addEventListener("change", function() {
    if (serult3.checked) {
        document.getElementById("serult3-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult3-label").style.border = "";
    }
});

serult4.addEventListener("change", function() {
    if (serult4.checked) {
        document.getElementById("serult4-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult4-label").style.border = "";
    }
});

serult5.addEventListener("change", function() {
    if (serult5.checked) {
        document.getElementById("serult5-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult5-label").style.border = "";
    }
});

serult6.addEventListener("change", function() {
    if (serult6.checked) {
        document.getElementById("serult6-label").style.border = "3px solid var(--c)";
    }
    else {
        document.getElementById("serult6-label").style.border = "";
    }
});

//A lépegetés
document.querySelectorAll('.nextgomb').forEach(button => {
    button.addEventListener('click', async function () {

        let currentStep = document.querySelector('.step.active');

        let valid = false;

        if (currentStep.classList.contains('active')) {
            if (currentStep === document.querySelector('.step:nth-child(1)')) {
                valid = await nextStep1(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(2)')) {
                valid = nextStep2(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(3)')) {
                valid = nextStep3(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(4)')) {
                valid = nextStep4(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(5)')) {
                valid = nextStep5(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(6)')) {
                valid = nextStep6(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(7)')) {
                valid = nextStep7(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(8)')) {
                valid = nextStep8(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(9)')) {
                valid = nextStep9(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(10)')) {
                valid = nextStep10(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(11)')) {
                valid = nextStep11(); 
            }
            else if (currentStep === document.querySelector('.step:nth-child(12)')) {
                valid = nextStep12(); 
            }
        }

        console.log("Valid értéke:", valid);
        if (!valid) return;

        currentStep.classList.remove('active');
        let nextStep = currentStep.nextElementSibling;
        if (nextStep && nextStep.classList.contains('step')) {
            nextStep.classList.add('active');
        }
    });
});

document.querySelectorAll('.backgomb').forEach(button => {
    button.addEventListener('click', function () {

        let currentStep = document.querySelector('.step.active'); 
        let prevStep = currentStep.previousElementSibling;

        if (prevStep && prevStep.classList.contains('step')) {

            currentStep.classList.remove('active');
            prevStep.classList.add('active');
        }
    });
});

document.getElementById("multiStepForm").addEventListener("submit", function () {
    document.getElementById("loader").style.display = "flex"; 
    document.getElementById("multiStepForm").style.display = "none";
});