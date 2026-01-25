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
            $_SESSION['username'] = $user['username'];
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
