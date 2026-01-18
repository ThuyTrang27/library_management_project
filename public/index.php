<?php

/**
 * public/index.php
 * Front Controller
 */

// 1. Load config
require_once dirname(__DIR__) . '/config/config.php';

// 2. Load Models
require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';

// 3. Load Controllers
require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';

try {
    $database = new Database();
    $db = $database->connect();

    $authController = new AuthController(new UserModel($db));
    $bookController = new BookController($db);

    $action = $_GET['action'] ?? 'home';

    switch ($action) {

        case 'login':
            if (isset($_POST['login'])) {
                $message = $authController->handleLogin(
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['role']
                );
            }
            require dirname(__DIR__) . '/app/views/auth/login.php';
            break;

        case 'forgot_password':
            if (isset($_POST['send_otp'])) {
                $message = $authController->handleForgetPassword($_POST['email']);
            }
            require dirname(__DIR__) . '/app/views/auth/forgot_password.php';
            break;

        case 'verify_otp':
            if (isset($_POST['verify'])) {
                $message = $authController->handleVerifyOTP($_POST['otp_input']);
            }
            require dirname(__DIR__) . '/app/views/auth/verify_otp.php';
            break;

        case 'reset_password':
            if (isset($_POST['reset'])) {
                $message = $authController->handleResetPassword(
                    $_POST['new_password'],
                    $_POST['confirm_password']
                );
            }
            require dirname(__DIR__) . '/app/views/auth/reset_password.php';
            break;

        case 'home':
        case 'listbook':
            $bookController->showListBook();
            break;

        case 'logout':
            session_destroy();
            header("Location: index.php?action=login");
            exit();

        default:
            header("Location: index.php?action=home");
            exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Lỗi hệ thống: " . htmlspecialchars($e->getMessage());
}
