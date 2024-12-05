<?php
// Kết nối với cơ sở dữ liệu MySQL
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Truy vấn dữ liệu doanh thu theo ngày
$query = "
    SELECT t.ngayThanhToan, SUM(t.tongTien) AS tongDoanhThu
    FROM thanhtoan t
    GROUP BY t.ngayThanhToan
    ORDER BY t.ngayThanhToan DESC
";

// Thực thi truy vấn và lấy kết quả
$result = $conn->query($query);

// Mảng để chứa dữ liệu cho biểu đồ
$dates = [];
$sales = [];

// Lấy dữ liệu từ kết quả truy vấn
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['ngayThanhToan'];
    $sales[] = (float) $row['tongDoanhThu'];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Bán Đồ Em Bé - Thống Kê Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Header */
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

        /* Table */
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

        /* Chart */
        .chart-container {
            margin-top: 40px;
            width: 80%;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="menu" class="sidebar">
        <h2 class="text-center" style="color: #a39074; font-size: 20px;">Shop Bán Đồ Em Bé</h2>
        <a href="http://localhost/web_new_born/new_born/admin2.php">Quản lý sản phẩm</a>
        <a href="#">Đơn hàng</a>
        <a href="#">Khách hàng</a>
        <a href="http://localhost/WEB_NEW_BORN/new_born/thongtinnguoidung.php">Quản lý người dùng</a>
        <a href="#">Báo cáo doanh thu</a>
        <a href="#">Cài đặt</a>
        <a href="#">Đăng xuất</a>
    </div>

    <!-- Header with title -->
    <div class="header">
        <h3 style="color: #a39074;">Thống Kê Đơn Hàng</h3>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="table-container">
            <h2 style="color: #a39074;">Danh Sách Đơn Hàng</h2>
            <table class="table table-bordered">
                <thead>
                    <!-- <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày thanh toán</th>
                        <th>Tổng tiền (VNĐ)</th>
                    </tr> -->
                </thead>
                <tbody>
                    <!-- <?php
                    if ($result->num_rows > 0) {
                        $stt = 1;
                        // Xuất dữ liệu từng hàng
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $stt++ . "</td>";
                            echo "<td>" . $row['hoTen'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['soDienThoai'] . "</td>";
                            echo "<td>" . $row['diaChi'] . "</td>";
                            echo "<td>" . $row['ngayThanhToan'] . "</td>";
                            echo "<td>" . number_format($row['tongTien'], 0, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Không có đơn hàng nào.</td></tr>";
                    }
                    ?> -->
                </tbody>
            </table>
        </div>

        <!-- Biểu đồ đường -->
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
        
        <form action="" class="form-group">
            <a href="http://localhost/web_new_born/new_born/Frontend_web/admin2.php" class="btn btn-primary">Quay lại</a>
        </form>
    </div>

    <!-- Script to render chart -->
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>, // Dữ liệu ngày
                datasets: [{
                    label: 'Doanh thu theo ngày (VNĐ)',
                    data: <?php echo json_encode($sales); ?>, // Dữ liệu doanh thu
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Doanh thu: ' + tooltipItem.raw.toLocaleString() + ' VNĐ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
