<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to = $email;
        $subject = "Hírlevél feliratkozás";
        $message = "Köszönjük, hogy feliratkoztál hírlevelünkre!";
        $headers = "From: noreply@mind.fit\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "Sikeresen feliratkoztál!";
        } else {
            echo "Hiba történt az e-mail küldésekor.";
        }
    } else {
        echo "Érvénytelen e-mail cím.";
    }
}
?>
