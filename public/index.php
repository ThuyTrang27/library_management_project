<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/user.php';
require_once __DIR__ . '/../app/controllers/authController.php';

$db = (new Database())->connect();
$userModel = new UserModel($db);
$authController = new AuthController($userModel);

$action = $_GET['action'] ?? 'login';
$message = null;

switch ($action) {
    case 'login':
        if (isset($_POST['login'])) $message = $authController->handleLogin($_POST['email'], $_POST['password'], $_POST['role']);
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
        if (isset($_POST['verify'])) $message = $authController->handleVerifyOTP($_POST['otp_input']);
        include __DIR__ . '/../app/views/auth/verify_otp.php';
        break;

    case 'reset_password':
        if (isset($_POST['reset'])) {
            $message = $authController->handleResetPassword($_POST['new_password'], $_POST['confirm_password']);
            if ($message === "Đổi mật khẩu thành công!") header("Refresh: 2; url=index.php?action=login");
        }
        include __DIR__ . '/../app/views/auth/reset_password.php';
        break;

    case 'home':
        if (!isset($_SESSION['user_id'])) header("Location: index.php");
        echo "<h1>Chào mừng, " . $_SESSION['full_name'] . "</h1><a href='index.php?action=logout'>Đăng xuất</a>";
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php");
        break;

    default:
        header("Location: index.php?action=login");
}
