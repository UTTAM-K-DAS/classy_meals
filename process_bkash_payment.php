<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header('location: index.php');
   exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$grand_total = 0;

$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">
</head>
<body>   
    <?php include 'header.php'; ?>
    <div class="heading">
    <h3>Select Payment Method</h3>
    <p><a href="index.php">Home</a> <span>/ Payment</span></p>
    </div>

    <section class="contact">

<div class="row">
    <form action="process_bkash_payment.php" method="post">
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" placeholder="Enter payment amount" required><br><br>

        <label for="password">bKash Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your bKash password" required><br><br>

        <input type="submit" value="Pay with bKash" name="send" class="btn"  >
    </form>

    <?php
    include 'db_connection.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['phone'], $_POST['amount'], $_POST['password'], $_SESSION['user_id'])) {
            $phone = $_POST['phone'];
            $amount = $_POST['amount'];
            $password = $_POST['password'];
            $user_id = $_SESSION['user_id'];

            try {
                $insert_query = "INSERT INTO online_payment (user_id, phone, amount, password, payment_status, created_at)
                                 VALUES (:user_id, :phone, :amount, :password, 'Pending', NOW())";
                $stmt = $conn->prepare($insert_query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':password', $password);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    
                    $update_status_query = "UPDATE online_payment SET payment_status = 'Paid' WHERE user_id = :user_id AND payment_status = 'Pending'";
                    $update_stmt = $conn->prepare($update_status_query);
                    $update_stmt->bindParam(':user_id', $user_id);
                    $update_stmt->execute();

                    echo "Payment successful. Payment status updated to 'Paid'.";
                } else {
                    echo "Error inserting payment record.";
                }
              header("Location: orders.php");
                
            } catch (PDOException $e) {
                echo "Error inserting/updating payment record: " . $e->getMessage();
            }
        } else {
            echo "Incomplete data received.";
        }
    }
    ?>
   <?php include 'footer.php'; ?>



<script src="js/script.js"></script> 
</body>
</html>
