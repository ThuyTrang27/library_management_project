<?php
<<<<<<< HEAD
session_start(); // Bắt buộc để dùng OTP trong Session

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/user.php';
require_once __DIR__ . '/../app/controllers/authController.php';

$database = new Database();
$db = $database->connect();
$userModel = new UserModel($db);
$authController = new AuthController($userModel);

$action = $_GET['action'] ?? 'login';
$message = null;

switch ($action) {
    case 'login':
        if (isset($_POST['login'])) {
            $message = $authController->handleLogin($_POST['email'], $_POST['password'], $_POST['role']);
        }
        include __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'forgot_password':
        if (isset($_POST['send_otp'])) {
            $message = $authController->handleForgetPassword($_POST['email']);
            if (strpos($message, 'đã gửi') !== false) {
                header("Location: index.php?action=verify_otp");
                exit();
            }
        }
        include __DIR__ . '/../app/views/auth/forgot_password.php';
        break;

    case 'verify_otp':
        if (isset($_POST['verify'])) {
            $message = $authController->handleVerifyOTP($_POST['otp_input']);
        }
        include __DIR__ . '/../app/views/auth/verify_otp.php';
        break;

    case 'reset_password':
        if (isset($_POST['reset'])) {
            $message = $authController->handleResetPassword($_POST['new_password'], $_POST['confirm_password']);
            if ($message === "Đổi mật khẩu thành công!") {
                header("Refresh: 2; url=index.php?action=login");
            }
        }
        include __DIR__ . '/../app/views/auth/reset_password.php';
        break;

    case 'home':
        if (!isset($_SESSION['user_id'])) header("Location: index.php");
        echo "<h1>Trang chủ - Chào " . $_SESSION['full_name'] . "</h1>";
        break;

    default:
        header("Location: index.php?action=login");
=======

/**
 * public/index.php
 * Entry Point - Điểm bắt đầu của ứng dụng
 */

// Load config
require_once dirname(__DIR__) . '/config/config.php';
// Load models
require_once MODELS_PATH . '/book.php';
require_once MODELS_PATH . '/category.php';

// Load controllers
require_once CONTROLLERS_PATH . '/bookController.php';

// ===== ROUTING =====
$action = $_GET['action'] ?? 'home';
$id = $_GET['id'] ?? null;

try {
    $bookController = new BookController($pdo);

    switch ($action) {
        case 'home':
            $bookController->index();
            break;

        case 'book':
            if ($id) {
                $bookController->show($id);
            } else {
                $bookController->index();
            }
            break;

        case 'category':
            if ($id) {
                $bookController->showByCategory($id);
            } else {
                $bookController->index();
            }
            break;

        case 'search':
            $bookController->search();
            break;

        default:
            $bookController->index();
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . htmlspecialchars($e->getMessage());
>>>>>>> bb1a4fc23cac2d01eabe85366b40306b21f45d48
}
