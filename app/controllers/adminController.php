<?php

require_once dirname(__DIR__, 2) . '/app/core/Auth.php';
require_once dirname(__DIR__, 2) . '/app/models/borrowRequest.php';

class AdminController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new BorrowRequest($db);
    }

    public function list()
    {
        Auth::admin();
        $requests = $this->model->getAll();
        require dirname(__DIR__, 2) . '/app/views/admin/borrowList.php';
    }

    public function detail($id)
    {
        Auth::admin();
        $request = $this->model->getById($id);
        $items   = $this->model->getItems($id);
        require dirname(__DIR__, 2) . '/app/views/admin/borrowDetail.php';
    }

    public function updateStatus($id, $status)
    {
        Auth::admin();
        $this->model->updateStatus($id, $status);
        header("Location: index.php?action=admin_borrow_list");
        exit;
    }
}
