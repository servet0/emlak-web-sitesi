<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// İlan ID kontrolü
if (!isset($_GET['id'])) {
    header("Location: kiraliklar.php");
    exit;
}

$id = $_GET['id'];

// İlan bilgilerini getir
$query = "SELECT * FROM properties WHERE id = ? AND status = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header("Location: kiraliklar.php");
    exit;
}

$property = mysqli_fetch_assoc($result);

// İlanın kaydedilip kaydedilmediğini kontrol et
$is_saved = false;
if (isset($_SESSION['user_giris']) && $_SESSION['user_giris'] === true) {
    $user_id = $_SESSION['user_id'];
    $check_query = "SELECT * FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $id);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);
    $is_saved = mysqli_num_rows($check_result) > 0;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($property['title']); ?> - Es Emlak</title>
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

    <style>
        .property-single .carousel-item-b {
            height: 500px;
            overflow: hidden;
            position: relative;
        }
        .property-single .carousel-item-b img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        .property-single .owl-carousel {
            position: relative;
            height: 500px;
        }
        .property-single .owl-stage-outer {
            height: 100%;
        }
        .property-single .owl-stage {
            height: 100%;
        }
        .property-single .owl-item {
            height: 100%;
        }
        .property-single .owl-nav {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 2;
        }
        .property-single .owl-prev,
        .property-single .owl-next {
            background: rgba(255,255,255,0.8);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 20px;
            transition: all 0.3s;
        }
        .property-single .owl-prev:hover,
        .property-single .owl-next:hover {
            background: #2eca6a;
            color: white;
        }
        .property-single .owl-dots {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 2;
        }
        .property-single .owl-dot {
            width: 12px;
            height: 12px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            transition: all 0.3s;
        }
        .property-single .owl-dot.active {
            background: #2eca6a;
        }
        .save-btn {
            background: #2eca6a;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .save-btn:hover {
            background: #25a85a;
            color: white;
        }
        .save-btn i {
            margin-right: 5px;
        }
        .save-btn.loading {
            pointer-events: none;
        }
        .save-btn.loading:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            animation: loading 1s infinite;
        }
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .toast {
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 10px 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
        }
        .toast i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .toast.success i {
            color: #2eca6a;
        }
        .toast.error i {
            color: #dc3545;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="toast-container"></div>

    <!--/ Intro Single star /-->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single"><?php echo htmlspecialchars($property['title']); ?></h1>
                        <span class="color-text-a"><?php echo $property['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?></span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="kiraliklar.php">İlanlar</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo htmlspecialchars($property['title']); ?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--/ Intro Single End /-->

    <!--/ Property Single Star /-->
    <section class="property-single nav-arrow-b">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
                        <div class="carousel-item-b">
                            <img src="img/properties/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-5 col-lg-4">
                            <div class="property-price d-flex justify-content-center foo">
                                <div class="card-header-c d-flex">
                                    <div class="card-box-ico">
                                        <div class="card-title-c align-self-center">
                                            <h5 class="title-c"><?php echo number_format($property['price'], 0, ',', '.'); ?> TL</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="property-summary">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title-box-d section-t4">
                                            <h3 class="title-d">İlan Bilgileri</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary-list">
                                    <ul class="list">
                                        <li class="d-flex justify-content-between">
                                            <strong>İlan No:</strong>
                                            <span><?php echo $property['id']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>İlan Türü:</strong>
                                            <span><?php echo $property['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?></span>
                                        </li>
                                        <?php if (isset($_SESSION['user_giris']) && $_SESSION['user_giris'] === true): ?>
                                            <li class="d-flex justify-content-between">
                                                <strong>İşlem:</strong>
                                                <button type="button" class="save-btn" id="savePropertyBtn">
                                                    <i class="fa <?php echo $is_saved ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
                                                    <?php echo $is_saved ? 'Kaydedildi' : 'Kaydet'; ?>
                                                </button>
                                            </li>
                                        <?php else: ?>
                                            <li class="d-flex justify-content-between">
                                                <strong>İşlem:</strong>
                                                <a href="giris.php" class="btn btn-success btn-sm">Kaydetmek için Giriş Yapın</a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="d-flex justify-content-between">
                                            <strong>Konum:</strong>
                                            <span><?php echo htmlspecialchars($property['konum']); ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Alan:</strong>
                                            <span><?php echo $property['alan']; ?> m²</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Oda Sayısı:</strong>
                                            <span><?php echo $property['oda_sayisi']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Banyo Sayısı:</strong>
                                            <span><?php echo $property['banyo_sayisi']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Garaj:</strong>
                                            <span><?php echo $property['garaj'] ? 'Var' : 'Yok'; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Eklenme Tarihi:</strong>
                                            <span><?php echo date('d.m.Y', strtotime($property['created_at'])); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 section-md-t3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title-box-d">
                                        <h3 class="title-d">Açıklama</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="property-description">
                                <p class="description color-text-a">
                                    <?php echo nl2br(htmlspecialchars($property['description'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Property Single End /-->

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

    <script>
        $(document).ready(function() {
            // Owl Carousel başlatma
            $('#property-single-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                dots: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                items: 1,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 1000,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                lazyLoad: true
            });

            $('#savePropertyBtn').click(function() {
                const $btn = $(this);
                const propertyId = <?php echo $id; ?>;
                const isSaved = $btn.find('i').hasClass('fa-heart');
                
                $btn.addClass('loading');
                
                $.ajax({
                    url: 'save_property.php',
                    method: 'POST',
                    data: { property_id: propertyId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Buton durumunu güncelle
                            if (isSaved) {
                                $btn.find('i').removeClass('fa-heart').addClass('fa-heart-o');
                                $btn.html('<i class="fa fa-heart-o"></i> Kaydet');
                                showToast('İlan kaydedilenlerden kaldırıldı', 'success');
                            } else {
                                $btn.find('i').removeClass('fa-heart-o').addClass('fa-heart');
                                $btn.html('<i class="fa fa-heart"></i> Kaydedildi');
                                showToast('İlan başarıyla kaydedildi', 'success');
                            }
                        } else {
                            showToast(response.message || 'Bir hata oluştu', 'error');
                        }
                    },
                    error: function() {
                        showToast('Bir hata oluştu', 'error');
                    },
                    complete: function() {
                        $btn.removeClass('loading');
                    }
                });
            });
            
            function showToast(message, type) {
                const $toast = $('<div class="toast ' + type + '">' +
                    '<i class="fa ' + (type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') + '"></i>' +
                    '<span>' + message + '</span>' +
                    '</div>');
                
                $('.toast-container').append($toast);
                
                setTimeout(function() {
                    $toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });
    </script>
</body>
</html>
