<!DOCTYPE html>
<html>
<head>
    <title>Payment Form</title>
</head>
<body>
    <form action="process_bkash_payment.php" method="post">
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="password">bKash Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="hidden" name="user_id" value="123"> 

        <input type="submit" value="Submit">
    </form>
</body>
</html>
