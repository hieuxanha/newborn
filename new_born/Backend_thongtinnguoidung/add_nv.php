<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'nhanvien';

    // Kiểm tra email đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Chuyển hướng về giao diện mong muốn và truyền thông báo qua query string
       
        echo "<script>
        alert('Email đã tồn tại.');
        window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/thongtinnguoidung.php'; 
      </script>";
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Chèn dữ liệu mới
        $sql_insert = "INSERT INTO users (name, phone, email, address, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $name, $phone, $email, $address, $password, $role);

        if ($stmt_insert->execute()) {
            header("Location: ../Frontend_web/thongtinnguoidung.php?success=Thêm người dùng mới thành công!");
            exit();
        } else {
            header("Location: ../Frontend_web/thongtinnguoidung.php?error=Lỗi khi thêm dữ liệu.");
            exit();
        }
    }

    // Đóng kết nối các prepared statements
    $stmt_check->close();
    if (isset($stmt_insert)) {
        $stmt_insert->close();
    }
}

$conn->close();
?>