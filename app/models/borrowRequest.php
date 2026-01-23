<?php
class BorrowRequest {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createRequest($userId, $name, $phone, $address, $borrowDate, $returnDate, $books) {
    try {
        $this->conn->beginTransaction();

        $query = "INSERT INTO borrow_request (user_id, full_name, phone, address, borrow_date, return_date, status) 
                  VALUES (:user_id, :name, :phone, :address, :b_date, :r_date, 'Pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $userId,
            ':name'    => $name,
            ':phone'   => $phone,
            ':address' => $address,
            ':b_date'  => $borrowDate,
            ':r_date'  => $returnDate
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