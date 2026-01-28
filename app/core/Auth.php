<?php
class Auth
{
    public static function check()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public static function admin()
    {
        self::check();
        if ($_SESSION['user']['role'] != 1) {
            header("Location: index.php?action=listbook");
            exit;
        }
    }

    public static function user()
    {
        self::check();
        if ($_SESSION['user']['role'] != 0) {
            header("Location: index.php?action=admin_borrow_list");
            exit;
        }
    }
}
