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


    public function showByCategory()
    {
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        // Lấy dữ liệu lọc
        $books = $this->bookModel->getBooksByCategory($categoryId, $limit, $offset);
        $totalBooks = $this->bookModel->getTotalBooksByCategory($categoryId);
        $totalPages = ceil($totalBooks / $limit);

        // Load View (dùng chung view listbook nhưng dữ liệu đã được lọc)
        require_once __DIR__ . '/../views/books/bookListView.php';
    }
}
