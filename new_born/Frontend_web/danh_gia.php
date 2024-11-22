<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newborn_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách sản phẩm
$sql = "SELECT id, ten_san_pham, anh_san_pham FROM sanpham";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá sản phẩm</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: #a39074;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #6d6d6d;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            border-color: #a39074;
            outline: none;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            background-color: #a39074;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #8d7a5e;
        }

        .product-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-option img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="submit_review.php" method="post">
        <h2>Đánh giá sản phẩm</h2>

        <!-- Dropdown sản phẩm -->
        <label for="sanpham">Chọn sản phẩm:</label>
        <select name="sanpham_id" id="sanpham" required>
            <option value="">-- Chọn sản phẩm --</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['id']) . '">' 
                        . htmlspecialchars($row['ten_san_pham']) . '</option>';
                }
            }
            ?>
        </select>

        <!-- Trường nhập tên -->
        <label for="name">Họ và Tên:</label>
        <input type="text" id="name" name="name" placeholder="Nhập họ và tên của bạn" required>

        <!-- Trường nhập email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>

        <!-- Đánh giá bằng sao -->
        <label for="rating">Đánh giá (1-5 sao):</label>
        <select id="rating" name="rating" required>
            <option value="">Chọn đánh giá</option>
            <option value="1">1 sao</option>
            <option value="2">2 sao</option>
            <option value="3">3 sao</option>
            <option value="4">4 sao</option>
            <option value="5">5 sao</option>
        </select>

        <!-- Ý kiến -->
        <label for="comment">Ý kiến của bạn:</label>
        <textarea id="comment" name="comment" rows="4" placeholder="Viết ý kiến của bạn ở đây..." required></textarea>

        <!-- Nút gửi -->
        <input type="submit" value="Gửi đánh giá">
    </form>
</div>
</body>
</html>
<?php
$conn->close();
?>
