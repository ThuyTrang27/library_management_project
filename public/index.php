<?php
require_once dirname(__DIR__) . '/config/config.php';

require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';

require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';

session_start();

$database = new Database();
$db = $database->connect();

$authController = new AuthController(new User($db));
$bookController = new BookController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'listbook';

switch ($action) {

    case 'login':
        $authController->login();
        break;

    // case 'logout':
    //     $authController->logout();
    //     break;

    case 'home':
    case 'listbook':
        $bookController->showListBook();
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}
?>