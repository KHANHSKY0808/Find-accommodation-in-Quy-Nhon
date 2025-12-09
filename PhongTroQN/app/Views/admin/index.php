<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - PhongTroQN</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: #FEF9EE;
      color: #333;
    }
    .sidebar {
      width: 260px;
      height: 100vh;
      background: #E7F1FF;
      position: fixed;
      top: 0;
      left: 0;
      padding: 30px 0;
      box-shadow: 2px 0 10px rgba(0,0,0,0.05);
      overflow-y: auto;
    }
    .sidebar h2 {
      text-align: center;
      color: #2d5aa0;
      margin-bottom: 40px;
      font-size: 24px;
    }
    .sidebar a {
      display: block;
      padding: 14px 30px;
      color: #2d5aa0;
      text-decoration: none;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .sidebar a:hover {
      background: rgba(45, 90, 160, 0.1);
      color: #1e40af;
    }
    .sidebar a.active {
      background: rgba(45, 90, 160, 0.15);
      border-left: 4px solid #2d5aa0;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
    }
    .topbar {
      background: #fff;
      padding: 20px 30px;
      border-radius: 12px;
      margin-bottom: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .topbar h2 {
      margin: 0;
      color: #2d5aa0;
    }
    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }
    .card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .card h3 {
      margin: 0 0 10px 0;
      font-size: 28px;
      color: #2d5aa0;
    }
    .card p {
      margin: 0;
      color: #666;
      font-size: 16px;
    }
    .section-title {
      color: #2d5aa0;
      margin: 40px 0 20px 0;
      font-size: 22px;
    }
    table {
      width: 100%;
      background: #fff;
      border-collapse: collapse;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    table th {
      background: #E7F1FF;
      color: #2d5aa0;
      padding: 15px;
      text-align: left;
      font-weight: 600;
    }
    table td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
    }
    table tr:hover {
      background: #f8fbff;
    }
    .btn {
      padding: 6px 12px;
      background: #2d5aa0;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn:hover {
      background: #1e40af;
    }
    .btn-danger {
      background: #dc3545;
    }
    .btn-danger:hover {
      background: #c82333;
    }
  </style>
</head>
<body>

<?php
// app/Views/admin/index.php – Đoạn đầu file (thay thế hoàn toàn phần cũ)

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    redirect('/');
    exit;
}

// Require cần thiết (nếu chưa có autoload, đảm bảo require ở đây)
require_once __DIR__ . '/../../Models/DB.php';
require_once __DIR__ . '/../../Models/User.php';
require_once __DIR__ . '/../../Models/Post.php';

// Thống kê (sử dụng fetchColumn() cho COUNT)
$totalPosts     = query("SELECT COUNT(*) FROM post")->fetchColumn();
$todayPosts     = query("SELECT COUNT(*) FROM post WHERE DATE(NgayDang) = CURDATE()")->fetchColumn();
$totalUsers     = query("SELECT COUNT(*) FROM user WHERE IsAdmin = 0")->fetchColumn();
$todayUsers     = query("SELECT COUNT(*) FROM user WHERE DATE(created_at) = CURDATE() AND IsAdmin = 0")->fetchColumn();
$totalReports   = query("SELECT COUNT(*) FROM baocao")->fetchColumn();
$pendingReports = query("SELECT COUNT(*) FROM baocao WHERE DaXuLy = 0")->fetchColumn();
$resolvedReports = query("SELECT COUNT(*) FROM baocao WHERE DaXuLy = 1")->fetchColumn();

// Tin mới nhất (sử dụng fetchAll cho SELECT nhiều cột)
$stmt = query("SELECT p.PostID, p.TieuDe, u.HoTen, p.NgayDang 
               FROM post p 
               JOIN user u ON p.UserID = u.UserID 
               ORDER BY p.NgayDang DESC LIMIT 10");
$recentPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


  <div class="sidebar">
    <h2>Quản Trị Viên</h2>
    <a href="<?= BASE_URL ?>/index.php?page=admin" class="active">Tổng quan</a>
    <a href="<?= BASE_URL ?>/index.php?page=admin/users">Quản lý người dùng</a>
    <a href="#">Quản lý tin đăng</a>
    <a href="<?= BASE_URL ?>/index.php?page=admin/reports">Quản lý báo cáo</a>
    <a href="<?= BASE_URL ?>/index.php">Về trang chủ</a>

  </div>

  <div class="content">
    <div class="topbar">
      <h2>Bảng điều khiển</h2>
      <span>Xin chào, Admin! Hôm nay: <?= date('d/m/Y') ?></span>
    </div>

    <div class="card-container">
      <div class="card">
        <h3><?= $todayPosts ?> / <?= $totalPosts ?></h3>
        <p>Số tin đăng hôm nay / Tổng tin</p>
      </div>
      <div class="card">
        <h3><?= $todayUsers ?> / <?= $totalUsers ?></h3>
        <p>Người dùng mới hôm nay / Tổng người dùng</p>
      </div>
      <div class="card">
        <h3><?= $pendingReports ?> / <?= $totalReports ?></h3>
        <p>Báo cáo chưa xử lý / Tổng báo cáo</p>
      </div>
      <div class="card">
        <h3><?= $resolvedReports ?></h3>
        <p>Báo cáo đã xử lý</p>
      </div>
    </div>

    <h2 class="section-title">Tin đăng gần đây</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tiêu đề</th>
          <th>Người đăng</th>
          <th>Ngày đăng</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentPosts as $post): ?>
        <tr>
          <td><?= $post['PostID'] ?></td>
          <td><?= htmlspecialchars($post['TieuDe']) ?></td>
          <td><?= htmlspecialchars($post['HoTen']) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($post['NgayDang'])) ?></td>
          <td>
            <a href="manage-posts.php?action=view&id=<?= $post['PostID'] ?>"><button class="btn">Xem</button></a>
            <a href="manage-posts.php?action=delete&id=<?= $post['PostID'] ?>" onclick="return confirm('Xóa tin này?')">
              <button class="btn btn-danger">Xóa</button>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>