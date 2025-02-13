<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "mindfit";
    $conn = "";


    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        $conn->set_charset("utf8");
    }
    catch (mysqli_sql_exception) {

    }
    
?>