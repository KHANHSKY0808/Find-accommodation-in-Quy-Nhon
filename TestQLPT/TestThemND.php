<?php
include 'connect.php';

$sql = "INSERT INTO user (HoTen, Email, MatKhau, SoDienThoai, DiaChi, TrangThai, IsAdmin)
        VALUES ('Test User', 'test@example.com', MD5('123456'), '0900000000', 'TP.HCM', 1, 0)";

if ($conn->query($sql) === TRUE) {
    echo "Thêm người dùng thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}
?>
