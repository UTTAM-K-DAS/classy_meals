<?php

session_start();

include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['place_order'])) {
   $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart->execute([$user_id]);

   if ($select_cart->rowCount() > 0) {
      $cart_items = [];
      $total_price = 0;

      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         $cart_items[] = $fetch_cart['name'] . ' x' . $fetch_cart['quantity'];
         $total_price += ($fetch_cart['price'] * $fetch_cart['quantity']);
      }

      $total_products = implode(', ', $cart_items);

      $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, total_products, total_price) VALUES (?, ?, ?)");
      $insert_order->execute([$user_id, $total_products, $total_price]);

      $delete_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart_items->execute([$user_id]);

      header('Location: order_confirmation.php');
      exit();
   } else {
      $_SESSION['order_error'] = "Your cart is empty!";
      header('Location: cart.php');
      exit();
   }
} else {
   header('Location: cart.php');
   exit();
}
?>
