<?php
session_start();
include '../baglan.php';

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_giris']) || $_SESSION['user_giris'] !== true) {
    die(json_encode(['success' => false, 'message' => 'Lütfen giriş yapın']));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['property_id'])) {
    $user_id = $_SESSION['user_id'];
    $property_id = intval($_POST['property_id']);
    
    // İlanın daha önce kaydedilip kaydedilmediğini kontrol et
    $check_query = "SELECT * FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 0) {
        // İlanı kaydet
        $insert_query = "INSERT INTO saved_properties (user_id, property_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'İlan başarıyla kaydedildi']);
        } else {
            echo json_encode(['success' => false, 'message' => 'İlan kaydedilirken bir hata oluştu']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Bu ilan zaten kaydedilmiş']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek']);
}
?> 