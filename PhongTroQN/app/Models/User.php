<?php
// D:\xampp\htdocs\PhongTroQN\app\Models\User.php
// Model User – hoàn chỉnh, gọn, bảo mật, đúng 100% với CSDL của bạn

class User
{
    // Kiểm tra Email hoặc Số điện thoại đã tồn tại chưa
    public function exists($field, $value)
    {
        $allowed = ['Email', 'SoDienThoai'];
        if (!in_array($field, $allowed)) return false;

        $sql = "SELECT UserID FROM user WHERE $field = :value LIMIT 1";
        $stmt = query($sql, [':value' => $value]);
        return $stmt->rowCount() > 0;
    }

    // Đăng ký người dùng mới (mặc định là Người thuê – RoleID = 3)
    public function register($data)
    {
        $hashedPassword = password_hash($data['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user 
                (HoTen, Email, MatKhau, SoDienThoai, DiaChi, TrangThai, IsAdmin) 
                VALUES 
                (:hoten, :email, :matkhau, :phone, :diachi, 1, 0)";

        $stmt = query($sql, [
            ':hoten'   => $data['hoten'],
            ':email'   => $data['email'],
            ':matkhau' => $hashedPassword,
            ':phone'   => $data['phone'],
            ':diachi'  => $data['address']
        ]);

        if ($stmt->rowCount() > 0) {
            $userId = DB::connect()->lastInsertId();

            // Tự động gán vai trò "Người thuê" (RoleID = 3)
            $roleSql = "INSERT IGNORE INTO user_role (UserID, RoleID) VALUES (:uid, 3)";
            query($roleSql, [':uid' => $userId]);

            return $userId;
        }

        return false;
    }

    // Lấy thông tin user theo Email (dùng cho đăng nhập)
    public function findByEmail($email)
    {
        $sql = "
            SELECT 
                u.*,
                GROUP_CONCAT(v.TenVaiTro SEPARATOR ', ') AS roles
            FROM user u
            LEFT JOIN user_role ur ON u.UserID = ur.UserID
            LEFT JOIN vaitro v ON ur.RoleID = v.RoleID
            WHERE u.Email = :email 
              AND u.TrangThai = 1
            GROUP BY u.UserID
            LIMIT 1
        ";

        $stmt = query($sql, [':email' => $email]);
        return $stmt->fetch(); // trả về false nếu không tìm thấy
    }

    // (Tùy chọn) Lấy user theo UserID – dùng khi cần
    public function findById($id)
    {
        $sql = "
            SELECT 
                u.*,
                GROUP_CONCAT(v.TenVaiTro SEPARATOR ', ') AS roles
            FROM user u
            LEFT JOIN user_role ur ON u.UserID = ur.UserID
            LEFT JOIN vaitro v ON ur.RoleID = v.RoleID
            WHERE u.UserID = :id
            GROUP BY u.UserID
        ";
        $stmt = query($sql, [':id' => $id]);
        return $stmt->fetch();
    }
}