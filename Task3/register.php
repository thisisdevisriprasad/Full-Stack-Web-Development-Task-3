<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $pass  = trim($_POST['password']);

    $password = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()){
        echo "Registration successful!";
    } else {
        if(strpos($conn->error, 'Duplicate') !== false){
            echo "Email already exists.";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>