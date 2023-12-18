<?php
include 'db_connection.php';


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

include 'add_to_cart.php';
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
   <h1 class="title">food category</h1>

   <h1 class="title"><?php echo $_GET['category']; ?></h1>


      <?php
  
      $categoryName = isset($_GET['category']) ? $_GET['category'] : '';
      
     
       

     
   $category = $_GET['category'] ?? '';

   $select_menu = $conn->prepare("SELECT * FROM `menu` WHERE category = ?");
   $select_menu->execute([$category]);
  
   if ($select_menu->rowCount() > 0) {
      while ($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)) {
         echo "<div class='product-item'>";
         echo "<img src='images/{$fetch_menu['image_url']}' alt='{$fetch_menu['name']}' class=''>";

         echo '<a href="quick_view.php?pid=' . $fetch_menu['product_id'] . '" class="fas fa-eye"></a>';

         echo '<div class="name">' . $fetch_menu['name'] . '</div>';

         echo '<div class="price"><span>$</span>' . $fetch_menu['price'] . '</div>';

         echo "<form action='add_to_cart.php' method='post'>";
         echo "<input type='hidden' name='pid' value='{$fetch_menu['product_id']}'>";
         echo "<input type='hidden' name='name' value='{$fetch_menu['name']}'>";
         echo "<input type='hidden' name='price' value='{$fetch_menu['price']}'>";
         echo "<input type='hidden' name='image' value='{$fetch_menu['image_url']}'>";
         echo '<div class="flex">';
         echo "<input type='number' name='qty' class='qty' min='1' max='99' value='1' maxlength='2'>";
         if (isset($_SESSION['user_id'])) {
            echo "<button type='submit' name='add_to_cart' class='cart-btn'>Add to Cart</button>";
         } else {
            echo "<p>Please <a href='login_form.php'>log in</a> to add items to the cart.</p>";
         }
         echo '</div>';
         echo '</form>';

         echo "</div>"; 
      }
   } else {
      echo '<p class="empty">No dish added yet!</p>';
   }
   ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script></body>
</html>
