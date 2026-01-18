<?php
class App
{
    public function __construct()
    {
        require_once "app/controllers/HomeController.php";
        $controller = new bookController($pdo);
        $controller->index();
    }
}
