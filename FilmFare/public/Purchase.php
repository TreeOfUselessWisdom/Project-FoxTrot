<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, show an alert and redirect them to the login page
    echo '<script>alert("You must be logged in to access this page."); window.location.href = "login.php";</script>';
    exit;
}
include 'aside.php';
include 'db.php';

$movie_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM movies WHERE movie_id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

$movie_title = $movie['movie_name'];
$movie_description = $movie['movie_description'];
$movie_price = $movie['movie_price'];
$movie_image = $movie['movie_image'];

$stmt = $conn->prepare("SELECT * FROM movie_timings WHERE movie_id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$timings = array();
while ($timing = $result->fetch_assoc()) {
    $timings[] = $timing;
}

// Insert review into database
if (isset($_POST['submit_review'])) {
    $movie_id = $_GET['id'];
    $user_name = $_POST['user_name'];
    $location = $_POST['location'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
  
    if (!empty($review)) {
      $stmt = $conn->prepare("INSERT INTO reviews (movie_id, user_name, location, rating, review) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issis", $movie_id, $user_name, $location, $rating, $review);
      $stmt->execute();
  
      // Redirect to the same page to prevent multiple submissions
      header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $movie_id);
      exit;
    }
  }

  // Display reviews
  $stmt = $conn->prepare("SELECT * FROM reviews WHERE movie_id = ?");
  $stmt->bind_param("i", $movie_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $reviews = array();
  while ($review = $result->fetch_assoc()) {
    $reviews[] = $review;
  }




?>


<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>FilmFare | Your Go To Movie Site</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="assets/css/theme.css" rel="stylesheet" />

  </head>


  <style>
    .seat-selection {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s;
    }
    .seat.selected {
        background-color: #007bff; 
        color: white;
    }
    .seat:hover {
        background-color: #007bff; 
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }
    .seat.locked {
        background-color: #ccc; 
        color: #666;
        pointer-events: none; /* Disable interaction for locked seats */
    }
</style>



<!-- Movie Buying Page -->


<div class="container-fluid full-width-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4">Buy Movie Tickets</h1>
            <br>
            <form action="process_purchase.php?id=<?php echo $movie_id; ?>" method="post">
                <!-- Movie Details -->
                <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="display-5"><?php echo $movie_title; ?></h2>
                                <p class="lead"><?php echo $movie_description; ?></p>
                                <p class="text-muted">Price: <?php echo number_format($movie_price, 2) . ' Rs'; ?></p>
                                <p>
                                    <?php
                                    $rating = $movie['rating'];
                                    $stars = '';
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $rating) {
                                            $stars .= '<i class="fas fa-star"></i>';
                                        } else {
                                            $stars .= '<i class="far fa-star grey-star"></i>';
                                        }
                                    }
                                    echo $stars . ' (' . $rating . '/5)';
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <img src="<?php echo $movie_image; ?>" alt="<?php echo $movie_title; ?>" class="img-fluid rounded" style="height: 350px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Quantity Selection -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="adult_quantity" class="form-label">Adults:</label>
                            <input type="number" id="adult_quantity" name="adult_quantity" value="1" min="1" class="form-control" onchange="calculateTotal()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="child_quantity" class="form-label">Children:</label>
                            <input type="number" id="child_quantity" name="child_quantity" value="0" min="0" class="form-control" onchange="calculateTotal()">
                        </div>
                    </div>
                </div>

                <!-- Timing Select Option -->
                <div class="mb-3">
                    <label for="timing" class="form-label">Timing:</label>
                    <select id="timing" name="timing" class="form-select">
                        <?php foreach ($timings as $timing) { ?>
                            <option value="<?php echo $timing['timing_id']; ?>"><?php echo date('g:i A', strtotime($timing['show_time'])) . ' on ' . date('M j, Y', strtotime($timing['show_date'])); ?></option>
                        <?php } ?>
                    </select>
                </div>

<!-- Package Selection Option -->
<div class="mb-3">
    <label for="package" class="form-label">Package:</label>
    <?php
    $stmt = $conn->prepare("SELECT * FROM packages");
    $stmt->execute();
    $result = $stmt->get_result();
    $i = 0;
    while ($package = $result->fetch_assoc()) {
        ?>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="package_price" id="<?php echo $package['package_name']; ?>" value="<?php echo $package['package_price']; ?>" onchange="calculateTotal(); lockSeats()" <?php if ($i == 0) { echo 'checked'; } ?>>
            <label class="form-check-label" for="<?php echo $package['package_name']; ?>"><?php echo $package['package_name']; ?> (Rs <?php echo number_format($package['package_price'], 2); ?>)</label>
        </div>
    <?php $i++; } ?>
