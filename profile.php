<?php

include 'db_connection.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];

   $select_user = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
   $select_user->execute([$user_id]);
   $fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);
}else{
   $user_id = '';
   header('location:index.php');
   exit();}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="user-details">
   <div class="user">
      <img src="images/user-icon.png" alt="">
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name']; ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="update_profile.php" class="btn">Update Info</a>
      <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php echo ($fetch_profile['address'] == '') ? 'Please enter your address' : $fetch_profile['address']; ?></span></p>
      <a href="update_address.php" class="btn">Update Address</a>
      <form action="logout.php" method="POST">
    <button type="submit" class="btn">Logout</button>
</form>
   </div>
   
</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
