<?php
// Kết nối cơ sở dữ liệu
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');


session_start();


if (isset($_POST['id'], $_POST['action'])) {

    $cart_id = $_POST['id'];  
    $action = $_POST['action'];  
    $redirect = $_POST['redirect'];

    
    try {
    
        $sql = "SELECT * FROM gio_hang WHERE id = $cart_id";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            $cart_item = $result->fetch_assoc(); 

            $current_quantity = $cart_item['so_luong'];

            
            if ($action == 'increase') {
                $new_quantity = $current_quantity + 1; 
            } elseif ($action == 'decrease' && $current_quantity > 1) {
                $new_quantity = $current_quantity - 1; 
            } else {
                $new_quantity = $current_quantity; 
            }

        
            $update_sql = "UPDATE gio_hang SET so_luong = $new_quantity WHERE id = $cart_id";
            $conn->query($update_sql); 


            $_SESSION['message'] = "Cập nhật giỏ hàng thành công!";
        } else {
            
            $_SESSION['error'] = "Sản phẩm không tồn tại trong giỏ hàng!";
        }

    } catch (Exception $e) {
    
        $_SESSION['error'] = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
    }
} else {

    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
}


    if ($redirect == 'chitietgiohang') {
       header('Location: ../Frontend_web/chitietgiohang.php');
    } else {
        header('Location: ../Frontend_web/trangchu.php'); 
    }
    exit();
?>