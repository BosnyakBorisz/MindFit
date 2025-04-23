<?php

    session_start();

    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];

    include("database.php");

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        session_destroy();
    } 

    $sql = "SELECT *
            FROM users 
            JOIN user_information ON user_information.user_id = users.id 
            WHERE users.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    $user_id = $user["user_id"];
    $serult_testrész_array = explode(',', $user['serult_testrész']);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["felhasznSubmit"])) {
            $username = trim(($_POST['username']));
            $new_email = trim(($_POST['email']));

            if ($username !== $user['felhasznnev'] || $new_email !== $user['email']) {
                $sql = "UPDATE users SET felhasznnev = ?, email = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $username, $new_email, $user_id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['email'] = $new_email;
                header("Location: beallitasok.php"); 
                exit();
                
            }
        }
        elseif (isset($_POST["jelszoSubmit"])) {
            if (!empty($_POST['password']) && !empty($_POST['repeatpassword'])) {
                $password = $_POST['password'];
                $repeatPassword = $_POST['repeatpassword'];
        
                if ($password === $repeatPassword && !password_verify($password, $user['jelszo'])) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET jelszo = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $hashedPassword, $user_id);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: beallitasok.php"); 
                    exit();
                }
            }
        } 
        elseif (isset($_POST["informationSubmit"])) {
            // Get input values
            $kor = intval($_POST["kor"]);
            $testsuly = floatval($_POST["testsuly"]);
            $magassag = floatval($_POST["magassag"]);
            $cel = trim($_POST["cel"]);
            $jelenlegi_testzsir = intval($_POST["jelenlegi_testzsir"]);
            $cel_testzsir = intval($_POST["cel_testzsir"]);
            $kivant_edzes_per_het = intval($_POST["kivant_edzes_per_het"]);
            $kivant_edzes_hossza = intval($_POST["kivant_edzes_hossza"]);
            $edzes_helye = trim($_POST["edzes_helye"]);
            $felszereltseg = trim($_POST["felszereltseg"]);
            $fokuszalt_izomcsoport = trim($_POST["fokuszalt_izomcsoport"]);
            $serult_testrész = trim($_POST["serult_testrész"]);

            $sql = "UPDATE user_information SET 
                        kor = ?, 
                        testsuly = ?, 
                        magassag = ?, 
                        cel = ?, 
                        jelenlegi_testzsir = ?, 
                        cel_testzsir = ?, 
                        kivant_edzes_per_het = ?, 
                        kivant_edzes_hossza = ?, 
                        edzes_helye = ?, 
                        felszereltseg = ?, 
                        fokuszalt_izomcsoport = ?, 
                        serult_testrész = ?
                    WHERE user_id = ?";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "iddsiiiissssi",
                $kor, $testsuly, $magassag, $cel, $jelenlegi_testzsir, $cel_testzsir,
                $kivant_edzes_per_het, $kivant_edzes_hossza, $edzes_helye, $felszereltseg, 
                $fokuszalt_izomcsoport, $serult_testrész, $user_id
            );
            $stmt->execute();
            $stmt->close();
            header("Location: beallitasok.php"); 
            exit();
        }
        
        
    }
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/strong.png"></link:icon>
    <title>Profil</title>

