<?php
session_start();
require_once('../baglan.php');

// Oturum kontrolü
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// ID kontrolü
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ilanlar.php");
    exit;
}

$id = $_GET['id'];

// İlan bilgilerini çek
$sorgu = $db->prepare("SELECT * FROM properties WHERE id = ?");
$sorgu->execute([$id]);
$ilan = $sorgu->fetch(PDO::FETCH_ASSOC);

if(!$ilan) {
    header("Location: ilanlar.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    // Resim yükleme işlemi
    $image = $ilan['image']; // Mevcut resmi koru
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/properties/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Eski resmi sil
        if($ilan['image'] && file_exists($target_dir . $ilan['image'])) {
            unlink($target_dir . $ilan['image']);
        }
        
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Resim başarıyla yüklendi
        } else {
            $hata = "Resim yüklenirken bir hata oluştu.";
        }
    }
    
    if(!isset($hata)) {
        $sorgu = $db->prepare("UPDATE properties SET title = ?, description = ?, price = ?, type = ?, status = ?, image = ? WHERE id = ?");
        $guncelle = $sorgu->execute([$title, $description, $price, $type, $status, $image, $id]);
        
        if($guncelle) {
            header("Location: ilanlar.php?mesaj=guncellendi");
            exit;
        } else {
            $hata = "İlan güncellenirken bir hata oluştu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Düzenle - Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>İlan Düzenle</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($hata)): ?>
                            <div class="alert alert-danger"><?php echo $hata; ?></div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">İlan Başlığı</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $ilan['title']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">İlan Açıklaması</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $ilan['description']; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Fiyat (TL)</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $ilan['price']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="type" class="form-label">İlan Türü</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="kiralik" <?php echo $ilan['type'] == 'kiralik' ? 'selected' : ''; ?>>Kiralık</option>
                                    <option value="satilik" <?php echo $ilan['type'] == 'satilik' ? 'selected' : ''; ?>>Satılık</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">İlan Görseli</label>
                                <?php if($ilan['image']): ?>
                                    <div class="mb-2">
                                        <img src="../img/properties/<?php echo $ilan['image']; ?>" alt="Mevcut Görsel" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">Yeni bir görsel seçmezseniz mevcut görsel korunacaktır.</small>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status" <?php echo $ilan['status'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status">İlan Aktif</label>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                                <a href="ilanlar.php" class="btn btn-secondary">İptal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 