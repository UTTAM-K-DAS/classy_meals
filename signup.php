<?php
include 'db_connection.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password']; 

    $check_existing_user = $conn->prepare("SELECT * FROM users WHERE email = ? OR number = ?");
    $check_existing_user->execute([$email, $number]);
    
    if ($check_existing_user->rowCount() > 0) {
        header('Location: signup_form.php?error=Email or number already exists');
        exit();
    }

    $insert_user = $conn->prepare("INSERT INTO users (name, email, number, password) VALUES (?, ?, ?, ?)");
    $insert_user->execute([$name, $email, $number, password_hash($password, PASSWORD_DEFAULT)]);

    if ($insert_user) {
        header('Location: login_form.php');
        exit();
    } else {
        header('Location: signup_form.php?error=Failed to create user');
        exit();
    }
} else {
    header('Location: signup_form.php');
    exit();
}
?>