</head>
<body>

    <header>
        <?php
            include("header.html")
        ?>
    </header>

    <main>
 
    <h2>Fiók beállítások</h2>

        <div class="d-flex flex-column mx-auto" style="width: 500px;">

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

                    <label for="username">Felhasználónév</label>
                    <input class="form-control" type="text" name="username" minlength="5"  maxlength="20" value="<?php echo $user['felhasznnev']; ?>" required>

                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" value="<?php echo $user['email']; ?>" required>

                    <button type="submit" class="nextgomb" name="felhasznSubmit">Módosítások mentése</button>

            </form>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

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

                    <label for="repeat-password">Új jelszó megerősítése</label>
                    <div class="password-container">
                        <input class="form-control" type="password" name="repeatpassword" id="repeatpassword"  minlength="8"  maxlength="15" required>
                        <label class="container-szem">
                            <input type="checkbox" id="togglePasswordCheckbox2" checked="checked">
                            <svg id="eyeOpen2" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                            <svg id="eyeClosed2" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                        </label>
                    </div>

                <button type="submit" class="nextgomb" name="jelszoSubmit">Módosítások mentése</button>

            </form>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

                <label for="kor">Kor</label>
                <input class="form-control" type="number" name="kor" min="14" max="100" value="<?php echo $user['kor']; ?>" required >

                <label for="testsuly">Testsúly</label>
                <input class="form-control" type="number" name="testsuly" min="40" max="200" value="<?php echo $user['testsuly']; ?>" step="any"  required>

                <label for="magassag">Magasság</label>
                <input class="form-control" type="number" name="magassag" min="120" max="250" value="<?php echo $user['magassag']; ?>" step="any"  required>

                <label for="cel">Cél</label>
                <select class="form-control" name="cel" required>
                    <option value="lose weight" <?php if ($user['cel'] == 'Fogyás') echo 'selected'; ?>>Fogyás</option>
                    <option value="gain muscle" <?php if ($user['cel'] == 'Izomnövelés') echo 'selected'; ?>>Izomnövelés</option>
                    <option value="lose weight and gain musclegyás és izomtömeg növelés" <?php if ($user['cel'] == 'Fogyás és izomtömegnövelés') echo 'selected'; ?>>Fogyás és izomtömeg növelés</option>
                    <option value="stay in shape" <?php if ($user['cel'] == 'Formában tartás') echo 'selected'; ?>>Formában tartás</option>
                    <option value="start an athletic career" <?php if ($user['cel'] == 'Sportólói karrier elkezdése') echo 'selected'; ?>>Sportólói karrier elkezdése</option>
                </select>

                <label for="jelenlegi_testzsir">Jelenlegi testzsírszázalék</label>
                <select class="form-control" name="jelenlegi_testzsir" required>
                    <option value="5" <?php if ($user['jelenlegi_testzsir'] == '5') echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($user['jelenlegi_testzsir'] == '10') echo 'selected'; ?>>10</option>
                    <option value="15" <?php if ($user['jelenlegi_testzsir'] == '15') echo 'selected'; ?>>15</option>
                    <option value="20" <?php if ($user['jelenlegi_testzsir'] == '20') echo 'selected'; ?>>20</option>
                    <option value="25" <?php if ($user['jelenlegi_testzsir'] == '25') echo 'selected'; ?>>25</option>
                    <option value="30" <?php if ($user['jelenlegi_testzsir'] == '30') echo 'selected'; ?>>30</option>
                    <option value="35" <?php if ($user['jelenlegi_testzsir'] == '35') echo 'selected'; ?>>35</option>
                    <option value="40" <?php if ($user['jelenlegi_testzsir'] == '40') echo 'selected'; ?>>40</option>
                </select>
   
                <label for="cel_testzsir">Cél testzsírszázalék</label>
                <select class="form-control" name="cel_testzsir" required>
                    <option value="5" <?php if ($user['cel_testzsir'] == '5') echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($user['cel_testzsir'] == '10') echo 'selected'; ?>>10</option>
                    <option value="15" <?php if ($user['cel_testzsir'] == '15') echo 'selected'; ?>>15</option>
                    <option value="20" <?php if ($user['cel_testzsir'] == '20') echo 'selected'; ?>>20</option>
                    <option value="25" <?php if ($user['cel_testzsir'] == '25') echo 'selected'; ?>>25</option>
                    <option value="30" <?php if ($user['cel_testzsir'] == '30') echo 'selected'; ?>>30</option>
                    <option value="35" <?php if ($user['cel_testzsir'] == '35') echo 'selected'; ?>>35</option>
                    <option value="40" <?php if ($user['cel_testzsir'] == '40') echo 'selected'; ?>>40</option>
                </select>

                <label for="kivant_edzes_per_het">Heti edzések száma</label>
                <select class="form-control" name="kivant_edzes_per_het" required>
                    <option value="1" <?php if ($user['kivant_edzes_per_het'] == '1') echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($user['kivant_edzes_per_het'] == '2') echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($user['kivant_edzes_per_het'] == '3') echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($user['kivant_edzes_per_het'] == '4') echo 'selected'; ?>>4</option>
                    <option value="5" <?php if ($user['kivant_edzes_per_het'] == '5') echo 'selected'; ?>>5</option>
                    <option value="6" <?php if ($user['kivant_edzes_per_het'] == '6') echo 'selected'; ?>>6</option>
                    <option value="7" <?php if ($user['kivant_edzes_per_het'] == '7') echo 'selected'; ?>>7</option>
                </select>

                <label for="kivant_edzes_hossza">Edzés hossza</label>
                <select class="form-control" name="kivant_edzes_hossza" required>
                    <option value="30" <?php if ($user['kivant_edzes_hossza'] == '30') echo 'selected'; ?>>30</option>
                    <option value="45" <?php if ($user['kivant_edzes_hossza'] == '45') echo 'selected'; ?>>45</option>
                    <option value="60" <?php if ($user['kivant_edzes_hossza'] == '60') echo 'selected'; ?>>60</option>
                    <option value="75" <?php if ($user['kivant_edzes_hossza'] == '75') echo 'selected'; ?>>75</option>
                    <option value="90" <?php if ($user['kivant_edzes_hossza'] == '90') echo 'selected'; ?>>90</option>
                    <option value="105" <?php if ($user['kivant_edzes_hossza'] == '105') echo 'selected'; ?>>105</option>
                    <option value="120" <?php if ($user['kivant_edzes_hossza'] == '120') echo 'selected'; ?>>120</option>
                </select>

                <label for="edzes_helye">Edzés helye</label>
                <select class="form-control" name="edzes_helye" required>
                    <option value="GYM" <?php if ($user['edzes_helye'] == 'Konditerem') echo 'selected'; ?>>Konditerem</option>
                    <option value="Home" <?php if ($user['edzes_helye'] == 'Otthon') echo 'selected'; ?>>Otthon</option>
                    <option value="both in GYM and home" <?php if ($user['edzes_helye'] == 'Hibrid') echo 'selected'; ?>>Hibrid</option>
                </select>
                
                <label for="felszereltseg">Edzés helye</label>
                <select class="form-control" name="felszereltseg" required>
                    <option value="max" <?php if ($user['felszereltseg'] == 'Maximális felszereltség') echo 'selected'; ?>>Maximális felszereltség</option>
                    <option value="limited" <?php if ($user['felszereltseg'] == 'Korlátozott felszereltség') echo 'selected'; ?>>Korlátozott felszereltség</option>
                    <option value="bodyweight" <?php if ($user['felszereltseg'] == 'Saját testsúly') echo 'selected'; ?>>Saját testsúly</option>
                </select>

                <label for="fokuszalt_izomcsoport">Fókuszált izomcsoportok</label>
                <input class="form-control" type="text" name="fokuszalt_izomcsoport" value="<?php echo $user['fokuszalt_izomcsoport']; ?>" required>

                <label for="serult_testrész">Sérült testrész</label>
                <input class="form-control" type="text" name="serult_testrész" value="<?php echo $user['serult_testrész']; ?>">

                <button type="submit" class="nextgomb" name="informationSubmit">Módosítások mentése</button>
                
            </form>

            <div class="m-auto">
                <button class="btn btn-danger"><a href="logout.php" style="text-decoration: none; color: white;">Kijelentkezés</a></button>
            </div>

            <div class="m-auto mt-2">
                <button class="btn btn-danger" onclick="showDeleteModal()">Fiók törlése</button>
                
                <div id="modalOverlay" onclick="closeDeleteModal()"></div>
                <div id="deleteModal">
                    <h3>Biztosan törölni szeretnéd a fiókod?</h3>
                    <p>Add meg a jelszavad a megerősítéshez</p>
                    <input class="form-control mb-2" type="password" id="passwordDelete" >
                    <p id="deletePassError"></p>
                    <button class="btn btn-success" onclick="confirmDelete()">Confirm</button>
                    <button class="btn btn-danger" onclick="closeDeleteModal()">Mégsem</button>
                </div>
            </div>
          
    </div>
    
    <?php
        include("footer.html")
    ?>


    <script src="js/showPass.js"></script>
    <script src="js/deleteAccount.js"></script>

</body>
</html>