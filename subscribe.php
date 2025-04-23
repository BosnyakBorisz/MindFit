<?php
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    $response = []; 
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["email"]);
    
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
            include("database.php");
    
            $stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows === 0) {
                $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
                $stmt->bind_param("s", $email);
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {

                    $mail = new PHPMailer(true);

                    try {
                        $unsubscribeLink = 'https://mindfit.hu/unsubscribe.php?email=' . urlencode($email);

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'turrmindfit@gmail.com'; 
                        $mail->Password = 'knci jdwl iteb ytrh';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8'; 
    
                        $mail->setFrom('turrmindfit@gmail.com', 'MindFit');
                        $mail->addAddress($email);
    
                        $mail->isHTML(true);
                        $mail->Subject = 'Feliratkozás sikeres.';
                        $mail->Body = "
                        <h2>Kedves felhasználó!</h2>
                        <p>Köszönjük, hogy feliratkoztál hírlevelünkre.</p>
                        <a href='$unsubscribeLink'>Leiratkozás</a>";
                        $mail->send();
    
                        $response['status'] = 'success';
                        $response['message'] = '✅ Sikeresen feliratkoztál.';
                    } catch (Exception $e) {
                        // Return error response if email failed
                        $response['status'] = 'error';
                        $response['message'] = "❌ Hiba történt.";
                    }
                }
            } else {
                // If email is already subscribed
                $response['status'] = 'info';
                $response['message'] = '📧 Már feliratkoztál.';
            }

            $stmt->close();
            $conn->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = '❌ elytelen email.';
        }
    }
    exit;
?>