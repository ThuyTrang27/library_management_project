<?php
// require_once __DIR__ . '/../config/config.php';
require_once dirname(__DIR__) . '/config/config.php';

require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';

require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';
require_once dirname(__DIR__) . '/app/models/category.php';



session_start();

$database = new Database();
$db = $database->connect();
$categoryModel = new Category($db);
$categories = $categoryModel->getAllCategories();

$authController = new AuthController(new User($db));
$bookController = new BookController($db);
require_once dirname(__DIR__) . '/app/models/category.php';



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

    case 'home':
    case 'listbook':
        $bookController->showListBook();
        break;
    case 'category':
        $bookController->showByCategory();
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
