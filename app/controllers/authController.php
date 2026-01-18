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