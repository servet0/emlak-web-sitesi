<?php
session_start();
require_once('../baglan.php');

// Oturum kontrolü
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// İlan silme işlemi
if(isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $sil = $db->prepare("DELETE FROM properties WHERE id = ?");
    $sil->execute([$_GET['sil']]);
    header("Location: ilanlar.php?mesaj=silindi");
    exit;
}

// İlanları listele
$ilanlar = $db->query("SELECT * FROM properties ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Yönetimi - Admin Paneli</title>
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
                        <a class="nav-link active" href="ilanlar.php">İlanlar</a>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>İlan Yönetimi</h2>
            <a href="ilan-ekle.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Yeni İlan Ekle
            </a>
        </div>

        <?php if(isset($_GET['mesaj']) && $_GET['mesaj'] == 'silindi'): ?>
            <div class="alert alert-success">İlan başarıyla silindi.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Başlık</th>
                                <th>Tür</th>
                                <th>Fiyat</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ilanlar as $ilan): ?>
                            <tr>
                                <td><?php echo $ilan['id']; ?></td>
                                <td><?php echo $ilan['title']; ?></td>
                                <td><?php echo $ilan['type']; ?></td>
                                <td><?php echo number_format($ilan['price'], 0, ',', '.'); ?> TL</td>
                                <td>
                                    <?php if($ilan['status'] == 1): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Pasif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d.m.Y', strtotime($ilan['created_at'])); ?></td>
                                <td>
                                    <a href="ilan-duzenle.php?id=<?php echo $ilan['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="ilanlar.php?sil=<?php echo $ilan['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu ilanı silmek istediğinizden emin misiniz?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 