<?php
include 'db.php';

$movie_id = $_POST['movie_id'];
$show_date = $_POST['show_date'];
$show_time = $_POST['show_time'];

$sql = "INSERT INTO movie_timings (movie_id, show_date, show_time) VALUES ('$movie_id', '$show_date', '$show_time')";
if ($conn->query($sql) === TRUE) {
  echo "Movie timings added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>