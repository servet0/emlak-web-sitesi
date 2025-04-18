<?php
session_start();
require_once('../baglan.php');

// Oturum kontrolü
if(!isset($_SESSION['admin_giris']) || $_SESSION['admin_giris'] !== true) {
    header("Location: login.php");
    exit;
}

// İstatistikleri çek
$ilan_sayisi = $db->query("SELECT COUNT(*) FROM properties")->fetchColumn();
$kiralik_sayisi = $db->query("SELECT COUNT(*) FROM properties WHERE type = 'kiralik'")->fetchColumn();
$satilik_sayisi = $db->query("SELECT COUNT(*) FROM properties WHERE type = 'satilik'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Paneli</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="ilanlar.php">İlanlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kullanicilar.php">Kullanıcılar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="raporlar.php">Raporlar</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['admin_kullanici_adi']); ?></h2>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Toplam İlan</h5>
                        <p class="card-text display-4"><?php echo $ilan_sayisi; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Kiralık İlanlar</h5>
                        <p class="card-text display-4"><?php echo $kiralik_sayisi; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Satılık İlanlar</h5>
                        <p class="card-text display-4"><?php echo $satilik_sayisi; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Hızlı İşlemler</h5>
                    </div>
                    <div class="card-body">
                        <a href="ilan-ekle.php" class="btn btn-primary mb-2 w-100">Yeni İlan Ekle</a>
                        <a href="ilanlar.php" class="btn btn-secondary mb-2 w-100">İlanları Yönet</a>
                        <a href="raporlar.php" class="btn btn-info w-100">Raporları Görüntüle</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Son Eklenen İlanlar</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php
                            $son_ilanlar = $db->query("SELECT * FROM properties ORDER BY id DESC LIMIT 5")->fetchAll();
                            foreach($son_ilanlar as $ilan):
                            ?>
                            <a href="ilan-duzenle.php?id=<?php echo $ilan['id']; ?>" class="list-group-item list-group-item-action">
                                <?php echo htmlspecialchars($ilan['title']); ?>
                                <small class="text-muted float-end"><?php echo date('d.m.Y', strtotime($ilan['created_at'])); ?></small>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 