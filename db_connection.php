<?php

$servername = "localhost";
$username = "uttam";
$password = "221009612";
$dbname = "classy_meals";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage(), 0);

    echo "Oops! Something went wrong. Please try again later.";
}
?>
