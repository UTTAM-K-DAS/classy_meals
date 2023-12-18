<?php
include 'db_connection.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'header.php'; ?>
<section class="hero">

<div class="swiper hero-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="content">
            <span>order online</span>
            <h3>chezzy hamburger</h3>
            <a href="menu.php" class="btn">menus</a>
         </div>
         <div class="image">
            <img src="images/home-img-2.png" alt="">
         </div>
      </div>

      <div class="swiper-pagination"></div>
   

   </div>

   </section>
   
   <section class="category">
      <h1 class="title">food category</h1>

   <div class="box-container">

   


      <a href="category.php?category=fast food" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fast food</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>main dish</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a>

   </div>

   </section>
  

  


   <section class="products">

<h1 class="title">latest dishes</h1>

<div class="box-container">
<?php


include 'db_connection.php'; 

try {
$select_latest_dishes = $conn->prepare("SELECT product_id, name, category, price, image_url, description FROM menu ORDER BY date_added DESC LIMIT 6");
$select_latest_dishes->execute();

$rowCount = $select_latest_dishes->rowCount();

if ($rowCount > 0) {
   echo '<form action="add_to_cart.php" method="post" class="box">';
   echo '<div class="dish-list">';
   $counter = 0;
   while ($fetch_menu = $select_latest_dishes->fetch(PDO::FETCH_ASSOC)) {
       echo "<div class='dish-item'>";
       echo "<h3>{$fetch_menu['name']}</h3>";
       echo "<p>Category: {$fetch_menu['category']}</p>";
       echo "<img src='images/{$fetch_menu['image_url']}' alt='{$fetch_menu['name']}' class='dish-image'>";
       echo "<p>Description: {$fetch_menu['description']}</p>";
       if (isset($fetch_menu['price'])) {
         echo "<p>Price: {$fetch_menu['price']} TK</p>"; 
         echo "<p>Price not available</p>";
     }

     echo "<form action='add_to_cart.php' method='post'>";
     echo "<input type='number' name='qty' class='qty' min='1' max='99' value='1' maxlength='2'>";
     echo "<input type='hidden' name='pid' value='{$fetch_menu['product_id']}'>";
     echo "<input type='hidden' name='name' value='{$fetch_menu['name']}'>";
     echo "<input type='hidden' name='price' value='{$fetch_menu['price']}'>";
     echo "<input type='hidden' name='image' value='{$fetch_menu['image_url']}'>";
     if (isset($_SESSION['user_id'])) {
      echo "<button type='submit' name='add_to_cart' class='cart-btn'>Add to Cart</button>";
  } else {
      echo "<p>Please <a href='login_form.php'>log in</a> to add items to the cart.</p>";
 }
 echo "</form>";
 echo "</div>";
   }
   echo "</div>";

} else {
    echo "No dishes found.";
}
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
}
?>
      </div>
      <div class="more-btn">
         
      </div>
   </div>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>