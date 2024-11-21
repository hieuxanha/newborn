<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php'); // Ensure this connects to your database

// Check if user ID is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "Người dùng đã được xóa thành công!";
    } else {
        echo "Lỗi khi xóa người dùng.";
    }
} else {
    echo "ID người dùng không hợp lệ.";
    exit;
}

// Redirect back to the admin page
header("Location: ../Frontend_web/thongtinnguoidung.php");
exit;
?>
