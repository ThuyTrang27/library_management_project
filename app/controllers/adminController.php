<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/book.php';
require_once __DIR__ . '/../models/category.php';

class AdminController
{
    private $userModel;
    private $bookModel;

    private $categoryModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
        
        $this->bookModel = new Book($db);

        $this->categoryModel = new Category($db);
    }

    public function showAdminDashboard()
    {
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

        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }                                                                   

    public function showAddBookForm() {
        require_once __DIR__ . '/../views/admin/formAddBook.php';

    }
    public function doAddBook() {
    // Debug: Kiểm tra xem dữ liệu có gửi lên không
    // print_r($_POST); print_r($_FILES); die(); 

    $data = [
        "book_title"    => $_POST['book_title'] ?? '',
        "author"        => $_POST['author'] ?? '',
        "categories_id" => $_POST['categories_id'] ?? '',
        "price"         => $_POST['price'] ?? 0,
        "stock_quantity"=> $_POST['stock_quantity'] ?? 0,
        "publisher"     => $_POST['publisher'] ?? '',
        "publish_year"  => $_POST['publish_year'] ?? '',
        "image_url"     => 'default.png', // Mặc định
        "content"       => $_POST['content'] ?? ''
    ];

    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        // Lưu ý: Đảm bảo thư mục "public/images/" đã tồn tại
        $folder = "public/images/";
        if (!is_dir($folder)) mkdir($folder, 0777, true); 

        $filename = time() . "_" . $_FILES['book_image']['name'];
        $destination = $folder . $filename;

        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $destination)) {
            $data['image_url'] = $filename;
        }
    }

    $result = $this->bookModel->addNewBook($data);

    if (!$result['status']) {
        // Hiện lỗi ra để bạn biết sai ở đâu (ví dụ: sai tên cột, sai ID...)
        die("Lỗi Database: " . ($result['message'] ?? 'Unknown Error'));
    } else {
        header("Location: index.php?action=listbook");
        exit();
    }
}
}
