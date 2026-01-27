<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/category.php';

class AdminController
{
    private $userModel;
    private $categoryModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
        $this->categoryModel = new Category($db);
    }

    public function userManagement()
    {
        $users = $this->userModel->getAllUsers();
        $categories = $this->categoryModel->getAllCategories();
        require __DIR__ . '/../views/admin/userManagement.php';
    }

    public function lockUser()
    {
        if (isset($_GET['id'])) {
            $this->userModel->lockUser($_GET['id']);
        }
        header('Location: index.php?action=user_management');
        exit();
    }

    public function unlockUser()
    {
        if (isset($_GET['id'])) {
            $this->userModel->unlockUser($_GET['id']);
        }
        header('Location: index.php?action=user_management');
        exit();
    }
}
