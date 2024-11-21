<?php

require_once("C:/xampp/htdocs/web_new_born/new_born/db.php");

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "DELETE FROM sanpham WHERE id = $productId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Xóa sản phẩm thành công');
                window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/admin2.php'; // Thay đổi URL này về trang admin của bạn
              </script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
