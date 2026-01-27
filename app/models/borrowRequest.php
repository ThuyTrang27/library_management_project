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
        // Lưu ý: Tên bảng trong SQL của bạn là book_coopies (sai chính tả)
        $sql = "SELECT b.book_id, b.book_title, b.author, brb.quantity, c.categories_name AS category, 
                       bc.barcode
                FROM borrow_request_books brb
                JOIN books b ON brb.book_id = b.book_id
                JOIN categories c ON b.categories_id = c.categories_id
                LEFT JOIN book_coopies bc ON b.book_id = bc.book_id 
                WHERE brb.borrow_request_id = ?";
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
    public function createRequest($userId, $name, $phone, $address, $borrowDate, $returnDate, $books)
    {
        try {
            $this->db->beginTransaction();

            // 1. Tính tổng số lượng sách
            $totalQty = $this->calculateTotalQuantity($books);

            // 2. Chèn đơn mượn chính và lấy ID
            $requestId = $this->insertBorrowRequest($userId, $name, $phone, $address, $borrowDate, $returnDate, $totalQty);

            // 3. Xử lý từng cuốn sách (Lưu chi tiết & Trừ kho)
            foreach ($books as $book) {
                $this->insertRequestDetail($requestId, $book['id'], $book['quantity']);
                $this->updateBookStock($book['id'], $book['quantity']);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Ghi log lỗi hoặc die để debug nếu cần
            // error_log($e->getMessage());
            return false;
        }
    }

    // --- Các hàm hỗ trợ riêng biệt (Private Helpers) ---

    private function calculateTotalQuantity($books)
    {
        $total = 0;
        foreach ($books as $book) {
            $total += $book['quantity'];
        }
        return $total;
    }

    private function insertBorrowRequest($userId, $name, $phone, $address, $bDate, $rDate, $totalQty)
    {
        $query = "INSERT INTO borrow_requests (user_id, full_name, phone, address, request_date, schedule_return_date, quantity, request_status) 
                  VALUES (:user_id, :name, :phone, :address, :b_date, :r_date, :total_qty, 'Pending')";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':user_id' => $userId,
            ':name' => $name,
            ':phone' => $phone,
            ':address' => $address,
            ':b_date' => $bDate,
            ':r_date' => $rDate,
            ':total_qty' => $totalQty
        ]);

        return $this->db->lastInsertId();
    }

    private function insertRequestDetail($requestId, $bookId, $qty)
    {
        $query = "INSERT INTO borrow_request_books (borrow_request_id, book_id, quantity) 
                  VALUES (:request_id, :book_id, :qty)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':request_id' => $requestId,
            ':book_id'    => $bookId,
            ':qty'         => $qty
        ]);
    }

    private function updateBookStock($bookId, $qty)
    {
        $query = "UPDATE books SET stock_quantity = stock_quantity - :qty 
                  WHERE book_id = :id AND stock_quantity >= :qty";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':qty' => $qty, ':id' => $bookId]);

        // Nếu rowCount == 0 nghĩa là không tìm thấy sách hoặc kho không đủ để trừ
        if ($stmt->rowCount() == 0) {
            throw new Exception("Sách ID $bookId không đủ số lượng trong kho.");
        }
    }
}
