<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update_product'])) {
    
    $update_product_query = $conn->prepare("UPDATE `menu` SET name=?, price=?, category=?, description=?, restaurant_name=?, restaurant_id=? WHERE product_id=?");
    $update_product_query->execute([$name, $price, $category, $description, $restaurant_name, $restaurant_id, $product_id]);

    
}

$product_id_to_update = $_GET['update'];

$fetch_product_query = $conn->prepare("SELECT * FROM `menu` WHERE product_id = ?");
$fetch_product_query->execute([$product_id_to_update]);
$selected_product = $fetch_product_query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Restaurant Menu</title>

    <style>
        .product-image {
            max-width: 200px; 
            height: auto; 
            display: block; 
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>
    <?php include 'admin_hedder.php'; ?>

    <section class="update-products">
        <h3>Update Product</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= $selected_product['product_id']; ?>">
            <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box" value="<?= $selected_product['name']; ?>">
            <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $selected_product['price']; ?>">
            <select name="category" class="box" required>
                <option value="main dish" <?= ($selected_product['category'] == 'main dish') ? 'selected' : ''; ?>>Main Dish</option>
                <option value="desserts" <?= ($selected_product['category'] == 'desserts') ? 'selected' : ''; ?>>Desserts</option>
                
            </select>
            <img src="../uploaded_img/<?= $selected_product['image_url']; ?>" alt="<?= $selected_product['name']; ?>" class="product-image">
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <input type="text" required placeholder="Enter restaurant description" name="description" maxlength="5000" class="box" value="<?= $selected_product['description']; ?>">
            <input type="text" required placeholder="Enter restaurant name" name="restaurant_name" class="box" value="<?= $selected_product['restaurant_name']; ?>">
            <input type="number" min="1" required placeholder="Enter restaurant ID" name="restaurant_id" class="box" value="<?= $selected_product['restaurant_id']; ?>">
            <input type="submit" value="Update Product" name="update_product" class="btn">
        </form>
    </section>
</body>
</html>
