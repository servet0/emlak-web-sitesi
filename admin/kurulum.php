<?php
require_once('../baglan.php');

// Admin tablosunu oluştur
try {
    $sql = "CREATE TABLE IF NOT EXISTS `admin` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `kullanici_adi` varchar(50) NOT NULL,
      `sifre` varchar(32) NOT NULL,
      `email` varchar(100) NOT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $db->exec($sql);
    echo "Admin tablosu başarıyla oluşturuldu.<br>";
    
    // Varsayılan admin kullanıcısını ekle
    $kullanici_adi = "admin";
    $sifre = md5("admin123"); // Şifre: admin123
    $email = "admin@example.com";
    
    // Önce kullanıcının var olup olmadığını kontrol et
    $kontrol = $db->prepare("SELECT COUNT(*) FROM admin WHERE kullanici_adi = ?");
    $kontrol->execute([$kullanici_adi]);
    
    if($kontrol->fetchColumn() == 0) {
        $ekle = $db->prepare("INSERT INTO admin (kullanici_adi, sifre, email) VALUES (?, ?, ?)");
        $ekle->execute([$kullanici_adi, $sifre, $email]);
        echo "Varsayılan admin kullanıcısı oluşturuldu.<br>";
        echo "Kullanıcı adı: admin<br>";
        echo "Şifre: admin123<br>";
    } else {
        echo "Admin kullanıcısı zaten mevcut.<br>";
    }
    
    // Properties tablosunu oluştur
    $sql = "CREATE TABLE IF NOT EXISTS `properties` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text NOT NULL,
      `price` decimal(10,2) NOT NULL,
      `type` enum('kiralik','satilik') NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 1,
      `image` varchar(255) DEFAULT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $db->exec($sql);
    echo "Properties tablosu başarıyla oluşturuldu.<br>";
    
    echo "<br>Kurulum tamamlandı. <a href='login.php'>Giriş sayfasına git</a>";
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?> 