<?php
session_start();
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id']; 

    $stmt = $conn->prepare("SELECT * FROM gio_hang WHERE user_id = ? AND san_pham_id = ?");
    
    if ($stmt === false) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $stmt = $conn->prepare("UPDATE gio_hang SET so_luong = so_luong + 1 WHERE user_id = ? AND san_pham_id = ?");
        if ($stmt === false) {
            die("Lỗi chuẩn bị truy vấn UPDATE: " . $conn->error);
        }

        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    } else {
        
        $stmt = $conn->prepare("INSERT INTO gio_hang (user_id, san_pham_id, so_luong) VALUES (?, ?, 1)");
        if ($stmt === false) {
            die("Lỗi chuẩn bị truy vấn INSERT: " . $conn->error);
        }

        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    
    $stmt->close();
    $conn->close();

    
   echo "<script>window.location.href = '../Frontend_web/trangchu.php';</script>";
   // Chuyển hướng về trang chủ

    exit();
} else {
    echo "Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng.";
    
}
?>