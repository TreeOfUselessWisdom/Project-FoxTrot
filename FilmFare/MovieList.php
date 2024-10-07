<?php
session_start();
include 'db.php';
include 'aside.php';
?>

<!-- Rest of your MovieList.php file content here -->
<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="pt-5" id="destination">

    <div class="container">
        <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4"><img src="assets/img/dest/shape.svg" alt="destination" /></div>
        <div class="row">
        <?php
// Fetch the movies and their timings from the database
$query = "SELECT m.movie_id, m.movie_name, m.movie_description, m.movie_image, m.movie_price, m.rating 
            FROM movies m";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $movie_id = $row['movie_id'];
        $movie_name = $row['movie_name'];
        $movie_description = $row['movie_description'];
        $movie_image = $row['movie_image'];
        $movie_price = $row['movie_price'];
        $rating = $row['rating'];
?>
        <div class="col-md-4 mb-4">
            <div class="card overflow-hidden shadow"> 
                <img class="card-img-top" src="<?php echo $movie_image; ?>" alt="<?php echo $movie_name; ?>">
                <div class="card-body py-4 px-3">    
                    <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                        <h4 class="text-secondary fw-medium"><a class="link-900 text-decoration-none stretched-link" href="Purchase.php?id=<?php echo $movie_id; ?>"><?php echo $movie_name; ?></a></h4>
                        <span class="fs-1 fw-medium"><?php echo number_format($movie_price, 2) . ' Rs'; ?></span>
                    </div>
                    <div class="mt-2">
                        <span class="fs-1 fw-medium">
                            <?php
                            $stars = '';
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $rating) {
                                    $stars .= '<i class="fas fa-star"></i>';
                                } else {
                                    $stars .= '<i class="far fa-star"></i>';
                                }
                            }
                            echo $stars . ' (' . $rating . '/5)';
                            ?>
                        </span>
                    </div>
                    <div class="d-flex align-items-center"> 
                        <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                        <span class="fs-0 fw-medium"><?php echo $movie_description; ?></span>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "No movies found";
}
?>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <?php
    include 'footer.php';
    ?>