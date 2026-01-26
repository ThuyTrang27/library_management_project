<?php
require_once 'app/core/Auth.php';
require_once 'app/models/borrowRequest.php';

class AdminController
{

    public static function list()
    {
        Auth::admin();
        $model = new BorrowRequest();
        $requests = $model->getAll();
        require 'app/views/admin/borrowList.php';
    }

    public static function detail($id)
    {
        Auth::admin();
        $model = new BorrowRequest();
        $request = $model->getById($id);
        $items = $model->getItems($id);
        require 'app/views/admin/borrowDetail.php';
    }

    public static function updateStatus($id, $status)
    {
        Auth::admin();
        $model = new BorrowRequest();
        $model->updateStatus($id, $status);
        header("Location: index.php?action=admin_borrow_list");
    }
}
