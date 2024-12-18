<?php
// Kết nối đến cơ sở dữ liệu
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'] ?? 'khachhang'; 


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      
        echo "<script>
        alert('Email đã tồn tại!');
        window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/formdangnhapky.php'; 
      </script>";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (name, phone, email, address, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $phone, $email, $address, $password, $role);

        if ($stmt->execute()) {
          
            echo "<script>
            alert('Đăng ký thành công!');
            window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/formdangnhapky.php'; 
          </script>";

        } else {
            echo "Đã xảy ra lỗi: " . $stmt->error;
        }
    }

    $stmt->close();
}
$conn->close();
?>
