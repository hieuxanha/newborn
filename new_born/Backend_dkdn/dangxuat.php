<?php
session_start(); // Khởi động session
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy session
// header("Location: ../Frontend_web/trangchu.php"); 

header("Location: ../Frontend_web/giaodienchung.php"); 
// Chuyển hướng người dùng về
exit();
?>
