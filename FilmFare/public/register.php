<?php
// Start output buffering
ob_start();

// Start the session
session_start();

// Include the database connection file
include 'db.php';

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['register'])) {
  // Get the username, email, and password from the form
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the username and email are already taken
  $query = "SELECT * FROM users WHERE username = ? OR email = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Check if the username and email are available
  if (mysqli_num_rows($result) == 0) {
    // Hash the password
    $hashed_password = password_hash ($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    mysqli_stmt_execute($stmt);

    // Get the user's ID and store it in the session
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['logged_in'] = true;

    // Clear the output buffer and redirect the user
    ob_end_clean();
    header("Location: index.php");
    exit;
  } else {
    echo "<div class='alert alert-danger'>Username or email is already taken.</div>";
  }
}
?>

<?php
include 'aside.php';
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body">
          <h2>Register</h2>
          <form action="" method="post">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" class="form-control ">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include 'footer.php';
?>