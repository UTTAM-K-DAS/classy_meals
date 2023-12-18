<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>RESTAURANT MENU</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <!-- Include your CSS file here -->
  
</head>
<body>

<?php include 'admin_hedder.php'; ?>

<section class="add-menu-item">
    <h1 class="heading">Add Menu Item</h1>

    <!-- Form for adding menu items -->
    <form action="products.php" method="POST" enctype="multipart/form-data">
        <!-- Input fields for menu item details -->
        <input type="hidden" name="restaurant_id" value="<?= $restaurant_id; ?>">
        <span>Name</span>
        <input type="text" required placeholder="Enter menu item name" name="name" maxlength="100" class="box">
        <span>Price</span>
        <input type="number" min="0" required placeholder="Enter menu item price" name="price" class="box">
        <span>Category</span>
        <select name="category" class="box" required>
            <option value="main dish">Main Dish</option>
            <option value="desserts">Desserts</option>
            <option value="main dish">FAST FOOD</option>
            <option value="desserts">DRINKS</option>
            <!-- Add more categories as needed -->
        </select>
        <span>Image</span>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
        <div class="flex-btn">
            <input type="submit" value="Add Menu Item" class="btn" name="add_menu_item">
        </div>
    </form>

    <!-- Display menu items for the specific restaurant -->
    <?php
    $restaurant_id = $_GET['restaurant_id'];

    $show_menu = $conn->prepare("SELECT * FROM `menu` WHERE restaurant_id = ?");
    $show_menu->execute([$restaurant_id]);

    if ($show_menu->rowCount() > 0) {
        while ($menu_item = $show_menu->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="menu-item">
                <img src="../uploaded_img/<?= $menu_item['image_url']; ?>" alt="<?= $menu_item['name']; ?>">
                <h2><?= $menu_item['name']; ?></h2>
                <p>Price: $<?= $menu_item['price']; ?></p>
                <p>Category: <?= $menu_item['category']; ?></p>
                <div class="flex-btn">
                  <a href="update_restaurentmenu.php?update=<?= $menu_item['product_id']; ?>" class="option-btn">Update</a>
                  <a href="delete_menu_item.php?delete=<?= $menu_item['product_id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
               </div>
            </div>
        <?php
        }
    } else {
        echo '<p>No menu items found for this restaurant.</p>';
    }
    ?>
</section>


<script src="../js/admin_script.js"></script>
</body>
</html>