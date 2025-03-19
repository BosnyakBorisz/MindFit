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

    if ($stmt->fetch()) {
        $workout_plan;
    } else {
        echo "No workout plan found for this user.";
    }

    $stmt->close();
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
</head>
<body>
  
    <?php
      include("header.html")
    ?>

    <div class="d-flex align-items-center flex-column">
        <?php     
            echo $workout_plan
        ?>
    </div>

</body>
</html>