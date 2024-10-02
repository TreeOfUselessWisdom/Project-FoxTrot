<?php
// Include the database connection file
include 'db.php';

// Get the movie ID from the URL parameter
$movie_id = $_GET['id'];

// Get the form data
$adult_quantity = $_POST['adult_quantity'] ?? '';
$child_quantity = $_POST['child_quantity'] ?? '';
$ticket_type = $_POST['ticket_type'] ?? '';
$timing = $_POST['timing'] ?? '';
$package_price = $_POST['package_price'] ?? '';
$total_price = $_POST['total_price'] ?? '';
$card_number = $_POST['card_number'] ?? '';
$expiration_date = $_POST['expiration_date'] ?? '';
$cvv = $_POST['cvv'] ?? '';

// Print out the form data for debugging purposes
print_r($_POST);

// Validate the form data
if ($adult_quantity == '' || $child_quantity == '' || $ticket_type == '' || $timing == '' || $total_price == '' || $card_number == '' || $expiration_date == '' || $cvv == '') {
    echo "Please fill out all fields.";
    exit;
  }

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to make a purchase.'); window.location.href = 'login.php';</script>";
    exit;
}
  
// Remove the comma from the total price
$total_price = str_replace(',', '', $total_price);

// Create a new payment record in the database
$query = "INSERT INTO payments (movie_id, user_id, payment_date, payment_amount, payment_method, payment_status) VALUES (?, ?, NOW(), ?, ?, 'pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiids", $movie_id, $_SESSION['user_id'], $total_price, $card_number);
$stmt->execute();

// Get the payment ID from the last insert
$payment_id = $stmt->insert_id;

// Update the payment status to "success" if the payment is successful
if ($total_price > 0) {
  $query = "UPDATE payments SET payment_status = 'success' WHERE payment_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $payment_id);
  $stmt->execute();
}

// Redirect the user to a confirmation page
header("Location: confirmation.php?payment_id=$payment_id");
exit;
