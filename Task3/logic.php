<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo trim("success");
        } else {
            echo trim("invalid");
        }
    } else {
        echo trim("notfound");
    }

    $stmt->close();
    $conn->close();
}