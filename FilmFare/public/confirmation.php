<?php
// Include the database connection file
include 'db.php';

// Get the payment ID from the URL parameter
$payment_id = $_GET['payment_id'];

// Get the payment information from the database
$query = "SELECT * FROM payments WHERE payment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();

// Display a confirmation message to the user
echo "Thank you for your payment! Your payment has been successfully processed.";

// Display additional information about the payment
echo "Payment ID: " . $payment['payment_id'];
echo "Movie ID: " . $payment['movie_id'];
echo "Payment Amount: " . $payment['payment_amount'];
echo "Payment Method: " . $payment['payment_method'];
echo "Payment Status: " . $payment['payment_status'];
?>