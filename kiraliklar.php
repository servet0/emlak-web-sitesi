<?php
include 'baglan.php';

// Sayfalama için gerekli değişkenler
$limit = 12;  // Her sayfada gösterilecek veri sayısı
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // Geçerli sayfa numarası
$offset = ($page - 1) * $limit;  // Sayfa başına verileri almak için offset

// Filtreleme için type parametresi
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Veritabanından verileri çek
$sql = "SELECT * FROM properties WHERE status = 1";
if ($type) {
    $sql .= " AND type = '$type'";
}
$sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Sayfa sayısını hesaplamak için toplam veri sayısını al
$total_sql = "SELECT COUNT(*) AS total FROM properties WHERE status = 1";
if ($type) {
    $total_sql .= " AND type = '$type'";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);  // Toplam sayfa sayısı
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Es Emlak</title>
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
            <h1 class="title-single">Emlak İlanları</h1>
            <span class="color-text-a">Es Emlak</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                İlanlar
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Grid Star /-->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="grid-option">
            <form id="filterForm" class="d-flex">
              <select name="type" id="typeFilter" class="form-control">
                <option value="">Tümü</option>
                <option value="kiralik" <?php echo ($type == 'kiralik') ? 'selected' : ''; ?>>Kiralık</option>
                <option value="satilik" <?php echo ($type == 'satilik') ? 'selected' : ''; ?>>Satılık</option>
              </select>
            </form>
          </div>
        </div>
      </div>

      <div class="row" id="propertyList">
        <?php while($row = $result->fetch_assoc()) { ?>
          <div class="col-md-4">
            <div class="card-box-a card-shadow">
              <div class="img-box-a">
                <img src="img/properties/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-a img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-overlay-a-content">
                  <div class="card-header-a">
                    <h2 class="card-title-a">
                      <a href="kiralik-single.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                    </h2>
                  </div>
                  <div class="card-body-a">
                    <div class="price-box d-flex">
                      <span class="price-a"><?php echo $row['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?> | <?php echo number_format($row['price']); ?> TL</span>
                    </div>
                    <a href="kiralik-single.php?id=<?php echo $row['id']; ?>" class="link-a">Detayları gör
                      <span class="ion-ios-arrow-forward"></span>
                    </a>
                  </div>
                  <div class="card-footer-a">
                    <ul class="card-info d-flex justify-content-around">
                      <li>
                        <h4 class="card-info-title">Alan</h4>
                        <span><?php echo htmlspecialchars($row['alan']); ?>m<sup>2</sup></span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Oda</h4>
                        <span><?php echo htmlspecialchars($row['oda_sayisi']); ?></span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Banyo</h4>
                        <span><?php echo htmlspecialchars($row['banyo_sayisi']); ?></span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Garaj</h4>
                        <span><?php echo htmlspecialchars($row['garaj']); ?></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- Sayfalama -->
      <div class="row">
        <div class="col-sm-12">
          <nav class="pagination-a">
            <ul class="pagination justify-content-end">
              <?php if($page > 1) { ?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $type ? '&type='.$type : ''; ?>" tabindex="-1">
                    <span class="ion-ios-arrow-back"></span>
                  </a>
                </li>
              <?php } ?>

              <?php for($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $i; ?><?php echo $type ? '&type='.$type : ''; ?>"><?php echo $i; ?></a>
                </li>
              <?php } ?>

              <?php if($page < $total_pages) { ?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $type ? '&type='.$type : ''; ?>">
                    <span class="ion-ios-arrow-forward"></span>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Property Grid End /-->

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

  <script>
  $(document).ready(function() {
    $('#typeFilter').change(function() {
      var type = $(this).val();
      var page = <?php echo $page; ?>;
      
      $.ajax({
        url: 'ajax/filter_properties.php',
        type: 'POST',
        data: {
          type: type,
          page: page
        },
        success: function(response) {
          $('#propertyList').html(response);
          // Sayfa numarasını güncelle
          history.pushState(null, '', '?page=' + page + (type ? '&type=' + type : ''));
        },
        error: function() {
          alert('Bir hata oluştu. Lütfen tekrar deneyin.');
        }
      });
    });
  });
  </script>

</body>
</html>