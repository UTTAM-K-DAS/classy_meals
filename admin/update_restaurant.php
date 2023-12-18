<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Update/Add Restaurant</title>
</head>
<body>

<?php include 'C:\xampp\htdocs\classy_meals\admin\admin_hedder.php'; ?>

<section class="update-restaurants">
   <h1 class="heading">Update/Add Restaurants</h1>

   <?php
   include 'C:\xampp\htdocs\classy_meals\db_connection.php'; 

   
   $admin_id = $_SESSION['admin_id'] ?? null;

   if (!$admin_id) {
       header('Location: admin_login.php');
       exit; 
   }

   if (isset($_GET['update'])) {
       $update_id = $_GET['update'];
       $show_restaurant = $conn->prepare("SELECT * FROM `restaurants` WHERE restaurant_id = ?");
       $show_restaurant->execute([$update_id]);

       if ($show_restaurant->rowCount() > 0) {
           $fetch_restaurant = $show_restaurant->fetch(PDO::FETCH_ASSOC);
           ?>
           <form action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_restaurant['restaurant_id']; ?>">
               <input type="hidden" name="old_image" value="<?= $fetch_restaurant['image_url']; ?>">
               <img src="../uploaded_img/<?= $fetch_restaurant['image_url']; ?>" alt="">
               <span>Name</span>
               <input type="text" required placeholder="Enter restaurant name" name="name" maxlength="100" class="box" value="<?= $fetch_restaurant['name']; ?>">
               <span>Location</span>
               <input type="text" required placeholder="Enter restaurant location" name="location" maxlength="1000" class="box" value="<?= $fetch_restaurant['location']; ?>">
               <span>Description</span>
               <input type="text" required placeholder="Enter restaurant description" name="description" maxlength="5000" class="box" value="<?= $fetch_restaurant['description']; ?>">
               <span>Image</span>
               <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
               <div class="flex-btn">
                   <input type="submit" value="Update" class="btn" name="update">
               </div>
           </form>
           <?php
       } else {
           echo '<p class="empty">Restaurant not found!</p>';
       }
   }
   ?>

<script src="../js/admin_script.js"></script>
</body>
</html>
