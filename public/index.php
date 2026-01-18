<?php
session_start();

// 1. Load file cấu hình
require_once __DIR__ . '/../config/config.php';

// 2. KHỞI TẠO KẾT NỐI (Thiếu đoạn này)
$db = new Database();
$conn = $db->getConnection();

// Kiểm tra xem đã có biến $conn chưa
if (!isset($conn)) {
    die('❌ conn NOT FOUND in index.php');
}

$action = $_GET['action'] ?? 'registerview';

require_once __DIR__ . '/../app/controllers/authController.php';

$auth = new AuthController();
switch ($action) {

    case 'registerview':

        $auth->registerView();

        break;



    case 'doregister':

        $auth->doRegister();

        break;



    default:

        echo "Home";

}

?>