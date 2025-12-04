<?php
// app/Controllers/UserController.php

class UserController
{
    private $userModel;

    public function __construct()
    {
        // CHỈ KHỞI ĐỘNG SESSION NẾU CHƯA CÓ
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra đăng nhập – giống hệt PostController
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để truy cập trang này!";
            redirect('/dang-nhap');
        }

        // Khởi tạo model
        $this->userModel = new User();
    }

    // Trang quản lý tài khoản
    public function profile()
    {
        $user = $_SESSION['user']; // Đã có sẵn từ session
        view('user/profile', ['user' => $user]);
    }

    // Cập nhật họ tên
    public function updateProfile()
    {
        
        if (!isset($_SESSION['user'])) {
            redirect('/dang-nhap');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/tai-khoan');
        }

        $userId = $_SESSION['user']['UserID'];
        $hoTen  = trim($_POST['hoten'] ?? '');

        if (empty($hoTen)) {
            $_SESSION['error'] = "Vui lòng nhập họ tên!";
            redirect('/tai-khoan?tab=info');
        }

        if ($this->userModel->updateName($userId, $hoTen)) {
            $_SESSION['user']['HoTen'] = $hoTen; // cập nhật luôn session
            $_SESSION['success'] = "Cập nhật thông tin thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }
        redirect(BASE_URL);
    }

    // Đổi số điện thoại
    public function changePhone()
    {
        
        if (!isset($_SESSION['user'])) {
            redirect('/dang-nhap');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/tai-khoan?tab=phone');
        }

        $userId   = $_SESSION['user']['UserID'];
        $newPhone = trim($_POST['new_phone'] ?? '');
        $otp      = $_POST['otp'] ?? '';

        // Mô phỏng OTP đúng = 123456
        if ($otp !== '123456') {
            $_SESSION['error'] = "Mã xác thực không đúng! (dùng 123456 để test)";
            redirect('/tai-khoan?tab=phone');
        }

        if (!preg_match('/^0[3-9][0-9]{8}$/', $newPhone)) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ!";
            redirect('/tai-khoan?tab=phone');
        }

        if ($this->userModel->phoneExistsExcept($newPhone, $userId)) {
            $_SESSION['error'] = "Số điện thoại đã có người sử dụng!";
            redirect('/tai-khoan?tab=phone');
        }

        if ($this->userModel->updatePhone($userId, $newPhone)) {
            $_SESSION['user']['SoDienThoai'] = $newPhone;
            $_SESSION['success'] = "Đổi số điện thoại thành công!";
        } else {
            $_SESSION['error'] = "Đổi số điện thoại thất bại!";
        }
        redirect(BASE_URL);
    }

    // Đổi mật khẩu
    public function changePassword()
    {
        
        if (!isset($_SESSION['user'])) {
            redirect('/dang-nhap');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/tai-khoan?tab=password');
        }

        $userId = $_SESSION['user']['UserID'];
        $old    = $_POST['old_password'] ?? '';
        $new    = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $user = $this->userModel->findById($userId);

        if (!password_verify($old, $user['MatKhau'])) {
            $_SESSION['error'] = "Mật khẩu cũ không đúng!";
            redirect('/tai-khoan?tab=password');
        }

        if (strlen($new) < 6) {
            $_SESSION['error'] = "Mật khẩu mới phải từ 6 ký tự!";
            redirect('/tai-khoan?tab=password');
        }

        if ($new !== $confirm) {
            $_SESSION['error'] = "Xác nhận mật khẩu không khớp!";
            redirect('/tai-khoan?tab=password');
        }

        if ($this->userModel->updatePassword($userId, $new)) {
            $_SESSION['success'] = "Đổi mật khẩu thành công!";
        } else {
            $_SESSION['error'] = "Đổi mật khẩu thất bại!";
        }
        redirect(BASE_URL);
    }

}