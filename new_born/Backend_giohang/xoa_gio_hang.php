<?php
session_start();
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Lấy thông tin user và sản phẩm
$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];

// Lệnh SQL xóa sản phẩm trong giỏ hàng
$query = "DELETE FROM gio_hang WHERE user_id = ? AND san_pham_id = ?";
$stmt = $conn->prepare($query);  // Sử dụng chuẩn bị câu lệnh SQL
$stmt->bind_param("ii", $userId, $productId); // Bind giá trị

if ($stmt->execute()) {
    // Kiểm tra tham số redirect trong URL hoặc form
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';

    if ($redirect == 'chitietgiohang') {
        // Chuyển hướng về chi tiết giỏ hàng
        header('Location: ../Frontend_web/chitietgiohang.php');
    } else {
      
        header('Location: ../Frontend_web/trangchu.php');
    }
    exit(); // Dừng chương trình sau khi chuyển hướng
} else {
    // Nếu có lỗi khi xóa sản phẩm
    echo "Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.";
}
?>
