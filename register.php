<?php
session_start();

if (isset($_SESSION["email"])) {
    header("Location: profil.php");
    exit();
}

include("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
    $password = trim($_POST["password"]);


    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Email already in use!");
    }
    $stmt->close();

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (felhasznnev, email, jelszo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hash);
    if (!$stmt->execute()) {
        die("Database error: " . $stmt->error);
    }
    $userID = $stmt->insert_id;
    $stmt->close();

    $sex = trim($_POST['sex']);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    $weight = filter_var($_POST['weight'], FILTER_VALIDATE_INT);
    $height = filter_var($_POST['height'], FILTER_VALIDATE_INT);
    $goal = trim($_POST['goal']);
    $bodytype = trim($_POST['bodytype']);

    $currentBodyfatValue = filter_var($_POST['bodyfat-range'], FILTER_VALIDATE_INT);
    $goalBodyfatValue = filter_var($_POST['bodyfat-range2'], FILTER_VALIDATE_INT);
    if ($currentBodyfatValue < 1 || $currentBodyfatValue > 8 || $goalBodyfatValue < 1 || $goalBodyfatValue > 8) {
        die("A testzsír értékeknek 1 és 8 között kell lenniük.");
    }
    $currentBodyfat = $currentBodyfatValue * 5;
    $goalBodyfat = $goalBodyfatValue * 5;

    $workoutFrequency = trim($_POST['workout-frequency']);
    $wantedWorkoutFrequency = filter_var($_POST['wanted-workout-frequency'], FILTER_VALIDATE_INT);
    $wantedWorkoutTime = filter_var($_POST['wanted-workout-time'], FILTER_VALIDATE_INT);
    $workoutPlace = trim($_POST['edzeshelye']);
    $equipment = trim($_POST['felszereltseg']);
    $focusedMuscle = isset($_POST['fokuszaltizomcsoport']) ? implode(', ', $_POST['fokuszaltizomcsoport']) : 'nincs';
    $injured = isset($_POST['injured']) ? implode(', ', $_POST['injured']) : 'nincs';   

    $validGoals = ['Fogyás', 'Izomnövelés', 'Fogyás és izomtömegnövelés', 'Formában tartás', 'Sportólói karrier elkezdése'];
    $validBodytypes = ['Ectomorph', 'Mesomorph', 'Endomorph'];
    $validWorkoutPlaces = ['Konditerem', 'Otthon', 'Hibrid'];
    $validEquipments = ['Maximális felszereltség', 'Korlátozott felszereltség', 'Saját testsúly'];

    if (!in_array($goal, $validGoals) || !in_array($bodytype, $validBodytypes) || !in_array($workoutPlace, $validWorkoutPlaces) || !in_array($equipment, $validEquipments)) {
        die("Invalid input data.");
    }

    $stmt = $conn->prepare("INSERT INTO user_information 
        (user_id, nem, kor, testsuly, magassag, cel, testalkat, jelenlegi_testzsir, cel_testzsir, jelenlegi_edzes_per_het, kivant_edzes_per_het, kivant_edzes_hossza, edzes_helye, felszereltseg, fokuszalt_izomcsoport, serult_testrész)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isiiissiiiiissss", 
        $userID, $sex, $age, $weight, $height, $goal, $bodytype, 
        $currentBodyfat, $goalBodyfat, $workoutFrequency, 
        $wantedWorkoutFrequency, $wantedWorkoutTime, $workoutPlace, 
        $equipment, $focusedMuscle, $injured
    );

    if (!$stmt->execute()) {
        die("Database error: " . $stmt->error);
    }


    $stmt->close();

    $_SESSION["email"] = $email;
    $_SESSION["username"] = $username;

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
                            <input class="form-control" type="text" id="username" name="username" minlength="5"  maxlength="20" required>
                            <p class="error" id="usernameError"></p>

                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <p class="error" id="emailError"></p>

                            <label for="password">Jelszó</label>
                            <div class="password-container">
                                <input class="form-control" type="password" id="password" name="password" minlength="8"  maxlength="15" required>
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox" checked="checked">
                                    <svg id="eyeOpen" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>
                            <p class="error" id="passwordError"></p>

                            <label for="repeat-password">Jelszó megerősítése</label>
                            <div class="password-container">
                                <input class="form-control" type="password" name="repeatpassword" id="repeatpassword"  minlength="8"  maxlength="15" required>
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
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="">Válassz...</option>
                                <option value="Férfi">Férfi</option>
                                <option value="Nő">Nő</option>
                                <option value="Nem kívánom megválaszolni">Nem kívánom megválaszolni</option>
                            </select>
                            <p class="error" id="sexError"></p>

                            <label for="age">Kor:</label>
                            <input class="form-control" min="14" max="100" type="number" id="age" name="age" required>
                            <p class="error" id="ageError"></p>

                            <label for="weight">Testsúly:</label>
                            <input class="form-control" min="40" max="200" type="number" id="weight" name="weight" required>
                            <p class="error" id="weightError"></p>

                            <label for="height">Magasság:</label>
                            <input class="form-control" min="120" max="300" type="number" id="height" name="height" required>
                            <p class="error" id="heightError"></p>

                            <button type="button" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep2()" class="nextgomb">Következő</button>
                        </div>
                    </div>

                    <div class="step">
                        <div id="keret">
                            <label for="goal">Milyen célokat szeretnél elérni?</label>
                            <select class="form-control" id="goal" name="goal" required>
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
                                    <input class="hidden testalkatin" type="radio" id="bodytype-ecto" name="bodytype" value="Ectomorph" required>
                                    <img class="testalkat" id="ectomorph-img" src="" alt="">
                                </label>
                                <label>
                                    <input class="hidden testalkatin" type="radio" id="bodytype-meso" name="bodytype" value="Mesomorph">      
                                    <img class="testalkat" id="mesomorph-img" src="" alt="">
                   
                                </label>
                                <label>
                                    <input class="hidden testalkatin" type="radio" id="bodytype-endo" name="bodytype" value="Endomorph">                        
                                    <img class="testalkat" id="endomorph-img" src="" alt="">
                                </label>
                            </div>
                            <p class="error" id="bodytypeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep4()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Jelenlegi testzsírszázalék</h2>
                            <img id="bodyfat-image" src="img/man-15-bodyfat.jpeg" alt="Testzsíszázalék">
                            <p id="bodyfat-text">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range" name="bodyfat-range" required>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep5()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">                                                                                                                      
                        <div id="keret">
                            <h2>Cél testzsírszázalék</h2>
                            <img id="bodyfat-image2" src="img/man-15-bodyfat.jpeg" alt="Testzsíszázalék" >
                            <p id="bodyfat-text2">15%</p>
                            <input class="form-control" type="range" min="1" max="8" value="3" id="bodyfat-range2" name="bodyfat-range2" required>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep6()" class="nextgomb">Következő</button>
                        </div>
                    </div>
                
                    <div class="step">
                        <div id="keret">
                            <h2>Hányszor edzel egy héten?</h2>    
                            <div class="d-flex flex-column">
                                <label class="workout-card" id="workout-frequency1-label">1-2x hetente 
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency1" value="3x hetente" required>
                                </label>                                                     
                                <label class="workout-card" id="workout-frequency2-label">3x hetente
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency2" value="3x hetente">
                                </label>  
                                <label class="workout-card" id="workout-frequency3-label">Több mint 4x hetente 
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency3" value="Több mint 4x hetente" >
                                </label> 
                                <label class="workout-card" id="workout-frequency4-label">Nem edzek
                                    <input class="hidden" type="radio" name="workout-frequency" id="workout-frequency4" value="Nem edzek">
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
                                <label class="workout-card" id="wanted-workout-frequency1-label">1x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency1" value="1" required>
                                </label>                                                     
                                <label class="workout-card" id="wanted-workout-frequency2-label">2x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency2" value="2">
                                </label>  
                                <label class="workout-card" id="wanted-workout-frequency3-label">3x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency3" value="3">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency4-label">4x hetente
                                    <input class="hidden" type="radio"name="wanted-workout-frequency" id="wanted-workout-frequency4" value="4">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency5-label">5x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency5" value="5">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency6-label">6x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency6" value="6">
                                </label> 
                                <label class="workout-card" id="wanted-workout-frequency7-label">7x hetente
                                    <input class="hidden" type="radio" name="wanted-workout-frequency" id="wanted-workout-frequency7" value="7">
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
                                <label class="workout-card" id="w-time1-label">30 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time1" value="30" required>
                                </label>                                                       
                                <label class="workout-card" id="w-time2-label">45 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time2" value="45">
                                </label>     
                                <label class="workout-card" id="w-time3-label">60 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time3" value="60">
                                </label>     
                                <label class="workout-card" id="w-time4-label">75 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time4" value="75">
                                </label>     
                                <label class="workout-card" id="w-time5-label">90 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time5" value="90">
                                </label>     
                                <label class="workout-card" id="w-time6-label">120 perc
                                    <input class="hidden" type="radio" name="wanted-workout-time" id="wanted-workout-time6" value="120">
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
                            <label class="workout-card" id="place1-label">Konditerem
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace1" value="Konditerem" required>
                            </label>
                            <label class="workout-card" id="place2-label">Otthon
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace2" value="Otthon">
                            </label>
                            <label class="workout-card" id="place3-label">Hibrid
                                <input class="hidden" type="radio" name="edzeshelye" id="workoutplace3" value="Hibrid">
                            </label>
                            <p class="error" id="placeError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep10()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Felszeretlség</h2>
                            <label class="workout-card" id="equipment1-label">Maximális felszereltség
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment1" value="Maximális felszereltség">
                            </label>
                            <label class="workout-card" id="equipment2-label">Korlátozott felszereltség
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment2" value="Korlátozott felszereltség">
                            </label>
                            <label class="workout-card" id="equipment3-label">Saját testsúly
                                <input class="hidden" type="radio" name="felszereltseg" id="equipment3" value="Saját testsúly">
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
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Mell">
                                    <img class="w-25" src="img/fokusz-mell.png" alt="Férfi mell">
                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Hát">
                                    <img class="w-25" src="img/fokusz-hat.png" alt="Férfi hát">
                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Has">
                                    <img class="w-25" src="img/fokusz-has.png" alt="Férfi has">

                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Bicepsz">
                                    <img class="w-25" src="img/fokusz-bicepsz.png" alt="Férfi bicepsz">

                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Tricepsz">
                                    <img class="w-25" src="img/fokusz.tricepsz.png" alt="Férfi tricepsz">

                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Váll">
                                    <img class="w-25" src="img/fokusz-vall.png" alt="Férfi váll">
                                </label>
                                <label>
                                    <input class="hidden" type="checkbox" name="fokuszaltizomcsoport[]" value="Láb">
                                    <img class="w-25" src="img/fokusz-lab.png" alt="Férfi Láb">

                                </label>
                            </div>
                            <p class="error" id="fokuszError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="button" onclick="nextStep12()" class="nextgomb">Következő</button>
                        </div>
                    </div>
            
                    <div class="step">
                        <div id="keret">
                            <h2>Érzékeny testrész</h2>
                            <div class="d-flex flex-column">
                                <label class="workout-card" id="serult1-label">Váll
                                    <input class="hidden" type="checkbox" name="injured[]" value="Váll" id="serult1">
                                </label>
                                <label class="workout-card" id="serult2-label">Könyök
                                    <input class="hidden" type="checkbox" name="injured[]" value="Könyök" id="serult2">
                                </label>
                                <label class="workout-card" id="serult3-label">Csukló
                                    <input class="hidden" type="checkbox" name="injured[]" value="Csukló" id="serult3">
                                </label>
                                <label class="workout-card" id="serult4-label">Alsóhát                                   
                                    <input class="hidden" type="checkbox" name="injured[]" value="Alsóhát" id="serult4">
                                </label>
                                <label class="workout-card" id="serult5-label">Térd
                                    <input class="hidden" type="checkbox" name="injured[]" value="Térd" id="serult5">
                                </label>
                                <label class="workout-card" id="serult6-label">Boka
                                    <input class="hidden" type="checkbox" name="injured[]" value="Boka" id="serult6">
                                </label>
                            </div>
                            <p class="error" id="serultError"></p>
                            <button type="button" onclick="prevStep()" class="backgomb">Vissza</button>
                            <button type="submit" name="register" class="nextgomb">Regisztrálás</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="nextStep.js"></script>
    <script src="showPass.js"></script>
</body>
</html>