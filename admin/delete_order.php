<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

if(isset($_GET['order_id']) && isset($_GET['user_id'])) {
    $order_id = $_GET['order_id'];
    $user_id = $_GET['user_id'];

    try {
    

        $sql = "DELETE FROM orders WHERE order_id = :order_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        header("Location: placed_orders.php");
        exit(); 
    } catch(PDOException $e) {
        echo "Error deleting order: " . $e->getMessage();
    }
} else {
    echo "Error: Missing order_id or user_id.";
}
?>
