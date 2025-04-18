<?php
session_start();
if(!isset($_SESSION['admin_giris']) || $_SESSION['admin_giris'] !== true) {
    header("Location: login.php");
    exit;
}

include '../baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $konum = $_POST['konum'];
    $alan = $_POST['alan'];
    $oda_sayisi = $_POST['oda_sayisi'];
    $banyo_sayisi = $_POST['banyo_sayisi'];
    $garaj = $_POST['garaj'];
    $description = $_POST['description'];
    
    // Resim yükleme işlemi
    $target_dir = "images/";
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Resim kontrolü
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
    
    // Dosya boyutu kontrolü
    if ($_FILES["image"]["size"] > 5000000) {
        $uploadOk = 0;
    }
    
    // Dosya tipi kontrolü
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO properties (title, type, price, konum, alan, oda_sayisi, banyo_sayisi, garaj, description, image, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisssssss", $title, $type, $price, $konum, $alan, $oda_sayisi, $banyo_sayisi, $garaj, $description, $image);
            
            if ($stmt->execute()) {
                header("Location: ilanlar.php?success=1");
                exit;
            } else {
                $error = "İlan eklenirken bir hata oluştu.";
            }
        } else {
            $error = "Resim yüklenirken bir hata oluştu.";
        }
    } else {
        $error = "Geçersiz resim dosyası.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İlan Ekle - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <h3 class="mb-4">Admin Panel</h3>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="index.php"><i class="fas fa-home"></i> Ana Sayfa</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="ilanlar.php"><i class="fas fa-list"></i> İlanlar</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="ilan-ekle.php" class="active"><i class="fas fa-plus"></i> Yeni İlan Ekle</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="mb-4">Yeni İlan Ekle</h2>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">İlan Başlığı</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">İlan Türü</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Seçiniz</option>
                                <option value="kiralik">Kiralık</option>
                                <option value="satilik">Satılık</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Fiyat</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="konum" class="form-label">Konum</label>
                            <input type="text" class="form-control" id="konum" name="konum" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="alan" class="form-label">Alan (m²)</label>
                            <input type="number" class="form-control" id="alan" name="alan" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="oda_sayisi" class="form-label">Oda Sayısı</label>
                            <input type="text" class="form-control" id="oda_sayisi" name="oda_sayisi" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="banyo_sayisi" class="form-label">Banyo Sayısı</label>
                            <input type="text" class="form-control" id="banyo_sayisi" name="banyo_sayisi" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="garaj" class="form-label">Garaj</label>
                            <input type="text" class="form-control" id="garaj" name="garaj">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">İlan Görseli</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">İlanı Ekle</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Form doğrulama
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
    </script>
</body>
</html> 