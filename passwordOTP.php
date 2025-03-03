<?php



?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>OTP</title>
</head>
<body>
<div class="container mt-5">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <div class="container">
                <div class="row">
                    <div id="box1">
                        <div id="keret">
                            <h2>OTP</h2>
                            <p>Küldtünk egy verifikát az email címedre</p>
                            <div class="d-flex">
                                <input type="text" maxlength="1" required>
                                <input type="text" maxlength="1" required>
                                <input type="text" maxlength="1" required>
                                <input type="text" maxlength="1" required>
                            </div>
                            <button type="submit" name="otpsubmit">Ellenőrzés</button>
                            <p>Nem kaptál kódot?</p>
                            <a href="">Kód ujraküldése</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>