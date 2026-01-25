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

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/
$database = new Database();
$db = $database->connect();

/*
|--------------------------------------------------------------------------
| CONTROLLER INSTANCES
|--------------------------------------------------------------------------
*/
$authController = new AuthController(new User($db));
$bookController = new BookController($db);

/*
|--------------------------------------------------------------------------
| ROUTING
|--------------------------------------------------------------------------
*/
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
    case 'search':
        $bookController->search();
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
