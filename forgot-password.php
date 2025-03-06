<?php

    session_start();

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $conn = new mysqli("localhost", "root", "", "mindfit");

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); 

            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $token, $expiry, $email);
            $stmt->execute();

            $resetLink = "http://" . "localhost/mindfit/mindfit/" . "/reset-password.php?token=" . $token;

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
                

                $mail->setFrom('turrmindfit@gmail.com', 'Jelszó-visszaállítás');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Jelszó visszaállítás';
                $mail->Body    = "Kattints a linkre a jelszavad visszaállításához: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                $message = "Ellenőrizd az e-mailed a visszaállító linkért!";
                
            } catch (Exception $e) {
                $message = "Hiba történt: {$mail->ErrorInfo}";
            }
        } else {
            $message = "Nincs ilyen e-mail regisztrálva!";
        }
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Elfelejtett jelszó</title>
</head>
<body>
    <div class="container mt-5">
        <?php if (empty($message)): ?>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <div class="container">
                <div class="row">
                    <div id="box1">
                        <div id="keret">
                            <h2>Elfelejtett jelszó</h2>
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <?php if ($message != ""): ?>
                                <div class="message"><?php echo $message; ?></div>
                            <?php endif; ?> 
                            <button type="submit" class="backgomb" name="request-new-password">Elküldés</button>
                            <p><a href="login.php">Mégse</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php else: ?>
           
            <div class="container">
                <div class="row">
                    <div id="box1">
                        <div id="keret">
                            <div class="alert alert-success">
                                <?php echo $message; ?>
                            </div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                <button type="submit" class="ujrakuldgomb">Nem kaptad meg? Újraküldés</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>