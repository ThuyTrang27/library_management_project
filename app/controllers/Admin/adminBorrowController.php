<?php
class AdminBorrowController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        // CHẶN USER
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    // LIST REQUEST
    public function index()
    {
        $sql = "
            SELECT 
                br.borrow_request_id,
                u.full_name,
                u.address,
                u.phone,
                br.request_date,
                br.schedule_return_date,
                br.request_status
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            ORDER BY br.request_date DESC
        ";

        $requests = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        require_once dirname(__DIR__) . "/views/admin/borrowList.php";
    }

    // DETAIL REQUEST
    public function detail($id)
    {
        // Request info
        $stmt = $this->db->prepare("
            SELECT 
                br.borrow_request_id,
                u.full_name,
                u.phone,
                u.address,
                br.request_date,
                br.schedule_return_date,
                br.request_status
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            WHERE br.borrow_request_id = ?
        ");
        $stmt->execute([$id]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        // Books
        $stmt = $this->db->prepare("
            SELECT 
                b.book_id,
                b.book_title,
                b.author,
                c.categories_name,
                brb.quantity
            FROM borrow_request_books brb
            JOIN books b ON brb.book_id = b.book_id
            JOIN categories c ON b.categories_id = c.categories_id
            WHERE brb.borrow_request_id = ?
        ");
        $stmt->execute([$id]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once dirname(__DIR__) . "/views/admin/borrowDetail.php";
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE borrow_requests 
            SET request_status = ?
            WHERE borrow_request_id = ?
        ");
        $stmt->execute([$status, $id]);

        header("Location: index.php?action=admin_borrow");
        exit();
    }
}
