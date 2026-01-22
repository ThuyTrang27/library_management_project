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
    public function addToMyBook($bookId, $bookTitle, $author, $image)
    {
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
            echo "<script>alert('Đã thêm vào My Book!'); window.history.back();</script>";
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

            if (!empty($books) && $this->requestModel->createRequest($userId, $name, $phone, $address, $books)) {
                unset($_SESSION['my_book_cart']); // Xóa giỏ sau khi thành công
                echo "<script>alert('Gửi yêu cầu mượn thành công!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra hoặc danh sách sách trống!');</script>";
            }
        }
    }
}