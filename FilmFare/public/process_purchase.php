<?php
// Start the session
session_start();
// Include the database connection file
include 'db.php';

// Get the movie ID from the form variable
$movie_id = $_POST['movie_id'];

// Get the form data
$adult_quantity = $_POST['adult_quantity'] ?? '';
$child_quantity = $_POST['child_quantity'] ?? '';
$timing = $_POST['timing'] ?? '';
$package_price = $_POST['package_price'] ?? '';
$total_price = $_POST['total_price'] ?? '';
$card_number = $_POST['card_number'] ?? '';
$expiration_date = $_POST['expiration_date'] ?? '';
$cvv = $_POST['cvv'] ?? '';

// Print out the form data for debugging purposes
print_r($_POST);

// Validate the form data
if ($adult_quantity == '' || $child_quantity == '' || $timing == '' || $total_price == '' || $card_number == '' || $expiration_date == '' || $cvv == '') {
    echo "Please fill out all fields.";
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('You must be logged in to make a purchase.'); window.location.href = 'login.php';</script>";
  exit;
} else {
  // If the user is logged in, display their user ID
  echo "You are logged in as user ID: " . $_SESSION['user_id'];
}

// Remove the comma from the total price
$total_price = str_replace(',', '', $total_price);

// Check if the movie ID is empty
if (empty($movie_id)) {
    echo "Error: Movie ID is empty.";
    exit;
}

// Retrieve the total price from the form, remove the comma separator, and convert it to a numeric value
$total_price = floatval($total_price);

// Check if the total price is empty
if (empty($total_price)) {
    echo "Error: Total price is empty.";
    exit;
}

// Create a new payment record in the database
$query = "INSERT INTO payments (movie_id, user_id, payment_amount, payment_method, payment_status, payment_date) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($query);

$user_id = $_SESSION['user_id'];
$payment_method = 'card';
$payment_status = 'success';

$stmt->bind_param("iiiss", $movie_id, $user_id, $total_price, $payment_method, $payment_status);
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