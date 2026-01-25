<?php
require_once __DIR__ . '/../models/user.php';

class AdminController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function userList()
    {
        $users = $this->userModel->getAllUsers();
        require __DIR__ . '/../views/admin/userList.php';
    }

    public function lockUser()
    {
        if (isset($_GET['id'])) {
            $this->userModel->lockUser($_GET['id']);
        }
        header('Location: index.php?action=user_list');
        exit();
    }

    public function unlockUser()
    {
        if (isset($_GET['id'])) {
            $this->userModel->unlockUser($_GET['id']);
        }
        header('Location: index.php?action=user_list');
        exit();
    }
}
