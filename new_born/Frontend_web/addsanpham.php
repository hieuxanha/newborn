<?php
// Kết nối với cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newborn_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra và lọc dữ liệu từ form
    $ten_san_pham = mysqli_real_escape_string($conn, $_POST['ten_san_pham']);
    $gia = floatval($_POST['gia']);
    $loai_san_pham = mysqli_real_escape_string($conn, $_POST['loai_san_pham']);
    $mo_ta = mysqli_real_escape_string($conn, $_POST['mo_ta']);
    $so_luong = intval($_POST['so_luong']);
    $san_pham_noi_bat = isset($_POST['san_pham_noi_bat']) ? 1 : 0;

    // Xử lý ảnh sản phẩm
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["anh_san_pham"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu file có thực sự là ảnh
    $check = getimagesize($_FILES["anh_san_pham"]["tmp_name"]);
    if ($check === false) {
        die("File không phải là ảnh.");
    }

    // Kiểm tra định dạng file
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "webp"])) {
        die("Chỉ chấp nhận các định dạng JPG, JPEG, PNG, GIF, WEBP.");
    }

    // Kiểm tra nếu file tồn tại
    if (file_exists($target_file)) {
        die("File ảnh đã tồn tại.");
    }

    // Tạo thư mục uploads nếu chưa có
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Upload file
    if (!move_uploaded_file($_FILES["anh_san_pham"]["tmp_name"], $target_file)) {
        die("Lỗi khi tải ảnh lên.");
    }

    // Thêm sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO sanpham (ten_san_pham, gia, loai_san_pham, mo_ta, so_luong, anh_san_pham, san_pham_noi_bat)
            VALUES ('$ten_san_pham', '$gia', '$loai_san_pham', '$mo_ta', '$so_luong', '$target_file', $san_pham_noi_bat)";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sản phẩm thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm - Phong Cách Nous</title>
    <style>
        /* CSS của bạn */
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f9f9f9;
            color: #333;
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 16px;
            color: #6d6d6d;
            margin-bottom: 10px;
            display: block;
        }
        .form-group input[type="text"], .form-group input[type="number"], .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }
        .form-group input[type="text"]:focus, .form-group input[type="number"]:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: #a39074;
            outline: none;
        }
        .form-group input[type="file"] {
            font-size: 16px;
            margin-top: 10px;
        }
        .form-group img {
            width: 150px;
            margin-top: 10px;
            border-radius: 10px;
        }
        .form-group button {
            background-color: #a39074;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button a {
            background-color: #a39074;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .form-group button:hover {
            background-color: #8d7a5e;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Thêm Sản Phẩm</h2>

        <form action="addsanpham.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Tên Sản Phẩm</label>
                <input type="text" id="product_name" name="ten_san_pham" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" id="price" name="gia" placeholder="Nhập giá sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea id="description" name="mo_ta" rows="4" placeholder="Nhập mô tả sản phẩm" required></textarea>
            </div>
            <div class="form-group">
                <label for="product_image">Ảnh Sản Phẩm</label>
                <input type="file" id="product_image" name="anh_san_pham" accept="image/*" required>
                <img id="preview" src="" alt="Xem trước ảnh sản phẩm" style="display: none;">
            </div>
            <div class="form-group">
                <label for="quantity">Số Lượng</label>
                <input type="number" id="quantity" name="so_luong" placeholder="Nhập số lượng sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="category">Danh Mục</label>
                <select id="category" name="loai_san_pham" required>
                    <option value="" disabled selected>Chọn danh mục</option>
                    <option value="Bé mặc">Bé mặc</option>
                    <option value="Bé ngủ">Bé ngủ</option>
                    <option value="Bé chơi">Bé chơi</option>
                    <option value="Bé ăn uống">Bé ăn uống</option>
                    <option value="Bé vệ sinh">Bé vệ sinh</option>
                    <option value="Bé ra ngoài">Bé ra ngoài</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label for="featured">Sản Phẩm Nổi Bật</label>
                <input type="checkbox" id="featured" name="san_pham_noi_bat" value="1">
            </div>
            <div class="form-group">
                <button type="submit">Thêm Sản Phẩm</button>
                <button type="button"><a href="./admin2.php">HỦY</a></button>
            </div>
        </form>

        <script>
            document.getElementById('product_image').onchange = function(event) {
                const preview = document.getElementById('preview');
                preview.style.display = 'block';
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
    </div>

</body>
</html>
