<?php
// Include database connection
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Get the search keyword from the URL
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// SQL query to search products by name or description
$sql = "SELECT * FROM sanpham WHERE ten_san_pham LIKE ? OR mo_ta LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $keyword . '%';
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <!-- <th>Giá (VNĐ)</th> -->
                        <!-- <th>Mô tả</th> -->
                        <th>Ảnh</th>
                        <th>Nổi bật</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_san_pham']); ?></td>
                            <!-- <td><?php echo number_format($row['gia'], 0, ',', '.'); ?></td> -->
                            <!-- <td><?php echo htmlspecialchars($row['mo_ta']); ?></td> -->
                            <td>
                                <?php if (!empty($row['anh_san_pham'])): ?>
                                    <img src="/web_new_born/new_born/Frontend_web/<?php echo htmlspecialchars($row['anh_san_pham']); ?>" width="50">
                                <?php else: ?>
                                    Không có ảnh
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['san_pham_noi_bat'] ? 'Có' : 'Không'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php endif; ?>
        <div class="form-group">
               
                <button type="button"><a href="./Frontend_web/trangchu.php">Quay lại</a></button>
            </div>
    </div>
</body>
</html>
