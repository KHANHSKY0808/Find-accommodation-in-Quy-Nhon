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
            <?php if ($u['IsAdmin'] == 1): ?>
                <a href="<?= BASE_URL ?>/index.php?page=admin" class="btn-manage">🔐 Admin Dashboard</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/quan-ly" class="btn-manage">Quản lý</a>
            <?php endif; ?>

            <div class="user-menu">
                <div class="user-info">
					<i class="fas fa-user-circle fa-lg"></i>
					<?= htmlspecialchars($u['HoTen']) ?> 
				</div>
                <div class="dropdown">
                    <a href="<?= BASE_URL ?>/ho-so"><i class="fas fa-user-cog"></i> Quản lý tài khoản</a>
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


<?php // === KẾT NỐI NÚT "BỘ LỌC" TRONG HEADER VỚI POPUP SIÊU ĐẸP === ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
/* ===== TOÀN BỘ CSS POPUP ĐẸP NHƯ BẠN ĐÃ CÓ (chỉ copy nguyên) ===== */
.filter-fab { display:none; } /* ẩn nút nổi cũ đi, vì giờ dùng nút trong header */

#superModal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(12px);
    z-index: 10000;
    align-items: flex-end;
}
#superModal.active { display: flex; }

.super-box {
    background: #fff;
    width: 100%;
    max-width: 560px;
    border-radius: 24px 24px 0 0;
    overflow: hidden;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 -10px 40px rgba(0,0,0,0.15);
    animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@media (min-width: 768px) {
    .super-box { border-radius: 24px; margin: 40px auto; }
    #superModal { align-items: center; }
}
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }

