<?php

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
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p><a href="index.php">home</a> <span> / about</span></p>
</div>


<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>good food </p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

   </div>

</section>


<section class="reviews">
   <h2 class="title">OWNERS</h2>

   <div class="swiper reviews-slider">
   <div class="swiper-wrapper">
   <div class="swiper-slide slide">
            <img src="images/UTTAM.jpg" alt="UTTAM DAS">
            <h3>UTTAM DAS</h3>
            <p>Overall, I'm driven by a desire to continuously grow and make a meaningful impact, both personally and professionally.</p>
         </div>


   
         <div class="swiper-slide slide">
            <img src="images/NANDAN.jpg" alt="NANDAN PAUL">
            <h3>NANDAN PAUL</h3>
            <p>Overall, I'm driven by a desire to continuously grow and make a meaningful impact, both personally and professionally.</p>
         </div>

         
         <div class="swiper-slide slide">
            <img src="images/anirban.jpg" alt="UTTAM DAS">
            <h3>ANIRBAN DHAR</h3>
            <p>Overall, I'm driven by a desire to continuously grow and make a meaningful impact, both personally and professionally.</p>
         </div>

         <div class="swiper-slide slide">
            <img src="images\chayti.jpg" alt="UTTAM DAS">
            <h3>CHAYTI DHAR</h3>
            <p>Overall, I'm driven by a desire to continuously grow and make a meaningful impact, both personally and professionally.</p>
         </div>

       

      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>



<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choose order</h3>
         <p></p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>fast delivery</h3>
         <p></p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food</h3>
         <p></p>
      </div>

   </div>

</section>

<?php
include 'db_connection.php'; 
try {
    $fetch_reviews = $conn->query("
    SELECT r.*, u.name AS user_name
    FROM `review` r
    INNER JOIN `users` u ON r.user_id = user.id

    ");

    if ($fetch_reviews->rowCount() > 0) {
        echo '<section class="reviews">';
        echo '<h1 class="title">customer\'s reviews</h1>';
        echo '<div class="swiper reviews-slider">';
        echo '<div class="swiper-wrapper">';

        while ($row = $fetch_reviews->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="swiper-slide slide">';
            echo '<h3>' . $row['user_name'] . '</h3>'; 
            echo '<p>' . $row['message'] . '</p>';
            if ($row['stars'] > 0) {
                echo '<div class="stars">';
                for ($i = 0; $i < $row['stars']; $i++) {
                    echo '<i class="fas fa-star"></i>';
                }
                echo '</div>';
            }
            echo '</div>';
        }

        echo '</div>';
        echo '<div class="swiper-pagination"></div>';
        echo '</div>';
        echo '</section>';
    } else {
        echo 'No reviews found.';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>








<?php include 'footer.php'; ?>






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
   var swiper = new Swiper('.reviews-slider', {
      slidesPerView: 4, // Display 4 slides at a time
      spaceBetween: 20, // Adjust spacing between slides as needed
      pagination: {
         el: '.swiper-pagination',
         clickable: true,
      },
   });
</script>

</body>
</html>