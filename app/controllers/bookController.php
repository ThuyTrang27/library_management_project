<?php
class BookController
{
    private $bookModel;

    public function __construct($db)
    {
        require_once __DIR__ . '/../models/book.php';
        $this->bookModel = new Book($db);
    }

    public function showListBook()
    {
        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        $books = $this->bookModel->getBooksPagination($limit, $offset);
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $limit);

        require_once __DIR__ . '/../views/books/bookListView.php';
    }
     // Hiển thị chi tiết sách
    public function viewDetail($bookId) {
        $book = $this->bookModel->getBookById($bookId);
        
        if ($book) {
            require_once __DIR__ . '/../views/books/viewBookDetail.php';
        } else {
            echo "Không tìm thấy sách!";
        }
    }
}

