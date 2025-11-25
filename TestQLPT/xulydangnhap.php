<?php
session_start();
include 'connect.php';

$email = $_POST['email'];
$matkhau = md5($_POST['matkhau']);

$sql = "SELECT * FROM user WHERE Email='$email' AND MatKhau='$matkhau' AND TrangThai=1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Tạo session
    $_SESSION['UserID'] = $row['UserID'];
    $_SESSION['HoTen'] = $row['HoTen'];
    $_SESSION['IsAdmin'] = $row['IsAdmin'];

    header("Location: index.php");
    exit();
} else {
    echo "Sai tài khoản hoặc mật khẩu!";
}
?>
