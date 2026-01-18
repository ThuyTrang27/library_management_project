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
}

  