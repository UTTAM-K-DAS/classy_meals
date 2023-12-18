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
    <style>
<link rel="stylesheet" href="css/style.css">>
 
.bkash-form, .cod-form {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">>
</head>
<body>
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="index.php">Home</a> <span>/ Checkout</span></p>
</div>
<section class="checkout">
    <h2>Select Payment Method</h2>
    <form method="post" id="paymentForm">
        <input type="radio" id="bkash" name="payment_method" value="bkash">
        <label for="bkash">Pay with bKash</label><br>

        <input type="radio" id="cod" name="payment_method" value="cod">
        <label for="cod">Cash on Delivery</label><br>

        <input type="submit" value="Proceed to Payment"name="send" class="btn"  >
    </form>

    <div class="payment-status">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['payment_method'])) {
                $payment_method = $_POST['payment_method'];

                if ($payment_method === 'bkash') {
                    echo "Redirecting to bKash payment..."; 
                } elseif ($payment_method === 'cod') {
                    echo "Proceeding with Cash on Delivery..."; 
                } else {
                    echo "Invalid payment method selected.";
                }
            } else {
                echo "Payment method not specified.";
            }
        }
        ?>
    </div>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (paymentMethod === 'bkash') {
                this.action = 'process_bkash_payment.php';
            } else if (paymentMethod === 'cod') {
                this.action = 'process_cod_payment.php';
            }

            this.submit();
        });
    </script>
    <?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>
