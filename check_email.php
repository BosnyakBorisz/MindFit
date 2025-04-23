<?php
    include("database.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "exists";
        } else {
            echo "available";
        }

        $stmt->close();
    }

    $conn->close();
?>
