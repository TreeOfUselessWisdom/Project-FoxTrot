<?php if (!isset($_SESSION['user_id'])) { ?>
    <script>alert("You must be logged in to access this page."); window.location.href = "signin.php";</script>
<?php } ?>

<?php
include 'aside.php';

// Establish a database connection
$conn = new mysqli("localhost", "root", "", "Filmfare");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Movie</h5>
                    <form action="add_movie.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Movie_name" class="form-label">Movie Name</label>
                            <input type="text" class="form-control" id="Movie_name" name="Movie_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_description" class="form-label">Movie Description</label>
                            <textarea class="form-control" id="movie_description" name="Movie_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="movie_price" class="form-label">Movie Price</label>
                            <input type="number" class="form-control" id="movie_price" name="movie_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_image" class="form-label">Movie Image</label>
                            <input type="file" class="form-control" id="movie_image" name="movie_image" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_rating" class="form-label">Movie Rating</label>
                            <input type="number" class="form-control" id="movie_rating" name="movie_rating" step="0.1" min="0" max="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Movies</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="moviesTable">
                        <?php
                        $sql = "SELECT * FROM movies";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";                       
                                echo "<td>" . $row["movie_id"] . "</td>";                  
                                echo "<td>" . $row["movie_name"] . "</td>";                      
                                echo "<td>" . $row["movie_description"] . "</td>";                        
                                echo "<td><img src='" . $row["movie_image"] . "' width='50' height='50'></td>";                        
                                echo "<td>" . $row["movie_price"] . "</td>"; 
                                echo "<td>";                        
                                echo "<a href='EditMovie.php?id=" . $row["movie_id"] . "' class='btn btn-sm btn-primary'>Edit</a>";                       
                                echo "<a href='delete_movie.php?movie_id=" . $row["movie_id"] . "' target='_blank' class='btn btn-sm btn-danger'>Delete</a>";                        
                                echo "<a type='button' class='btn btn-sm btn-success'>View</a>";                        
                                echo "</td>";                       
                                echo "</tr>";                        
                            }
                        } else {
                            echo "<tr><td colspan='5'>No movies found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Movie Timings</h5>
            <form action="add_movie_timings.php" method="post">
                <div class="mb-3">
                    <label for="movie_id" class="form-label">Select Movie</label>
                    <select class="form-control" id="movie_id" name="movie_id" required>
                        <option value="">Select Movie</option>
                        <?php
                        $sql = "SELECT * FROM movies";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["movie_id"] . "'>" . $row["movie_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="show_date" class="form-label">Show Date</label>
                    <input type="date" class="form-control" id="show_date" name="show_date" required>
                </div>
                <div class="mb-3">
                    <label for="show_time" class="form-label">Show Time</label>
                    <input type="time" class="form-control" id="show_time" name="show_time" required>
                </div>
                <button type="submit" class="btn btn -primary">Add Timings</button>
            </form>
        </div>
    </div>
</div>
   

