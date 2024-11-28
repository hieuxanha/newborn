<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php'); // Kết nối cơ sở dữ liệu

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Truy vấn tìm kiếm người dùng theo tên và vai trò 'nhanvien'
    $stmt = $conn->prepare("SELECT id, name, phone, email, address, `role`, created_at FROM users WHERE name LIKE ? AND `role` = 'khachhang'");
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Trả kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($users);
}
?>
