<?php
session_start();
// Kết nối đến cơ sở dữ liệu
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra và lấy dữ liệu email và mật khẩu từ POST request
    $email = trim($_POST['email'] ?? null);
    $password = $_POST['password'] ?? null;

    // Xác thực email và mật khẩu đã nhập
    if (!empty($email) && !empty($password)) {
        // Chuẩn bị truy vấn để lấy thông tin người dùng
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $name, $hashedPassword, $role);

            if ($stmt->fetch()) {
                // Kiểm tra mật khẩu
                if (password_verify($password, $hashedPassword)) {
                    // Đăng nhập thành công, lưu thông tin vào session
                    $_SESSION['user_id'] = $id;
                    $_SESSION['name'] = $name;
                    $_SESSION['role'] = $role;

                    // Xác định trang chính theo vai trò người dùng
                    if ($role === 'admin') {
                        // header("Location: ../Frontend_web/admin2.php");
                        header("Location: ../Frontend_web/giaodienql.php");
                    } elseif ($role === 'nhanvien') {
                        header("Location: ../Frontend_web/giaodienql.php"); // Trang cho nhân viên
                    } else {
                        header("Location: ../Frontend_web/trangchu.php");
                    }
                    exit();
                } else {
                    echo "Mật khẩu không đúng.";
                }
            } else {
                echo "Email không tồn tại.";
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
