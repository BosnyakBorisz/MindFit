<?php

    session_start();

    if (!isset($_SESSION["email"])){
        header("Location: login.php");
        exit();
    }

    include("database.php");

    $email = $_SESSION["email"];

    $stmt = $conn->prepare("
        SELECT user_workout_plan.plan 
        FROM user_workout_plan 
        JOIN users ON users.id = user_workout_plan.user_id 
        WHERE users.email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($workout_plan);

?>  
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Edzésterv</title>
    <link rel="icon" href="img/strong.png"></link:icon>
</head>
<body>
  
    <?php
      include("header.html")
    ?>

    <div class="d-flex align-items-center flex-column">
        <?php
            if ($stmt->fetch()) {
                echo $workout_plan;
            } else {
                echo "Nem található edzésterv.";
            }
            $stmt->close();
        ?>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkbox = document.getElementById('exerciseCheckbox1');

            const savedState = localStorage.getItem('exerciseCheckbox1');
            if (savedState === 'checked') {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    localStorage.setItem('exerciseCheckbox1', 'checked');
                } else {
                    localStorage.setItem('exerciseCheckbox1', 'unchecked');
                }
            });
        });
    </script>
    
</body>
</html>