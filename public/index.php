<?php
session_start();

/*
|--------------------------------------------------------------------------
| CONFIG & CORE
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/core/Auth.php';

/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';
require_once dirname(__DIR__)  . '/app/models/category.php';
require_once dirname(__DIR__)  . '/app/models/borrowRequest.php';

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';
require_once dirname(__DIR__)  . '/app/controllers/borrowController.php';
require_once dirname(__DIR__)  . '/app/controllers/adminController.php';

/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/
$database = new Database();
$db = $database->connect();

/*
|--------------------------------------------------------------------------
| CONTROLLER INSTANCES
|--------------------------------------------------------------------------
*/
$authController   = new AuthController(new User($db));
$bookController   = new BookController($db);
$borrowController = new BorrowController($db);
$adminController  = new AdminController($db);

/*
|--------------------------------------------------------------------------
| ROUTER
|--------------------------------------------------------------------------
*/
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

    case 'category':
        $bookController->showByCategory();
        break;

    case 'bookdetail':
        $bookController->viewDetail($_GET['id'] ?? 0);
        break;

    case 'search':
        $bookController->search();
        break;

    case 'mybook':
        $borrowController->showMyBook();
        break;

    case 'add_to_mybook':
        $borrowController->addToMyBook(
            $_GET['id'],
            $_GET['title'],
            $_GET['author'],
            $_GET['img']
        );
        break;

    case 'show_borrow_form':
        $borrowController->showFormBookRequest();
        break;

    case 'submit_borrow':
        $borrowController->submitRequest();
        break;

    case 'remove_from_cart':
        $borrowController->removeFromCart();
        break;

    case 'update_cart_qty':
        $borrowController->updateCartQty();
        break;

    /* ========= ADMIN ========= */
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
        $adminController->updateStatus((int)$_GET['id'], 'Approved');
        break;

    case 'admin_borrow_refuse':
        Auth::admin();
        $adminController->updateStatus((int)$_GET['id'], 'Rejected');
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
