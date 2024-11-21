<?php
// Kết nối cơ sở dữ liệu
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Khởi tạo session nếu chưa có
session_start();

// Kiểm tra nếu có 'id' và 'action' từ form gửi lên
if (isset($_POST['id'], $_POST['action'])) {
    // Lấy id giỏ hàng và action
    $cart_id = $_POST['id'];  // Lấy id giỏ hàng
    $action = $_POST['action'];  // Lấy hành động từ form ('increase' hoặc 'decrease')
    $redirect = $_POST['redirect'];

    // Debug: Hiển thị giá trị của cart_id và action
    // echo "Cart ID: " . $cart_id . "<br>";
    // echo "Action: " . $action . "<br>";

    // Tiếp tục xử lý cập nhật cơ sở dữ liệu (chỉ khi id và action có)
    try {
        // Lấy thông tin sản phẩm từ giỏ hàng bằng cart_id (không dùng prepare)
        $sql = "SELECT * FROM gio_hang WHERE id = $cart_id";
        $result = $conn->query($sql);

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if ($result->num_rows > 0) {
            $cart_item = $result->fetch_assoc();  // Lấy thông tin sản phẩm trong giỏ hàng

            // Lấy số lượng hiện tại của sản phẩm
            $current_quantity = $cart_item['so_luong'];

            // Quyết định tăng hoặc giảm số lượng
            if ($action == 'increase') {
                $new_quantity = $current_quantity + 1;  // Tăng số lượng lên 1
            } elseif ($action == 'decrease' && $current_quantity > 1) {
                $new_quantity = $current_quantity - 1;  // Giảm số lượng xuống 1, nhưng không cho giảm dưới 1
            } else {
                $new_quantity = $current_quantity;  // Nếu không có hành động hợp lệ, giữ nguyên số lượng
            }

            // Cập nhật lại số lượng vào cơ sở dữ liệu (cập nhật với SQL không dùng prepare)
            $update_sql = "UPDATE gio_hang SET so_luong = $new_quantity WHERE id = $cart_id";
            $conn->query($update_sql);  // Thực thi câu lệnh cập nhật

            // Thông báo cập nhật thành công
            $_SESSION['message'] = "Cập nhật giỏ hàng thành công!";
        } else {
            // Nếu không tìm thấy sản phẩm trong giỏ hàng
            $_SESSION['error'] = "Sản phẩm không tồn tại trong giỏ hàng!";
        }

    } catch (Exception $e) {
        // Nếu có lỗi khi thực hiện câu lệnh SQL
        $_SESSION['error'] = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
    }
} else {
    // Nếu không có 'id' hoặc 'action' từ form
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
}

 // Chuyển hướng sau khi cập nhật
    if ($redirect == 'chitietgiohang') {
       header('Location: ../Frontend_web/chitietgiohang.php');// Về chi tiết giỏ hàng nếu từ trang chi tiết 
    } else {
        header('Location: ../Frontend_web/trangchu.php'); // Về trang chủ nếu từ giỏ hàng con
    }
    exit();
?>