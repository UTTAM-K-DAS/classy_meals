<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];

    if ($username === 'example_user' && $password === 'example_password') {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid username or password. Please try again.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
       
    <div class="heading">
        <h3>LOGIN FORM</h3>
        <p><a href="index.php">Home</a> <span>/ LOGIN FORM</span></p>
    </div>

    <section class="contact">
        <div class="row">
            <form action="login.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Login">
            </form>

            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>

            <?php
            if (isset($_SESSION['login_error'])) {
                echo "<p>{$_SESSION['login_error']}</p>";
                unset($_SESSION['login_error']);
            }
            ?>
        </div>
    </section>
</body>
</html>
