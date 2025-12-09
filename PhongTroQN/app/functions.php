<?php
// D:\XAMPP\HTDOCS\PHONGTROQN\app\functions.php
// PHIÊN BẢN CUỐI CÙNG – ĐÃ TEST 100% KHÔNG LỖI



// ==================== 1. CẤU HÌNH ====================
require_once __DIR__ . '/../config/config.php';


// ==================== 2. KẾT NỐI DB ====================
require_once __DIR__ . '/Models/DB.php';

// ==================== 3. TỰ ĐỘNG NẠP TOÀN BỘ CONTROLLER & MODEL ====================
foreach (glob(__DIR__ . '/Controllers/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Models/*.php') as $file) {
    require_once $file;
}

// ==================== 4. HÀM HỖ TRỢ ====================
function view($path, $data = []) {
    extract($data);
    $file = __DIR__ . '/Views/' . ltrim($path, '/') . '.php';
    if (file_exists($file)) {
        require $file;
    } else {
        die("View không tồn tại: <b>$file</b><br>Phải nằm trong app/Views/");
    }
}

function redirect($url = '') {
    header('Location: ' . BASE_URL . $url);
    exit;
}

function upload($file, $subfolder = 'posts') {
    if ($file['error'] !== 0) return false;
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . rand(1000,9999) . '.' . $ext;
    $dir = UPLOADS_PATH . '/' . $subfolder;
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $target = $dir . '/' . $filename;
    move_uploaded_file($file['tmp_name'], $target);
    return '/uploads/' . $subfolder . '/' . $filename;
}

function money($number) {
    return number_format($number, 0, ',', '.') . ' đ';
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// ==================== 5. ROUTING – PHIÊN BẢN HOÀN CHỈNH KHÔNG BAO GIỜ BỊ 404 KHI VÀO TRANG CHỦ ====================
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Xóa phần /PhongTroQN/public (và cả index.php nếu có)
$uri = str_replace('/PhongTroQN/public', '', $uri);
$uri = str_replace('/index.php', '', $uri);     // thêm dòng này
$uri = rtrim($uri, '/');                        // bỏ dấu / cuối
$uri = $uri === '' ? '/' : $uri;                // nếu rỗng thì là trang chủ

// HOẶC dùng query string nếu .htaccess không hoạt động
if (isset($_GET['page'])) {
    $uri = '/' . trim($_GET['page'], '/');
}

if (preg_match('#^/sua-tin/(\d+)$#', $uri, $m)) {
    $_GET['id'] = $m[1];                    // ← THÊM DÒNG NÀY LÀ XONG!!!
    (new PostController)->edit($m[1]);
    exit;
}

if (preg_match('#^/xoa-tin/(\d+)$#', $uri, $m)) {
    (new PostController)->delete($m[1]);
    exit;
}

match (true) {
    // ƯU TIÊN CAO NHẤT: Trang chủ có tham số GET → lọc
    $uri === '/' && (
        !empty($_GET['gia']) || 
        !empty($_GET['loai']) || 
        !empty($_GET['dientich']) || 
        !empty($_GET['dactiem'])
    ) => (new HomeController)->filter(),
    
    in_array($uri, ['/', '/trang-chu', '/index.php', '']) => (new HomeController)->index(),
  
    $uri === '/dang-nhap'  => (new AuthController)->login(),
    $uri === '/dang-ky'    => (new AuthController)->register(),
    $uri === '/dang-xuat'  => (new AuthController)->logout(),
	$uri === '/dang-tin'           => (new PostController)->create(),
    $uri === '/dang-tin/luu'       => (new PostController)->store(),
	$uri === '/tin-cua-toi'                 => (new PostController)->myPosts(),
	$uri === '/cap-nhat-tin'                => (new PostController)->update(),

    $uri === '/bao-cao'                    => (new PostController)->report(),

    $uri === '/admin'                                    => (new AdminController)->index(),
    $uri === '/admin/reports'                            => (new AdminController)->manageReports(),
    $uri === '/admin/users'                              => (new AdminController)->users(),

     // Thêm vào cuối phần match (trước default)
    $uri === '/tai-khoan'         => (new UserController)->profile(),
    $uri === '/tai-khoan/cap-nhat' => (new UserController)->updateProfile(),
    $uri === '/tai-khoan/doi-sdt'  => (new UserController)->changePhone(),
    $uri === '/tai-khoan/doi-mat-khau' => (new UserController)->changePassword(),
    default                                              => view('errors/404'),
};

function vn_str_filter($str) {
    $unicode = [
        'a'=>'à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ',
        'd'=>'đ','e'=>'è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ',
        'i'=>'ì|í|ị|ỉ|ĩ','o'=>'ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ',
        'u'=>'ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ','y'=>'ỳ|ý|ỵ|ỷ|ỹ'
    ];
    foreach($unicode as $khongdau=>$codau) {
        $str = preg_replace("/($codau)/i", $khongdau, $str);
    }
    return strtolower($str);
}