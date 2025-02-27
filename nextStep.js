
function nextStep1() {

    let valid = true;

    let username = document.getElementById("username").value;

    if (username === ""){
        document.getElementById("usernameError").style.display = "block";
        document.getElementById("usernameError").textContent = "Felhasználónév megadása kötelező!";
        valid = false;
    }
    else if (username.length < 5){
        document.getElementById("usernameError").style.display = "block";
        document.getElementById("usernameError").textContent = "Felhasználónévnek minimum 5 karakterből kell állnia!";
        valid = false;
    }
    else {
        document.getElementById("usernameError").style.display = "none";
        document.getElementById("usernameError").textContent = "";
    }


    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");

    if (email === "") {
        error.style.display = "block";
        error.textContent = "Email megadása kötelező!";
        valid = false;
    }
    else {
        error.style.display = "none";
        error.textContent = "";
    }
   
    let password = document.getElementById("password").value;
    let repeatPassword = document.getElementById("repeat-password").value;
    
    let lower = /^(?=.*[a-z])/;
    let upper = /(?=.*[A-Z])/;
    let digit = /(?=.*\d)/;
    let special = /(?=.*[@$!%*?&])/;
    
    let pwdLower = lower.test(password);
    let pwdUpper = upper.test(password);
    let pwdDigit = digit.test(password);
    let pwdSPecial = special.test(password);

    console.log(password);
    console.log(password.length);
    if (password === ""){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "Jelszó megadása kötelező!";
        valid = false;
    }
    else if (8 > password.length || password.length > 15){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "A jelszónak 8 és 15 karakter között kell lennie!";
        valid = false;
    }
    else if (!pwdLower){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell kis karaktert!";
        valid = false;
    }
    else if (!pwdUpper){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell nagy karaktert!";
        valid = false;
    }
    else if (!pwdDigit){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell szám karaktert!";
        valid = false;
    }
    else if (!pwdSPecial){
        document.getElementById("passwordError").style.display = "block";
        document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell speciális karaktert!";
        valid = false;
    }
    else {
        document.getElementById("passwordError").style.display = "none";
        document.getElementById("passwordError").textContent = "";
    }

    if (repeatPassword !== password){
        document.getElementById("repeatPasswordError").style.display = "block";
        document.getElementById("repeatPasswordError").textContent = "A jelszavak nem egyeznek!";
        valid = false;
    }
    else {
        document.getElementById("repeatPasswordError").style.display = "none";
        document.getElementById("repeatPasswordError").textContent = "";
    }
    return valid;
}

function nextStep2(){

    let valid = true;

    let sex = document.getElementById("sex").value;
    let age = document.getElementById("age").value;
    let weight = document.getElementById("weight").value;
    let height = document.getElementById("height").value;

    if (sex === ""){
        document.getElementById("sexError").style.display = "block";
        document.getElementById("sexError").textContent = "Válassz nemet!";
        valid = false;
    }
    else {
        document.getElementById("sexError").style.display = "none";
        document.getElementById("sexError").textContent = "";
    }

    if (age === ""){
        document.getElementById("ageError").style.display = "block";
        document.getElementById("ageError").textContent = "Add meg az életkorodat!";
        valid = false;
    }
    else if( 14 > age || age > 100){
        document.getElementById("ageError").style.display = "block";
        document.getElementById("ageError").textContent = "14 és 100 év közötti értéket adj meg!";
        valid = false;
    }
    else {
        document.getElementById("ageError").style.display = "none";
        document.getElementById("ageError").textContent = "";
    }

    if (weight === ""){
        document.getElementById("weightError").style.display = "block";
        document.getElementById("weightError").textContent = "Add meg a testsúlyod!";
        valid = false;
    }
    else if (40 > weight || weight > 150){
        document.getElementById("weightError").style.display = "block";
        document.getElementById("weightError").textContent = "40 és 150kg közötti értéket adj meg!";
        valid = false;
    }
    else {
        document.getElementById("weightError").style.display = "none";
        document.getElementById("weightError").textContent = "";
    }

    if (height === ""){
        document.getElementById("heightError").style.display = "block";
        document.getElementById("heightError").textContent = "Add meg a magasságod!";
        valid = false;
    }
    else if (120 > height || height > 250) {
        document.getElementById("heightError").style.display = "block";
        document.getElementById("heightError").textContent = "120 és 250cm közötti értéket adj meg!";
        valid = false;
    }
    else {
        document.getElementById("heightError").style.display = "none";
        document.getElementById("heightError").textContent = "";
    }
    return valid;
}

