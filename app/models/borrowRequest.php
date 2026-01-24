<?php
class BorrowRequest {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createRequest($userId, $name, $phone, $address, $borrowDate, $returnDate, $books) {
    try {
        $this->conn->beginTransaction();

        // 1. Chèn vào borrow_requests (Sửa tên bảng và tên cột cho khớp SQL của bạn)
        // Lưu ý: Database của bạn không có cột name, phone, address ở bảng này. 
        // Nếu muốn lưu, bạn phải ALTER TABLE thêm cột hoặc bỏ qua. Ở đây mình khớp theo bảng bạn gửi:
        $query = "INSERT INTO borrow_requests (user_id, request_date, schedule_return_date, quantity, request_status) 
                  VALUES (:user_id, :b_date, :r_date, :total_qty, 'Pending')";
        
        $totalQty = 0;
        foreach($books as $b) { $totalQty += $b['quantity']; }

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':user_id'   => $userId,
            ':b_date'    => $borrowDate,
            ':r_date'    => $returnDate,
            ':total_qty' => $totalQty
        ]);

        $requestId = $this->conn->lastInsertId();

        // 2. Duyệt sách
        foreach ($books as $book) {
            // A. Lưu vào borrow_request_books (Thêm 's')
            $queryBook = "INSERT INTO borrow_request_books (borrow_request_id, book_copies_id) 
                          VALUES (:request_id, :book_id)";
            $stmtBook = $this->conn->prepare($queryBook);
            
            // Lưu ý: Ở đây tạm thời lưu book_id vào cột book_copies_id để chạy được code. 
            // Đúng chuẩn thì bạn phải tìm 1 barcode 'Available' để gán vào.
            $stmtBook->execute([
                ':request_id' => $requestId,
                ':book_id'    => $book['id']
            ]);

            // B. Trừ kho trong bảng books
            $queryUpdate = "UPDATE books SET stock_quantity = stock_quantity - :qty 
                            WHERE book_id = :id AND stock_quantity >= :qty";
            $stmtUpdate = $this->conn->prepare($queryUpdate);
            $stmtUpdate->execute([
                ':qty' => $book['quantity'],
                ':id'  => $book['id']
            ]);

            if ($stmtUpdate->rowCount() == 0) {
                throw new Exception("Sách ID " . $book['id'] . " đã hết hàng!");
            }
        }

        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        $this->conn->rollBack();
        // Debug lỗi: Mở dòng dưới đây để xem thông báo lỗi thực tế từ SQL
        // die("Lỗi hệ thống: " . $e->getMessage()); 
        return false;
    }
}
}
?>