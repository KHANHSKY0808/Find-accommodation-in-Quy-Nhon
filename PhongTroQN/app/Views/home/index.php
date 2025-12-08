<?php
// app/Views/home/index.php

// Bạn có thể thêm title riêng nếu muốn
$title = "PhongTroQN - Phòng trọ Quy Nhơn số 1";
require_once __DIR__ . '/../partials/header.php';
?>

<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/index.css">

<!-- Header info -->
<div class="header-info">
    <h1>Kênh thông tin Phòng Trọ số 1 Quy Nhơn</h1>
    <p>Hiện có <b><?= number_format($totalPosts) ?></b> tin đăng đang hoạt động</p>
</div>

<div class="container">
    <h2 style="margin:20px 0;">Đề xuất dành cho bạn</h2>

    <?php if (!empty($posts)): ?>
        <div class="posts-grid">
            <?php foreach ($posts as $row): ?>
                <div class="post-card">
                    <!-- Hình ảnh đại diện -->
                    <div class="post-image">
                        <?php
                        $anh = $row['AnhDaiDien']
                            ? '../uploads/' . $row['AnhDaiDien']           // quan trọng: ../uploads vì View nằm ngoài public
                            : ASSETS_URL . '/img/noimage.png';
                        ?>
                        <img src="<?= htmlspecialchars($anh) ?>"
                             alt="<?= htmlspecialchars($row['TieuDe']) ?>">
                    </div>

                    <div class="post-title">
                        <?= htmlspecialchars($row['TieuDe']) ?>
                    </div>

                    <div class="post-price">
                        <?= number_format($row['GiaPhong']) ?> đ/tháng
                    </div>

                    <div class="post-info">
                        <?= number_format($row['DienTich'], 1) ?> m² ·
                        <?= htmlspecialchars($row['DiaChi']) ?>
                    </div>

                    <div class="post-info" style="color: #666;">
                        <?= mb_substr(strip_tags($row['MoTa']), 0, 100, 'UTF-8') 
                            . (mb_strlen(strip_tags($row['MoTa'])) > 100 ? '...' : '') ?>
                    </div>

                    <div class="post-user">
                        <img src="<?= ASSETS_URL ?>/img/default-user.png" alt="user">
                        <div>
                            <b><?= htmlspecialchars($row['TenNguoiDang']) ?></b><br>
                            <small><?= date("d/m/Y", strtotime($row['NgayDang'])) ?></small>
                        </div>
                        <?php if ($row['SoDienThoai']): ?>
                            <a href="tel:<?= htmlspecialchars($row['SoDienThoai']) ?>" class="btn-call">Gọi ngay</a>
                        <?php else: ?>
                            <span class="btn-call" style="background:#ccc;cursor:not-allowed;">Liên hệ</span>
                        <?php endif; ?>
                        <span class="heart">❤</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center; padding:60px 20px; color:#666; font-size:1.1rem;">
            Hiện chưa có tin đăng nào. Hãy quay lại sau nhé!
        </p>
    <?php endif; ?>
</div>

<!-- Phần giới thiệu dưới cùng -->
<div class="footer-info container">
    <div class="footer-card">
        <h2>CHO THUÊ PHÒNG TRỌ, NHÀ TRỌ</h2>
        <p>Khi có nhu cầu thuê phòng trọ, chắc hẳn bạn sẽ băn khoăn với hàng loạt câu hỏi như: “Không biết bắt đầu từ đâu? Sợ bị mất cọc oan vì những phòng trọ “ảo”? Tìm mãi nhưng không ra phòng ưng ý?...”</p>
        <p>Đừng quá lo lắng, vì <strong>PhongtroQN.com</strong> chính là giải pháp tối ưu dành cho những vấn đề đó. Nơi bạn có thể tìm phòng trọ mà không cần lặn lội khắp nơi, chỉ cần vài cú nhấp chuột là tìm thấy ngay một nơi ở tiềm năng.</p>
        
        <h3>Giới thiệu về PhongtroQN.com</h3>
        <p>PhongtroQN.com là kênh thông tin Phòng trọ số 1 Quy Nhơn, một nền tảng chuyên biệt về cho thuê phòng trọ, nhà trọ lớn nhất hiện nay.</p>

        <h3>Ưu điểm của website PhongtroQN.com</h3>
        <ul>
            <li><b>Chuyên môn hóa về phòng trọ:</b> Giúp khách tìm kiếm tiết kiệm thời gian và tránh lọc qua tin không liên quan.</li>
            <li><b>Nguồn tin dồi dào, cập nhật liên tục:</b> Với rất nhiều người dùng, đảm bảo tin đăng mới mỗi ngày.</li>
            <li><b>Thông tin minh bạch - hạn chế rủi ro:</b> Kiểm duyệt kỹ lưỡng, tránh phòng trọ “ảo”.</li>
            <li><b>Bộ lọc thông minh, dễ dùng:</b> Lọc phòng trọ theo khu vực, giá, loại phòng nhanh chóng.</li>
            <li><b>Hỗ trợ người cho thuê phòng:</b> Chủ trọ nhanh chóng kết nối với người có nhu cầu, đăng tin dễ dàng.</li>
        </ul>
        <h3>Cam kết khi sử dụng dịch vụ tại PhongtroQN.com</h3>
        <ul>
            <li>Chất lượng tin đăng: thông tin minh bạch, rõ ràng.</li>
            <li>Hỗ trợ tận tâm: bộ phận chăm sóc khách hàng chuyên nghiệp.</li>
            <li>Tin đăng hiệu quả: tiếp cận đúng đối tượng.</li>
            <li>Chi phí rẻ: đa dạng gói dịch vụ.</li>
            <li>Đổi mới, cải tiến: cải thiện giao diện và trải nghiệm người dùng.</li>
        </ul>
        <!-- Thống kê -->
        <section class="stats">
            <h3>Thống kê nổi bật</h3>
            <div class="stat-items">
                <div class="stat-item"><span class="number">15.000+</span><span class="label">Chủ nhà & Môi giới</span></div>
                <div class="stat-item"><span class="number">50.000+</span><span class="label">Tin đăng</span></div>
                <div class="stat-item"><span class="number">200+</span><span class="label">Tin đăng/ngày</span></div>
                <div class="stat-item"><span class="number">300.000+</span><span class="label">Lượt xem/tháng</span></div>
            </div>
        </section>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>