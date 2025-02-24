<?php
    session_start();

    if (isset($_SESSION['username'])) {
        header("Location: profil.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Regisztráció</title>
</head>
<body>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["next1"])){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $repeat_password = filter_input(INPUT_POST, "reapeat-password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)){

        }
        elseif (empty($email)){

        }
        elseif (empty($password)){

        }
        elseif ($password != $repeat_password){
            
        }
        else {

        }

    }

    ?>


    <div class="container mt-5">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" id="multiStepForm">
            <div class="container">
                <div class="row">

                    <div class="step active">
                        <div id="keret">
                            <h2>Regisztráció</h2>
                            
                            <label for="username">Felhasználónév</label>
                            <input class="form-control" type="text" id="username" name="username">
                            <p class="error" id="usernameError"></p>

                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email">
                            <p class="error" id="emailError"></p>

                            <label for="password">Jelszó</label>
                            <input class="form-control" type="password" id="password" name="password">
                            <input type="checkbox" onclick="showPass()">Jelszó mutatása
                            <p class="error" id="passwordError"></p>

                            <label for="repeat-password">Jelszó megerősítése</label>
                            <input class="form-control" type="password" name="repeat-password" id="repeat-password">
                            <input type="checkbox" onclick="showRepPass()">Jelszó mutatása
                            <p class="error" id="repeatPasswordError"></p>

                            <button type="button" name="next1" onclick="checkEmail()" class="nextgomb">Következő</button>
                            <p>Van már fiókod? <a href="login.php">Jelentkezz be</a></p>
                        </div>
                    </div>

                    <script>
                            
                            function checkEmail() {
                               
                                let username = document.getElementById("username").value;
                                let email = document.getElementById("email").value;
                                let password = document.getElementById("password").value;
                                let repeatPassword = document.getElementById("repeat-password").value;
                                let error = document.getElementById("emailError");



                                if (username === ""){
                                    document.getElementById("usernameError").style.display = "block";
                                    document.getElementById("usernameError").textContent = "Felhasználónév megadása kötelező!";
                                }
                                else if (username.length < 5){
                                    document.getElementById("usernameError").style.display = "block";
                                    document.getElementById("usernameError").textContent = "Felhasználónévnek minimum 5 karakterből kell állnia!";
                                }
                                else {
                                    document.getElementById("usernameError").style.display = "none";
                                    document.getElementById("usernameError").textContent = "";
                                }
                                
                                let lower = /^(?=.*[a-z])/;
                                let upper = /(?=.*[A-Z])/;
                                let digit = /(?=.*\d)/;
                                let special = /(?=.*[@$!%*?&])/;
                                let long = /[A-Za-z\d@$!%*?&]{8,15}/;
                                
                                let pwdLower = lower.test(password);
                                let pwdUpper = upper.test(password);
                                let pwdDigit = digit.test(password);
                                let pwdSPecial = special.test(password);
                                let pwdLong = long.test(password);

                                if (password === ""){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "Jelszó megadása kötelező!";
                                }
                                else if (!pwdLong){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "A jelszónak 8 és 15 karakter között kell lennie!";
                                }
                                else if (!pwdLower){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell kis karaktert!";
                                }
                                else if (!pwdUpper){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell nagy karaktert!";
                                }
                                else if (!pwdDigit){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell szám karaktert!";
                                }
                                else if (!pwdSPecial){
                                    document.getElementById("passwordError").style.display = "block";
                                    document.getElementById("passwordError").textContent = "A jelszónak tartalmaznia kell speciális karaktert!";
                                }
                                else {
                                    document.getElementById("passwordError").style.display = "none";
                                    document.getElementById("passwordError").textContent = "";
                                }

                                if (repeatPassword !== password){
                                    document.getElementById("repeatPasswordError").style.display = "block";
                                    document.getElementById("repeatPasswordError").textContent = "A jelszavak nem egyeznek!";
                                }
                                else {
                                    document.getElementById("repeatPasswordError").style.display = "none";
                                    document.getElementById("repeatPasswordError").textContent = "";
                                }
                            }
                    </script>

                    <div class="step">
                        <div id="keret">
                            <label for="sex">Nem</label>
                            <select class="form-control" id="sex" name="sex">
                                <option value="">Válassz...</option>
                                <option value="Férfi">Férfi</option>
                                <option value="Nő">Nő</option>
                                <option value="Nem kívánom megválaszolni">Nem kívánom megválaszolni</option>
                            </select>
                            <p class="error" id="sexError"></p>

                            <label for="age">Kor:</label>
                            <input class="form-control" min="14" max="100" type="number" id="age" name="age">
                            <p class="error" id="ageError"></p>

                            <label for="weight">Testsúly:</label>
                            <input class="form-control" min="40" max="200" type="number" id="weight" name="weight">
                            <p class="error" id="weightError"></p>

                            <label for="height">Magasság:</label>
                            <input class="form-control" min="120" max="300" type="number" id="height" name="height">
                            <p class="error" id="heightError"></p>

                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep2()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <script>
                        function nextStep2(){

                            let sex = document.getElementById("sex").value;
                            let age = document.getElementById("age").value;
                            let weight = document.getElementById("weight").value;
                            let height = document.getElementById("height").value;
                        
                            if (sex === ""){
                                document.getElementById("sexError").style.display = "block";
                                document.getElementById("sexError").textContent = "Válassz nemet!";
                            }
                            else {
                                document.getElementById("sexError").style.display = "none";
                                document.getElementById("sexError").textContent = "";
                            }

                            if (age === ""){
                                document.getElementById("ageError").style.display = "block";
                                document.getElementById("ageError").textContent = "Add meg az életkorodat!";
                            }
                            else {
                                document.getElementById("ageError").style.display = "none";
                                document.getElementById("ageError").textContent = "";
                            }

                            if (weight === ""){
                                document.getElementById("weightError").style.display = "block";
                                document.getElementById("weightError").textContent = "Add meg a testsúlyod!";
                            }
                            else if (40 > weight || weight > 150){
                                document.getElementById("weightError").style.display = "block";
                                document.getElementById("weightError").textContent = "40 és 150kg közötti értéket adj meg!";
                            }
                            else {
                                document.getElementById("weightError").style.display = "none";
                                document.getElementById("weightError").textContent = "";
                            }

                            if (height === ""){
                                height.getElementById("heightError").style.display = "block";
                                document.getElementById("heightError").textContent = "Add meg a magasságod!";
                            }
                            else if (120 > height || height > 250) {
                                height.getElementById("heightError").style.display = "block";
                                document.getElementById("heightError").textContent = "120 és 250cm közötti értéket adj meg!";
                            }
                            else {
                                document.getElementById("heightError").style.display = "none";
                                document.getElementById("heightError").textContent = "";
                            }
                        }
                        
                    </script>

                    <div class="step">
                        <div id="keret">
                            <label for="goal">Milyen célokat szeretnél elérni?</label>
                            <select class="form-control" id="goal" name="goal">
                                <option value="">Válassz...</option>
                                <option value="Fogyás">Fogyás</option>
                                <option value="Izomnövelés">Izomnövelés</option>
                                <option value="Fogyás és izomtömegnövelés">Fogyás és izomtömegnövelés</option>
                                <option value="Formában tartás">Formában tartás</option>
                                <option value="Sportólói karrier elkezdése">Sportólói karrier elkezdése</option>
                            </select>
                            <p class="error" id="goalError"></p>

                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <div class="step">
                        <h2>Jelenlegi testalkat</h2>
                        <div class="d-flex">
                            <label>
                                <img id="ectomorph-img" src="img/ectomorph-ferfi.png" alt="Mezmorf férfi">
                                <input class="hidden" type="radio" id="bodytype-ecto" name="bodytype"></input>
                            </label>
                            <label>
                                <img id="mesomoph-img" src="img/mesomorph-ferfi.png" alt="Mezmorf férfi">
                                <input class="hidden" type="radio" id="bodytype-meso" name="bodytype"></input>                            
                            </label>
                            <label>
                                <img id="endomorph-img" src="img/endomorph-ferfi.png" alt="Mezomorf férfi">
                                <input class="hidden" type="radio" id="bodytype-endo" name="bodytype"></input>                           
                            </label>
                        </div>
                        <p class="error" id="bodytypeError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Jelenlegi testzsírszázalék</h2>
                        <img id="bodyfat-image" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék">
                        <p id="bodyfat-text">15%</p>
                        <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range" name="bodyfat-range"></input>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Cél testzsírszázalék</h2>
                        <img id="bodyfat-image2" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék">
                        <p id="bodyfat-text2">15%</p>
                        <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range2" name="bodyfat-range2"></input>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Hányszor edzel egy héten?</h2>    
                        <div class="d-flex flex-column">
                            <label class="workout-card">1-2x hetente 
                                <input type="radio" name="workout-frequency" id="workout-frequency1"></input>
                            </label>                                                     
                            <label class="workout-card">3x hetente
                                <input type="radio" name="workout-frequency" id="workout-frequency2">
                            </label>  
                            <label class="workout-card">Több mint 4x hetente 
                                <input type="radio" name="workout-frequency" id="workout-frequency3">
                            </label> 
                            <label class="workout-card">Nem edzek
                                <input type="radio" name="workout-frequency" id="workout-frequency4">
                            </label>  
                        </div>   
                        <p class="error" id="workoutError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Hány alkalommal szeretnél edzeni?</h2>                                             
                        <div class="d-flex flex-column">
                            <label class="workout-card">1x hetente
                                <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency1"></input>
                            </label>                                                     
                            <label class="workout-card">2x hetente
                                <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency2"></input>
                            </label>  
                            <label class="workout-card">3x hetente
                                <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency3"></input>
                            </label> 
                            <label class="workout-card">4x hetente
                                <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency4"></input>
                            </label> 
                            <label class="workout-card">5x hetente
                                <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency5"></input>
                            </label> 
                            <label class="workout-card">6x hetente
                                <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency6"></input>
                            </label> 
                            <label class="workout-card">7x hetente
                                <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency7"></input>
                            </label> 
                        </div>   
                        <p class="error" id="wantedWorkoutError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>  
                
                    <div class="step">
                        <h2>Hány percig szeretnél edzeni?</h2>                                             
                        <div class="d-flex flex-column">
                            <label class="workout-card">30 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time1"></input>
                            </label>                                                     
                            <label class="workout-card">45 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time2"></input>
                            </label>     
                            <label class="workout-card">60 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time3"></input>
                            </label>     
                            <label class="workout-card">75 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time4"></input>
                            </label>     
                            <label class="workout-card">90 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time5"></input>
                            </label>     
                            <label class="workout-card">120 perc
                                <input type="radio" name="wanted-workout-time" id="wanted-workout-time6"></input>
                            </label>     
                        </div>   
                        <p class="error" id="wantedTimeError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>  
            
                    <div class="step">
                            <h2>Hol edzel?</h2>
                            <label class="workout-card">Konditerem
                                <input type="radio" name="edzeshelye"></input>
                            </label>
                            <label class="workout-card">Otthon
                                <input type="radio" name="edzeshelye"></input>
                            </label>
                            <label class="workout-card">Hibrid
                                <input type="radio" name="edzeshelye"></input>
                            </label>
                            <p class="error" id="placeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
            
                    <div class="step">
                        <h2>Felszeretlség</h2>
                        <label class="workout-card">Maximális felszereltség
                            <input type="radio" name="felszereltseg"></input>
                        </label>
                        <label class="workout-card">Korlátozott felszereltség
                            <input type="radio" name="felszereltseg"></input>
                        </label>
                        <label class="workout-card">Saját testsúly
                            <input type="radio" name="felszereltseg"></input>
                        </label>
                        <p class="error" id="felszereltsegError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Fókuszált izomcsoport</h2>
                        <div class="d-flex flex-column">
                            <label>
                                <img class="w-25" src="img/ferfi-mell.png" alt="Férfi mell">
                                <input type="radio" name="fokuszaltizomcsoport"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/ferfi-hat.png" alt="Férfi hát">
                                <input type="radio" name="fokuszaltizomcsoport"></input>
                                </label>
                            <label>
                                <img class="w-25" src="img/ferfi-has.png" alt="Férfi has">
                                <input type="radio" name="fokuszaltizomcsoport"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/ferfi-bicepsz.png" alt="Férfi bicepsz">
                                <input type="radio" name="fokuszaltizomcsoport"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/ferfi-vall.png" alt="Férfi váll">
                                <input type="radio" name="fokuszaltizomcsoport"></input>
                            </label>
                        </div>
                        <p class="error" id="fokuszError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" class="nextgomb">Következő</button>
                    </div>
            
                    <div class="step">
                        <h2>Sérült testrész</h2>
                        <div class="d-flex flex-column">
                            <label>
                                <img class="w-25" src="img/vall.png" alt="Váll">
                                <input type="radio"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/konyok.png" alt="Könyök">
                                <input type="radio"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/csuklo.png" alt="Csukló">
                                <input type="radio"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/alsohat-png" alt="Alsó hát">
                                <input type="radio"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/terd-png" alt="Térd">
                                <input type="radio"></input>
                            </label>
                            <label>
                                <img class="w-25" src="img/boka-png" alt="Boka">
                                <input type="radio"></input>
                            </label>
                        </div>
                        <p class="error" id="serultError"></p>
                        <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                        <button type="submit" class="nextgomb">Regisztrálás</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

        <script>
            function showPass() {
                let showPass = document.getElementById("password");

                if (showPass.type === "password") {
                    showPass.type = "text";
                } else {
                    showPass.type = "password";
                }
            }

            function showRepPass() {
                let showRepPass = document.getElementById("repeat-password");

                if (showRepPass.type === "password") {
                    showRepPass.type = "text";
                } else {
                    showRepPass.type = "password";
                }
            }
        </script>

        <script>

            const rangeInput = document.getElementById('bodyfat-range');
            const image = document.getElementById('bodyfat-image');
            const valueText = document.getElementById('bodyfat-text');

            const rangeInput2 = document.getElementById('bodyfat-range2');
            const image2 = document.getElementById('bodyfat-image2');
            const valueText2 = document.getElementById('bodyfat-text2');

            rangeInput.addEventListener('input', function() {
                const value = rangeInput.value * 5;
                valueText.textContent = value + "%";
                image.src = `img/ferfi-testzsir-${value}.jpg`;
            });

            rangeInput2.addEventListener('input', function() {
                const value = rangeInput2.value * 5;
                valueText2.textContent = value + "%";
                image2.src = `img/ferfi-testzsir-${value}.jpg`;
            });

        </script>
</body>
</html>