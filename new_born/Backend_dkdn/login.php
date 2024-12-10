<?php
session_start();
// Kết nối đến cơ sở dữ liệu
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = trim($_POST['email'] ?? null);
    $password = $_POST['password'] ?? null;

   
    if (!empty($email) && !empty($password)) {
        
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $name, $hashedPassword, $role);

            if ($stmt->fetch()) {
                // Kiểm tra mật khẩu
                if (password_verify($password, $hashedPassword)) {
                 
                    $_SESSION['user_id'] = $id;
                    $_SESSION['name'] = $name;
                    $_SESSION['role'] = $role;

                    // Xác định trang chính theo vai trò người dùng
                    if ($role === 'admin') {
                    
                        header("Location: ../Frontend_web/giaodienql.php");

                    } elseif ($role === 'nhanvien') {

                        header("Location: ../Frontend_web/giaodienql1.php"); // Trang cho nhân viên
                    } else {
                        // giao khách hàng
                        header("Location: ../Frontend_web/trangchu.php");
                    }
                    exit();
                } else {
                    // echo "Mật khẩu không đúng.";
                    echo "<script>
                    alert('Mật khẩu không đúng.');
                    window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/formdangnhapky.php'; 
                  </script>";
                }
            } else {
               
                echo "<script>
                alert('Email không tồn tại.');
                window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/formdangnhapky.php'; 
              </script>";
            }
            $stmt->close();
        } else {
            echo "Lỗi khi thực hiện truy vấn.";
        }
    } else {
        echo "Vui lòng nhập đầy đủ thông tin đăng nhập.";
    }
}
$conn->close();
?>
