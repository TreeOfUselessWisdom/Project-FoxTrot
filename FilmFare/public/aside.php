
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


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-5 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="assets/img/FilmFare.png" height="50" alt="logo" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
    <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-lg-center align-items-start">
        <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="#service">Services</a></li>
        <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="MovieList.php">Movies</a></li>
        <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="Purchase.php">Booking</a></li>
        <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="#testimonial">Testimonial</a></li>
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li class="nav-item px-3 px-xl-4"><span class="nav-link fw-medium" aria-current="page">Welcome, <?php echo $_SESSION['username']; ?>!</span></li>
          <li class="nav-item px-3 px-xl-4"><a class="btn btn-outline-dark order-1 order-lg-0 fw-medium" href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="login.php">Login</a></li>
          <li class="nav-item px-3 px-xl-4"><a class="btn btn-outline-dark order-1 order-lg-0 fw-medium" href="register.php">Sign Up</a></li>
        <?php } ?>
        <li class="nav-item dropdown px-3 px-lg-0"> <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">EN</a>
          <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius:0.3rem;" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#!">EN</a></li>
            <li><a class="dropdown-item" href="#!">BN</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
      <section style="padding-top: 7rem;">
        <div class="bg-holder" style="background-image:url(assets/img/hero/hero-bg.svg);">
        </div>
        <!--/.bg-holder-->