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
    
    // İlanı kayıtlardan kaldır
    $delete_query = "DELETE FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'İlan kaydı başarıyla kaldırıldı']);
    } else {
        echo json_encode(['success' => false, 'message' => 'İlan kaydı kaldırılırken bir hata oluştu']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek']);
}
?> 