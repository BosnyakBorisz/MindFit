<?php
    session_start();

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
        echo json_encode(["success" => true]);
        exit();
    } else {
        echo json_encode(["success" => false, "error" => "Hiba történt a törlés közben!"]);
        exit();
    }
?>
