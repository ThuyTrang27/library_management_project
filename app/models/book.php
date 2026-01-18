<?php
class Book
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Lấy sách có giới hạn để phân trang
    public function getBooksPagination($limit, $offset)
    {
        // b là viết tắt cho books, c là viết tắt cho categories
        $sql = "SELECT b.book_id, b.book_title, b.author, b.stock_quantity, b.image_url, c.categories_name 
            FROM books b
            LEFT JOIN categories c ON b.categories_id = c.categories_id 
            LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sách để tính số trang
    public function getTotalBooks()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM books");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
