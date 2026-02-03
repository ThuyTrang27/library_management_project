<<<<<<< HEAD
<?php
class AuthController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /* ================= LOGIN ================= */
    public function login()
    {
        $message = null;

        if (isset($_POST['login'])) {
            $message = $this->handleLogin(
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );
        }

        require dirname(__DIR__) . '/views/auth/login.php';
    }

    private function handleLogin($email, $password)
    {
        $user = $this->model->getUserByEmail($email);

        if (!$user) {
            return "You did not register yet!";
        }

        if (!password_verify($password, $user['password'])) {
            return "Wrong email or password!";
        }

        $_SESSION['user'] = [
            'id'       => $user['user_id'],
            'username' => $user['username'],
            'role'     => (int)$user['role']
        ];

        // Redirect theo role
        if ((int)$user['role'] === 1) {
            header("Location: index.php?action=admin_borrow_list");
        } else {
            header("Location: index.php?action=listbook");
        }
        exit();
    }



    /* ================= REGISTER ================= */



    public function registerView()
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function doRegister()
    {
        $data = [
            'fullname'      => $_POST['fullname'] ?? '',
            'username'      => $_POST['username'] ?? '',
            'email'         => $_POST['email'] ?? '',
            'phone'         => $_POST['phone'] ?? '',
            'password'      => $_POST['pwd'] ?? '',
            'address'       => $_POST['address'] ?? '',
            'gender'        => $_POST['gender'] ?? 0,
            'date_of_birth' => $_POST['date_of_birth'] ?? '',
        ];

        $result = $this->model->register($data);
        if ($result['status'] === true) {
            header("Location: index.php?action=login");
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=listbook");
        exit();
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
=======
<?php 
    class AuthController {
        private $userModel;

        public function __construct() {
            require_once __DIR__ . '/../models/user.php';
            global $conn;

            if (!isset($conn)) {
                die('❌ conn NOT FOUND in controller');
            }

            $this->userModel = new User($conn);
        }

        public function registerView() {
            require_once __DIR__ . '/../views/auth/register.php';
        }

       public function doRegister() {
    // Lưu ý: Tên key trong $_POST phải khớp với thuộc tính 'name' trong file HTML register.php
    $data = [
        'fullname'      => $_POST['fullname'] ?? '',
        'username'      => $_POST['username'] ?? '',
        'email'         => $_POST['email'] ?? '',
        'phone'         => $_POST['phone'] ?? '',
        'password'      => $_POST['pwd'] ?? '', // Trong view bạn đặt name="pwd"
        'address'       => $_POST['address'] ?? '',
        'gender'        => $_POST['gender'] ?? 0,
        'date_of_birth' => $_POST['date_of_birth'] ?? '',
    ];

    $result = $this->userModel->register($data);

    // VÌ MODEL TRẢ VỀ MẢNG, NÊN PHẢI KIỂM TRA ['status']
    if ($result['status'] === true) {
        // Đăng ký thành công -> Chuyển hướng
        header("Location: /library_management_project/public/views/login.php");
        exit();
    } else {
        // Đăng ký thất bại -> Lưu thông báo lỗi vào Session và quay lại trang đăng ký
        $_SESSION['error'] = $result['message'];
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    }
}
    }
?>
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
