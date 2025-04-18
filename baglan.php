<?php
// Veritabanı bağlantısı için gerekli bilgiler
// $host = "127.0.0.1"; // XAMPP için genelde localhost veya 127.0.0.1 kullanılır
// $username = "821620221046"; // XAMPP varsayılan kullanıcı adı
// $password = "bvoWwF5clC3"; // XAMPP varsayılan şifresi boş bırakılır
// $database = "db_821620221046"; // Emlak projeniz için oluşturduğunuz veritabanı adı

// ESKİ

// Veritabanı bağlantısı için gerekli bilgiler
$host = "127.0.0.1"; // XAMPP için genelde localhost veya 127.0.0.1 kullanılır
$username = "root"; // XAMPP varsayılan kullanıcı adı
$password = ""; // XAMPP varsayılan şifresi boş bırakılır
$database = "emlak"; // Emlak projeniz için oluşturduğunuz veritabanı adı

// mysqli bağlantısı
$conn = mysqli_connect($host, $username, $password, $database);

// Bağlantıyı kontrol et
if (mysqli_connect_errno()) {
    echo "Bağlantı Başarısız. Hata: " . mysqli_connect_error();
    die(); // Eğer bağlantı başarısız olursa, işlemi durdur
} else {
    // echo "Bağlantı Başarılı"; // Test amaçlı, gerektiğinde kullanabilirsiniz
}

// Karakter setini Türkçe uyumlu yapmak için ayarlayın
mysqli_query($conn, "SET NAMES 'utf8'");

// PDO bağlantısı
try {
    $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "PDO Bağlantı Hatası: " . $e->getMessage();
    die();
}

// Veritabanı işlemlerinizi buradan itibaren yazabilirsiniz
// Örnek: Veri çekmek veya eklemek için SQL sorgularını kullanabilirsiniz

// Bağlantıyı kapatmak için
// mysqli_close($conn);

?>


