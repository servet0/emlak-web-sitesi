<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>EstateAgency Bootstrap Template</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: EstateAgency
    Theme URL: https://bootstrapmade.com/real-estate-agency-bootstrap-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <!--/ Nav Star /-->
  <?php include 'navbar.php'; ?>
  <!--/ Nav End /-->

  <!--/ Carousel Star /-->
  <?php
include 'baglan.php';

// Son 3 veriyi çek
$query = "SELECT * FROM kiralik_daireler ORDER BY id DESC LIMIT 3";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Sorgu başarısız: " . mysqli_error($conn));
}
?>
<div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="carousel-item-a intro-item bg-image" style="background-image: url('<?php echo $row['resim']; ?>')">
                <div class="overlay overlay-a"></div>
                <div class="intro-content display-table">
                    <div class="table-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="intro-body">
                                        <p class="intro-title-top">
                                            <?php echo $row['konum']; ?>
                                            <br> Genişlik: <?php echo $row['alan']; ?> m²
                                        </p>
                                        <h1 class="intro-title mb-4">
                                            <span class="color-b"> <?php echo $row['baslik']; ?></span>
                                        </h1>
                                        <p class="intro-subtitle intro-price">
                                            <a href="#"><span class="price-a">Kira Fiyatı | <?php echo $row['fiyat']; ?> TL</span></a>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        
    </div>
</div>


  <!--/ Carousel end /-->

  <!--/ Services Star /-->
  <section class="section-services section-t8">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="title-wrap d-flex justify-content-between">
            <div class="title-box">
              <h2 class="title-a">Our Services</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="fa fa-gamepad"></span>
              </div>
              <div class="card-title-c align-self-center">
                <h2 class="title-c">Lifestyle</h2>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Sed porttitor lectus nibh. Cras ultricies ligula sed magna dictum porta. Praesent sapien massa,
                convallis a pellentesque
                nec, egestas non nisi.
              </p>
            </div>
            <div class="card-footer-c">
              <a href="#" class="link-c link-icon">Read more
                <span class="ion-ios-arrow-forward"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="fa fa-usd"></span>
              </div>
              <div class="card-title-c align-self-center">
                <h2 class="title-c">Loans</h2>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Nulla porttitor accumsan tincidunt. Curabitur aliquet quam id dui posuere blandit. Mauris blandit
                aliquet elit, eget tincidunt
                nibh pulvinar a.
              </p>
            </div>
            <div class="card-footer-c">
              <a href="#" class="link-c link-icon">Read more
                <span class="ion-ios-arrow-forward"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="fa fa-home"></span>
              </div>
              <div class="card-title-c align-self-center">
                <h2 class="title-c">Sell</h2>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Sed porttitor lectus nibh. Cras ultricies ligula sed magna dictum porta. Praesent sapien massa,
                convallis a pellentesque
                nec, egestas non nisi.
              </p>
            </div>
            <div class="card-footer-c">
              <a href="#" class="link-c link-icon">Read more
                <span class="ion-ios-arrow-forward"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Services End /-->

  <!--/ Property Star /-->
  <?php
include 'baglan.php';

// Son 4 veriyi çek
$query = "SELECT * FROM kiralik_daireler ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Sorgu başarısız: " . mysqli_error($conn));
}
?>
<section class="section-property section-t8">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-wrap d-flex justify-content-between">
                    <div class="title-box">
                        <h2 class="title-a">Kiralık Daireler</h2>
                    </div>
                    <div class="title-link">
                        <a href="property-grid.html">Tüm Daireler
                            <span class="ion-ios-arrow-forward"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="property-carousel" class="owl-carousel owl-theme">
            <?php
            // Veritabanından alınan her mülk için slider öğesi oluşturuyoruz
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="carousel-item-b">
                        <div class="card-box-a card-shadow">
                            <div class="img-box-a">
                                <img src="<?php echo $row['resim']; ?>" alt="" class="img-a img-fluid">
                            </div>
                            <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                    <div class="card-header-a">
                                        <h2 class="card-title-a">
                                            <a href="property-single.html"><?php echo $row['baslik']; ?></a>
                                        </h2>
                                    </div>
                                    <div class="card-body-a">
                                        <div class="price-box d-flex">
                                            <span class="price-a">Fiyat | $<?php echo $row['fiyat']; ?></span>
                                        </div>
                                        <a href="property-single.html" class="link-a">Click here to view
                                            <span class="ion-ios-arrow-forward"></span>
                                        </a>
                                    </div>
                                    <div class="card-footer-a">
                                        <ul class="card-info d-flex justify-content-around">
                                            <li>
                                                <h4 class="card-info-title">Genişlik</h4>
                                                <span><?php echo $row['alan']; ?>m<sup>2</sup></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Oda</h4>
                                                <span><?php echo $row['oda_sayisi']; ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Banyo</h4>
                                                <span><?php echo $row['banyo_sayisi']; ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Garaj</h4>
                                                <span><?php echo $row['garaj']; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No properties found.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
  <!--/ Property End /-->
  <br>
  <br>
  <br>
  <!--/ Footer End /-->
  <?php include 'footer.php'; ?>
  <!--/ Footer End /-->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/popper/popper.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/scrollreveal/scrollreveal.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>
</html>
