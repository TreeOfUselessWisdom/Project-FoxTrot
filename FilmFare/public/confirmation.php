<?php
// Include the database connection file
include 'db.php';
$conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

// Get the payment ID from the URL parameter
$payment_id = $_GET['payment_id'];

// Get the payment information from the database
$query = "SELECT * FROM payments WHERE payment_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "Error preparing SQL statement: " . $conn->errno . " - " . $conn->error . " (" . $conn->sqlstate . ")";
    exit;
}
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();

// Get the movie information from the database
$query = "SELECT movie_name FROM movies WHERE movie_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "Error preparing SQL statement: " . $conn->errno . " - " . $conn->error . " (" . $conn->sqlstate . ")";
    exit;
}
$stmt->bind_param("i", $payment['movie_id']);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();



// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, show an alert and redirect them to the login page
    echo '<script>alert("You must be logged in to access this page."); window.location.href = "login.php";</script>';
    exit;
}
?>

<!-- Confirmation Page -->

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
  <!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>FilmFare | Your Go To Movie Site</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="assets/css/theme.css" rel="stylesheet" />

  </head>
  </head>
<body>
    



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="display-4"><?php echo $movie['movie_name']; ?> Payment Successful!</h1>
            <p class="lead">Thank you for your purchase. Your payment has been processed successfully.</p>
            <p>Payment ID: <?php echo $payment['payment_id']; ?></p>
            <p>Movie ID: <?php echo $payment['movie_id']; ?></p>
            <p>Payment Amount: <?php echo $payment['payment_amount']; ?></p>
            <p>Payment Method: <?php echo $payment['payment_method']; ?></p>
            <p>Payment Status: <?php echo $payment['payment_status']; ?></p>
            <a href="movielist.php" class="btn btn-primary">Back to Movie List</a>
        </div>
    </div>
</div>

</body>
</html>