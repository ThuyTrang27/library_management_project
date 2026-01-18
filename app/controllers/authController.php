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
                $_POST['email'],
                $_POST['password'],
                $_POST['role']
            );
        }

        require dirname(__DIR__) . '/views/auth/login.php';
    }

    private function handleLogin($email, $password, $role)
    {
        $user = $this->model->getUserByEmail($email);
        $roleValue = (int)$role; // FIX CHUẨN VỚI VIEW

        if (!$user) return "You did not register yet!";

        if (password_verify($password, $user['password']) && $user['role'] == $roleValue) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php?action=home");
            exit();
        }
        return "You have entered the wrong password/email";
    }

    public function registerView()
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function doRegister()
    {
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

        $result = $this->model->register($data);

        // VÌ MODEL TRẢ VỀ MẢNG, NÊN PHẢI KIỂM TRA ['status']
        if ($result['status'] === true) {
            // Đăng ký thành công -> Chuyển hướng
            header("Location: index.php?action=login");
            exit();
        } else {
            // Đăng ký thất bại -> Lưu thông báo lỗi vào Session và quay lại trang đăng ký
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
    }
}