.super-header { padding: 20px 24px 16px; text-align: center; position: relative; border-bottom: 1px solid #eee; }
.super-header h3 { margin: 0; font-size: 20px; font-weight: 600; }
.super-close { position: absolute; right: 20px; top: 16px; font-size: 34px; cursor: pointer; color: #999; }

.super-body { padding: 24px; overflow-y: auto; flex-grow: 1; }
.super-group + .super-group { margin-top: 32px; }
.super-group h4 { margin: 0 0 14px 0; font-size: 15.5px; font-weight: 600; color: #333; }

.super-location { display: grid; grid-template-columns: 1fr 1fr; gap:14px; margin-bottom:20px; }
.super-location select { padding:13px 16px; border:1.5px solid #ddd; border-radius:14px; font-size:14.5px; background:#fff; }

.super-tags { display:flex; flex-wrap:wrap; gap:10px; }
.super-tag {
    padding:11px 20px; border:1.5px solid #e0e0e0; border-radius:30px; font-size:14px;
    cursor:pointer; background:#fafafa; transition:all .25s;
}
.super-tag.active, .super-tag:hover { background:#ff5722; color:white; border-color:#ff5722; }

/* Đặc điểm nổi bật – màu xanh lá nhạt */
.super-tag.feature { background:#e8f5e9; border-color:#c8e6c9; color:#2e7d32; }
.super-tag.feature.active, .super-tag.feature:hover { background:#4caf50; color:white; border-color:#4caf50; }

.super-footer { padding:24px; background:#fff; }
.btn-apply {
    width:100%; padding:17px; background:#ff5722; color:white; border:none;
    border-radius:50px; font-size:17.5px; font-weight:600; cursor:pointer;
    box-shadow:0 4px 15px rgba(255,87,34,.3);
}
</style>

<!-- POPUP SIÊU ĐẸP -->
<div id="superModal">
    <div class="super-box">
        <div class="super-header">
            <h3>Bộ lọc</h3>
            <div class="super-close">×</div>
        </div>

        <div class="super-body">
            <!-- Khu vực -->
            <div class="super-group">
                <h4>Lọc theo khu vực</h4>
                <div class="super-location">
                    <select id="provSelect">
                        <option value="">Tỉnh/Thành phố</option>
                        <option value="hcm">TP. Hồ Chí Minh</option>
                        <option value="hn">Hà Nội</option>
                        <option value="danang">Đà Nẵng</option>
                        <option value="binhduong">Bình Dương</option>
                        <option value="camaau">Cà Mau</option>
                        <option value="binhdinh">Bình Định</option>
                        <option value="cantho">Cần Thơ</option>
                    </select>
                    <select id="distSelect"><option value="">Quận/Huyện</option></select>
                </div>
            </div>

            <!-- Danh mục, Giá, Diện tích, Đặc điểm nổi bật – giữ nguyên như cũ -->
            <div class="super-group"><h4>Danh mục cho thuê</h4><div class="super-tags">
                <div class="super-tag active">Tất cả</div><div class="super-tag">Phòng trọ</div><div class="super-tag">Nhà nguyên căn</div>
                <div class="super-tag">Ở ghép</div><div class="super-tag">Căn hộ mini</div><div class="super-tag">Mặt bằng</div>
            </div></div>

            <div class="super-group"><h4>Khoảng giá</h4><div class="super-tags">
                <div class="super-tag active">Tất cả</div><div class="super-tag">Dưới 1 triệu</div><div class="super-tag">1 - 2 triệu</div>
                <div class="super-tag">2 - 3 triệu</div><div class="super-tag">3 - 5 triệu</div><div class="super-tag">5 - 7 triệu</div>
                <div class="super-tag">Trên 7 triệu</div>
            </div></div>

            <div class="super-group"><h4>Khoảng diện tích</h4><div class="super-tags">
                <div class="super-tag active">Tất cả</div><div class="super-tag">Dưới 20m²</div><div class="super-tag">20 - 30m²</div>
                <div class="super-tag">30 - 50m²</div><div class="super-tag">Trên 50m²</div>
            </div></div>

            <div class="super-group">
                <h4>Đặc điểm nổi bật</h4>
                <div class="super-tags">
                    <div class="super-tag feature">Đầy đủ nội thất</div>
                    <div class="super-tag feature">Có gác</div>
                    <div class="super-tag feature">Kệ bếp</div>
                    <div class="super-tag feature">Có máy lạnh</div>
                    <div class="super-tag feature">Có máy giặt</div>
                    <div class="super-tag feature">Có tủ lạnh</div>
                    <div class="super-tag feature">Có thang máy</div>
                    <div class="super-tag feature">Không chung chủ</div>
                    <div class="super-tag feature">Giờ giấc tự do</div>
                    <div class="super-tag feature">Có bảo vệ 24/24</div>
                    <div class="super-tag feature">Có hầm để xe</div>
                </div>
            </div>
        </div>

        <div class="super-footer">
			<form id="filterForm" method="GET" action="<?= BASE_URL ?>/">
				<!-- Các input hidden giữ nguyên -->
				<input type="hidden" name="tinh" value="">
				<input type="hidden" name="huyen" value="">
				<input type="hidden" name="loai" value="">
				<input type="hidden" name="gia" value="">
				<input type="hidden" name="dientich" value="">
				<input type="hidden" name="dactiem" value="">

				<button type="submit" class="btn-apply">Áp dụng</button>
			</form>
        </div>
    </div>
</div>

<script>
// KẾT NỐI NÚT "BỘ LỌC" TRONG HEADER VỚI POPUP
document.querySelector('.filter-button')?.addEventListener('click', () => {
    document.getElementById('superModal').classList.add('active');
});

// Đóng popup
document.querySelector('.super-close')?.addEventListener('click', () => {
    document.getElementById('superModal').classList.remove('active');
});
document.getElementById('superModal')?.addEventListener('click', e => {
    if (e.target === document.getElementById('superModal')) {
        document.getElementById('superModal').classList.remove('active');
    }
});

// Tỉnh → Quận/huyện động
const districtsData = {
    hcm: ["Quận 1","Quận 3","Bình Thạnh","Gò Vấp","Tân Bình","Phú Nhuận","Thủ Đức","Quận 7"],
    hn: ["Ba Đình","Hoàn Kiếm","Đống Đa","Cầu Giấy","Hai Bà Trưng","Thanh Xuân"],
    danang: ["Hải Châu","Thanh Khê","Sơn Trà","Ngũ Hành Sơn"],
    binhduong: ["TP. Thủ Dầu Một","Dĩ An","Thuận An"],
    camaau: ["TP. Cà Mau","Huyện U Minh","Huyện Thới Bình"],
    binhdinh: ["TP. Quy Nhơn","An Nhơn","Phù Cát","Hoài Nhơn"],
    cantho: ["Ninh Kiều","Cái Răng","Bình Thủy"]
};
document.getElementById('provSelect')?.addEventListener('change', function() {
    const dist = document.getElementById('distSelect');
    dist.innerHTML = '<option value="">Quận/Huyện</option>';
    if (this.value && districtsData[this.value]) {
        districtsData[this.value].forEach(d => {
            const o = document.createElement('option');
            o.value = d; o.textContent = d;
            dist.appendChild(o);
        });
    }
});

// Tag active – Đặc điểm nổi bật cho phép chọn nhiều
document.querySelectorAll('.super-tag').forEach(t => {
    t.addEventListener('click', function() {
        if (this.classList.contains('feature')) {
            this.classList.toggle('active');
        } else {
            this.parentNode.querySelectorAll('.super-tag').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// Khi bấm "Áp dụng" → thu thập tất cả giá trị đã chọn → điền vào form → submit
document.querySelector('.btn-apply').addEventListener('click', function(e) {
    e.preventDefault();

    const form = document.getElementById('filterForm');

    // 1. Tỉnh (mặc định Bình Định)
    form.querySelector('[name="tinh"]').value = 'binhdinh';

    // 2. Huyện
    const huyen = document.getElementById('distSelect').value;
    form.querySelector('[name="huyen"]').value = huyen;

    // 3. Loại phòng (chỉ 1 cái active)
    const loaiActive = document.querySelector('.super-group:nth-of-type(2) .super-tag.active');
    form.querySelector('[name="loai"]').value = loaiActive ? loaiActive.textContent.trim() : '';

    // 4. Khoảng giá
    const giaActive = document.querySelector('.super-group:nth-of-type(3) .super-tag.active');
    let giaVal = '';
    if (giaActive && giaActive.textContent.trim() !== 'Tất cả') {
        const txt = giaActive.textContent.trim();
        if (txt === 'Dưới 1 triệu') giaVal = '0-1000000';
        else if (txt === '1 - 2 triệu') giaVal = '1000000-2000000';
        else if (txt === '2 - 3 triệu') giaVal = '2000000-3000000';
        else if (txt === '3 - 5 triệu') giaVal = '3000000-5000000';
        else if (txt === '5 - 7 triệu') giaVal = '5000000-7000000';
        else if (txt === 'Trên 7 triệu') giaVal = '7000000-999999999';
    }
    form.querySelector('[name="gia"]').value = giaVal;

    // 5. Diện tích
    const dtActive = document.querySelector('.super-group:nth-of-type(4) .super-tag.active');
    let dtVal = '';
    if (dtActive && dtActive.textContent.trim() !== 'Tất cả') {
        const txt = dtActive.textContent.trim();
        if (txt === 'Dưới 20m²') dtVal = '0-20';
        else if (txt === '20 - 30m²') dtVal = '20-30';
        else if (txt === '30 - 50m²') dtVal = '30-50';
        else if (txt === 'Trên 50m²') dtVal = '50-999';
    }
    form.querySelector('[name="dientich"]').value = dtVal;

    // 6. Đặc điểm nổi bật (có thể chọn nhiều)
    const dactiem = Array.from(document.querySelectorAll('.super-group:last-child .super-tag.active'))
                         .map(t => t.textContent.trim());
    form.querySelector('[name="dactiem"]').value = dactiem.join(',');

    // Submit form
    form.submit();
});
</script>