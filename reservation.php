<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Make a Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .reservation-form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-input {
            width: calc(100% - 12px);
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .submit-btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <h1 style="text-align: center;">Make a Reservation</h1>
    <form action="process_reservation.php" method="post" class="reservation-form">
        <div class="form-group">
            <label for="contact_number" class="form-label">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="reservation_date" class="form-label">Reservation Date:</label>
            <input type="date" id="reservation_date" name="reservation_date" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="reservation_time" class="form-label">Reservation Time:</label>
            <input type="time" id="reservation_time" name="reservation_time" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="num_guests" class="form-label">Number of Guests:</label>
            <input type="number" id="num_guests" name="num_guests" class="form-input" required>
        </div>

        <input type="submit" value="Make Reservation" class="submit-btn">
    </form>
    
<?php include 'footer.php'; ?>
</body>
</html>
