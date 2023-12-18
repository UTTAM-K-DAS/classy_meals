<?php
include 'db_connection.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

include 'add_to_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Search page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="search-form">
   <form method="post" action="">
      <input type="text" name="search_box" placeholder="Search here..." class="box">
      <button type="submit" name="search_btn" class="fas fa-search"></button>
   </form>
</section>

<section class="products">
   <div class="box-container">
      <?php
      if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
         $search_box = $_POST['search_box'];
         $select_menu = $conn->prepare("SELECT * FROM `menu` WHERE name LIKE ?");
         $select_menu->execute(["%$search_box%"]);

         if ($select_menu->rowCount() > 0) {
            while ($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_menu['product_id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_menu['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_menu['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_menu['image_url']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_menu['product_id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="cart-btn" name="add_to_cart.php">Add to Cart</button>';
         <img src="images/<?= $fetch_menu['image_url']; ?>" alt="<?= $fetch_menu['name']; ?>">
         <a href="category.php?category=<?= $fetch_menu['category']; ?>" class="cat"><?= $fetch_menu['category']; ?></a>
         <div class="name"><?= $fetch_menu['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_menu['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">No menu items found!</p>';
         }
      }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
