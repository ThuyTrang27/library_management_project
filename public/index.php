<?php

/**
 * public/index.php
 */

// 1. Load config để lấy các hằng số PATH và khởi chạy Session
require_once __DIR__ . '/../config/config.php';

// 2. Load Models
require_once __DIR__ . '/../app/models/user.php';
require_once __DIR__ . '/../app/models/book.php';
// 3. Load Controllers
require_once __DIR__ . '/../app/controllers/authController.php';
require_once __DIR__ . '/../app/controllers/bookController.php';

// 4. Khởi tạo Database và Controllers
try {
    $database = new Database();
    $db = $database->connect();

    $authController = new AuthController(new UserModel($db));
    $bookController = new BookController($db);

    $action = $_GET['action'] ?? 'home';
    $id = $_GET['id'] ?? null;
    $message = null;

    // 5. Điều hướng (Routing)
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
                if (strpos($message, 'sent') !== false) {
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
                if ($message === "update password successfull!") {
                    header("Refresh: 2; url=index.php?action=login");
                }
            }
            include __DIR__ . '/../app/views/auth/reset_password.php';
            break;

        case 'home':
            $bookController->showListBook();
            break;
        case 'listbook':
            $bookController->showListBook();
            break;
        case 'logout':
            session_start();
            session_unset();
            session_destroy();
            header("Location: index.php?action=login");
            exit();
            break;

        default:
            header("Location: index.php?action=home");
            break;
    } // Kết thúc switch

} catch (Exception $e) {
    http_response_code(500);
    echo "Lỗi hệ thống: " . htmlspecialchars($e->getMessage());
} // Kết thúc try-catch