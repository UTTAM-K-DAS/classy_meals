<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
include 'db_connection.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_email = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
    $check_email->execute([$email]);
    $row = $check_email->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];

    if ($count > 0) {
        echo '<p>Email is already registered. Please use a different email.</p>';
    } else {
        $insert_user = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insert_user->execute([$name, $email, $password]);

        if ($insert_user) {
            echo '<p>Registration successful. You can now <a href="login.php">login</a>.</p>';

            $select_user_info = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $select_user_info->execute([$email]);
            $user_info = $select_user_info->fetch(PDO::FETCH_ASSOC);

            if ($user_info) {
                echo '<h2>User Information:</h2>';
                echo '<p>Name: ' . $user_info['name'] . '</p>';
                echo '<p>Email: ' . $user_info['email'] . '</p>';
            }
        } else {
            echo '<p>Error occurred. Please try again later.</p>';
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Signup Form</h3>
    <p><a href="index.php">home</a> <span> / Signup Form</span></p>
</div>

<section class="contact">
    <div class="row">
        <div class="image">
            <img src="images/contact-img.svg" alt="">
        </div>

        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Sign Up">
        </form>
