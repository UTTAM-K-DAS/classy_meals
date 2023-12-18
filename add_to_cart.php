<?php
include 'db_connection.php';
session_start();

if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'] ?? '';

    $pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);

    if ($user_id && $pid && $qty) {
        $stmt = $conn->prepare("SELECT name, price, image_url FROM menu WHERE product_id = ?");
        $stmt->execute([$pid]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $name = $product['name'];
            $price = $product['price'];
            $image = $product['image_url'];

            $insert_cart = $conn->prepare("INSERT INTO cart (user_id, pid, name, price, quantity, `image`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            

            header('Location: cart.php');
            exit();
        } else {
            header('Location: menu.php?message=product_not_found');
            exit();
        }
    } else {
        header('Location: menu.php?message=error_invalid_data');
        exit();
    }
}
?>
