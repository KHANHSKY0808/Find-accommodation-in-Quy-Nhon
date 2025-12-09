<?php
class AdminController
{
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
            redirect('/');
            exit;
        }

        return view('admin/index');
    }

    public function manageReports()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
            redirect('/');
            exit;
        }

        // Xử lý hành động
        $action = $_GET['action'] ?? null;
        $reportID = $_GET['id'] ?? null;

        if ($action === 'resolve' && $reportID) {
            query("UPDATE baocao SET DaXuLy = 1 WHERE BaoCaoID = ?", [$reportID]);
            redirect('/index.php?page=admin/reports&success=1');
        }

        if ($action === 'delete' && $reportID) {
            query("DELETE FROM baocao WHERE BaoCaoID = ?", [$reportID]);
            redirect('/index.php?page=admin/reports&success=2');
        }

        if ($action === 'delete_user') {
            $userID = $_GET['user_id'] ?? null;
            if ($userID) {
                // Kiểm tra xem user có phải admin không
                $user = query("SELECT IsAdmin FROM user WHERE UserID = ?", [$userID])->fetch(PDO::FETCH_ASSOC);
                if ($user && $user['IsAdmin'] == 1) {
                    redirect('/index.php?page=admin/reports&error=admin');
                    exit;
                }
                // Xóa tất cả báo cáo của user này
                query("DELETE FROM baocao WHERE UserID = ?", [$userID]);
                // Xóa tất cả bài đăng của user này
                query("DELETE FROM post WHERE UserID = ?", [$userID]);
                // Xóa user
                query("DELETE FROM user WHERE UserID = ?", [$userID]);
                redirect('/index.php?page=admin/reports&success=3');
            }
        }

        if ($action === 'delete_post') {
            $postID = $_GET['post_id'] ?? null;
            if ($postID) {
                // Xóa tất cả báo cáo cho bài đăng này
                query("DELETE FROM baocao WHERE PostID = ?", [$postID]);
                // Xóa bài đăng
                query("DELETE FROM post WHERE PostID = ?", [$postID]);
                redirect('/index.php?page=admin/reports&success=4');
            }
        }

        // Lấy bộ lọc từ query string
        $filterStatus = $_GET['status'] ?? '';
        $searchKeyword = $_GET['search'] ?? '';

        // Xây dựng query
        $sql = "SELECT b.BaoCaoID, b.UserID, b.PostID, b.NoiDung, b.NgayBaoCao, b.DaXuLy,
                       u.HoTen as TenNguoiBaoCao, p.TieuDe, p.GiaPhong, p.DiaChi, p.NgayDang
                FROM baocao b
                JOIN user u ON b.UserID = u.UserID
                JOIN post p ON b.PostID = p.PostID
                WHERE 1=1";

        if ($filterStatus !== '') {
            $sql .= " AND b.DaXuLy = " . ($filterStatus == '1' ? '1' : '0');
        }

        if ($searchKeyword !== '') {
            $sql .= " AND (p.TieuDe LIKE ? OR u.HoTen LIKE ? OR b.NoiDung LIKE ?)";
            $keyword = "%$searchKeyword%";
            $reports = query($sql . " ORDER BY b.NgayBaoCao DESC", [$keyword, $keyword, $keyword])->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $reports = query($sql . " ORDER BY b.NgayBaoCao DESC")->fetchAll(PDO::FETCH_ASSOC);
        }

        // Thống kê
        $totalReports = query("SELECT COUNT(*) FROM baocao")->fetchColumn();
        $pendingReports = query("SELECT COUNT(*) FROM baocao WHERE DaXuLy = 0")->fetchColumn();
        $resolvedReports = query("SELECT COUNT(*) FROM baocao WHERE DaXuLy = 1")->fetchColumn();

        // Gán dữ liệu vào biến toàn cục để view sử dụng
        $GLOBALS['reports'] = $reports;
        $GLOBALS['totalReports'] = $totalReports;
        $GLOBALS['pendingReports'] = $pendingReports;
        $GLOBALS['resolvedReports'] = $resolvedReports;
        $GLOBALS['filterStatus'] = $filterStatus;
        $GLOBALS['searchKeyword'] = $searchKeyword;

        require __DIR__ . '/../Views/admin/manage-reports.php';
    }

    public function users()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
            redirect('/');
            exit;
        }

        // Xử lý xóa
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $userId = (int)$_GET['id'];
            if ($userId === $_SESSION['user_id'] || $userId === 1) { // Bảo vệ admin
                redirect('/index.php?page=admin/users&error=protected');
                exit;
            }
            query("DELETE FROM post WHERE UserID = ?", [$userId]);
            query("DELETE FROM baocao WHERE UserID = ?", [$userId]);
            query("DELETE FROM user WHERE UserID = ? AND IsAdmin = 0", [$userId]);
            redirect('/index.php?page=admin/users&success=1');
        }

        // Lấy danh sách user thường
        $users = query("SELECT * FROM user WHERE IsAdmin = 0 ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

        // Truyền data cho view (chuẩn hơn $GLOBALS)
        return view('admin/users', [
            'users' => $users,
            'total' => count($users)
        ]);
    }
}