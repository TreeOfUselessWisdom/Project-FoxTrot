<?php
include 'db.php';

if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    // Delete associated payments
    $sql = "DELETE FROM payments WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close(); // Close the statement

    // Delete movie timings
    $sql = "DELETE FROM movie_timings WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close(); // Close the statement

    // Delete the trailer
    $sql = "DELETE FROM trailers WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close(); // Close the statement

    // Delete the movie
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