function nextStep3() {
    let valid = true;

    let goal =  document.getElementById("goal").value;

    if (goal === ""){
        document.getElementById("goalError").style.display = "block";
        document.getElementById("goalError").textContent = "Válassz célt!";
        valid = false;
    }
    else {
        document.getElementById("goalError").style.display = "none";
        document.getElementById("goalError").textContent = "";
    }
    return valid;
}

function nextStep4() {

    let valid = true;

    const ectoRadio = document.getElementById('bodytype-ecto');
    const mesoRadio = document.getElementById('bodytype-meso');
    const endoRadio = document.getElementById('bodytype-endo');

    if (!ectoRadio.checked && !mesoRadio.checked && !endoRadio.checked) {
        document.getElementById("bodytypeError").style.display = "block";
        document.getElementById("bodytypeError").textContent = "Válassz testalkatot!";
        valid = false;
    }
    else {
        document.getElementById("bodytypeError").style.display = "none";
        document.getElementById("bodytypeError").textContent = "";
    }
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

    const freq1 = document.getElementById('workout-frequency1');
    const freq2 = document.getElementById('workout-frequency2');
    const freq3 = document.getElementById('workout-frequency3');
    const freq4 = document.getElementById('workout-frequency4');


    if (!freq1.checked && !freq2.checked && !freq3.checked && !freq4.checked) {
        document.getElementById("workoutError").style.display = "block";
        document.getElementById("workoutError").textContent = "Válassz egy értéket!";
        valid = false;
    }
    else {
        document.getElementById("workoutError").style.display = "none";
        document.getElementById("workoutError").textContent = "";
    }
    return valid;
}

function nextStep8() {

    let valid = true;

    const freq1 = document.getElementById('wanted-workout-frequency1');
    const freq2 = document.getElementById('wanted-workout-frequency2');
    const freq3 = document.getElementById('wanted-workout-frequency3');
    const freq4 = document.getElementById('wanted-workout-frequency4');
    const freq5 = document.getElementById('wanted-workout-frequency5');
    const freq6 = document.getElementById('wanted-workout-frequency6');
    const freq7 = document.getElementById('wanted-workout-frequency7');


    if (!freq1.checked && !freq2.checked && !freq3.checked && !freq4.checked && !freq5.checked && !freq6.checked && !freq7.checked) {
        document.getElementById("wantedWorkoutError").style.display = "block";
        document.getElementById("wantedWorkoutError").textContent = "Válassz egy értéket!";
        valid = false;
    }
    else {
        document.getElementById("wantedWorkoutError").style.display = "none";
        document.getElementById("wantedWorkoutError").textContent = "";
    }
    return valid;
}

function nextStep9() {

    let valid = true;

    const freq1 = document.getElementById('wanted-workout-time1');
    const freq2 = document.getElementById('wanted-workout-time2');
    const freq3 = document.getElementById('wanted-workout-time3');
    const freq4 = document.getElementById('wanted-workout-time4');
    const freq5 = document.getElementById('wanted-workout-time5');
    const freq6 = document.getElementById('wanted-workout-time6');


    if (!freq1.checked && !freq2.checked && !freq3.checked && !freq4.checked && !freq5.checked && !freq6.checked) {
        document.getElementById("wantedTimeError").style.display = "block";
        document.getElementById("wantedTimeError").textContent = "Válassz egy értéket!";
        valid = false;
    }
    else {
        document.getElementById("wantedTimeError").style.display = "none";
        document.getElementById("wantedTimeError").textContent = "";
    }
    return valid;
}

function nextStep10() {

    let valid = true;

    const place1 = document.getElementById('workoutplace1');
    const place2 = document.getElementById('workoutplace2');
    const place3 = document.getElementById('workoutplace3');

    if (!place1.checked && !place2.checked && !place3.checked) {
        document.getElementById("placeError").style.display = "block";
        document.getElementById("placeError").textContent = "Válassz egy értéket!";
        valid = false;
    }
    else {
        document.getElementById("placeError").style.display = "none";
        document.getElementById("placeError").textContent = "";
    }
    return valid;
}

function nextStep11() {

    let valid = true;

    const time1 = document.getElementById('equipment1');
    const time2 = document.getElementById('equipment2');
    const time3 = document.getElementById('equipment3');



    if (!time1.checked && !time2.checked && !time3.checked) {
        document.getElementById("felszereltsegError").style.display = "block";
        document.getElementById("felszereltsegError").textContent = "Válassz egy értéket!";
        valid = false;
    }
    else {
        document.getElementById("felszereltsegError").style.display = "none";
        document.getElementById("felszereltsegError").textContent = "";
    }
    return valid;
}

function nextStep12() {
    let valid = true;
    return valid;
}