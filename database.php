<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "mindfit";
    $conn = "";


    try {
        $conn = mysqlconnect($db_server, $db_user, $db_pass, $db_name);
    }
    catch (mysqli_sql_exception) {

    }
    
?>