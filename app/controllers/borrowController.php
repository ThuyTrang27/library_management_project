<?php

require_once __DIR__ . '/../models/borrowRequest.php';

class BorrowController
{
    private $db;
    private $requestModel;

   public function __construct($dbConnection) {
        // Nhận biến kết nối từ index.php truyền sang
        $this->db = $dbConnection; 
        $this->requestModel = new BorrowRequest($this->db);
    }

    /**
     * Thêm sách vào danh sách chờ mượn (Session)
     */
    private function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('You must login to borrow book!');</script>";
        header("Location: index.php?action=login");
        exit();
    }
}
    public function addToMyBook($bookId, $bookTitle, $author, $image)
    {
            $this->checkLogin();

        if (!isset($_SESSION['my_book_cart'])) {
            $_SESSION['my_book_cart'] = [];
        }

        if (!isset($_SESSION['my_book_cart'][$bookId])) {
            $_SESSION['my_book_cart'][$bookId] = [
                'id'       => $bookId,
                'title'    => $bookTitle,
                'author'   => $author,
                'image'    => $image,
                'quantity' => 1
            ];
            echo "<script>alert('Add to My book!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Sách này đã có trong danh sách của bạn!'); window.history.back();</script>";
        }
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
        require_once __DIR__ . '/../views/books/myBook.php';
    }

    /**
     * Xử lý gửi yêu cầu mượn vào Database
     */
   public function submitRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lưu ý: Phải có login mới có user_id
            $userId = $_SESSION['user_id'] ?? 1; // Tạm để 1 nếu chưa làm login
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            // SỬA TẠI ĐÂY: Dùng đúng tên session đã lưu ở hàm addToMyBook
            $books = $_SESSION['my_book_cart'] ?? []; 
            $borrowDate = $_POST['borrow_date'];
            $returnDate = $_POST['return_date'];
            if (!empty($books) && $this->requestModel->createRequest($userId, $name, $phone, $address, $borrowDate, $returnDate, $books)) {
                // 1. Xóa giỏ hàng sau khi lưu DB thành công
                unset($_SESSION['my_book_cart']); 
                
                // 2. Hiện thông báo và chuyển hướng bằng Javascript (Cách này cực kỳ ổn định)
                echo "<script>
                        alert('Gửi yêu cầu mượn thành công!'); 
                        window.location.href = 'index.php?action=home'; 
                    </script>";
                exit(); // Dừng thực thi để đảm bảo không load thêm gì nữa
            } else {
                echo "<script>
                        alert('Có lỗi xảy ra hoặc danh sách sách trống!'); 
                        window.history.back();
                    </script>";
                exit();
            }
        }
    }
}