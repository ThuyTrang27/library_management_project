<?php
class BookController
{
    private $bookModel;
    private $categoryModel;

    public function __construct($db)
    {
        require_once __DIR__ . '/../models/book.php';
        require_once __DIR__ . '/../models/category.php';
        $this->bookModel = new Book($db);
        $this->categoryModel = new Category($db);
    }  
    
    public function showListBook()
    {
        // 1. Get categories for header menu
        $categories = $this->categoryModel->getAllCategories();

        // 2. Pagination setup
        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        // 3. Get books
        $books = $this->bookModel->getBooksPagination($limit, $offset);
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $limit);

        // 4. Load view
        require_once __DIR__ . '/../views/books/bookListView.php';
    }

    public function viewDetail($bookId) {
        $book = $this->bookModel->getBookById($bookId);
        $categories = $this->categoryModel->getAllCategories();

        if ($book) {
            require_once __DIR__ . '/../views/books/viewBookDetail.php';
        } else {
            echo "Book not found!";
        }
    }

    public function showByCategory()
    {
        // Get categories for header
        $categories = $this->categoryModel->getAllCategories();

        // Category ID from request
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Find selected category info
        $selectedCategory = null;
        foreach ($categories as $cat) {
            if ($cat['id'] == $categoryId) {
                $selectedCategory = $cat;
                break;
            }
        }

        // If category not found → redirect to home page
        if ($selectedCategory === null) {
            header("Location: index.php");
            exit();
        }

        // Pagination setup
        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        // Get books by category
        $books = $this->categoryModel->getBooksByCategory($categoryId, $limit, $offset);
        $totalBooks = $this->categoryModel->getTotalBooksByCategory($categoryId);
        $totalPages = ceil($totalBooks / $limit);

        require_once __DIR__ . '/../views/books/filterBook.php';
    }

    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $categories = $this->categoryModel->getAllCategories();
        
        // Call model to search books
        $books = $this->bookModel->searchBooks($keyword);

        // Show result in a separate view
        require_once __DIR__ . '/../views/books/searchResult.php';
    }
}
?>
