<?php

    if (isset($_GET['email'])) {
        $email = $_GET['email'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $conn = new mysqli('localhost', 'root', '', 'mindfit');

            $stmt = $conn->prepare("DELETE FROM subscribers WHERE email = ?");
            $stmt->bind_param('s', $email);
            
            if ($stmt->execute()) {
                echo "Sikeresen leiratkoztál.";
            } else {
                echo "Hiba történt. Kérjük probáld meg később.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Helytelen email cím.";
        }
    } else {
        echo "Nincs email cím";
    }
?>
