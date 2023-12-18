<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
?>
<?php


include 'db_connection.php'; 
if (isset($_GET['restaurant_id'])) {
    $restaurant_id = $_GET['restaurant_id'];

    $restaurant_query = $conn->prepare("SELECT * FROM `restaurants` WHERE restaurant_id = ?");
    $restaurant_query->execute([$restaurant_id]);
    $restaurant = $restaurant_query->fetch(PDO::FETCH_ASSOC);

    if ($restaurant) {
        echo '<h1>' . $restaurant['name'] . ' Menu</h1>';

        $show_menu = $conn->prepare("SELECT * FROM `menu` WHERE restaurant_id = ? ORDER BY category");
        $show_menu->execute([$restaurant_id]);

        $current_category = null;

        if ($show_menu->rowCount() > 0) {
            while ($menu = $show_menu->fetch(PDO::FETCH_ASSOC)) {
                if ($menu['category'] !== $current_category) {
                    $current_category = $menu['category'];
                    echo '<h2>' . $current_category . '</h2>';
                }
                echo '<div class="menu-item">';
                echo '<img src="images/' . $menu['image_url'] . '" alt="' . $menu['name'] . '">';
                echo '<h3>' . $menu['name'] . '</h3>';
                echo '<p>Description: ' . $menu['description'] . '</p>';
                echo '<p>Price: $' . $menu['price'] . '</p>';
                echo "<form action='add_to_cart.php' method='post'>";
                echo "<input type='number' name='qty' class='qty' min='1' max='99' value='1' maxlength='2'>";
                echo "<input type='hidden' name='pid' value='{$menu['product_id']}'>";
                echo "<input type='hidden' name='name' value='{$menu['name']}'>";
                echo "<input type='hidden' name='price' value='{$menu['price']}'>";
                echo "<input type='hidden' name='image' value='{$menu['image_url']}'>";
                if (isset($_SESSION['user_id'])) {
                    echo "<button type='submit' name='add_to_cart' class='cart-btn'>Add to Cart</button>";
                } else {
                    echo "<p>Please <a href='login_form.php'>log in</a> to add items to the cart.</p>";
                }
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo '<p>No menu items found for this restaurant.</p>';
        }
    } else {
        echo '<p>Restaurant not found.</p>';
    }
} else {
    echo '<p>No restaurant ID provided.</p>';
}
?>
