    <?php
    session_start();
    include 'db.php';
    include 'aside.php';
    ?>

    <style>

#play {
  cursor: pointer;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateY(-50%) translateX(-50%);
}

    .stroke-solid {
  stroke-dashoffset: 0;
  stroke-dashArray: 300;
  stroke-width: 4px;
  transition: stroke-dashoffset 1s ease, 
              opacity 1s ease;
}

.icon {
  transform: scale(.8);
  transform-origin: 50% 50%;
  transition: transform 200ms ease-out;
}

#play:hover {
  .stroke-solid {
    opacity: 1;
    stroke-dashoffset: 300;
  }
  .icon {
    transform: scale(.9);
  }
}
    </style>




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-5" id="destination">

        <div class="container">
            <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4"><img src="assets/img/dest/shape.svg" alt="destination" /></div>
            <div class="row">
            <?php
// Fetch the movies and their timings from the database
$query = "SELECT m.movie_id, m.movie_name, m.movie_description, m.movie_image, m.movie_price, m.rating, t.trailer_url 
            FROM movies m
            LEFT JOIN trailers t ON m.movie_id = t.movie_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $movie_id = $row['movie_id'];
        $movie_name = $row['movie_name'];
        $movie_description = $row['movie_description'];
        $movie_image = $row['movie_image'];
        $movie_price = $row['movie_price'];
        $rating = $row['rating'];
        $trailer_url = $row['trailer_url'];
        $trailer_url = str_replace('youtu.be/', 'www.youtube.com/embed/', $trailer_url);
        $trailer_url = explode('?si=', $trailer_url);
        $trailer_url = $trailer_url[0];

?>

<!-- Create a modal for each movie trailer -->
<div class="modal fade" id="popupVideo-<?php echo $movie_id; ?>" tabindex="-1" aria-labelledby="popupVideo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <iframe class="rounded" style="width:100%;max-height:500px;" height="500px" src="<?php echo $trailer_url; ?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>
        </div>
    </div>
</div>

<div class="col-md-4 mb-4">
    <div class="card overflow-hidden shadow position-relative"> 
        <div class="position-relative">
            <img class="card-img-top" src="<?php echo $movie_image; ?>" alt="<?php echo $movie_name; ?>">
            <?php if ($trailer_url) { ?>
                <a href="#!" class="glightbox" data-bs-toggle="modal" data-bs-target="#popupVideo-<?php echo $movie_id; ?>">
                    <svg version="1.1" id="play" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="100px" width="100px"
                         viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                        <path class="stroke-solid" fill="none" stroke="#FF0000"  d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                            C97.3,23.7,75.7,2.3,49.9,2.5"/>
                        <path class="icon" fill="#FF0000" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z"/>
                    </svg>
                </a>
            <?php } ?>
        </div>
        <div class="card-body py-4 px-3">    
            <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                <h4 class="text-secondary fw-medium"><?php echo $movie_name; ?></h4>
                <span class="fs-1 fw-medium"><?php echo number_format($movie_price, 2) . ' Rs'; ?></span>
            </div>

            <div class="mt-2">
                <span class="fs-1 fw-medium">
                    <?php
                    $rating = round($rating); 
                    $stars = '';
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $rating) {
                            $stars .= '<i class="fas fa-star"></i>';
                        } else {
                            $stars .= '<i class="far fa-star"></i>';
                        }
                    }
                    if ($rating == intval($rating)) { 
                        echo $stars . ' (' . $rating . '/5)';
                    } else {
                        echo $stars . ' (' . number_format($rating, 1) . '/5)';
                    }
                    ?>
                </span>
            </div>
                    <div class="d-flex align -items-center"> 
                        <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                        <span class="fs-0 fw-medium"><?php echo $movie_description; ?></span>
                    </div>
                    <a href="Purchase.php?id=<?php echo $movie_id; ?>" class="btn btn-primary mt-3">Purchase</a>
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

    <script>
    // Get all trailer containers
    const trailerContainers = document.querySelectorAll('.trailer-container');

    // Add event listener to each trailer container
    trailerContainers.forEach((container) => {
        const trailer = container.querySelector('.trailer');
        const playButton = container.querySelector('.play-button');

        // Add event listener to the play button
        playButton.addEventListener('click', () => {
            // Play the trailer
            trailer.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
        });
    });
    </script>