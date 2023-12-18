<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    $restaurant_id = $_POST['restaurant_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $reservation_date = $_POST['reservation_date'] ?? '';
    $reservation_time = $_POST['reservation_time'] ?? '';
    $num_guests = $_POST['num_guests'] ?? '';

    if (empty($restaurant_id) || empty($name) || empty($contact_number) || empty($reservation_date) || empty($reservation_time) || empty($num_guests)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO reservations (restaurant_id, name, contact_number, reservation_date, reservation_time, num_guests) VALUES (?, ?, ?, ?, ?, ?)");
            
            $stmt->bindParam(1, $restaurant_id);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $contact_number);
            $stmt->bindParam(4, $reservation_date);
            $stmt->bindParam(5, $reservation_time);
            $stmt->bindParam(6, $num_guests);
            
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                header("Location: reservation_success.php");
                exit();
            } else {
                echo "Failed to create a reservation.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
