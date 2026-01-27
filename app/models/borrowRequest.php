<?php
class BorrowRequest
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        // Đổi return_date thành schedule_return_date
        $sql = "SELECT br.borrow_request_id AS id, u.full_name, u.address, u.phone, 
                       br.request_date, br.schedule_return_date, br.request_status AS status
                FROM borrow_requests br
                JOIN users u ON br.user_id = u.user_id
                ORDER BY br.request_date DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT br.borrow_request_id AS id, u.user_id, u.full_name, u.phone, u.address, 
                       br.request_date, br.schedule_return_date, br.request_status AS status
                FROM borrow_requests br 
                JOIN users u ON br.user_id = u.user_id
                WHERE br.borrow_request_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($id)
    {
        $sql = "SELECT b.book_id, b.book_title, b.author, brb.quantity, c.categories_name AS category, 
                   MIN(bc.barcode) AS barcode -- Lấy mã vạch đầu tiên tìm thấy
            FROM borrow_request_books brb
            JOIN books b ON brb.book_id = b.book_id
            JOIN categories c ON b.categories_id = c.categories_id
            LEFT JOIN book_coopies bc ON b.book_id = bc.book_id 
            WHERE brb.borrow_request_id = ?
            GROUP BY b.book_id"; // Group để mỗi đầu sách chỉ hiện 1 dòng
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        try {
            $this->db->beginTransaction();

            // Cập nhật trạng thái (Approved/Rejected/Pending/Returned)
            $sql = "UPDATE borrow_requests SET request_status = ? WHERE borrow_request_id = ?";
            $this->db->prepare($sql)->execute([$status, $id]);

            // Nếu Duyệt (Approved), trừ kho ở bảng books
            if ($status === 'Approved') {
                $items = $this->getItems($id);
                foreach ($items as $item) {
                    $sqlStock = "UPDATE books SET stock_quantity = stock_quantity - ? 
                                 WHERE book_id = ? AND stock_quantity >= ?";
                    $this->db->prepare($sqlStock)->execute([$item['quantity'], $item['book_id'], $item['quantity']]);
                }
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
