<?php
require_once('../baglan.php');

// Yeni admin şifresi oluştur
$yeni_sifre = "admin123";
$hash_sifre = md5($yeni_sifre);

try {
    // Önce admin tablosunu kontrol et
    $kontrol = $db->query("SHOW TABLES LIKE 'admin'");
    if($kontrol->rowCount() == 0) {
        echo "Admin tablosu bulunamadı. Lütfen önce kurulum.php dosyasını çalıştırın.";
        exit;
    }
    
    // Admin kullanıcısını güncelle veya oluştur
    $sorgu = $db->prepare("SELECT COUNT(*) FROM admin WHERE kullanici_adi = 'admin'");
    $sorgu->execute();
    
    if($sorgu->fetchColumn() > 0) {
        // Mevcut admin kullanıcısını güncelle
        $guncelle = $db->prepare("UPDATE admin SET sifre = ? WHERE kullanici_adi = 'admin'");
        $guncelle->execute([$hash_sifre]);
        echo "Admin şifresi başarıyla güncellendi.<br>";
    } else {
        // Yeni admin kullanıcısı oluştur
        $ekle = $db->prepare("INSERT INTO admin (kullanici_adi, sifre, email) VALUES (?, ?, ?)");
        $ekle->execute(['admin', $hash_sifre, 'admin@example.com']);
        echo "Yeni admin kullanıcısı oluşturuldu.<br>";
    }
    
    echo "Yeni giriş bilgileri:<br>";
    echo "Kullanıcı adı: admin<br>";
    echo "Şifre: " . $yeni_sifre . "<br><br>";
    echo "<a href='login.php'>Giriş sayfasına git</a>";
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?> 