<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    move_uploaded_file($image_tmp_name, $image_folder);

    $insert_restaurant = $conn->prepare("INSERT INTO `restaurants`(name, location, description, image_url) VALUES(?,?,?,?)");
    $insert_restaurant->execute([$name, $location, $description, $image]);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>RESTAURANTS</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'admin_hedder.php'; ?>
<section class="add-products">
<section class="update-restaurants">
   <h1 class="heading">Add Restaurants</h1>
   
   <form action="" method="POST" enctype="multipart/form-data">
      <span>Name</span>
      <input type="text" required placeholder="Enter restaurant name" name="name" maxlength="100" class="box">
      <span>Location</span>
      <input type="text" required placeholder="Enter restaurant location" name="location" maxlength="1000" class="box">
      <span>Description</span>
      <input type="text" required placeholder="Enter restaurant description" name="description" maxlength="5000" class="box">
      <span>Image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="Add" class="btn" name="add">
      </div>
   </form>

</section>



<section class="restaurant-details">
        <?php
        $show_restaurants = $conn->prepare("SELECT * FROM `restaurants`");
        $show_restaurants->execute();

        if ($show_restaurants->rowCount() > 0) {
            while ($restaurant = $show_restaurants->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="restaurant">
                    <h2><?= $restaurant['name']; ?></h2>
                    <img src="../uploaded_img/<?= $restaurant['image_url']; ?>" alt="">
                    <p><strong>Location:</strong> <?= $restaurant['location']; ?></p>
                    <p><?= $restaurant['description']; ?></p>
                    <a href="restaurantsmenu.php?restaurant_id=<?= $restaurant['restaurant_id']; ?>" class="menu-btn">View Menu</a>
                </div>
                </div>
               <div class="flex-btn">
                  <a href="update_restaurant.php?update=<?= $restaurant['restaurant_id']; ?>" class="option-btn">update</a>
                  <a href="restaurant.php?delete=<?= $restaurant['restaurant_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
               </div>
            </div>
                <?php
            }
        } else {
            echo '<p>No restaurants found.</p>';
        }
        ?>
    </div>
    </div?>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
