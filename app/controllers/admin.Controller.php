<?php
require_once '../app/models/user.php';

class AdminController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function userManagement()
    {
        // Lấy tất cả người dùng từ model
        $users = $this->userModel->getAllUsers();

        // Tải view và truyền dữ liệu
        require_once '../app/views/admin/userManagement.php';
    }
}
