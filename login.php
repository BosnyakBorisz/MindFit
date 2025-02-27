<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Bejelentkezés</title>
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
                            <label for="password">Jelszó</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                            <button class="backgomb">Bejelentkezés</button>
                            <p>Még nincs fiókod? <a href="register.php">Regisztrálj</a></p>
                            <p><a href="recovery.php">Elfelejtett jelszó?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>