</div>


                        <!-- Seat Selection Section -->
                        <div class="mb-3">
                            <label for="seat_selection" class="form-label">Select Seats:</label>
                            <div id="seat_selection" class="seat-selection">
                                <div class="row justify-content-center">
                                    <?php
                                    // Generate main seats (A1-A30)
                                    for ($i = 1; $i <= 30; $i++) {
                                        echo '<div class="col-1">
                                                <div class="seat" data-seat="A' . $i . '">' . $i . '</div>
                                            </div>';
                                        if ($i % 10 == 0) echo '</div><div class="row justify-content-center">'; // new row after every 10 seats
                                    }

                                    // Generate special seats (B1-B10)
                                    for ($i = 1; $i <= 10; $i++) {
                                        echo '<div class="col-1 offset-1">
                                                <div class="seat" data-seat="B' . $i . '">B' . $i . '</div>
                                            </div>';
                                        if ($i % 5 == 0) echo '</div><div class="row justify-content-center">'; // new row after every 5 special seats
                                    }
                                    ?>
                                </div>
                            </div>
                            <input type="hidden" id="selected_seats" name="selected_seats" value="">
                        </div>



                        <!-- Total Price -->
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Price:</label>
                            <input type="text" id="total_price" name ="total_price" value="<?php echo number_format($movie_price, 2); ?>" class="form-control" readonly>
                        </div>
                        <div class="card mb-3">
                            <h3 class="display-6">Payment Details</h3>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="card_number" class="form-label">Card Number:</label>
                                            <input type="text" id="card_number" name="card_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="expiration_date" class="form-label">Expiration Date:</label>
                                            <input type="date" id="expiration_date" name="expiration_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cvv" class="form-label">CVV:</label>
                                            <input type="text" id="cvv" name="cvv" class="form-control">
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <!-- Purchase Button -->
                        <button type="submit" class="btn btn-primary">Purchase Tickets</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<br>
<br>
<br>

<!-- Review Form -->
<div class="container-fluid full-width-container">
<div class="card mb-3">
  <h3 class="display-6">Leave a Review</h3>
  <div class="card-body">
    <form action="" method="post">
      <div class="mb-3">
        <label for="user_name" class="form-label">Name:</label>
        <input type="text" id="user_name" name="user_name" class="form-control">
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Location:</label>
        <input type="text" id="location" name="location" class="form-control">
      </div>
      <div class="mb-3">
        <label for="rating" class="form-label">Rating:</label>
        <select id="rating" name="rating" class="form-select">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="review" class="form-label">Review:</label>
        <textarea id="review" name="review" class="form-control"></textarea>
      </div>
      <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
    </form>
  </div>
</div>
</div>
<!-- Display Reviews -->
<div class="container-fluid full-width-container">
<div class="card mb-3">
  <h3 class="display-6">Reviews</h3>
  <div class="card-body">
    <?php foreach ($reviews as $review) { ?>
      <div class="review">
        <h5><?php echo $review['user_name']; ?> (<?php echo $review['location']; ?>)</h5>
        <p><?php echo $review['review']; ?></p>
        <p>Rating: <?php echo $review['rating']; ?>/5</p>
      </div>
    <?php } ?>
  </div>
</div>
</div>


<script>
function calculateTotal() {
    var adultQuantity = document.getElementById('adult_quantity').value || 0;
    var childQuantity = document.getElementById('child_quantity').value || 0;
    var packagePrice = Array.from(document.getElementsByName('package_price')).reduce((acc, radio) => {
        return radio.checked ? parseFloat(radio.value) : acc;
    }, 0);
    var moviePrice = <?php echo $movie_price; ?>;

    var totalPrice = (moviePrice * adultQuantity) + (moviePrice * 0.5 * childQuantity) + packagePrice;

    document.getElementById('total_price').value = totalPrice.toFixed(2);
}

// Call calculateTotal on page load to set initial state
window.onload = calculateTotal;

// Call calculateTotal whenever the quantity changes
document.getElementById('adult_quantity').oninput = calculateTotal;
document.getElementById('child_quantity').oninput = calculateTotal;

function lockSeats() {
    var adultQuantity = document.getElementById('adult_quantity').value || 0;
    var childQuantity = document.getElementById('child_quantity').value || 0;
    var totalSeats = parseInt(adultQuantity) + parseInt(childQuantity);

    var basicSelected = false;
    var vipSelected = false;
    var premiumSelected = false;

    // Check which package is selected
    Array.from(document.getElementsByName('package_price')).forEach(radio => {
        if (radio.checked) {
            if (radio.id === "Basic") {
                basicSelected = true;
            } else if (radio.id === "VIP") {
                vipSelected = true;
            } else if (radio.id === "Premium") {
                premiumSelected = true;
            }
        }
    });

    // Logic to lock or unlock seats
    var allSeats = document.querySelectorAll('.seat'); // All seats
    var bSeats = document.querySelectorAll('.seat[data-seat^="B"]'); // Select B seats
    var aSeats = document.querySelectorAll('.seat[data-seat^="A"]'); // Select A seats

    // Lock all seats initially
    allSeats.forEach(seat => {
        seat.classList.add('locked'); // Add locked class
        seat.classList.remove('selected'); // Remove selected class
    });

    if (basicSelected) {
        // Unlock A seats based on total quantity
        var i = 0;
        aSeats.forEach(seat => {
            if (i < totalSeats) {
                seat.classList.remove('locked'); // Unlock A seats
            }
            i++;
        });
    } else if (vipSelected) {
        // Unlock all B seats
        bSeats.forEach(seat => {
            seat.classList.remove('locked'); // Unlock B seats
        });
    } else if (premiumSelected) {
        // Unlock all A seats
        aSeats.forEach(seat => {
            seat.classList.remove('locked'); // Unlock A seats
        });
    }

    // Attach click event to seats for selection
    allSeats.forEach(seat => {
        seat.onclick = function () {
            if (!this.classList.contains('locked')) {
                var selectedSeats = document.querySelectorAll('.seat.selected');
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected'); // Deselect the seat
                } else if (selectedSeats.length < totalSeats) {
                    this.classList.add('selected'); // Select the seat
                }
            }
        };
    });
}

// Call lockSeats on page load to set initial state
window.onload = lockSeats;

// Call lockSeats whenever the quantity changes
document.getElementById('adult_quantity').onchange = lockSeats;
document.getElementById('child_quantity').onchange = lockSeats;
</script>

