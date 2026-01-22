<?php
class Book
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
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
    
}
?>