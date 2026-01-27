<?php
session_start();

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/core/Auth.php';

// MODELS
require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';
require_once dirname(__DIR__) . '/app/models/category.php';
require_once dirname(__DIR__) . '/app/models/borrowRequest.php';

// CONTROLLERS
require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';
require_once dirname(__DIR__) . '/app/controllers/borrowController.php';
require_once dirname(__DIR__) . '/app/controllers/adminController.php';

$database = new Database();
$db = $database->connect();

// Khởi tạo các Controller
$authController   = new AuthController(new User($db));
$bookController   = new BookController($db);
$borrowController = new BorrowController($db);
$adminController  = new AdminController($db);

$action = $_GET['action'] ?? 'listbook';

switch ($action) {
    /* ========= AUTH ========= */
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'register':
        $authController->registerView();
        break;
    case 'doregister':
        $authController->doRegister();
        break;

    /* ========= USER ========= */
    case 'listbook':
        $bookController->showListBook();
        break;
    case 'bookdetail':
        $bookController->viewDetail($_GET['id'] ?? 0);
        break;
    case 'mybook':
        $borrowController->showMyBook();
        break;
    case 'submit_borrow':
        $borrowController->submitRequest();
        break;

    /* ========= ADMIN (Quản lý mượn sách) ========= */
    case 'admin_borrow_list':
        Auth::admin();
        $adminController->list();
        break;

    case 'admin_borrow_detail':
        Auth::admin();
        $adminController->detail((int)($_GET['id'] ?? 0));
        break;

    case 'admin_borrow_accept':
        Auth::admin();
        // Gọi hàm update với status 'Accepted' để trừ kho
        $adminController->updateStatus((int)$_GET['id'], 'Accepted');
        break;

    case 'admin_borrow_refuse':
        Auth::admin();
        // Gọi hàm update với status 'Refused'
        $adminController->updateStatus((int)$_GET['id'], 'Refused');
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
