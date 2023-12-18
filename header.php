<?php
include 'db_connection.php';



try {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $count_cart_items = $conn->prepare("SELECT SUM(quantity) AS total_products FROM `cart` WHERE user_id = ?");
        $count_cart_items->execute([$user_id]);
        $total_cart_items = $count_cart_items->fetchColumn();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">CLASSY_MEAL🍽</a>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="about.php">about</a>
            <a href="restaurants.php">restaurants</a>
            <a href="orders.php" class="order-btn">orders</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <a href='search.php'><i class='fas fa-search'></i></a>          
            <a href='cart.php'><i class='fas fa-shopping-cart'></i><span><?= ($total_cart_items ?? 0) ?></span></a>
            <a href='profile.php'><i class='fas fa-user'></i></a>

            <div id='menu-btn' class='fas fa-bars'></div>
        </div>
    </section>
</header>

<div class="user">
    <?php
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
        $select_user->execute([$user_id]);

        if ($select_user->rowCount() > 0) {
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="name"><?= $fetch_user['name']; ?></p>
            <?php
        } else {
            ?>
            <div class="flex">
                <a href="login.php" class="btn signin-btn">Sign In</a>
                <a href="signup_form.php" class="btn register-btn">Register</a>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="flex">
            <a href="login.php" class="btn signin-btn">Sign In</a>
            <a href="signup_form.php" class="btn register-btn">Register</a>
        </div>
        <?php
    }
    ?>
</div>
