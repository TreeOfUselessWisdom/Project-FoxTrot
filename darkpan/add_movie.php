<?php
include 'db.php';

$movie_name = $_POST['Movie_name'];
$movie_description = $_POST['Movie_description'];
$movie_image = $_FILES['movie_image']['name'];
$movie_price = $_POST['movie_price'];
$movie_rating = $_POST['movie_rating'];
$trailer_url = $_POST['trailer_url'];

$target_dir = "img/dest/";
$movie_image = $_FILES['movie_image']['name'];
$target_file = $target_dir . basename($movie_image);
move_uploaded_file($_FILES['movie_image']['tmp_name'], $target_file);

$stmt = $conn->prepare("INSERT INTO movies (movie_name, movie_description, movie_price, movie_image, rating) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $movie_name, $movie_description, $movie_price, $target_file, $movie_rating);
$stmt->execute();

$movie_id = $stmt->insert_id;

$stmt = $conn->prepare("INSERT INTO trailers (movie_id, trailer_url) VALUES (?, ?)");
$stmt->bind_param("is", $movie_id, $trailer_url);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  echo "Movie added successfully";
} else {
  echo "Error: " . $stmt->error;
}
?>