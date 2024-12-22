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


  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">304 Blaster Up</h1>
            <span class="color-text-a">Chicago, IL 606543</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="property-grid.html">Properties</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                304 Blaster Up
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Single Star /-->
  <?php
// baglan.php dosyasını dahil ediyoruz
include 'baglan.php';

// Gelen ID'yi alıyoruz ve geçerli olup olmadığını kontrol ediyoruz
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Geçersiz ilan ID.");
}

// Veritabanından ilgili ilanı çekiyoruz
$query = "SELECT * FROM kiralik_daireler WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id); // Parametreyi bağla
mysqli_stmt_execute($stmt); // Sorguyu çalıştır
$result = mysqli_stmt_get_result($stmt); // Sonuçları al

// Sonuçları kontrol ediyoruz
$row = mysqli_fetch_assoc($result);

// Eğer ilan bulunamazsa hata veriyoruz
if (!$row) {
    die("İlan bulunamadı.");
}
?>

<!-- Property Single Start -->
<section class="property-single nav-arrow-b">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
                    <div class="carousel-item-b">
                        <img src="<?php echo $row['resim']; ?>" alt="<?php echo htmlspecialchars($row['baslik']); ?>">
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-5 col-lg-4">
                        <div class="property-price d-flex justify-content-center foo">
                            <div class="card-header-c d-flex">
                                <div class="card-box-ico">
                                    <span class="ion-money">$</span>
                                </div>
                                <div class="card-title-c align-self-center">
                                    <h5 class="title-c"><?php echo htmlspecialchars($row['fiyat']); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="property-summary">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title-box-d section-t4">
                                        <h3 class="title-d">Quick Summary</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-list">
                                <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong>Property ID:</strong>
                                        <span><?php echo htmlspecialchars($row['id']); ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Location:</strong>
                                        <span><?php echo htmlspecialchars($row['konum']); ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Area:</strong>
                                        <span><?php echo htmlspecialchars($row['alan']); ?>m<sup>2</sup></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Beds:</strong>
                                        <span><?php echo htmlspecialchars($row['oda_sayisi']); ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Baths:</strong>
                                        <span><?php echo htmlspecialchars($row['banyo_sayisi']); ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Garage:</strong>
                                        <span><?php echo htmlspecialchars($row['garaj']); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 section-md-t3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Property Description</h3>
                                </div>
                            </div>
                        </div>
                        <div class="property-description">
                            <p class="description color-text-a">
                                <?php echo nl2br(htmlspecialchars($row['aciklama'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Property Single End -->

<!-- Property Single End -->


  <!--/ Property Single End /-->

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
