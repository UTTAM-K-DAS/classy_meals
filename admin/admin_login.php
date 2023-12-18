<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php'; 

session_start(); 

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING); 
    $pass = $_POST['pass']; 
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);

    if($select_admin->rowCount() > 0){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC); 
        $_SESSION['admin_id'] = $fetch_admin_id['admin_id']; 
        header('location: dashboard.php'); 
        $message = 'Incorrect username or password!';
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <?php
    if(isset($message)){
        echo '<div class="message">' . $message . '</div>'; }
    ?>

    <section class="form-container">
        <form action="" method="POST">
            <h3>Login</h3>
            <input type="text" name="name" maxlength="20" required placeholder="Enter username" class="box">
            <input type="password" name="pass" maxlength="20" required placeholder="Enter password" class="box">
            <input type="submit" value="Login" name="submit" class="btn">
        </form>
    </section>
</body>
</html>
