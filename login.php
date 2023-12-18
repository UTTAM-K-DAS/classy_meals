<?php
session_start();
include 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name']; 
    $password = $_POST['password'];


    $check_user = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $check_user->execute([$username]);
    $user = $check_user->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id']; 
        header('Location: profile.php'); 
        exit();
    } else {
        $_SESSION['login_error'] = 'Invalid username or password';
        header('Location: login_form.php');
        exit();
    }
} else {
    header('Location: login_form.php');
    exit();
}
?>
