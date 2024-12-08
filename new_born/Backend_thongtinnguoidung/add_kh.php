<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'khachhang';

    // Kiểm tra email đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {

        echo "<script>
        alert('Email đã tồn tại.');
        window.location.href ='http://localhost/web_new_born/new_born/Frontend_web/ql_khchhang.php'; 
      </script>";
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        // Chèn dữ liệu mới
        $sql_insert = "INSERT INTO users (name, phone, email, address, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $name, $phone, $email, $address, $password, $role);

        if ($stmt_insert->execute()) {
            // Chèn thành công, chuyển hướng với thông báo thành công
            header("Location: ../Frontend_web/ql_khchhang.php?success=Thêm khách hàng mới thành công!");
            exit();
        } else {
            // Lỗi khi chèn dữ liệu
            header("Location: ../Frontend_web/ql_khchhang.php?error=Lỗi khi thêm dữ liệu.");
            exit();
        }
    }

    // Đóng các prepared statements
    $stmt_check->close();
    if (isset($stmt_insert)) {
        $stmt_insert->close();
    }
}

$conn->close();
?>