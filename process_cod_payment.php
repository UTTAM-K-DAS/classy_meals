<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        try {
            $select_cart = $conn->prepare("SELECT quantity, price FROM cart WHERE user_id = :user_id");
            $select_cart->bindParam(':user_id', $user_id);
            $select_cart->execute();
            $cart_items = $select_cart->fetchAll(PDO::FETCH_ASSOC);

            $total_products = 0;
            $total_price = 0;

            foreach ($cart_items as $item) {
                $total_products += $item['quantity'];
                $total_price += $item['quantity'] * $item['price'];
            }

            $user_details_query = "SELECT name, email, number, address FROM users WHERE user_id = :user_id";
            $stmt = $conn->prepare($user_details_query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $user_details = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_details) {
                $name = $user_details['name'];
                $email = $user_details['email'];
                $number = $user_details['number'];
                $address = $user_details['address'];

                $method = $_POST['payment_method']; 
                $payment_status = 'Pending'; 

                $insert_order_query = "INSERT INTO orders (user_id, placed_on, name, email, number, address, method, total_products, total_price, payment_status) 
                                       VALUES (:user_id, NOW(), :name, :email, :number, :address, :method, :total_products, :total_price, :payment_status)";
                $stmt = $conn->prepare($insert_order_query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':number', $number);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':method', $method);
                $stmt->bindParam(':total_products', $total_products);
                $stmt->bindParam(':total_price', $total_price);
                $stmt->bindParam(':payment_status', $payment_status);
                
                if ($stmt->execute()) {
                    $clear_cart_query = "DELETE FROM cart WHERE user_id = :user_id";
                    $stmt = $conn->prepare($clear_cart_query);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();

                    header('Location: orders.php');
                    exit();
                } else {
                    echo "Error placing order.";
                }
            } else {
                echo "User details not found.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "User not logged in.";
    }
}
?>
