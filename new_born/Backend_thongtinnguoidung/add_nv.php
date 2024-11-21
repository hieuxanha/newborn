<?php
require_once('C:/xampp/htdocs/web_new_born/new_born/db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'nhanvien';

    $sql = "INSERT INTO users (name, phone, email, address, password, role) VALUES ('$name', '$phone', '$email', '$address', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
