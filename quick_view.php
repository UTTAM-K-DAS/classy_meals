<?php
include 'db_connection.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart_items->execute([$user_id]);
} else {
   $user_id = '';
   $select_cart_items = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="quick-view">

   <h1 class="title">quick view</h1>

   <?php
    try {
      $select_menu = $conn->prepare("SELECT * FROM menu");
      $select_menu->execute();
  
      if ($select_menu->rowCount() > 0) {
          while ($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)) {
              echo '<form action="" method="post" class="box">';
              echo '<input type="hidden" name="pid" value="' . $fetch_menu['product_id'] . '">';
              echo '<input type="hidden" name="name" value="' . $fetch_menu['name'] . '">';
              echo '<input type="hidden" name="price" value="' . $fetch_menu['price'] . '">';
  
            
              echo "<img src='images/{$fetch_menu['image_url']}' alt='{$fetch_menu['name']}' class='product_id'>";
              echo '<a href="category.php?category=' . $fetch_menu['category'] . '" class="cat">' . $fetch_menu['category'] . '</a>';
              echo '<div class="name">' . $fetch_menu['name'] . '</div>';
              echo '<div class="flex">';
              echo '<div class="price"><span>$</span>' . $fetch_menu['price'] . '</div>';
              echo '<input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">';
              echo '</div>';
              echo '<button type="submit" name="add_to_cart.php" class="cart-btn">Add to Cart</button>';
              echo '</form>';
   
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
