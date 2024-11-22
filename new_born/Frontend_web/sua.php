<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Get product ID from URL
$id = $_GET['id'] ?? '';

// Fetch product details
$sql = "SELECT * FROM sanpham WHERE id = ?";
$hieudz = $conn->prepare($sql);
$hieudz->bind_param("i", $id);
$hieudz->execute();
$result = $hieudz->get_result();
$product = $result->fetch_assoc();

// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia = $_POST['gia'];
    $loai_san_pham = $_POST['loai_san_pham'];
    $mo_ta = $_POST['mo_ta'];
    $so_luong = $_POST['so_luong'];
    $san_pham_noi_bat = isset($_POST['san_pham_noi_bat']) ? 1 : 0; // Featured product checkbox

    // Xử lý ảnh nếu có tệp mới
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["anh_san_pham"]["name"]);
    $uploadOk = 1;
    $new_image_path = $product['anh_san_pham'];  // Giữ ảnh cũ nếu không có ảnh mới

    if (!empty($_FILES["anh_san_pham"]["name"])) {
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem tệp có phải là hình ảnh không
        $check = getimagesize($_FILES["anh_san_pham"]["tmp_name"]);
        if ($check === false) {
            echo "File không phải là hình ảnh.";
            $uploadOk = 0;
        }

        // Cho phép các định dạng hình ảnh nhất định
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "webp"])) {
            echo "Chỉ cho phép tệp hình ảnh với định dạng JPG, JPEG, PNG, GIF, WEBP.";
            $uploadOk = 0;
        }
        // Nếu không có lỗi, di chuyển tệp lên thư mục uploads
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["anh_san_pham"]["tmp_name"], $target_file)) {
                $new_image_path = $target_file; // Cập nhật đường dẫn ảnh mới
            } else {
                echo "Lỗi khi tải ảnh lên.";
            }
        }
    }

    // Cập nhật sản phẩm trong cơ sở dữ liệu
    $sql = "UPDATE sanpham SET ten_san_pham = ?, gia = ?, loai_san_pham = ?, mo_ta = ?, so_luong = ?, san_pham_noi_bat = ?, anh_san_pham = ? WHERE id = ?";
    $hieudz = $conn->prepare($sql);
    $hieudz->bind_param("sisiiisi", $ten_san_pham, $gia, $loai_san_pham, $mo_ta, $so_luong, $san_pham_noi_bat, $new_image_path, $id);
    $hieudz->execute();

    echo "Sản phẩm đã được cập nhật thành công!";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <style>
        /* Your styles remain the same */
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

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 16px;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="number"]:focus,
    .form-group textarea:focus {
        border-color: #a39074;
        outline: none;
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

    .form-group button:hover {
        background-color: #8d7a5e;
    }

    .form-group img {
        max-width: 100px;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ten_san_pham">Tên sản phẩm</label>
                <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham"
                    value="<?php echo htmlspecialchars($product['ten_san_pham']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gia">Giá</label>
                <input type="number" class="form-control" id="gia" name="gia"
                    value="<?php echo htmlspecialchars($product['gia']); ?>" required>
            </div>
            <div class="form-group">
                <label for="loai_san_pham">Loại sản phẩm</label>
                <input type="text" class="form-control" id="loai_san_pham" name="loai_san_pham"
                    value="<?php echo htmlspecialchars($product['loai_san_pham']); ?>" required>
            </div>
            <div class="form-group">
                <label for="mo_ta">Mô tả</label>
                <textarea class="form-control" id="mo_ta" name="mo_ta"
                    required><?php echo htmlspecialchars($product['mo_ta']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="so_luong">Số lượng</label>
                <input type="number" class="form-control" id="so_luong" name="so_luong"
                    value="<?php echo htmlspecialchars($product['so_luong']); ?>" required>
            </div>
            <div class="form-group">
                <label for="san_pham_noi_bat">Sản phẩm nổi bật</label>
                <input type="checkbox" id="san_pham_noi_bat" name="san_pham_noi_bat"
                    <?php if ($product['san_pham_noi_bat']) echo 'checked'; ?>>
            </div>
            <div class="form-group">
               <label for="anh_san_pham">Ảnh sản phẩm</label><br>
              <img src="/web_new_born/new_born/Frontend_web/<?php echo htmlspecialchars($product['anh_san_pham']); ?>" alt="Current Image" style="max-width: 100px; margin-bottom: 10px;">
              <input type="file" id="anh_san_pham" name="anh_san_pham" accept="image/*">
       </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <button type="button"><a href="./admin2.php">HỦY</a></button>
            </div>
        </form>
    </div>
</body>

</html>
