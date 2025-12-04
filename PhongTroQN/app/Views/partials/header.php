<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'NhaTroQN.COM - Phòng trọ Quy Nhơn số 1' ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="header">
    <a href="<?= BASE_URL ?>/" style="text-decoration:none; color:inherit;">
        <div class="logo">
            <span class="blue">NhaTro</span><span class="red">QN</span><span>.COM</span>
            <div class="slogan">Kênh thông tin phòng trọ số 1 Quy Nhơn</div>
        </div>
    </a>

    <!-- NÚT BỘ LỌC BÊN PHẢI LOGO -->
    <button class="filter-button"><i class="fas fa-sliders-h"></i> Bộ lọc</button>

    <div class="menu">
        <a href="#"><i class="far fa-heart"></i> Tin đã lưu</a>

        <?php if (isset($_SESSION['user'])): $u = $_SESSION['user']; ?>
            <a href="<?= BASE_URL ?>/quan-ly" class="btn-manage">Quản lý</a>

            <div class="user-menu">
                <div class="user-info">
					<i class="fas fa-user-circle fa-lg"></i>
					<?= htmlspecialchars($u['HoTen']) ?> 
				</div>
                <div class="dropdown">
                    <a href="<?= BASE_URL ?>/tai-khoan"><i class="fas fa-user-cog"></i> Quản lý tài khoản</a>
                    <a href="<?= BASE_URL ?>/tin-cua-toi"><i class="fas fa-list-alt"></i> Quản lý tin đăng</a>
                    <a href="<?= BASE_URL ?>/tin-dang/tao"><i class="fas fa-plus-circle"></i> Đăng tin mới</a>
                    <hr>
                    <a href="<?= BASE_URL ?>/dang-xuat"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                </div>
            </div>

            <a href="<?= BASE_URL ?>/dang-tin" class="btn-post">Đăng tin mới</a>

        <?php else: ?>
            <a href="<?= BASE_URL ?>/dang-ky">Đăng ký</a>
            <a href="<?= BASE_URL ?>/dang-nhap">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

<nav class="nav-bar">
    <a href="<?= BASE_URL ?>/" class="<?= ($uri ?? '') === '/' ? 'active' : '' ?>">Trang chủ</a>
    <a href="#">Tin tức</a>
    <a href="#">Hướng dẫn</a>
    <a href="#">Chính sách</a>
    <a href="#">Hợp đồng mẫu</a>
    <a href="#">Blog</a>
</nav>
<?php if(isset($_SESSION['success'])): ?>
    <div class="alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<main class="main-content">