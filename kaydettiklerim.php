<?php
session_start();
include 'baglan.php';

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_giris']) || $_SESSION['user_giris'] !== true) {
    header("Location: giris.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kaydedilen ilanları çek
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaydettiklerim - Es Emlak</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="section-about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a">Kaydettiklerim</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
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
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            Henüz kaydettiğiniz bir ilan bulunmamaktadır.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 