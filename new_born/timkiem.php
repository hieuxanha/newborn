<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');// Kết nối cơ sở dữ liệu

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Truy vấn tìm kiếm sản phẩm
    $stmt = $conn->prepare("SELECT id, ten_san_pham, gia, anh_san_pham FROM sanpham WHERE ten_san_pham LIKE ?");
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Trả kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($products);
}

?>
