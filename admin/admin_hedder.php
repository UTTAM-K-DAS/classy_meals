<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

$admin_id = isset($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 0;

if ($admin_id > 0) {
    $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE admin_id = ?");
    $select_profile->execute([$admin_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    if ($fetch_profile) {
        $admin_name = htmlspecialchars($fetch_profile['name']);
    } else {
        $admin_name = "Unknown"; 
    }
} else {
    $admin_name = "Unknown";}
?>

<header class="header">
   <section class="flex">
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>
      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="restaurants.php">restaurents</a>
         <a href="placed_orders.php">Orders</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
         <a href="messages.php">Messages</a>
         <a href="reservations_page.php">Reservations</a>
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <p><?= $admin_name; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Login</a>
            <a href="register_admin.php" class="option-btn">Register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
      </div>
   </section>
</header>


</body>
</html>
