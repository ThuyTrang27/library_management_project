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
        // 1. Lấy categories cho header
        $categories = $this->categoryModel->getAllCategories();

        // 2. Phân trang
        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        // 3. Lấy sách
        $books = $this->bookModel->getBooksPagination($limit, $offset);
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $limit);

        // 4. Load view
        require_once __DIR__ . '/../views/books/bookListView.php';
    }

    public function viewDetail($bookId)
    {
        $book = $this->bookModel->getBookById($bookId);
        $categories = $this->categoryModel->getAllCategories();

        if ($book) {
            require_once __DIR__ . '/../views/books/viewBookDetail.php';
        } else {
            echo "Không tìm thấy sách!";
        }
    }

    public function showByCategory()
    {
        // Categories cho header
        $categories = $this->categoryModel->getAllCategories();

        // ID thể loại
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Lấy tên thể loại đang chọn
        $selectedCategory = null;
        foreach ($categories as $cat) {
            if ($cat['id'] == $categoryId) {
                $selectedCategory = $cat;
                break;
            }
        }

        // Nếu không tìm thấy category → quay về trang chính
        if ($selectedCategory === null) {
            header("Location: index.php");
            exit();
        }

        // Phân trang
        $limit = 20;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        $offset = ($currentPage - 1) * $limit;

        // Lọc sách theo category
        $books = $this->categoryModel->getBooksByCategory($categoryId, $limit, $offset);
        $totalBooks = $this->categoryModel->getTotalBooksByCategory($categoryId);
        $totalPages = ceil($totalBooks / $limit);

        require_once __DIR__ . '/../views/books/filterBook.php';
    }
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        // Lấy dữ liệu categories để truyền vào header.php
        $categories = $this->categoryModel->getAllCategories();
        // ------------------------

        // Gọi model để tìm kiếm
        $books = $this->bookModel->searchBooks($keyword);

        // Hiển thị kết quả ra view
        require_once __DIR__ . '/../views/books/searchResult.php';
    }
}
