<?php
session_start();

$user_id = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
</head>

<body>

    <?php include 'header.php'; ?>
    
    <div class="heading">
        <h3>Food Menu</h3>
        <p><a href="index.php">Home</a> <span>/ Menu</span></p>
   
    </div>
   
    <section class="products">
    <?php
    include 'db_connection.php';

    $select_menu = $conn->prepare("SELECT * FROM `menu` ORDER BY date_added DESC");
    $select_menu->execute();

    if ($select_menu->rowCount() > 0) {
        echo "<div class='dish-list'>";
        while ($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='dish-item'>";
            echo "<h3>{$fetch_menu['name']}</h3>";
            echo "<p>Category: {$fetch_menu['category']}</p>";
            echo "<img src='images/{$fetch_menu['image_url']}' alt='{$fetch_menu['name']}' class='dish-image'>";
            echo "<p>Description: {$fetch_menu['description']}</p>";
            if (isset($fetch_menu['price'])) {
                echo "<p>Price: {$fetch_menu['price']} TK</p>"; 
            } else {
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
        echo "<p>No items found in the menu.</p>";
    }
    ?>

    <?php include 'footer.php'; ?>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <script src="js/script.js"></script>

    <script>
        var swiper = new Swiper(".reviews-slider", {
        
        });
    </script>

</body>

</html>
