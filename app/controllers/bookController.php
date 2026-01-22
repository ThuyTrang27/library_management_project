<?php
    class BookController {
        private $bookModel;

        public function __construct($db) {
            require_once __DIR__ . '/../models/book.php';
            $this->bookModel = new Book($db);
        }
    public function viewDetail($bookId) {
            $book = $this->bookModel->getBookById($bookId);
            
            if ($book) {
                require_once __DIR__ . '/../views/books/viewBookDetail.php';
            } else {
                echo "Không tìm thấy sách!";
            }
        }
    }
?>
