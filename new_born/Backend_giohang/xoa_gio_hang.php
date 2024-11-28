<?php
session_start();
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');


$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];


$query = "DELETE FROM gio_hang WHERE user_id = ? AND san_pham_id = ?";
$stmt = $conn->prepare($query);  
$stmt->bind_param("ii", $userId, $productId); // 

if ($stmt->execute()) {
    
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';

    if ($redirect == 'chitietgiohang') {
        
        header('Location: ../Frontend_web/chitietgiohang.php');
    } else {
      
        header('Location: ../Frontend_web/trangchu.php');
    }
    exit();
} else {
    
    echo "Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.";
}
?>
