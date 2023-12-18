<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Restaurants</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style1.css"> 
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Restaurants</h3>
   <p><a href="index.php">home</a> <span> / restaurants</span></p>
</div>

<div class="restaurants-container">
    <?php
    include 'db_connection.php'; 
    
    try {
        $stmt = $conn->prepare("SELECT restaurant_iD, name, image_url, location, description FROM restaurants");
        $stmt->execute();
    
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($restaurants) {
            echo '<div class="restaurants-list">';
            foreach ($restaurants as $restaurant) {
                echo '<div class="restaurant">';
                echo '<img src="images/' . $restaurant['image_url'] . '" alt="' . $restaurant['name'] . '" class="image">';
                echo '<h3>' . $restaurant['name'] . '</h3>';
                echo '<p><strong>Location:</strong> ' . $restaurant['location'] . '</p>';
                echo '<p>' . $restaurant['description'] . '</p>';
                echo '<a href="reservation.php?restaurant_id=' . $restaurant['restaurant_iD'] . '&restaurant_name=' . urlencode($restaurant['name']) . '" class="reservation-btn">Make a Reservation</a>';
                echo '<a href="restaurantsmenu.php?restaurant_id=' . $restaurant['restaurant_iD'] . '" class="menu-btn">Restaurant Menu</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "No restaurants found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>

<?php include 'footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script> 
</html>
