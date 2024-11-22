<?php


require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Truy vấn dữ liệu từ bảng `sanpham`
$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Bán Đồ Em Bé - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <style>
    body {
        font-family: 'Helvetica', sans-serif;
        background-color: #f9f9f9;

       
        color: #6d6d6d;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #f1f1f1;
        height: 100%;
        padding-top: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar a {
        padding: 15px;
        display: block;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .sidebar a:hover {
        background-color: #d1d1d1;
    }

    .content {
        margin-left: 260px;
        padding: 20px;
    }

  
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #fff;
        position: fixed;
        width: calc(100% - 250px);
        left: 250px;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-bar input[type="text"] {
        padding: 8px;
        border-radius: 20px;
        border: 1px solid #ddd;
        width: 250px;
        outline: none;
    }

   
    .avatar {
        position: relative;
        display: inline-block;
    }

    .avatar img {
        width: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
        min-width: 160px;
        border-radius: 5px;
    }

    .dropdown-menu a {
        color: black;
        padding: 10px 20px;
        display: block;
        text-decoration: none;
        font-size: 14px;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .avatar:hover .dropdown-menu {
        display: block;
    }

 
    .table-container {
        margin-top: 80px;
    }

    table {
        width: 100%;
        background-color: #fff;
        border-collapse: collapse;
    }

    th {
        background-color: #a39074;
        color: white;
        text-align: left;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    td img {
        border-radius: 5px;
    }

    /* Buttons */
    .btn-primary,
    .btn-warning,
    .btn-danger {
        border-radius: 30px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #a39074;
        border: none;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-primary:hover {
        background-color: #8d7a5e;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="menu" class="sidebar">
        <h2 class="text-center" style="color: #a39074; font-size: 20px;">Shop Bán Đồ Em Bé</h2>
             <hr>
    
      </div>
    </div>


    <div class="header">
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
        </div>
        <div class="avatar">
            <img src="https://via.placeholder.com/40" alt="User Avatar">
            <div class="dropdown-menu">
                <a href="#">Profile</a>
                <a href="#">Settings</a>
                <a href="#">Activity Log</a>
                <a href="#">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="table-container">
            <h2 style="color: #a39074;">Danh sách sản phẩm</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá (VNĐ)</th>
                        <th>Danh mục</th>
                        <th>Mô tả</th>
                        <th>Số lượng</th>
                        <th>Ảnh</th>
                        <th>Nổi bật</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <?php
                if ($result->num_rows > 0) {
                    $stt = 1;
                    // Xuất dữ liệu từng hàng
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . $row['ten_san_pham'] . "</td>";
                        echo "<td>" . number_format($row['gia'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['loai_san_pham'] . "</td>";
                        echo "<td>" . $row['mo_ta'] . "</td>";
                        echo "<td>" . $row['so_luong'] . "</td>";
        
                        if (isset($row['anh_san_pham']) && !empty($row['anh_san_pham'])) {
                            echo "<td><img src='/web_new_born/new_born/Frontend_web/" . htmlspecialchars($row['anh_san_pham']) . "' width='50'></td>";
                        } else {
                            echo "<td>Không có ảnh</td>";
                        }
                        
                        echo "<td>" . ($row['san_pham_noi_bat'] ? "Có" : "Không") . "</td>";
                        echo "<td><a href='sua.php?id=" . $row['id'] . "' class='btn btn-warning'>Sửa</a></td>";
                        echo "<td><a href='../Backend_sanpham/xoa_sanpham.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sản phẩm này?\")'>Xóa</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Không có sản phẩm nào</td></tr>";
                }

                ?>
                </tbody>
              
                </tbody>
            </table>
            <a href="./addsanpham.php" class="btn btn-primary"
                onclick="addNew()">Thêm mới</a>
            <a href="http://127.0.0.1:5501/new_born/Frontend_web/Menu.html" class="btn btn-primary">Quay lại</a>
        </div>
    </div>

    <script>
    // 
    </script>

</body>

</html>