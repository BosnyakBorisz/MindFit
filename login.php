<?php
    session_start();

    if (isset($_SESSION["email"])) {
        header("Location: profil.php");
        exit();
    }

    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
       
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = $_POST["password"]; 

        if (!$email || empty($password)) {
            $_SESSION["error"] = "Érvénytelen email vagy jelszó!";
            header("Location: login.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT id, felhasznnev, jelszo FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["jelszo"])) {

                session_regenerate_id(true);

                $_SESSION["email"] = $email;
                $_SESSION["username"] = $row["felhasznnev"];

                header("Location: profil.php");
                exit();
            }
        }

        $_SESSION["error"] = "Érvénytelen email vagy jelszó!";
        header("Location: login.php");
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Bejelentkezés</title>
    <link rel="icon" href="img/strong.png"></link:icon>
</head>
<body>
    <div class="container mt-5">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <div class="container">
                <div class="row">
                    <div id="box1">
                        <div id="keret">
                            <h2>Bejelentkezés</h2>
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <p class="error" id="emailError"></p>

                            <label for="password">Jelszó</label>
                            <div class="password-container">
                                <input class="form-control" type="password" id="password" name="password" required>
                                <label class="container-szem">
                                    <input type="checkbox" id="togglePasswordCheckbox" checked="checked">
                                    <svg id="eyeOpen" class="szem1" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                                    <svg id="eyeClosed" class="szem2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                                </label>
                            </div>
                            <p class="error" id="passwordError"></p>
                            <?php if (isset($_SESSION["error"])): ?>
                                <p class="error"><?= $_SESSION["error"]; ?></p>
                                <?php unset($_SESSION["error"]); ?>
                            <?php endif; ?>
                            <button type="submit" name="login" class="backgomb" onclick="loginCheck()">Bejelentkezés</button>
                            <p>Még nincs fiókod? <a href="register.php">Regisztrálj</a></p>
                            <p><a href="forgot-password.php">Elfelejtett jelszó?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="js/showPass.js"></script>
    <script src="js/loginStep.js"></script>

</body>
</html>