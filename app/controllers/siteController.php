<?php
require_once __DIR__ . '/../models/category.php';

class SiteController
{
    private $categoryModel;

    public function __construct($db)
    {
        $this->categoryModel = new Category($db);
    }

    public function about()
    {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/pages/about.php';
    }

    public function contact()
    {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/pages/contact.php';
    }
}
