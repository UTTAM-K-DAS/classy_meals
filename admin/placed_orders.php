<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit(); // Ensure to stop the script after redirection
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css"></head>

<body>

    <?php include 'C:\xampp\htdocs\classy_meals\admin\admin_hedder.php' ?>

    <section class="placed-orders">
        <h1 class="heading">Placed Orders</h1>

        <div class="box-container">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();

            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <p>User ID: <?= $fetch_orders['user_id']; ?></p>
                        <p>Placed On: <?= $fetch_orders['placed_on']; ?></p>
                        <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['pid']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
         <div class="flex-btn">
    <form action="update_payment.php" method="POST">
        <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
        <input type="hidden" name="user_id" value="<?= $fetch_orders['user_id']; ?>">

        <input type="submit" value="Update" class="btn" name="update_payment">
    </form>

    <a href="delete_order.php?order_id=<?= $fetch_orders['order_id']; ?>&user_id=<?= $fetch_orders['user_id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
</div>


                        <?php
                        $product_id = $fetch_orders['pid'];
                        $select_menu = $conn->prepare("SELECT * FROM `menu` WHERE product_id = ?");
                        $select_menu->execute([$product_id]);

                        if ($select_menu->rowCount() > 0) {
                            while ($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <div class="menu-details">
                                    <p>Menu ID: <?= $fetch_menu['product_id']; ?></p>
                                    <p>Name: <?= $fetch_menu['name']; ?></p>
                                    <p>Category: <?= $fetch_menu['category']; ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="empty">No menu details found for this order</p>';
                        }
                        ?>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            ?>
        </div>
    </section>

    
</body>

</html>
