<?php
class BorrowRequest
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /* ================= ADMIN: LIST ================= */
    public function getAll()
    {
        $sql = "
            SELECT 
                br.borrow_request_id,
                br.request_date,
                br.schedule_return_date,
                br.request_status,
                u.username,
                u.email
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            ORDER BY br.borrow_request_id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================= ADMIN: DETAIL ================= */
    public function getById($id)
    {
        $sql = "
            SELECT br.*, u.username, u.email
            FROM borrow_requests br
            JOIN users u ON br.user_id = u.user_id
            WHERE br.borrow_request_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($borrowRequestId)
    {
        $sql = "
            SELECT 
                b.book_title,
                brb.quantity
            FROM borrow_request_books brb
            JOIN books b ON brb.book_id = b.book_id
            WHERE brb.borrow_request_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$borrowRequestId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $sql = "
            UPDATE borrow_requests
            SET request_status = ?
            WHERE borrow_request_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
}
