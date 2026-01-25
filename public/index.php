<?php
session_start();

/*
|--------------------------------------------------------------------------
| CONFIG & DATABASE
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/config/config.php';

/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';
require_once dirname(__DIR__) . '/app/models/category.php';

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';
require_once dirname(__DIR__) . '/app/models/category.php';

require_once dirname(__DIR__) . '/app/controllers/borrowController.php';

$database = new Database();
$db = $database->connect();

/*
|--------------------------------------------------------------------------
| CONTROLLER INSTANCES
|--------------------------------------------------------------------------
*/
$authController = new AuthController(new User($db));
$bookController = new BookController($db);
$borrowController = new BorrowController($db);



$action = isset($_GET['action']) ? $_GET['action'] : 'listbook';

switch ($action) {

    case 'register':
        $authController->registerView();
        break;

    case 'doregister':
        $authController->doRegister();
        break;

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;
    case 'listbook':
        $bookController->showListBook();
        break;

    case 'category':
        $bookController->showByCategory();
        $bookController->showByCategory();
        break;

    case 'add_to_mybook':
        $borrowController->addToMyBook($_GET['id'], $_GET['title'], $_GET['author'], $_GET['img']);
        break;

    case 'bookdetail':
        $id = $_GET['id'] ?? null;
        $bookController->viewDetail($id);
        break;

    case 'mybook':
        $borrowController->showMyBook();
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

    case 'search':
        $bookController->search();
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
