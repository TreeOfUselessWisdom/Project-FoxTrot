<?php
include 'db.php';

$movie_id = $_GET['id'];
$movie_name = $_POST['Movie_name'];
$movie_description = $_POST['Movie_description'];
$movie_image = $_FILES['movie_image']['name'];

$sql = "UPDATE movies SET movie_name = '$movie_name', movie_description = '$movie_description', movie_image = '$movie_image' WHERE movie_id = '$movie_id'";
if ($conn->query($sql) === TRUE) {
  echo "Movie updated successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>