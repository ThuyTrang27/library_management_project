<?php
// require_once __DIR__ . '/../config/config.php';
require_once dirname(__DIR__) . '/config/config.php';

require_once dirname(__DIR__) . '/app/models/user.php';
require_once dirname(__DIR__) . '/app/models/book.php';

require_once dirname(__DIR__) . '/app/controllers/authController.php';
require_once dirname(__DIR__) . '/app/controllers/bookController.php';
require_once dirname(__DIR__) . '/app/controllers/borrowController.php';
require_once dirname(__DIR__) . '/app/models/category.php';



session_start();

$database = new Database();
$db = $database->connect();
$categoryModel = new Category($db);
$categories = $categoryModel->getAllCategories();

$authController = new AuthController(new User($db));
$bookController = new BookController($db);
$borrowController = new BorrowController($db);
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
        $borrowController->submitRequest(); // Hàm mình viết ở câu trả lời trước
        break;
    
    case 'remove_from_cart':
    $borrowController->removeFromCart();
    break;

    case 'update_cart_qty':
        $borrowController->updateCartQty();
        break;

    default:
        header("Location: index.php?action=listbook");
        exit();
}

?>