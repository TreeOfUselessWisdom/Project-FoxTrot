<?php
include 'aside.php';
include 'db.php';
?>

        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end">
              <img class="pt-7 pt-md-0 hero-img" src="assets/img/hero/pexels-brunomassao-2095594-removebg.png" alt="hero-header" />
            </div>
            <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
              <h4 class="fw-bold text-danger mb-3">Top Movies to Watch Now</h4>
              <h1 class="hero-title">Experience the thrill of cinema</h1>
              <p class="mb-4 fw-medium">Explore the latest blockbusters and timeless classics.<br class="d-none d-xl-block" />Immerse yourself in captivating stories and breathtaking visuals.<br class="d-none d-xl-block" />Book your tickets now and enjoy an unforgettable night out.</p>
              <div class="text-center text-md-start">
                <a class="btn btn-primary btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow" href="#!" role="button">Discover More</a>
                <div class="w-100 d-block d-md-none"></div>
                <a href="#!" role="button" data-bs-toggle="modal" data-bs-target="#popupVideo">
                  <span class="btn btn-danger round-btn-lg rounded-circle me-3 danger-btn-shadow">
                    <img src="assets/img/hero/play.svg" width="15" alt="play" />
                  </span>
                </a>
                <span class="fw-medium">Watch Trailer</span>
                <div class="modal fade" id="popupVideo" tabindex="-1" aria-labelledby="popupVideo" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <iframe class="rounded" style="width:100%;max-height:500px;" height="500px" src="https://www.youtube.com/embed/_lhdhL4UDIo" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pt-5 pt-md-9" id="service">

        <div class="container">
          <div class="position-absolute z-index--1 end-0 d-none d-lg-block"><img src="assets/img/category/shape.svg" style="max-width: 200px" alt="service" /></div>
          <div class="mb-7 text-center">
            <h5 class="text-secondary">CATEGORY </h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">We Offer Best Services</h3>
          </div>
          <div class="row">
            <div class="col-lg-3 col-sm-6 mb-6">
              <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                <div class="card-body p-xxl-5 p-4"> <img src="assets/img/category/icon1.png" width="75" alt="Service" />
                  <h4 class="mb-3">Cinema Signals</h4>
                  <p class="mb-0 fw-medium">Stay connected! Get the latest movie updates and news.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-6">
              <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                <div class="card-body p-xxl-5 p-4"> <img src="assets/img/category/icon2.png" width="75" alt="Service" />
                  <h4 class="mb-3">Quick Tickets</h4>
                  <p class="mb-0 fw-medium">Fast and easy! Book your cinema tickets in seconds.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-6">
              <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                <div class="card-body p-xxl-5 p-4"> <img src="assets/img/category/icon3.png" width="75" alt="Service" />
                  <h4 class="mb-3">Movie Buzz</h4>
                  <p class="mb-0 fw-medium">Hear it first! Exclusive movie announcements just for you.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-6">
              <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                <div class="card-body p-xxl-5 p-4"> <img src="assets/img/category/icon4.png" width="75" alt="Service" />
                  <h4 class="mb-3">Customization</h4>
                  <p class="mb-0 fw-medium">Manage your account settings for a personalized experience.</p>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pt-5" id="destination">

        <div class="container">
          <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4"><img src="assets/img/dest/shape.svg" alt="destination" /></div>
          <div class="mb-7 text-center">
            <h5 class="text-secondary">Top Selling </h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Top Picks</h3>
          </div>
          <div class="row">
            <?php
            // Fetch the top-rated movies
            $query = "SELECT m.movie_id, m.movie_name, m.movie_description, m.movie_image, m.movie_price, m.rating 
                        FROM movies m
                        ORDER BY m.rating DESC
                        LIMIT 3";
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
                echo "No top picks found";
            }
            ?>
          </div>
          <div class="text-center"> 
            <a class="btn btn-primary btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow" id="Button_new" href="#!" role="button">Find more</a>
          </div>
        </div>
        <!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="booking">

        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="mb-4 text-start">
                <h5 class="text-secondary">Simple and Fast </h5>
                <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Book your next movie in 3 easy steps</h3>
              </div>
              <div class="d-flex align-items-start mb-5">
                <div class="bg-primary me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="assets/img/steps/selection.svg" width="22" alt="steps" /></div>
                <div class="flex-1">
                  <h5 class="text-secondary fw-bold fs-0">Choose Your Movie</h5>
                  <p>Select the movie you want to watch  <br class="d-none d-sm-block">from our latest lineup. </p>
                </div>
              </div>
              <div class="d-flex align-items-start mb-5">
                <div class="bg-danger me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="assets/img/steps/water-sport.svg" width="22" alt="steps" /></div>
                <div class="flex-1">
                  <h5 class="text-secondary fw-bold fs-0">Pick Your Seats</h5>
                  <p>Find the perfect spot in the cinema <br class="d-none d-sm-block"> and reserve your seats.</p>
                </div>
              </div>
              <div class="d-flex align-items-start mb-5">
                <div class="bg-info me-sm-4 me-3 p-3" style="border-radius: 13px"> <img src="assets/img/steps/taxi.svg" width="22" alt="steps" /></div>
                <div class="flex-1">
                  <h5 class="text-secondary fw-bold fs-0">Complete Your Booking</h5>
                  <p>Finalize your payment and get ready for <br class="d-none d-sm-block"> an amazing show.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center align-items-start">
              <div class="card position-relative shadow" style="max-width: 370px;">
                <div class="position-absolute z-index--1 me-10 me-xxl-0" style="right:-160px;top:-210px;"> <img src="assets/img/steps/bg.png" style="max-width:550px;" alt="shape" /></div>
                <div class="card-body p-3"> <img class="mb-4 mt-2 rounded-2 w-100" src="assets/img/steps/Dunkirkbanner.png" alt="Dunkirk" />
                  <div>
                    <h5 class="fw-medium">Movie: Dunkirk</h5>
                    <p class="fs--1 mb-3 fw-medium">Showtime: 7:00 PM | Director: Robbin Joseph</p>
                    <div class="icon-group mb-4"> <span class="btn icon-item"> 
                      <img src="assets/img/steps/popcorn.svg" alt=""/></span><span class="btn icon-item"> 
                        <img src="assets/img/steps/ticket.svg" alt=""/></span><span class="btn icon-item"> 
                          <img src="assets/img/steps/cinema.svg" alt=""/></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center mt-n1"><img class="me-3" src="assets/img/steps/building.svg" width="18" alt="building" /><span class="fs--1 fw-medium">24 seats booked</span></div>
                      <div class="show-onhover position-relative">
                        <div class="card hideEl shadow position-absolute end-0 start-xl-50 bottom-100 translate-xl-middle-x ms-3" style="width: 260px;border-radius:18px;">
                          <div class="card-body py-3">
                            <div class="d-flex">
                              <div style="margin-right: 10px"> <img class="rounded-circle" src="assets/img/steps/favorite-placeholder.png" width="50" alt="favorite" /></div>
                              <div>
                                <p class="fs--1 mb-1 fw-medium">Upcoming </p>
                                <h5 class="fw-medium mb-3">Escape From Dunkirk</h5>
                                <h6 class="fs--1 fw-medium mb-2"><span>20%</span> tickets sold</h6>
                                <div class="progress" style="height: 6px;">
                                  <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button class="btn"> <img src="assets/img/steps/heart.svg" width="20" alt="step" /></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->


            <!-- ============================================-->
      <!-- <section> begin ============================-->
        <section class="pt-5" id="destination">

          <div class="container">
            <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4">
              <img src="assets/img/dest/shape.svg" alt="destination" />
            </div>
            <div class="mb-7 text-center">
              <h5 class="text-secondary">Top Selling</h5>
              <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Packages</h3>
            </div>
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="card overflow-hidden shadow">
                  <img class="card-img-top" src="assets/img/dest/pexels-pavel-danilyuk-7234212.jpg" alt="All Quiet on the Western Front" />
                  <div class="card-body py-4 px-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                      <h4 class="text-secondary fw-medium"><a class="link-900 text-decoration-none stretched-link" href="#!">Basic Package</a></h4>
                      <span class="fs-1 fw-medium">5,000 Rs</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                      <span class="fs-0 fw-medium">Enjoy a classic experience.</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card overflow-hidden shadow">
                  <img class="card-img-top" src="assets/img/dest/pexels-pavel-danilyuk-7234212.jpg" alt="Dunkirk" />
                  <div class="card-body py-4 px-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                      <h4 class="text-secondary fw-medium"><a class="link-900 text-decoration-none stretched-link" href="#!">Premium Package</a></h4>
                      <span class="fs-1 fw-medium">20,000 Rs</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                      <span class="fs-0 fw-medium">Custom Seats</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card overflow-hidden shadow">
                  <img class="card-img-top" src="assets/img/dest/pexels-pavel-danilyuk-7234212.jpg" alt="Forest Gump" />
                  <div class="card-body py-4 px-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                      <h4 class="text-secondary fw-medium"><a class="link-900 text-decoration-none stretched-link" href="#!">VIP Package</a></h4>
                      <span class="fs-1 fw-medium">50,000 Rs</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                      <span class="fs-0 fw-medium">Rooms Upper Level</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <a class="btn btn-primary btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow" id="Button_new" href="#!" role="button">Explore More Packages</a>
            </div>
          </div>
          <!-- end of .container-->
        
        </section>
        
        <!-- <section> close ============================-->
        <!-- ============================================-->
  


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="testimonial">

        <div class="container">
          <div class="row">
            <div class="col-lg-5">
              <div class="mb-8 text-start">
                <h5 class="text-secondary">Audience Reviews</h5>
                <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">What viewers are saying about us.</h3>
              </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-6">
              <div class="pe-7 ps-5 ps-lg-0">
                <div class="carousel slide carousel-fade position-static" id="testimonialIndicator" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    <button class="active" type="button" data-bs-target="#testimonialIndicator" data-bs-slide-to="0" aria-current="true" aria-label="Review 0"></button>
                    <button class="false" type="button" data-bs-target="#testimonialIndicator" data-bs-slide-to="1" aria-current="true" aria-label="Review 1"></button>
                    <button class="false" type="button" data-bs-target="#testimonialIndicator" data-bs-slide-to="2" aria-current="true" aria-label="Review 2"></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item position-relative active">
                      <div class="card shadow" style="border-radius:10px;">
                        <div class="position-absolute start-0 top-0 translate-middle">
                          <img class="rounded-circle fit-cover" src="assets/img/testimonial/author.png" height="65" width="65" alt="" />
                        </div>
                        <div class="card-body p-4">
                          <p class="fw-medium mb-4">&quot;An unforgettable cinematic experience! The ambiance and the films are simply top-notch.&quot;</p>
                          <h5 class="text-secondary">Mike Taylor</h5>
                          <p class="fw-medium fs--1 mb-0">Lahore, Pakistan</p>
                        </div>
                      </div>
                      <div class="card shadow-sm position-absolute top-0 z-index--1 mb-3 w-100 h-100" style="border-radius:10px;transform:translate(25px, 25px)"></div>
                    </div>
                    <div class="carousel-item position-relative">
                      <div class="card shadow" style="border-radius:10px;">
                        <div class="position-absolute start-0 top-0 translate-middle">
                          <img class="rounded-circle fit-cover" src="assets/img/testimonial/author2.png" height="65" width="65" alt="" />
                        </div>
                        <div class="card-body p-4">
                          <p class="fw-medium mb-4">&quot;The best cinema experience I've had! Their movie selection is fantastic, and the staff is so friendly.&quot;</p>
                          <h5 class="text-secondary">Thomas Wagon</h5>
                          <p class="fw-medium fs--1 mb-0">CEO of Red Button</p>
                        </div>
                      </div>
                      <div class="card shadow-sm position-absolute top-0 z-index--1 mb-3 w-100 h-100" style="border-radius:10px;transform:translate(25px, 25px)"></div>
                    </div>
                    <div class="carousel-item position-relative">
                      <div class="card shadow" style="border-radius:10px;">
                        <div class="position-absolute start-0 top-0 translate-middle">
                          <img class="rounded-circle fit-cover" src="assets/img/testimonial/author3.png" height="65" width="65" alt="" />
                        </div>
                        <div class="card-body p-4">
                          <p class="fw-medium mb-4">&quot;A wonderful place to watch movies! The atmosphere is lively, and the popcorn is amazing!&quot;</p>
                          <h5 class="text-secondary">Kelly Williams</h5>
                          <p class="fw-medium fs--1 mb-0">Khulna, Bangladesh</p>
                        </div>
                      </div>
                      <div class="card shadow-sm position-absolute top-0 z-index--1 mb-3 w-100 h-100" style="border-radius:10px;transform:translate(25px, 25px)"></div>
                    </div>
                  </div>
                  <div class="carousel-navigation d-flex flex-column flex-between-center position-absolute end-0 top-lg-50 bottom-0 translate-middle-y z-index-1 me-3 me-lg-0" style="height:60px;width:20px;">
                    <button class="carousel-control-prev position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="prev">
                      <img src="assets/img/icons/up.svg" width="16" alt="icon" />
                    </button>
                    <button class="carousel-control-next position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="next">
                      <img src="assets/img/icons/down.svg" width="16" alt="icon" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->


      <div class="position-relative pt-9 pt-lg-8 pb-6 pb-lg-8">
        <div class="container">
          <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2 flex-center">
            <div class="col">
              <div class="card shadow-hover mb-4" style="border-radius:10px;">
                <div class="card-body text-center"> <img class="img-fluid" src="assets/img/partner/CineHub.png" alt="" /></div>
              </div>
            </div>
            <div class="col">
              <div class="card shadow-hover mb-4" style="border-radius:10px;">
                <div class="card-body text-center"> <img class="img-fluid" src="assets/img/partner/Filmix.png" alt="" /></div>
              </div>
            </div>
            <div class="col">
              <div class="card shadow-hover mb-4" style="border-radius:10px;">
                <div class="card-body text-center"> <img class="img-fluid" src="assets/img/partner/ReelCo.png" alt="" /></div>
              </div>
            </div>
            <div class="col">
              <div class="card shadow-hover mb-4" style="border-radius:10px;">
                <div class="card-body text-center"> <img class="img-fluid" src="assets/img/partner/StarBox.png" alt="" /></div>
              </div>
            </div>
            <div class="col">
              <div class="card shadow-hover mb-4" style="border-radius:10px;">
                <div class="card-body text-center"> <img class="img-fluid" src="assets/img/partner/PopSpot.png" alt="" /></div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pt-6">

        <div class="container">
          <div class="py-8 px-5 position-relative text-center" style="background-color: rgba(223, 215, 249, 0.199);border-radius: 129px 20px 20px 20px;">
            <div class="position-absolute start-100 top-0 translate-middle ms-md-n3 ms-n4 mt-3"> <img src="assets/img/cta/send.png" style="max-width:70px;" alt="send icon" /></div>
            <div class="position-absolute end-0 top-0 z-index--1"> <img src="assets/img/cta/shape-bg2.png" width="264" alt="cta shape" /></div>
            <div class="position-absolute start-0 bottom-0 ms-3 z-index--1 d-none d-sm-block"> <img src="assets/img/cta/shape-bg1.png" style="max-width: 340px;" alt="cta shape" /></div>
            <div class="row justify-content-center">
              <div class="col-lg-8 col-md-10">
                <h2 class="text-secondary lh-1-7 mb-7">Subscribe to get information, latest news and other interesting offers about Cobham</h2>
                <form class="row g-3 align-items-center w-lg-75 mx-auto">
                  <div class="col-sm">
                    <div class="input-group-icon">
                      <input class="form-control form-little-squirrel-control" type="email" placeholder="Enter email " aria-label="email" /><img class="input-box-icon" src="assets/img/cta/mail.svg" width="17" alt="mail" />
                    </div>
                  </div>
                  <div class="col-sm-auto">
                    <button class="btn btn-danger orange-gradient-btn fs--1">Subscribe</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




<?php
include 'footer.php';
?>