<?php
include 'C:\xampp\htdocs\classy_meals\db_connection.php';

$select_reservations = $conn->prepare("SELECT * FROM reservations");
$select_reservations->execute();
$reservations = $select_reservations->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservations</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<section class="messages">



<?php include 'c:\xampp\htdocs\classy_meals\admin\admin_hedder.php'; ?>
    <h1>Reservations</h1>

    <table>
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Restaurant ID</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>Number of Guests</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation) { ?>
                <tr>
                    <td><?php echo $reservation['reservation_id']; ?></td>
                    <td><?php echo $reservation['restaurant_id']; ?></td>
                    <td><?php echo $reservation['name']; ?></td>
                    <td><?php echo $reservation['contact_number']; ?></td>
                    <td><?php echo $reservation['reservation_date']; ?></td>
                    <td><?php echo $reservation['reservation_time']; ?></td>
                    <td><?php echo $reservation['num_guests']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
