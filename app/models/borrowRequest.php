<?php
class BorrowRequest {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createRequest($userId, $name, $phone, $address, $books) {
        try {
            $this->conn->beginTransaction();

            // 1. Chèn vào bảng borrow_request
            $query = "INSERT INTO borrow_request (user_id, full_name, phone, address, status, created_at) 
                      VALUES (:user_id, :name, :phone, :address, 'Pending', NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':name' => $name,
                ':phone' => $phone,
                ':address' => $address
            ]);

            $requestId = $this->conn->lastInsertId();

            // 2. Chèn danh sách sách vào borrow_request_book
            $queryBook = "INSERT INTO borrow_request_book (request_id, book_id, quantity) 
                          VALUES (:request_id, :book_id, :qty)";
            $stmtBook = $this->conn->prepare($queryBook);

            foreach ($books as $book) {
                $stmtBook->execute([
                    ':request_id' => $requestId,
                    ':book_id' => $book['id'],
                    ':qty' => $book['quantity']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>