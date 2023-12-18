<?php

include 'C:\xampp\htdocs\classy_meals\db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if (isset($_POST['update'])) {
   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $restaurant_name = $_POST['restaurant_name'];
   $restaurant_name = filter_var($restaurant_name, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `menu` SET name = ?, category = ?, price = ?, restaurant_name = ? WHERE product_id = ?");
   $update_product->execute([$name, $category, $price, $restaurant_name, $pid]);

   $message[] = 'Product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `menu` SET image_url = ? WHERE product_id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
         $message[] = 'image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'C:\xampp\htdocs\classy_meals\admin\admin_hedder.php' ?>

<section class="update-product">
   <h1 class="heading">Update Product</h1>
   <?php
   $update_id = $_GET['update'];
   $show_products = $conn->prepare("SELECT * FROM `menu` WHERE product_id = ?");
   $show_products->execute([$update_id]);
   if ($show_products->rowCount() > 0) {
      while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['product_id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image_url']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image_url']; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>Description</span>
      <input type="text" required placeholder="Enter food description" name="description" maxlength="5000" class="box">
      <span>update price</span>
      <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>update category</span>
      <select name="category" class="box" required>
         <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
         <option value="main dish">main dish</option>
         <option value="fast food">fast food</option>
         <option value="drinks">drinks</option>
         <option value="desserts">desserts</option>
      </select>
      <span>update image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <span>Update restaurant name</span>
            <input type="text" required placeholder="Enter restaurant name" name="restaurant_name" class="box" value="<?= $fetch_products['restaurant_name']; ?>">
            <div class="flex-btn">
               <input type="submit" value="Update" class="btn" name="update">
               <a href="products.php" class="option-btn">Go Back</a>
            </div>
         </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>











<script src="../js/admin_script.js"></script>

</body>
</html>