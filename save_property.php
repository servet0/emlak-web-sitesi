<?php
session_start();
include 'baglan.php';

header('Content-Type: application/json');

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_giris']) || $_SESSION['user_giris'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Bu işlem için giriş yapmalısınız.']);
    exit;
}

// İlan ID kontrolü
if (!isset($_POST['property_id'])) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz ilan ID.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$property_id = intval($_POST['property_id']);

// İlanın daha önce kaydedilip kaydedilmediğini kontrol et
$check_query = "SELECT * FROM saved_properties WHERE user_id = ? AND property_id = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
mysqli_stmt_execute($stmt);
$check_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($check_result) == 0) {
    // İlanı kaydet
    $save_query = "INSERT INTO saved_properties (user_id, property_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $save_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'İlan başarıyla kaydedildi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'İlan kaydedilirken bir hata oluştu.']);
    }
} else {
    // İlanı kaydedilenlerden kaldır
    $remove_query = "DELETE FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt = mysqli_prepare($conn, $remove_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $property_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'İlan kaydedilenlerden kaldırıldı.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'İlan kaldırılırken bir hata oluştu.']);
    }
} 