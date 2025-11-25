<?php
include 'connect.php';

$email = "admin@example.com";
$matkhau = md5("admin123");

$sql = "SELECT * FROM user WHERE Email='$email' AND MatKhau='$matkhau'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Đăng nhập thành công!";
} else {
    echo "Sai tài khoản hoặc mật khẩu!";
}
?>
