<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');

// Fetch all users with role 'nhanvien' and 'user'
$sql = "SELECT * FROM users WHERE role IN ('nhanvien', 'khachhang')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <style>
        /* Your existing CSS code for layout, styling */
        /* Adjust table, buttons, and other styles for consistency */

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

        .search-bar input[type="text"] {
            padding: 8px;
            border-radius: 20px;
            border: 1px solid #ddd;
            width: 250px;
            outline: none;
        }

        /* User avatar and dropdown */
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

        /* Buttons */
        .btn-primary, .btn-warning, .btn-danger {
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

        /* Form for User Information */
        form {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            color: #a39074;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #a39074;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #a39074;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #8d7a5e;
        }
    </style>
</head>
<body>

<div id="menu" class="sidebar">
    <h2 class="text-center" style="color: #a39074; font-size: 20px;">Shop Bán Đồ Em Bé</h2>
    <!-- <a href="http://localhost/web_new_born/new_born/admin2.php">Quản lý sản phẩm</a>
    <a href="#">Nhân viên & Khách hàng</a>
    <a href="#">Cài đặt</a> -->
</div>

<div class="header">
<div class="search-bar">
    <input type="text" placeholder="Tìm kiếm ..." id="searchInput" />
    <div
        id="searchResults"
        style="display: none; position: absolute; background: #fff; border: 1px solid #ddd; border-radius: 5px; max-width: 400px; padding: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); z-index: 1000;">
    </div>
</div>
<script>
    document.getElementById("searchInput").addEventListener("input", function () {
        const keyword = document.getElementById("searchInput").value.trim();
        const resultsContainer = document.getElementById("searchResults");

        if (keyword === "") {
            resultsContainer.style.display = "none"; // Ẩn kết quả khi không có từ khóa
            return;
        }

        // Gửi yêu cầu tìm kiếm tới backend (tìm kiếm theo vai trò)
        fetch(`/web_new_born/new_born/timkiemphanquyen.php?keyword=${encodeURIComponent(keyword)}&searchBy=role`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Lỗi phản hồi từ máy chủ");
                }
                return response.json();
            })
            .then(data => {
                resultsContainer.innerHTML = ""; // Xóa kết quả cũ

                if (data.length === 0) {
                    resultsContainer.innerHTML = "<p>Không tìm thấy.</p>";
                    resultsContainer.style.display = "block";
                    return;
                }

                // Hiển thị danh sách người dùng tìm được
                const resultList = document.createElement("ul");
                resultList.style.listStyle = "none";
                resultList.style.margin = "0";
                resultList.style.padding = "0";

                data.forEach(item => {
                    const listItem = document.createElement("li");
                    listItem.style.marginBottom = "10px";
                    listItem.innerHTML = `
                        <div style="display: flex; align-items: center;">
                            <div>
                                <a href="/web_new_born/new_born/Frontend_web/ql_khchhang.php?id=${item.id}" 
                                    style="text-decoration: none; color: #333; font-weight: bold;">
                                    ${item.name} - ${item.role}
                                </a>
                                <p style="margin: 5px 0; color: #888;">
                                    Vai trò: ${item.role}
                                </p>
                            </div>
                        </div>
                    `;
                    resultList.appendChild(listItem);
                });

                resultsContainer.appendChild(resultList);
                resultsContainer.style.display = "block"; // Hiển thị kết quả tìm kiếm
            })
            .catch(error => {
console.error("Lỗi tìm kiếm:", error);
                alert("Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại!");
                resultsContainer.style.display = "none"; // Ẩn kết quả khi có lỗi
            });
    });

    // Ẩn kết quả khi nhấp ra ngoài
    document.addEventListener("click", function (event) {
        const resultsContainer = document.getElementById("searchResults");
        const searchInput = document.getElementById("searchInput");

        // Kiểm tra nếu nhấp vào ngoài vùng tìm kiếm hoặc input
        if (
            !resultsContainer.contains(event.target) &&
            event.target !== searchInput
        ) {
            resultsContainer.style.display = "none";
        }
    });
</script>


</div>

<div class="content" style="margin-top: 30px;">
    <h2>Phân quyền</h2>


    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Mật khẩu</th>
                    
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $stt++ . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . ucfirst($row['role']) . "</td>"; // Capitalize role
                        echo "<td>" . $row['password'] . "</td>"; // Displaying the password (you may want to remove this for security)
                        echo "<td>
                                <a href='../Backend_thongtinnguoidung/edit_user.php?id=" . $row['id'] . "' class='btn btn-primary'>Sửa</a>
                          
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>Chưa có nhân viên nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="form-group">
            <button class="btn btn-primary" type="button"><a href="./Menu.php">QUAY LẠI</a></button>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
