<?php
session_start();
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session
    $product_id = $_POST['product_id']; // Lấy ID sản phẩm từ form

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng chưa
    $stmt = $conn->prepare("SELECT * FROM gio_hang WHERE user_id = ? AND san_pham_id = ?");
    
    if ($stmt === false) {
        // Nếu chuẩn bị câu truy vấn thất bại, báo lỗi và dừng chương trình
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
        $stmt = $conn->prepare("UPDATE gio_hang SET so_luong = so_luong + 1 WHERE user_id = ? AND san_pham_id = ?");
        if ($stmt === false) {
            die("Lỗi chuẩn bị truy vấn UPDATE: " . $conn->error);
        }

        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        $stmt = $conn->prepare("INSERT INTO gio_hang (user_id, san_pham_id, so_luong) VALUES (?, ?, 1)");
        if ($stmt === false) {
            die("Lỗi chuẩn bị truy vấn INSERT: " . $conn->error);
        }

        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    // Đóng statement và kết nối
    $stmt->close();
    $conn->close();

    // Chuyển hướng về trang giỏ hàng hoặc trang chính
//    header("Location: ../Frontend_web/trangchu.php");  
   echo "<script>window.location.href = '../Frontend_web/trangchu.php';</script>";
   // Chuyển hướng về trang chủ

    exit();
} else {
    echo "Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng.";
    
}
?>