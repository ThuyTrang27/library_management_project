<?php

require_once __DIR__ . '/../models/borrowRequest.php';
require_once __DIR__ . '/../models/category.php';

class BorrowController
{
    private $db;
    private $requestModel;

    private $categoryModel;

    public function __construct($dbConnection)
    {
        // Nhận biến kết nối từ index.php truyền sang
        $this->db = $dbConnection;
        $this->requestModel = new BorrowRequest($this->db);
        $this->categoryModel = new Category($this->db);
    }

    /**
     * Thêm sách vào danh sách chờ mượn (Session)
     */
    private function checkLogin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }


    public function addToMyBook($bookId, $bookTitle, $author, $image)
    {
        // 1. Kiểm tra quyền truy cập
        $this->checkLogin();

        // 2. Đảm bảo giỏ hàng đã được khởi tạo
        $this->initCart();

        // 3. Xử lý logic thêm hoặc cập nhật
        if ($this->isBookInCart($bookId)) {
            echo "<script>alert('This book is already in My book!'); window.history.back();</script>";
        } else {
            $this->addNewBookToCart($bookId, $bookTitle, $author, $image);
            // Khi thêm mới, dùng Script để hiện Alert thông báo
            echo "<script>alert('Added to My book!'); window.history.back();</script>";
        }
        exit();
    }

    // --- Các hàm hỗ trợ (Private Helper Methods) ---

    private function initCart()
    {
        if (!isset($_SESSION['my_book_cart'])) {
            $_SESSION['my_book_cart'] = [];
        }
    }

    private function isBookInCart($bookId)
    {
        return isset($_SESSION['my_book_cart'][$bookId]);
    }

    private function addNewBookToCart($bookId, $bookTitle, $author, $image)
    {
        $_SESSION['my_book_cart'][$bookId] = [
            'id'       => $bookId,
            'title'    => $bookTitle,
            'author'   => $author,
            'image'    => $image,
            'quantity' => 1
        ];
    }

    /**
     * Hiển thị Form điền thông tin mượn
     */
    public function showFormBookRequest()
    {
        require_once __DIR__ . '/../views/books/formBookBorrowRequest.php';
    }

    /**
     * Hiển thị trang danh sách sách đã chọn
     */
    public function showMyBook()
    {
        $listBooks = isset($_SESSION['my_book_cart']) ? $_SESSION['my_book_cart'] : [];
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/books/myBook.php';
    }

    // Xử lý gửi yêu cầu mượn vào Database //    
    public function submitRequest()
    {
        Auth::user();

        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=mybook");
            exit();
        }

        $borrowData = $this->getBorrowFormData();
        $books = $_SESSION['my_book_cart'] ?? [];

        if (empty($books)) {
            $this->showMessage('Your borrowed book list is empty!', true);
        }

        $isSuccess = $this->requestModel->createRequest(
            $borrowData['userId'],
            $borrowData['name'],
            $borrowData['phone'],
            $borrowData['address'],
            $borrowData['borrowDate'],
            $borrowData['returnDate'],
            $books
        );

        if ($isSuccess) {
            unset($_SESSION['my_book_cart']);
            $this->showMessage(
                'Your request to borrow has been submitted!',
                false,
                'index.php?action=listbook'
            );
        } else {
            $this->showMessage('Failed to save data. Please try again!', true);
        }
    }




    // --- Các hàm hỗ trợ (Private Helper Methods) ---

    private function getBorrowFormData()
    {
        Auth::user();

        return [
            'userId' => $_SESSION['user']['id'],
            'name'       => $_POST['name'] ?? '',
            'phone'      => $_POST['phone'] ?? '',
            'address'    => $_POST['address'] ?? '',
            'borrowDate' => $_POST['borrow_date'] ?? date('Y-m-d'),
            'returnDate' => $_POST['return_date'] ?? ''
        ];
    }

    private function showMessage($msg, $isBack = true, $redirectUrl = '')
    {
        Auth::user();

        echo "<script>alert('$msg');";
        if ($isBack) {
            echo "window.history.back();";
        } elseif ($redirectUrl !== '') {
            echo "window.location.href = '$redirectUrl';";
        }
        echo "</script>";
        exit();
    }

    /**
     * Xóa sách khỏi danh sách mượn tạm (Session)
     */
    public function removeFromCart()
    {
        Auth::user();

        $id = $_GET['id'] ?? null;
        if ($id && isset($_SESSION['my_book_cart'][$id])) {
            unset($_SESSION['my_book_cart'][$id]);
            echo "Success";
        } else {
            echo "Error";
        }
        exit(); // Rất quan trọng: Dừng chương trình để không load thêm HTML thừa
    }

    /**
     * Cập nhật số lượng sách trong danh sách mượn (Session)
     */
    public function updateCartQty()
    {
        Auth::user();

        $id = $_GET['id'] ?? null;
        $qty = $_GET['qty'] ?? 1;

        if ($id && isset($_SESSION['my_book_cart'][$id])) {
            // Bạn có thể thêm kiểm tra tồn kho tại đây nếu muốn
            $_SESSION['my_book_cart'][$id]['quantity'] = $qty;
            echo "Updated";
        } else {
            echo "Error";
        }
        exit(); // Ngắt kết nối để trả phản hồi sạch về cho Javascript
    }
}
