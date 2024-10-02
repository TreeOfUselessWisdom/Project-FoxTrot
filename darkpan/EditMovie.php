<?php if (!isset($_SESSION['user_id'])) { ?>
    <script>alert("You must be logged in to access this page."); window.location.href = "login.php";</script>
<?php } ?>
<?php
include 'aside.php';

// Establish a database connection
$conn = new mysqli("localhost", "root", "", "Filmfare");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the movie ID from the URL parameter
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
} else {
    echo "Error: No movie ID provided";
    exit;
}

// Retrieve the movie details from the database
$sql = "SELECT * FROM movies WHERE movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc();
} else {
    echo "Error: No movie found with ID $movie_id";
    exit;
}
$stmt->close(); // Close the statement

// Retrieve the movie timings from the database
$sql = "SELECT * FROM movie_timings WHERE movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $movie_timings = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $movie_timings = array();
}
$stmt->close(); // Close the statement

// Check if the form was submitted correctly
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $movie_name = $_POST['Movie_name'];
    $movie_description = $_POST['Movie_description'];
    $movie_price = $_POST['movie_price'];
    $movie_rating = $_POST['movie_rating'];

    try {
        // Prepare a new statement for the update query
        $stmt = $conn->prepare("UPDATE movies SET movie_name = ?, movie_description = ?, movie_price = ?, rating = ? WHERE movie_id = ?");
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $conn->error);
        }
        
        // Bind the parameters
        $stmt->bind_param("ssssi", $movie_name, $movie_description, $movie_price, $movie_rating, $id);
        
        // Execute the query
        $stmt->execute();

        // Handle file upload
        if (isset($_FILES['movie_image']) && $_FILES['movie_image']['error'] == 0) {
            $movie_image = $_FILES['movie_image']['name'];
            $target_dir = "img/dest/";
            $target_file = $target_dir . basename($movie_image);
            move_uploaded_file($_FILES['movie_image']['tmp_name'], $target_file);
        } else {
            $movie_image = ''; // or set a default value
        }

        // Update the movie image
        if ($movie_image) {
            $stmt = $conn->prepare("UPDATE movies SET movie_image = ? WHERE movie_id = ?");
            $stmt->bind_param("si", $target_file, $id);
            $stmt->execute();
        }
    } catch (Exception $e) {
        echo "Error updating movie: " . $e->getMessage();
    }
}

if (isset($_POST['update_timings'])) {
    try {
        // Update the movie timings
        $existingShowDates = $_POST['existing_show_date'];
        $existingShowTimes = $_POST['existing_show_time'];
        $newShowDates = $_POST['new_show_date'];
        $newShowTimes = $_POST['new_show_time'];

        // Update existing timings
        foreach ($existingShowDates as $i => $showDate) {
            $showTime = $existingShowTimes[$i];

            // Check if the show date and time combination already exists
            $sql = "SELECT COUNT(*) AS count FROM movie_timings WHERE movie_id = ? AND show_date = ? AND show_time = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $id, $showDate, $showTime);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                // Update the timing
                $sql = "UPDATE movie_timings SET show_time = ? WHERE movie_id = ? AND show_date = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $showTime, $id, $showDate);
                $stmt->execute();
                $stmt->close(); // Close the statement
            } else {
                // Insert new timing
                $sql = "INSERT INTO movie_timings (movie_id, show_date, show_time) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $id, $showDate, $showTime);
                $stmt->execute();
                $stmt->close(); // Close the statement
            }
        }

        // Delete existing entries
        $sql = "DELETE FROM movie_timings WHERE movie_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close(); // Close the statement

        // Insert new entries
        foreach ($newShowDates as $i => $showDate) {
            $showTime = $newShowTimes[$i];

            $sql = "INSERT INTO movie_timings (movie_id, show_date, show_time) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt ->bind_param("iss", $id, $showDate, $showTime);
            $stmt->execute();
            $stmt->close(); // Close the statement
        }
 } catch (Exception $e) {
        echo "Error updating movie timings: " . $e->getMessage();
    }
}


?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Movie</h5>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $movie_id; ?>">
                        <div class="mb-3">
                            <label for="Movie_name" class="form-label">Movie Name</label>
                            <input type="text" class="form-control" id="Movie_name" name="Movie_name" value="<?php echo $movie['movie_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_description" class="form-label">Movie Description</label>
                            <textarea class="form-control" id="movie_description" name="Movie_description" rows="3"><?php echo $movie['movie_description']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="movie_price" class="form-label">Movie Price</label>
                            <input type="number" class="form-control" id="movie_price" name="movie_price" value="<?php echo $movie['movie_price']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_image" class="form-label">Movie Image</label>
                            <input type="file" class="form-control" id="movie_image" name="movie_image">
                            <p>Current image: <?php echo $movie['movie_image']; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="movie_rating" class="form-label">Movie Rating</label>
                            <input type="number" class="form-control" id="movie_rating" name="movie_rating" step="0.1" min="0" max="5" value="<?php echo $row['rating']; ?>" required>
                        </div>
                        <h5>Current Movie Timings</h5>
                            <?php foreach ($movie_timings as $timing) { ?>
                            <div class="mb-3">
                                <label for="show_date" class="form-label">Show Date</label>
                                <?php
                                $id = $timing['timing_id'];
                                $day = $timing['show_date'] ?? '';
                                $time = $timing['show_time'] ?? '';
                                ?>
                                <input type="date" class="form-control" id="show_date_<?php echo $id; ?>" name="existing_show_date[]" value="<?php echo $day; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="show_time" class="form-label">Show Time</label>
                                <input type="time" class="form-control" id="show_time_<?php echo $id; ?>" name="existing_show_time[]" value="<?php echo $time; ?>" required>
                            </div>
                            <?php } ?>

                            <h5>Replace Existing Timings</h5>
                            <div class="mb-3">
                                <label for="new_show_date" class="form-label">New Show Date (optional)</label>
                                <input type="date" class="form-control" id="new_show_date" name="new_show_date[]" value="">
                            </div>
                            <div class="mb-3">
                                <label for="new_show_time" class="form-label">New Show Time (optional)</label>
                                <input type="time" class="form-control" id="new_show_time" name="new_show_time[]" value="">
                            </div>
                        <button type="submit" name="update_movie" class="btn btn-primary">Update Movie</button>
                        <button type="submit" name="update_timings" class="btn btn-primary">Update Timings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>