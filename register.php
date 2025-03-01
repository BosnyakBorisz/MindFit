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
                            <div class="password-container">
                                <input class="form-control" type="password" id="password" name="password">
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox" checked="checked">
                                    <svg id="eyeOpen" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>
                            <p class="error" id="passwordError"></p>

                            <label for="repeat-password">Jelszó megerősítése</label>
                            <div class="password-container">
                                <input class="form-control" type="password" name="repeat-password" id="repeat-password">
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox2" checked="checked">
                                    <svg id="eyeOpen2" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed2" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>

                            <p class="error" id="repeatPasswordError"></p>

                            <button type="button" name="next1" onclick="nextStep1()" class="nextgomb">Következő</button>
                            <p>Van már fiókod? <a href="login.php">Jelentkezz be</a></p>
                        </div>  
                    </div>
                
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

                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep2()" class="nextgomb">Következő</button>
                        </div>
                    </div>

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

                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep3()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <div class="step">
                        <div id="keret">
                            <h2>Jelenlegi testalkat</h2>
                            <div class="d-flex">
                                <label>
                                    <img id="ectomorph-img" src="img/ectomorph-ferfi.png" alt="Mezmorf férfi">
                                    <input class="hidden" type="radio" id="bodytype-ecto" name="bodytype" value="Ectomorph"></input>
                                </label>
                                <label>
                                    <img id="mesomoph-img" src="img/mesomorph-ferfi.png" alt="Mezmorf férfi">
                                    <input class="hidden" type="radio" id="bodytype-meso" name="bodytype" value="Mesomorph"></input>                            
                                </label>
                                <label>
                                    <img id="endomorph-img" src="img/endomorph-ferfi.png" alt="Mezomorf férfi">
                                    <input class="hidden" type="radio" id="bodytype-endo" name="bodytype" value="Endomorph"></input>                           
                                </label>
                            </div>
                            <p class="error" id="bodytypeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep4()" class="nextgomb">Következő</button>
                        <</div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Jelenlegi testzsírszázalék</h2>
                            <img id="bodyfat-image" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék">
                            <p id="bodyfat-text">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range" name="bodyfat-range"></input>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep5()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">                                                                                                                      
                        <div id="keret">
                            <h2>Cél testzsírszázalék</h2>
                            <img id="bodyfat-image2" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék" >
                            <p id="bodyfat-text2">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range2" name="bodyfat-range2"></input>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep6()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Hányszor edzel egy héten?</h2>    
                            <div class="d-flex flex-column">
                                <label class="workout-card">1-2x hetente 
                                    <input type="radio" name="workout-frequency" id="workout-frequency2" value="3x hetente">
                                </label>                                                     
                                <label class="workout-card">3x hetente
                                    <input type="radio" name="workout-frequency" id="workout-frequency2" value="3x hetente">
                                </label>  
                                <label class="workout-card">Több mint 4x hetente 
                                    <input type="radio" name="workout-frequency" id="workout-frequency3" value="Több mint 4x hetente ">
                                </label> 
                                <label class="workout-card">Nem edzek
                                    <input type="radio" name="workout-frequency" id="workout-frequency4" value="Nem edzek">
                                </label>  
                            </div>   
                            <p class="error" id="workoutError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep7()" class="nextgomb">Következő</button>
                        </div>  
                    </div>

                    <div class="step">
                        <div id="keret">
                            <h2>Hány alkalommal szeretnél edzeni?</h2>                                             
                            <div class="d-flex flex-column">
                                <label class="workout-card">1x hetente
                                    <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency1" value="1"></input>
                                </label>                                                     
                                <label class="workout-card">2x hetente
                                    <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency2" value="2"></input>
                                </label>  
                                <label class="workout-card">3x hetente
                                    <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency3" value="3"></input>
                                </label> 
                                <label class="workout-card">4x hetente
                                    <input type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency4" value="4"></input>
                                </label> 
                                <label class="workout-card">5x hetente
                                    <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency5" value="5"></input>
                                </label> 
                                <label class="workout-card">6x hetente
                                    <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency6" value="6"></input>
                                </label> 
                                <label class="workout-card">7x hetente
                                    <input type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency7" value="7"></input>
                                </label> 
                            </div>   
                            <p class="error" id="wantedWorkoutError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep8()" class="nextgomb">Következő</button>
                        </div>  
                    </div> 
                
                    <div class="step">
                        <div id="keret">
                            <h2>Hány percig szeretnél edzeni?</h2>                                             
                            <div class="d-flex flex-column">
                                <label class="workout-card">30 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time1" value="30"></input>
                                </label>                                                       
                                <label class="workout-card">45 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time2" value="45"></input>
                                </label>     
                                <label class="workout-card">60 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time3" value="60"></input>
                                </label>     
                                <label class="workout-card">75 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time4" value="75"></input>
                                </label>     
                                <label class="workout-card">90 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time5" value="90"></input>
                                </label>     
                                <label class="workout-card">120 perc
                                    <input type="radio" name="wanted-workout-time" id="wanted-workout-time6" value="120"></input>
                                </label>     
                            </div>   
                            <p class="error" id="wantedTimeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep9()" class="nextgomb">Következő</button>
                        </div>
                    </div>  

                    <div class="step">
                        <div id="keret">
                            <h2>Hol edzel?</h2>
                            <label class="workout-card">Konditerem
                                <input type="radio" name="edzeshelye" id="workoutplace1" value="Konditerem"></input>
                            </label>
                            <label class="workout-card">Otthon
                                <input type="radio" name="edzeshelye" id="workoutplace2" value="Otthon"></input>
                            </label>
                            <label class="workout-card">Hibrid
                                <input type="radio" name="edzeshelye" id="workoutplace3" value="Hibrid"></input>
                            </label>
                            <p class="error" id="placeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep10()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Felszeretlség</h2>
                            <label class="workout-card">Maximális felszereltség
                                <input type="radio" name="felszereltseg" id="equipment1" value="Maximális felszereltség"></input>
                            </label>
                            <label class="workout-card">Korlátozott felszereltség
                                <input type="radio" name="felszereltseg" id="equipment2" value="Korlátozott felszereltség"></input>
                            </label>
                            <label class="workout-card">Saját testsúly
                                <input type="radio" name="felszereltseg" id="equipment3" value="Saját testsúly"></input>
                            </label>
                            <p class="error" id="felszereltsegError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep11()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Fókuszált izomcsoport</h2>
                            <div class="d-flex flex-column">
                                <label>
                                    <img class="w-25" src="img/ferfi-mell.png" alt="Férfi mell">
                                    <input type="checkbox" name="fokuszaltizomcsoport" value="Mell"></input>
                                </label>
                                <label>
                                    <img class="w-25" src="img/ferfi-hat.png" alt="Férfi hát">
                                    <input type="checkbox" name="fokuszaltizomcsoport" value="Hát"></input>
                                </label>
                                <label>
                                    <img class="w-25" src="img/ferfi-has.png" alt="Férfi has">
                                    <input type="checkbox" name="fokuszaltizomcsoport" value="Has"></input>
                                </label>
                                <label>
                                    <img class="w-25" src="img/ferfi-bicepsz.png" alt="Férfi bicepsz">
                                    <input type="checkbox" name="fokuszaltizomcsoport" value="Bicepsz"></input>
                                </label>
                                <label>
                                    <img class="w-25" src="img/ferfi-vall.png" alt="Férfi váll">
                                    <input type="checkbox" name="fokuszaltizomcsoport" value="Váll"></input>
                                </label>
                            </div>
                            <p class="error" id="fokuszError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep12()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Sérült testrész</h2>
                            <div class="d-flex flex-column">
                                <label>
                                    <img class="st_kep" src="img/váll.jpg" alt="Váll">
                                    <input type="checkbox" name="injured" value="Váll"></input>
                                </label>
                                <label>
                                    <img class="st_kep" src="img/konyok.jpg" alt="Könyök">
                                    <input type="checkbox" name="injured" value="Könyök"></input>
                                </label>
                                <label>
                                    <img class="st_kep" src="img/csuklo.jpg" alt="Csukló">
                                    <input type="checkbox" name="injured" value="Csukló"></input>
                                </label>
                                <label>
                                    <img class="st_kep" src="img/alsóháti.jpg" alt="Alsóhát">
                                    <input type="checkbox" name="injured" value="Alsóhát"></input>
                                </label>
                                <label>
                                    <img class="st_kep" src="img/terd.jpg" alt="Térd">
                                    <input type="checkbox" name="injured" value="Térd"></input>
                                </label>
                                <label>
                                    <img class="st_kep" src="img/boka.jpg" alt="Boka">
                                    <input type="checkbox" name="injured" value="Boka"></input>
                                </label>
                            </div>
                            <p class="error" id="serultError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="submit" class="nextgomb">Regisztrálás</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php

        include("database.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS));
            $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
            $password = trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));            
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $sql1 = "INSERT INTO `users`( `felhasznnev`, `email`, `jelszo`) VALUES ('$username', '$email', '$hash')";

            try {
                mysqli_query($conn, $sql1);
            }
            catch (mysqli_sql_exception) {
                
            }

            $sql2 = "SELECT `id` FROM `users` WHERE `email` LIKE '$email'";

            try {
                $result = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $userID = $row["id"];

                    $sex = trim(filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
                    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_INT);
                    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);
                    $goal = trim(filter_input(INPUT_POST, 'goal', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $bodytype = filter_input(INPUT_POST, 'bodytype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $currentBodyfat = filter_input(INPUT_POST, 'bodyfat-range', FILTER_SANITIZE_NUMBER_INT);
                    $goalBodyfat = filter_input(INPUT_POST, 'bodyfat-range2', FILTER_SANITIZE_NUMBER_INT);
                    $workoutFrequency = filter_input(INPUT_POST, 'workout-frequency', FILTER_SANITIZE_SPECIAL_CHARS);
                    $wantedWorkoutFrequency = filter_input(INPUT_POST, 'wanted-workout-frequency', FILTER_SANITIZE_NUMBER_INT);
                    $wantedWorkoutTime = filter_input(INPUT_POST, 'wanted-workout-time', FILTER_SANITIZE_NUMBER_INT);
                    $workoutPlace = filter_input(INPUT_POST, 'edzeshelye', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $equipment = filter_input(INPUT_POST, 'felszereltseg', FILTER_SANITIZE_SPECIAL_CHARS);
                    $focusedMuscle = filter_input(INPUT_POST, 'fokuszaltizomcsoport', FILTER_SANITIZE_SPECIAL_CHARS);
                    $injured = filter_input(INPUT_POST, 'injured', FILTER_SANITIZE_SPECIAL_CHARS);

                    $sql3 = "INSERT INTO `user_information` (`user_id`, `nem`, `kor`, `testsuly`, `magassag`, `cel`, `testalkat`, `jelenlegi_testzsir`, `cel_testzsir`, `jelenlegi_edzes_per_het`, `kivant_edzes_per_het`, `kivant_edzes_hossza`, `edzes_helye`, `felszereltseg`, `fokuszalt_izomcsoport`, `serult_testrész`) VALUES ('$userID','$sex','$age','$weight','$height','$goal','$bodytype','$currentBodyfat','$goalBodyfat','$workoutFrequency','$wantedWorkoutFrequency','$wantedWorkoutTime','$workoutPlace','$equipment','$focusedMuscle','$injured')";
        
                    try {
                        mysqli_query($conn, $sql3);
                    }
                    catch (mysqli_sql_exception) {
                        
                    }
                }
            }
            catch (mysqli_sql_exception) {
                
            }


        }

    ?>

    <script src="nextStep.js"></script>

    <script>

        document.querySelectorAll('.nextgomb').forEach(button => {
            button.addEventListener('click', function () {

                let currentStep = document.querySelector('.step.active');
                
                let valid = false;

                if (currentStep.classList.contains('active')) {
                    if (currentStep === document.querySelector('.step:nth-child(1)')) {
                        valid = nextStep1();
                        console.log(valid)
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

                if (valid) {
                    currentStep.classList.remove('active');
                    let nextStep = currentStep.nextElementSibling;
                    if (nextStep && nextStep.classList.contains('step')) {
                        nextStep.classList.add('active');
                        valid = false;
                    }
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


    </script>

    <script>

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

            let rpasswordField = document.getElementById("repeat-password");
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