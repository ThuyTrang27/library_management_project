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
    // Lấy thông tin chi tiết sách theo ID
    public function getBookById($bookId) {
        $query = "SELECT b.*, c.categories_name 
                  FROM books b 
                  LEFT JOIN categories c ON b.categories_id = c.categories_id 
                  WHERE b.book_id = :book_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy sách theo loại (Category) có phân trang
    public function getBooksByCategory($categoryId, $limit, $offset)
    {
        $sql = "SELECT b.book_id, b.book_title, b.author, b.stock_quantity, b.image_url, c.categories_name 
                FROM books b
                LEFT JOIN categories c ON b.categories_id = c.categories_id 
                WHERE b.categories_id = :cat_id
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cat_id', (int)$categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sách theo loại để tính trang
    public function getTotalBooksByCategory($categoryId)
    {
        $sql = "SELECT COUNT(*) FROM books WHERE categories_id = :cat_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cat_id', (int)$categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    // Tìm kiếm sách theo tên hoặc tác giả
    public function searchBooks($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $sql = "SELECT b.book_id, b.book_title, b.author, b.stock_quantity, b.image_url, c.categories_name 
            FROM books b
            LEFT JOIN categories c ON b.categories_id = c.categories_id 
            WHERE b.book_title LIKE :keyword OR b.author LIKE :keyword";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 


    
?>