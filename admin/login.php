<?php
session_start();
require_once('../baglan.php');

if(isset($_POST['giris'])) {
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = md5($_POST['sifre']);
    
    $sorgu = $db->prepare("SELECT * FROM admin WHERE kullanici_adi = ? AND sifre = ?");
    $sorgu->execute([$kullanici_adi, $sifre]);
    
    if($sorgu->rowCount() > 0) {
        $admin = $sorgu->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_kullanici_adi'] = $admin['kullanici_adi'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_giris'] = true; // Oturum durumunu kontrol etmek için
        
        header("Location: index.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Admin Girişi</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($hata)): ?>
                            <div class="alert alert-danger"><?php echo $hata; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" required>
                            </div>
                            <div class="mb-3">
                                <label for="sifre" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="sifre" name="sifre" required>
                            </div>
                            <button type="submit" name="giris" class="btn btn-primary w-100">Giriş Yap</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 