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
                    <div class="step">
                        <div id="keret">
                            <h2>Regisztráció</h2>
                            <label for="username">Felhasználónév</label>
                            <input class="form-control" type="text" id="username" name="username">
                            <span></span>
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email">
                            <span></span>
                            <label for="password">Jelszó</label>
                            <input class="form-control" type="password" id="password" name="password">
                            <span></span>
                            <label for="repeat-password">Jelszó megerősítése</label>
                            <input class="form-control" type="password" name="repeat-password" id="repeat-password">
                            <span></span>
                            <button type="submit" name="next1" onclick="nextStep()" id="nextgomb">Következő</button>
                            <p>Van már fiókod? <a href="login.php">Jelentkezz be</a></p>
                        </div>
                    </div>
              
                    <div class="step">
                        <div id="keret">
                            <label for="sex">Nem</label>
                            <select class="form-control" id="sex" name="sex">
                                <option value="Férfi">Férfi</option>
                                <option value="Nő">Nő</option>
                                <option value="Nem kívánom megválaszolni">Nem kívánom megválaszolni</option>
                            </select>
                            <label for="age">Kor:</label>
                            <input class="form-control" min="14" max="100" type="number" id="age" name="age">
                            <label for="weight">Testsúly:</label>
                            <input class="form-control" min="45" max="200" type="number" id="weight" name="weight">
                            <label for="height" min="120" max="300" >Magasság:</label>
                            <input class="form-control" type="number" id="height" name="height" >
                            <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                            <button type="submit" name="next2" onclick="nextStep()" id="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <label for="goal">Milyen célokat szeretnél elérni?</label>
                            <select class="form-control" id="goal" name="goal" >
                                <option>Fogyás</option>
                                <option>Izomnövelés</option>
                                <option>Fogyás és izomtömegnövelés</option>
                                <option>Formában tartás</option>
                                <option>Sportólói karrier elkezdése</option>
                            </select>
                            <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Jelenlegi testzsírszázalék</h2>
                        <img id="bodyfat-image" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék">
                        <p id="bodyfat-text">15%</p>
                        <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range" name="bodyfat-range"></input>
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
                    </div>
                
                    <div class="step">
                        <h2>Cél testzsírszázalék</h2>
                        <img id="bodyfat-image2" src="img/ferfi-testzsir-15.jpg" alt="Testzsíszázalék">
                        <p id="bodyfat-text2">15%</p>
                        <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range2" name="bodyfat-range2"></input>
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                            <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
                    </div>
            
                    <div class="step">
                        <h2>Felszeretlség</h2>
                        <label class="workout-card">Maximális felszereltség
                            <input type="radio" name="edzeshelye"></input>
                        </label>
                        <label class="workout-card">Korlátozott felszereltség
                            <input type="radio" name="edzeshelye"></input>
                        </label>
                        <label class="workout-card">Saját testsúly
                            <input type="radio" name="edzeshelye"></input>
                        </label>
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="button" onclick="nextStep()" id="nextgomb">Következő</button>
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
                        <button type="button" onclick="prevStep()" id="backgomb">Vissza</button>
                        <button type="submit" id="nextgomb">Regisztrálás</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

        
        <script>
            let currentStep = 0;
            const steps = document.querySelectorAll(".step");

            

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