<?php
session_start(); // Khởi động session
session_unset(); // Xóa tất cả on
session_destroy(); // Hủy sessi
header("Location: ../Frontend_web/giaodienchung.php"); // Chuyển hướng người dùng về
exit();
?>
