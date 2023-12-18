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
  <link rel="stylesheet" href="css/style.css">>
</head>

<body>
   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Checkout</h3>
      <p><a href="index.php">Home</a> <span>/ Checkout</span></p>
   </div>

   <section class="checkout">
      <h1 class="title">Review Your Order</h1>

      <div class="box-container">
         <?php
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <div class="checkout-item">
                  <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                  <div class="item-details">
                     <h3><?= $fetch_cart['name']; ?></h3>
                     <p>Product ID: <?= $fetch_cart['pid']; ?></p>
                     <p>Price: $<?= $fetch_cart['price']; ?></p>
                     <p>Quantity: <?= $fetch_cart['quantity']; ?></p>
                  </div>
               </div>
               <?php
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
          
               if (isset($_POST['place_order'])) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, email, number, address, method, total_products, total_price, payment_status, pid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                     $insert_order->execute([$user_id, $name, $email, $number, $address, $method, $total_products, $total_price, $payment_status, $fetch_cart['pid']]);
                 }    
            }
         }
         } else {
            echo '<p class="empty">Your cart is empty</p>';
         }
         ?>
      </div>

      <div class="order-summary">
         <h2>Order Summary</h2>
         <p>Cart Total: $<?= $grand_total; ?></p>
      </div>

      <div class="checkout-btn">
         <a href="payment.php" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to Payment</a>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>
</body>

</html>
