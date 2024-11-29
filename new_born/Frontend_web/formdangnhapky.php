<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register Form - Newborn Shop</title>
    <link rel="stylesheet" href="./css/dangnhap.css">
    <!-- <link rel="stylesheet" href="./dangnhap.css"> -->
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Styling ở đây không thay đổi */
    /* ... (code của bạn ở đây) ... */

    /* Global Styling */
    body {
        font-family: 'Poppins', sans-serif;
        /* background-color: #F5F5DC;  */
        /* Beige background - màu chủ đạo */
        background-color: #f7f4f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 10px;
        /* Thêm padding để nội dung không sát lề */
        box-sizing: border-box;
        /* Đảm bảo padding không làm ảnh hưởng đến kích thước */
    }

    .container {
        width: 100%;
        max-width: 400px;
        background: #FFF8DC;
        /* Cornsilk - màu nhạt hơn của beige */
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 30px 20px;
        /* Thêm padding để nội dung không bị sát lề */
        text-align: center;
        /* Đặt toàn bộ nội dung vào giữa */
        margin: 20px;
        /* Khoảng cách giữa container và rìa màn hình */
    }

    .form-box {
        width: 100%;
    }

    .title {
        font-size: 26px;
        /* Tăng kích thước tiêu đề để nổi bật hơn */
        color: #D2B48C;
        /* Tan - màu nhạt nhưng vẫn nổi bật */
        margin-bottom: 15px;
        /* Tăng khoảng cách dưới tiêu đề */
        font-weight: bold;
        text-align: center;
        /* Đặt tiêu đề vào chính giữa */
    }

    .subtitle {
        font-size: 14px;
        color: #C3B091;
        /* Pale taupe - màu nhạt và nhẹ nhàng */
        margin-bottom: 25px;
        /* Tăng khoảng cách dưới subtitle */
    }

    .input-group h2 {
        color: #C3B091;
        /* Pale taupe */
        margin-bottom: 15px;
        /* Thêm chút khoảng cách giữa heading và input fields */
    }

    .input-field {
        width: calc(100% - 50px);
        /* Đảm bảo input không chạm sát container */
        padding: 12px;
        margin: 10px 10px 20px 10px;
        /* Thêm margin dưới cho input */
        border: 2px solid #D2B48C;
        /* Tan */
        border-radius: 25px;
        font-size: 16px;
        background: #FFF8DC;
        /* Cornsilk - nền nhạt và sáng */
        outline: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .input-field:focus {
        border-color: #C3B091;
        /* Border khi focus - pale taupe */
    }

    .submit-btn {
        background-color: #D2B48C;
        /* Tan */
        color: white;
        border: none;
        padding: 12px;
        width: 95%;
        height: 45px;
        border-radius: 25px;
        font-size: 18px;
        margin-top: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #C3B091;
        /* Hover màu pale taupe nhạt */
    }

    .check-box {
        margin-right: 10px;
    }

    p {
        margin-top: 15px;
        /* Tăng khoảng cách giữa đoạn văn và các phần tử khác */
        font-size: 14px;
    }

    a {
        color: #D2B48C;
        /* Tan link color */
        cursor: pointer;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Cute Icons */
    input::placeholder {
        color: #C3B091;
        /* Placeholder - pale taupe */
    }

    /* Media Query for Mobile Responsiveness */
    @media (max-width: 480px) {
        .container {
            width: 90%;
            padding: 20px;
            /* Đảm bảo vẫn có đủ khoảng trống khi hiển thị trên màn hình nhỏ */
        }
    }

    #error-message {
        font-size: 14px;
        color: red;
        display: none;
        /* Hidden initially */
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-box">
            <h1 class="title">Shop bán đồ sơ sinh</h1>
            <p class="subtitle">Vui lòng đăng nhập hoặc đăng ký để nhận những sản phẩm dễ thương nhất cho bé!</p>
   <!-- Display message if exists -->
   
            
            <!-- Form đăng nhập -->
            <form id="loginForm" class="input-group" action="../Backend_dkdn/login.php" method="POST"
                style="display: block;">
                <h2>Đăng Nhập</h2>
                <input type="text" class="input-field" name="email" placeholder="&#xf0e0; Email Của Bạn"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="password" class="input-field" name="password" placeholder="&#xf023; Mật Khẩu Của Bạn"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="checkbox" class="check-box" id="remember-password"><label for="remember-password">Nhớ Mật
                    Khẩu</label><br>
                <button type="submit" class="submit-btn">Đăng Nhập</button>
                <p>Bạn chưa có tài khoản? <a href="javascript:void(0)" onclick="showRegisterForm()">Đăng Ký</a></p>
                <p id="error-message-login" style="color: red; display: none;">Vui lòng nhập email và mật khẩu hợp lệ.
                </p>
            </form>

            <!-- Form đăng ký -->
            <form id="registerForm" class="input-group" action="../Backend_dkdn/register.php" method="POST"
                style="display: none;">
                <h2>Đăng Ký</h2>
                <input type="text" class="input-field" name="name" placeholder="&#xf007; Tên Của Bạn"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="tel" class="input-field" name="phone" placeholder="&#xf095; Số Điện Thoại"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="email" class="input-field" name="email" placeholder="&#xf0e0; Email Của Bạn"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="text" class="input-field" name="address" placeholder="&#xf015; Địa Chỉ Của Bạn"
                    style="font-family: Arial, FontAwesome" required><br>
                <input type="password" class="input-field" name="password" id="password"
                    placeholder="&#xf023; Mật Khẩu Của Bạn" style="font-family: Arial, FontAwesome" required><br>
                <input type="password" class="input-field" id="confirm-password"
                    placeholder="&#xf023; Nhập Lại Mật Khẩu" style="font-family: Arial, FontAwesome" required><br>
                <!-- <select class="input-field" name="role" required>
                    <option value="user">Người Dùng</option>
                    <option value="admin">Quản Trị Viên</option>
                </select> -->
                <input type="checkbox" class="check-box" id="terms"><label for="terms">Tôi đồng ý với các điều khoản và
                    điều kiện</label><br>
                <button type="submit" class="submit-btn">Đăng Kí</button>
                <p>Đã có tài khoản? <a href="javascript:void(0)" onclick="showLoginForm()">Đăng Nhập</a></p>
                <p id="error-message-register" style="color: red; display: none;">Mật khẩu không khớp. Vui lòng nhập
                    lại.</p>
            </form>
        </div>
    </div>

    <script>
    function showRegisterForm() {
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("registerForm").style.display = "block";
    }

    function showLoginForm() {
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("registerForm").style.display = "none";
    }
    // Kiểm tra mật khẩu, mật khẩu xác nhận và điều khoản trong form đăng ký
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        var phoneNumber = document.querySelector('input[type="tel"]').value;
        var phonePattern = /^\d{10}$/; // Biểu thức chính quy để kiểm tra 10 chữ số
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm-password').value;
        var termsCheckbox = document.getElementById('terms'); // Lấy checkbox điều khoản

       // Kiểm tra số điện thoại
       if (!phonePattern.test(phoneNumber)) {
            event.preventDefault(); // Ngăn không cho form gửi đi
            alert('Số điện thoại phải gồm 10 chữ số!');
             return;
        }

        // Kiểm tra mật khẩu và mật khẩu xác nhận
        if (password !== confirmPassword) {
            event.preventDefault(); // Ngăn không cho form gửi đi
            alert('Mật khẩu và mật khẩu xác nhận không khớp!');
            return;
        }

        // Kiểm tra checkbox điều khoản
        if (!termsCheckbox.checked) {
            event.preventDefault(); // Ngăn không cho form gửi đi
            alert('Bạn phải đồng ý với các điều khoản và điều kiện!');
        } else {
             alert('Đăng ký thành công!');
        }
    });

    
    
    </script>

</body>

</html>