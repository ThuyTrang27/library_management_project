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
        // Hiển thị file formBorrowRequest.php
        $borrowController->showFormBookRequest();
        break;
        
    case 'submit_borrow':
        $borrowController->submitRequest(); // Hàm mình viết ở câu trả lời trước
        break;
    
    // Trong index.php, thêm case này vào switch ($action)
    case 'remove_from_cart':
        $id = $_GET['id'] ?? null;
        if ($id && isset($_SESSION['my_book_cart'][$id])) {
            unset($_SESSION['my_book_cart'][$id]); // Xóa bỏ phần tử khỏi session
        }
        echo "Success"; // Phản hồi cho fetch ở JS
        break;

    case 'update_cart_qty':
        $id = $_GET['id'] ?? null;
        $qty = $_GET['qty'] ?? 1;
        if ($id && isset($_SESSION['my_book_cart'][$id])) {
            $_SESSION['my_book_cart'][$id]['quantity'] = $qty;
        }
        echo "Updated";
        break;   

    default:
        header("Location: index.php?action=listbook");
        exit();
}

?>