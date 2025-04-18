<?php
session_start();
include 'baglan.php';

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['user_giris']) || $_SESSION['user_giris'] !== true) {
    header("Location: giris.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kaydedilen ilanları getir
$query = "SELECT p.* FROM properties p 
          INNER JOIN saved_properties sp ON p.id = sp.property_id 
          WHERE sp.user_id = ? AND p.status = 1 
          ORDER BY sp.created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Kaydedilen İlanlar - Es Emlak</title>
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
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!--/ Intro Single star /-->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single">Kaydedilen İlanlar</h1>
                        <span class="color-text-a">Favori ilanlarınızı buradan takip edebilirsiniz</span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Kaydedilen İlanlar
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
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($property = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4">
                            <div class="card-box-a card-shadow">
                                <div class="img-box-a">
                                    <img src="admin/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>" class="img-a img-fluid">
                                </div>
                                <div class="card-overlay">
                                    <div class="card-overlay-a-content">
                                        <div class="card-header-a">
                                            <h2 class="card-title-a">
                                                <a href="kiralik-single.php?id=<?php echo $property['id']; ?>"><?php echo htmlspecialchars($property['title']); ?></a>
                                            </h2>
                                        </div>
                                        <div class="card-body-a">
                                            <div class="price-box d-flex">
                                                <span class="price-a"><?php echo $property['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?> | <?php echo number_format($property['price'], 0, ',', '.'); ?> TL</span>
                                            </div>
                                            <a href="kiralik-single.php?id=<?php echo $property['id']; ?>" class="link-a">Detayları Gör
                                                <span class="ion-ios-arrow-forward"></span>
                                            </a>
                                        </div>
                                        <div class="card-footer-a">
                                            <ul class="card-info d-flex justify-content-around">
                                                <li>
                                                    <h4 class="card-info-title">Alan</h4>
                                                    <span><?php echo $property['alan']; ?> m²</span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Oda</h4>
                                                    <span><?php echo $property['oda_sayisi']; ?></span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Banyo</h4>
                                                    <span><?php echo $property['banyo_sayisi']; ?></span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Garaj</h4>
                                                    <span><?php echo $property['garaj'] ? 'Var' : 'Yok'; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <h4>Henüz kaydedilmiş ilanınız bulunmuyor.</h4>
                            <p>İlanları kaydetmek için ilan detay sayfasındaki "Kaydet" butonunu kullanabilirsiniz.</p>
                            <a href="kiraliklar.php" class="btn btn-success">İlanları Görüntüle</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--/ Property Grid End /-->

    <?php include 'footer.php'; ?>

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