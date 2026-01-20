<?php
require_once 'models/BorrowRequest.php';

class BorrowController {
    private $db;
    private $requestModel;

    public function __construct($database) {
        $this->db = $database->connect();
        $this->requestModel = new BorrowRequest($this->db);
    }

    public function addToMyBook($bookId, $bookTitle, $author, $image) {
        // Nếu chưa có mảng trong session thì tạo mới
        if (!isset($_SESSION['my_book_cart'])) {
            $_SESSION['my_book_cart'] = [];
        }

        // Kiểm tra xem sách đã có trong danh sách chưa để tránh trùng lặp
        if (!isset($_SESSION['my_book_cart'][$bookId])) {
            $_SESSION['my_book_cart'][$bookId] = [
                'id' => $bookId,
                'title' => $bookTitle,
                'author' => $author,
                'image' => $image,
                'quantity' => 1
            ];
            echo "<script>alert('Đã thêm vào My Book!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Sách này đã có trong danh sách của bạn!'); window.history.back();</script>";
        }
    }

    // Hiển thị trang myBook.php
    public function showMyBook() {
        $listBooks = isset($_SESSION['my_book_cart']) ? $_SESSION['my_book_cart'] : [];
        include 'views/myBook.php';
    }
    // Xử lý khi ấn Submit Form mượn
    public function submitRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id']; // Giả sử đã login
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $books = $_SESSION['cart']; // Lấy sách từ giỏ hàng tạm

            if ($this->requestModel->createRequest($userId, $name, $phone, $address, $books)) {
                unset($_SESSION['cart']); // Xóa giỏ hàng sau khi gửi thành công
                echo "<script>alert('Gửi yêu cầu mượn thành công!'); window.location.href='index.php';</script>";
            } else {
                echo "Có lỗi xảy ra.";
            }
        }
    }
}