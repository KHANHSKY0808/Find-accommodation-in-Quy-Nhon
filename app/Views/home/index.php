<?php
// app/Views/home/index.php
$title = "PhongTroQN - Phòng trọ Quy Nhơn số 1";
require_once __DIR__ . '/../partials/header.php';
?>

<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/index.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/post-detail-modal.css?v=<?= time() ?>">

<!-- Header info -->
<div class="header-info">
    <h1>Kênh thông tin Phòng Trọ số 1 Quy Nhơn</h1>
    <p>Hiện có <b><?= number_format($totalPosts ?? 0) ?></b> tin đăng đang hoạt động</p>
</div>

<div class="container">
    <h2 style="margin:20px 0; color:#0073e6;">Đề xuất dành cho bạn</h2>

    <?php if (!empty($posts)): ?>
        <div class="posts-grid">
            <?php foreach ($posts as $row): ?>
                <?php
                $anh = !empty($row['AnhDaiDien'])
                    ? UPLOADS_URL . $row['AnhDaiDien']
                    : ASSETS_URL . '/img/noimage.png';

                $images = $row['images'] ?? [];

                $postData = base64_encode(json_encode([
                    'PostID'       => $row['PostID'],
                    'TieuDe'       => $row['TieuDe'] ?? '',
                    'GiaPhong'     => $row['GiaPhong'] ?? 0,
                    'DienTich'     => $row['DienTich'] ?? 0,
                    'DiaChi'       => $row['DiaChi'] ?? '',
                    'MoTa'         => $row['MoTa'] ?? '',
                    'NgayDang'     => date("d/m/Y", strtotime($row['NgayDang'])),
                    'TenNguoiDang' => $row['TenNguoiDang'] ?? 'Chủ trọ',
                    'SoDienThoai'  => $row['SoDienThoai'] ?? '',
                    'AnhDaiDien'   => $row['AnhDaiDien'] ?? null,
                    'images'       => $images,
                    'Latitude'     => $row['Latitude'] ?? null,
                    'Longitude'    => $row['Longitude'] ?? null,
                ]));
                ?>

                <div class="post-card post-card-modal" data-post="<?= $postData ?>">
                    <div class="post-image">
                        <img src="<?= $anh ?>" alt="<?= htmlspecialchars($row['TieuDe']) ?>"
                             onerror="this.src='<?= ASSETS_URL ?>/img/noimage.png'" loading="lazy">
                    </div>
                    <div class="post-title"><?= htmlspecialchars($row['TieuDe']) ?></div>
                    <div class="post-price"><?= number_format($row['GiaPhong']) ?> đ/tháng</div>
                    <div class="post-info">
                        <?= number_format($row['DienTich'], 1) ?> m² · <?= htmlspecialchars($row['DiaChi']) ?>
                    </div>
                    <div class="post-info" style="color:#666;font-size:0.9rem;">
                        <?= mb_substr(strip_tags($row['MoTa'] ?? ''), 0, 100, 'UTF-8') . '...' ?>
                    </div>
                    <div class="post-user">
                        <img src="<?= ASSETS_URL ?>/img/default-user.png" alt="user">
                        <div>
                            <b><?= htmlspecialchars($row['TenNguoiDang']) ?></b><br>
                            <small><?= date("d/m/Y", strtotime($row['NgayDang'])) ?></small>
                        </div>
                        <?php if (!empty($row['SoDienThoai'])): ?>
                            <a href="tel:<?= $row['SoDienThoai'] ?>" class="btn-call" onclick="event.stopPropagation();">Gọi ngay</a>
                        <?php else: ?>
                            <span class="btn-call" style="background:#ccc;cursor:not-allowed;">Liên hệ</span>
                        <?php endif; ?>
                        <span class="heart" onclick="event.stopPropagation();">Heart</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center;padding:80px;color:#888;">Hiện chưa có tin đăng nào.</p>
    <?php endif; ?>
</div>

<!-- Phần giới thiệu giữ nguyên -->
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


<!-- ======================== MODAL CHI TIẾT PHÒNG TRỌ ======================== -->
<div id="detailModal" class="detail-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="detail-title" class="modal-title"></h2>
            <span class="close">×</span>
        </div>

        <div class="modal-body">
            <div class="modal-grid">
                <!-- Cột trái: Ảnh -->
                <div class="image-section">
                    <div class="main-slider-wrapper">
                        <button class="slider-btn prev">‹</button>
                        <img id="main-image" src="" alt="Phòng trọ">
                        <button class="slider-btn next">›</button>
                    </div>
                    <div class="thumbnail-container">
                        <ul id="detail-thumbnails"></ul>
                    </div>
                </div>

                <!-- Cột phải: Thông tin -->
                <div class="info-section">
                    <div class="price-tag" id="detail-price"></div>

                    <div class="meta-info">
                        <div class="meta-row"><strong>Diện tích:</strong> <span id="detail-area"></span> m²</div>
                        <div class="meta-row"><strong>Địa chỉ:</strong> <span id="detail-address"></span></div>
                        <div class="meta-row"><strong>Ngày đăng:</strong> <span id="detail-date"></span></div>
                    </div>

                    <h3 class="section-title">Mô tả chi tiết</h3>
                    <div class="description" id="detail-desc"></div>

                    <h3 class="section-title">Thông tin liên hệ</h3>
                    <div class="contact-box">
                        <p><strong>Chủ trọ:</strong> <span id="detail-hoten"></span></p>
                        <p><strong>Điện thoại:</strong> <a href="tel:" id="detail-phone" class="phone-link"></a></p>
                        <button type="button" class="btn-copy">Copy số điện thoại</button>
                    </div>

                    <div id="detail-map" class="map-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================== THƯ VIỆN CDN ======================== -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



