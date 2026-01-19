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

    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        // Gọi model để tìm kiếm
        $books = $this->bookModel->searchBooks($keyword);

        // Hiển thị kết quả ra view riêng
        require_once __DIR__ . '/../views/books/searchResult.php';
    }
}
