<?php

class BorrowRequest
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
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