<!-- ======================== JAVASCRIPT CHO MODAL ======================== -->
<script>
let currentMap = null;
let currentSlide = 0;
let totalSlides = 0;
let imagesArray = [];

function openDetailModal(data) {
    // === Điền thông tin ===
    $('#detail-title').text(data.TieuDe || 'Phòng trọ');
    $('#detail-price').text(new Intl.NumberFormat('vi-VN').format(data.GiaPhong) + ' đ/tháng');
    $('#detail-area').text(data.DienTich || 'N/A');
    $('#detail-address').text(data.DiaChi || 'Không có');
    $('#detail-date').text(data.NgayDang || '');
    $('#detail-desc').html((data.MoTa || 'Không có mô tả').replace(/\n/g, '<br>'));
    $('#detail-hoten').text(data.TenNguoiDang || 'Chủ trọ');

    const $phone = $('#detail-phone');
    if (data.SoDienThoai) {
        $phone.text(data.SoDienThoai).attr('href', 'tel:' + data.SoDienThoai);
    } else {
        $phone.text('Không công khai').removeAttr('href');
    }

    // === Xử lý ảnh ===
    const $thumbs = $('#detail-thumbnails').empty();
    imagesArray = data.images && data.images.length > 0 ? data.images : [];
    if (imagesArray.length === 0 && data.AnhDaiDien) imagesArray = [{URLAnh: data.AnhDaiDien}];
    if (imagesArray.length === 0) imagesArray = [{URLAnh: '/public/assets/img/noimage.png'}];

    totalSlides = imagesArray.length;

    imagesArray.forEach((img, i) => {
        const src = '<?= UPLOADS_URL ?>' + img.URLAnh;
        $thumbs.append(`<li><img src="${src}" alt="Thumbnail ${i+1}" onclick="selectSlide(${i})"></li>`);
    });

    currentSlide = 0;
    updateMainImage();

    // === Bản đồ ===
    const $map = $('#detail-map').html('<div style="height:100%;display:flex;align-items:center;justify-content:center;color:#666;font-size:1.2rem;">Đang tải bản đồ...</div>');

    if (currentMap) { currentMap.remove(); currentMap = null; }

    setTimeout(() => {
        let lat = parseFloat(data.Latitude) || 10.762622;
        let lng = parseFloat(data.Longitude) || 106.660172;

        currentMap = L.map('detail-map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(currentMap);

        L.marker([lat, lng]).addTo(currentMap)
            .bindPopup(`<b>${data.TieuDe}</b><br>${data.DiaChi}`)
            .openPopup();

        setTimeout(() => currentMap && currentMap.invalidateSize(), 200);
    }, 300);

    // Hiển thị modal
    $('#detailModal').fadeIn(300);
}

function closeModal() {
    $('#detailModal').fadeOut(300);
    if (currentMap) { currentMap.remove(); currentMap = null; }
}

function moveSlide(n) {
    currentSlide = (currentSlide + n + totalSlides) % totalSlides;
    updateMainImage();
}

function selectSlide(i) {
    currentSlide = i;
    updateMainImage();
}

function updateMainImage() {
    const src = '<?= UPLOADS_URL ?>' + imagesArray[currentSlide].URLAnh;
    $('#main-image').attr('src', src);
    $('#detail-thumbnails img').removeClass('active').eq(currentSlide).addClass('active');
}

// === Sự kiện đóng modal ===
$('.detail-modal .close, .detail-modal').on('click', function(e) {
    if (e.target === this || $(e.target).hasClass('close')) closeModal();
});

// === Copy số điện thoại ===
$('.btn-copy').on('click', function() {
    const phone = $('#detail-phone').text();
    if (phone && phone !== 'Không công khai') {
        navigator.clipboard.writeText(phone).then(() => {
            alert('Đã copy: ' + phone);
        }).catch(() => alert('Không thể copy'));
    }
});

// === Mở modal từ card ===
$(document).on('click', '.post-card-modal', function(e) {
    if ($(e.target).closest('.btn-call, .heart').length) return;
    const data = JSON.parse(atob(this.dataset.post));
    openDetailModal(data);
});
</script>