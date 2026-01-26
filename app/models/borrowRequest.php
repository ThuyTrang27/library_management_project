<?php
class BorrowRequest
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $sql = "SELECT br.*, u.full_name, u.phone, u.address
                FROM borrow_requests br
                JOIN users u ON br.user_id = u.user_id
                ORDER BY br.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT br.*, u.full_name, u.phone, u.address
                FROM borrow_requests br
                JOIN users u ON br.user_id = u.user_id
                WHERE br.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($id)
    {
        $sql = "SELECT b.book_title, b.author, c.name AS category, i.quantity
                FROM borrow_request_items i
                JOIN books b ON i.book_id = b.book_id
                JOIN categories c ON b.categories_id = c.id
                WHERE i.request_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare(
            "UPDATE borrow_requests SET status=? WHERE id=?"
        );
        $stmt->execute([$status, $id]);
    }
}
