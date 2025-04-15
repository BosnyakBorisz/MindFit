<?php
    session_start();

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'database.php';

     if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];
    $password = $_POST['password'];

    if (empty($password)) {
        echo json_encode(["success" => false, "error" => "A jelszó mező nem lehet üres!"]);
        exit();
    }

    // Fetch hashed password from DB
    $stmt = $conn->prepare("SELECT jelszo FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify password
    if (!password_verify($password, $hashed_password)) {
        echo json_encode(["success" => false, "error" => "Helytelen jelszó!"]);
        exit();
    }

    // Delete user
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $delete_stmt->bind_param("s", $email);

    
    if ($delete_stmt->execute()) {
        session_destroy();
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'turrmindfit@gmail.com';
            $mail->Password = 'knci jdwl iteb ytrh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8'; 
    
            $mail->setFrom('turrmindfit@gmail.com', 'Fiók törlés sikeres');
            $mail->addAddress($email);
    
            $mail->isHTML(true);
            $mail->Subject = 'Fiók törölve';
            $mail->Body    = '
                <h2>Kedves felhasználó!</h2>
                <p>A fiókod sikeresen törölve lett az oldalunkról.</p>';
    
            $mail->send();

        } catch (Exception $e) {
        }
        echo json_encode(["success" => true]);
        exit();
    } else {
        echo json_encode(["success" => false, "error" => "Hiba történt a törlés közben!"]);
        exit();
    }
?>
