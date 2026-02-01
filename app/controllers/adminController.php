<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/book.php';
require_once __DIR__ . '/../models/category.php';
require_once dirname(__DIR__, 2) . '/app/core/Auth.php';

class AdminController
{
    private $userModel;
    private $bookModel;

    private $categoryModel;
    private $model;

    public function __construct($db)
    {
        $this->userModel = new User($db);
        
        $this->bookModel = new Book($db);

        $this->categoryModel = new Category($db);
        $this->model = new BorrowRequest($db);
    }

    public function list()
    {
        Auth::admin();
        $requests = $this->model->getAll();
        require dirname(__DIR__, 2) . '/app/views/admin/borrowList.php';
    }

    public function detail($id)
    {
        Auth::admin();
        $request = $this->model->getById($id);
        $items = $this->model->getItems($id);
        require dirname(__DIR__, 2) . '/app/views/admin/borrowDetail.php';
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
        header("Location: index.php?action=admin_dashboard");
        exit();
    }
    }
    
     public function showEditBookForm($id) {
    // Nếu $id truyền vào bị rỗng hoặc false, thử lấy trực tiếp từ $_GET lần nữa để chắc chắn
    if (!$id) {
        $id = $_GET['id'] ?? 0;
    }

    $book = $this->bookModel->getBookById($id);

    if (!$book) {
        // Debug nếu vẫn lỗi
        echo "Không tìm thấy sách với ID: " . $id; 
        die();
    }

    $categories = $this->categoryModel->getAllCategories();
    require_once __DIR__ . '/../views/admin/formEditBook.php';
}

    public function doEditBook() {
        $id = $_POST['book_id'] ?? 0;
        $oldBook = $this->bookModel->getBookById($id);
        $img_url = $oldBook['image_url'];

        if (isset($_FILES['book_image'])&& $_FILES['book_image']['error']==0){
            $filename = time() . "_" . $_FILES['book_image']['name'];
            if (move_uploaded_file($_FILES['book_image']['tmp_name'], "public/images/".$filename)){
                $img_url = $filename;
            }
        }
        $data = [
            "book_id"       => $id,
            "book_title"    => $_POST['book_title'] ?? '',
            "author"        => $_POST['author'] ?? '',
            "categories_id" => $_POST['categories_id'] ?? '',
            "price"         => $_POST['price'] ?? 0,
            "stock_quantity"=> $_POST['stock_quantity'] ?? 0,
            "publisher"     => $_POST['publisher'] ?? '',
            "publish_year"  => $_POST['publish_year'] ?? '',
            "image_url"     => $img_url,
            "content"       => $_POST['content'] ?? ''
        ];

        $updateResult = $this->bookModel->updateBook($id, $data);
        if ($updateResult['status']) { // Kiểm tra key 'status' bên trong mảng
            header("Location: index.php?action=admin_dashboard");
            exit();
        } else {
            die("Error: " . $updateResult['message']);
        }
            }
        public function doDeleteBook($id) {
        if ($id) {
            $this->bookModel->deleteBook($id);
        }
        header("Location: index.php?action=admin_dashboard"); // Xóa xong quay về danh sách
        }
    public function updateStatus($id, $status)
    {
        Auth::admin();

        if (!in_array($status, ['Approved', 'Rejected'])) {
            die('Invalid status');
        }

        $this->model->updateStatus($id, $status);
        header("Location: index.php?action=admin_borrow_list");
        exit();
}
}
   

    
?>