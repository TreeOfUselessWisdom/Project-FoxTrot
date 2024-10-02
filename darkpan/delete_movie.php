<?php
include 'db.php';

if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    // Prepare a statement to delete movie timings associated with the movie
    $sql = "DELETE FROM movie_timings WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close(); // Close the statement

    // Prepare a statement to delete the movie
    $sql = "DELETE FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    if ($stmt->execute()) {
        echo "Movie deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close(); // Close the statement
} else {
    echo "Error: Movie ID not provided";
}
?>