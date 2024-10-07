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
?>

<!-- Movie Buying Page -->

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="display-4">Buy Movie Tickets</h1>
            <form action="process_purchase.php?id=<?php echo $movie_id; ?>" method="post">
                <!-- Movie Details -->
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
                        <!-- Quantity Selection -->
                        <div class="mb-3">
                            <label for="adult_quantity" class="form-label">Adults:</label>
                            <input type="number" id="adult_quantity" name="adult_quantity" value="1" min="1" class="form-control" onchange="calculateTotal()">
                        </div>
                        <div class="mb-3">
                            <label for="child_quantity" class="form-label">Children:</label>
                            <input type="number" id="child_quantity" name="child_quantity" value="0" min="0" class="form-control" onchange="calculateTotal()">
                        </div>
                        <!-- Ticket Type Selection -->
                        <div class="mb-3">
                            <label for="ticket_type" class="form-label">Ticket Type:</label>
                            <select id="ticket_type" name="ticket_type" class="form-select" onchange="calculateTotal()">
                                <option value="adult">Adult</option>
                            </select>
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
                                    <input class="form-check-input" type="radio" name="package_price" id="<?php echo $package['package_name']; ?>" value="<?php echo $package['package_price']; ?>" onchange="calculateTotal()" <?php if ($i == 0) { echo 'checked'; } ?>>
                                    <label class="form-check-label" for="<?php echo $package['package_name']; ?>"><?php echo $package['package_name']; ?> (Rs <?php echo number_format($package['package_price'], 2); ?>)</label>
                                </div>
                            <?php $i++; } ?>
                        </div>

                        <!-- Total Price -->
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Price:</label>
                            <input type="text" id="total_price" name="total_price" value="<?php echo number_format($movie_price, 2); ?>" class="form-control" readonly>
                        </div>
                        <!-- Payment Information -->
                        <div class="card mb-3">
                            <h3 class="display-6">Payment Details</h3>
                            <div class="mb-3">
                                <label for="card_number" class="form-label">Card Number:</label>
                                <input type="text" id="card_number" name="card_number" placeholder="1234-5678-9012-3456" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">Expiration Date:</label>
                                <input type="text" id="expiration_date" name="expiration_date" placeholder="MM/YY" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="cvv" class="form-label">CVV:</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" class="form-control" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Buy Tickets</button>
                    </div>
                    <div class="col-md-6">
                        <img class="img-fluid" src="<?php echo $movie_image; ?>" alt="<?php echo $movie_title; ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculateTotal() {
    var adultQuantity = document.getElementById('adult_quantity').value || 0;
    var childQuantity = document.getElementById('child_quantity').value || 0;
    var packagePrice = Array.from(document.getElementsByName('package')).reduce((acc, radio) => {
        return radio.checked ? parseFloat(radio.value) : acc;
    }, 0);
    var moviePrice = <?php echo $movie_price; ?>;
    
    var totalPrice = (moviePrice * adultQuantity) + (moviePrice * 0.5 * childQuantity) + packagePrice;
    
    document.getElementById('total_price').value = totalPrice.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
</script>