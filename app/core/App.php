<?php
class Auth
{
    public static function admin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?action=login");
            exit;
        }
    }
}
