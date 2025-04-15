<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "mindfit";
    $conn = "";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Kapcsolódási hiba: " . mysqli_connect_error());
    }

    $conn->set_charset("utf8");

    
?>