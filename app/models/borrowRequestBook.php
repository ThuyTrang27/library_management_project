<?php

require_once __DIR__ . '/../core/lib/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../core/lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../core/lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class BorrowRequestBook
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }public function getAll()
    {
        $sql = "SELECT br.borrow_request_id AS id, u.full_name, u.address, u.phone, 
                       br.request_date, br.schedule_return_date, br.request_status AS status
                FROM borrow_requests br
                JOIN users u ON br.user_id = u.user_id
                ORDER BY br.borrow_request_id DESC";
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

    private function getItems($requestId)
    {
        $sql = "SELECT book_id, quantity FROM borrow_request_books WHERE borrow_request_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$requestId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function modifyStock($bookId, $quantity, $operator)
{
    $sql = "UPDATE books SET stock_quantity = stock_quantity $operator ? WHERE book_id = ?";
    if ($operator === '-') $sql .= " AND stock_quantity >= ?";
    
    $params = ($operator === '-') ? [$quantity, $bookId, $quantity] : [$quantity, $bookId];
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    if ($operator === '-' && $stmt->rowCount() == 0) {
        throw new Exception("Sách ID $bookId không đủ số lượng.");
    }
}

public function handleNotifications($requestId, $status) {
    if (!in_array($status, ['Approved', 'Rejected'])) return;
    
    $sqlUser = "SELECT u.email, u.full_name FROM borrow_requests br 
                JOIN users u ON br.user_id = u.user_id WHERE br.borrow_request_id = ?";
    $stmt = $this->db->prepare($sqlUser);
    $stmt->execute([$requestId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $this->sendBorrowStatusEmail($user['email'], $user['full_name'], $status);
    }
}
public function updateStatus($id, $status)
{
    try {
        $this->db->beginTransaction();

        // 1. Cập nhật trạng thái trong bảng borrow_requests (Bảng chính)
        $sql = "UPDATE borrow_requests 
                SET request_status = ?, 
                    actual_return_date = CASE WHEN ? = 'Returned' THEN NOW() ELSE actual_return_date END 
                WHERE borrow_request_id = ?";
        $this->db->prepare($sql)->execute([$status, $status, $id]);

        // 2. Lấy danh sách các cuốn sách trong đơn hàng này
        $items = $this->getItems($id);

        foreach ($items as $item) {
            $bookId = $item['book_id'];

            if ($status === 'Approved') {
                // TÌM BẢN SAO: Lấy 1 bản sao đang rảnh (Available) của cuốn sách này
                $sqlCopy = "SELECT book_copies_id FROM book_copies 
                            WHERE book_id = ? AND book_status = 'Available' LIMIT 1";
                $stmt = $this->db->prepare($sqlCopy);
                $stmt->execute([$bookId]);
                $copy = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($copy) {
                    $copyId = $copy['book_copies_id'];

                    // GÁN ID VÀO CHI TIẾT ĐƠN: Cập nhật cột book_copies_id đang bị NULL
                    $updateDetail = "UPDATE borrow_request_books 
                                     SET book_copies_id = ? 
                                     WHERE borrow_request_id = ? AND book_id = ?";
                    $this->db->prepare($updateDetail)->execute([$copyId, $id, $bookId]);

                    // ĐỔI TRẠNG THÁI BẢN SAO: Chuyển sang 'Borrowed' để người khác không mượn trùng
                    $updateCopyStatus = "UPDATE book_copies SET book_status = 'Borrowed' WHERE book_copies_id = ?";
                    $this->db->prepare($updateCopyStatus)->execute([$copyId]);
                    
                    // Giảm tồn kho tổng trong bảng books
                    $this->modifyStock($bookId, $item['quantity'], '-');
                } else {
                    // Nếu hết bản sao rảnh, có thể ném ra lỗi hoặc dừng giao dịch
                    throw new Exception("Sách ID $bookId đã hết bản sao sẵn có.");
                }

            } elseif ($status === 'Returned') {
                // KHI TRẢ SÁCH: Tìm ID bản sao đã mượn để trả lại trạng thái 'Available'
                $sqlGetCopy = "SELECT book_copies_id FROM borrow_request_books 
                               WHERE borrow_request_id = ? AND book_id = ?";
                $stmt = $this->db->prepare($sqlGetCopy);
                $stmt->execute([$id, $bookId]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row && $row['book_copies_id']) {
                    $this->db->prepare("UPDATE book_copies SET book_status = 'Available' WHERE book_copies_id = ?")
                             ->execute([$row['book_copies_id']]);
                }
                
                // Tăng tồn kho tổng trong bảng books
                $this->modifyStock($bookId, $item['quantity'], '+');
            }
        }

        $this->handleNotifications($id, $status);
        $this->db->commit();
        return true;
    } catch (Exception $e) {
        $this->db->rollBack();
        error_log($e->getMessage()); // Ghi log lỗi để kiểm tra
        return false;
    }
}

    public function sendBorrowStatusEmail($email, $name, $status)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ngocanhqb123end@gmail.com';
            $mail->Password = 'bcox uaxi ntpv txri'; // app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('ngocanhqb123end@gmail.com', 'TVAN Library');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);

            if ($status === 'Approved') {
                $mail->Subject = 'Borrow Request Approved';
                $mail->Body = "
                <p>Hello <b>$name</b>,</p>
                <p>Your book borrowing request has been 
                <b style='color:green;'>APPROVED</b>.</p>
                <p>Please come to the library to collect your books.</p>
                <p>— TVAN Library</p>
            ";
            } elseif ($status === 'Rejected') {
                $mail->Subject = 'Borrow Request Rejected';
                $mail->Body = "
                <p>Hello <b>$name</b>,</p>
                <p>Your book borrowing request has been 
                <b style='color:red;'>REJECTED</b>.</p>
                <p>Please contact the library for more details.</p>
                <p>— TVAN Library</p>
            ";
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }}