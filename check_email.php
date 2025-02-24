<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mindfit";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Kapcsolódási hiba: " . $conn->connect_error); }

$email = $_POST['email'];
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

echo json_encode(["exists" => $stmt->num_rows > 0]);

$stmt->close();
$conn->close();
?>