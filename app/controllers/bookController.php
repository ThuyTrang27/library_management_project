<?php
/**
 * app/controllers/bookController.php
 * Controller quản lý sách
 */

require_once MODELS_PATH . '/book.php';
require_once MODELS_PATH . '/category.php';

class BookController
{
    private $bookModel;
    private $categoryModel;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->bookModel = new Book($pdo);
        $this->categoryModel = new Category($pdo);
    }

    /**
     * Hiển thị trang chủ - danh sách sách phân trang
     */
    public function index()
    {
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAllCategories();
        
        // Phân trang
        $booksPerPage = 20; // 4 dòng x 5 sách
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        
        // Lấy sách theo trang
        $books = $this->bookModel->getBooksByPage($page, $booksPerPage);
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $booksPerPage);
        
        // Truyền dữ liệu đến view
        require VIEWS_PATH . '/home.php';
    }

    /**
     * Hiển thị chi tiết một quyển sách
     */
    public function show($id)
    {
        $book = $this->bookModel->getBookById($id);
        $categories = $this->categoryModel->getAllCategories();
        
        if (!$book) {
            header("Location: " . BASE_URL . "/index.php?action=home");
            exit;
        }
        
        require VIEWS_PATH . '/bookDetail.php';
    }

    /**
     * Hiển thị sách theo danh mục
     */
    public function showByCategory($categoryId)
    {
        $category = $this->categoryModel->getCategoryById($categoryId);
        $categories = $this->categoryModel->getAllCategories();
        
        if (!$category) {
            header("Location: " . BASE_URL . "/index.php?action=home");
            exit;
        }
        
        $booksPerPage = 20;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $books = $this->bookModel->getBooksByCategory($categoryId, $page, $booksPerPage);
        $totalBooks = $this->bookModel->getTotalBooksByCategory($categoryId);
        $totalPages = ceil($totalBooks / $booksPerPage);
        
        require VIEWS_PATH . '/categoryBooks.php';
    }

    /**
     * Tìm kiếm sách
     */
    public function search()
    {
        $categories = $this->categoryModel->getAllCategories();
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $books = [];
        
        if (!empty($keyword)) {
            $books = $this->bookModel->searchBooks($keyword);
        }
        
        require VIEWS_PATH . '/searchResults.php';
    }
}
