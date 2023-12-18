
<?php
include 'db_connection.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location: index.php');
}


if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE user_id = ?");
      $update_name->execute([$name, $user_id]);
   }

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select_email->execute([$email]);
      if($select_email->rowCount() > 0){
         $message[] = 'email already taken!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE user_id = ?");
         $update_email->execute([$email, $user_id]);
      }
   }

   if(!empty($number)){
      $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
      $select_number->execute([$number]);
      if($select_number->rowCount() > 0){
         $message[] = 'number already taken!';
      }else{
         $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE user_id = ?");
         $update_number->execute([$number, $user_id]);
      }
   }
   
   // ...
$empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
$select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE user_id = ?");
$select_prev_pass->execute([$user_id]);
$fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
$prev_pass = $fetch_prev_pass['password'];
$old_pass = $_POST['old_pass']; // No need to sanitize password input here
$new_pass = $_POST['new_pass']; // No need to sanitize password input here
$confirm_pass = $_POST['confirm_pass']; // No need to sanitize password input here

if ($old_pass !== $empty_pass && $old_pass === $prev_pass) {
    if ($new_pass === $confirm_pass) {
        // Hash the new password before storing it
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        // Update the password
        $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE user_id = ?");
        $update_pass->execute([$hashed_password, $user_id]);
        $message[] = 'Password updated successfully!';
    } else {
        $message[] = 'New password and confirmation do not match!';
    }
} elseif ($old_pass !== $empty_pass && $old_pass !== $prev_pass) {
    $message[] = 'Old password is incorrect!';
} elseif ($old_pass === $empty_pass && $new_pass !== $empty_pass) {
    $message[] = 'Please enter your old password!';
}
// ...

      
   
     

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="form-container update-form">


<form action="" method="post">
    <h3>Update Profile</h3>
    <input type="text" name="name" placeholder="Enter your new name" value="<?= htmlspecialchars($fetch_profile['name']); ?>" class="box" maxlength="50"><br><br>
    <input type="email" name="email" placeholder="Enter your new email" value="<?= htmlspecialchars($fetch_profile['email']); ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"><br><br>
    <input type="tel" name="number" placeholder="Enter your new phone number" value="<?= htmlspecialchars($fetch_profile['number']); ?>" class="box" pattern="[0-9]{10}" maxlength="10"><br><br>
    <input type="password" name="old_pass" placeholder="Enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"><br><br>
    <input type="password" name="new_pass" placeholder="Enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"><br><br>
    <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"><br><br>
    <input type="submit" value="Update Now" name="submit" class="btn">
</form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>