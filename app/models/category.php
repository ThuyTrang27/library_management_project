<?php
class Category
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->prepare(
            "SELECT categories_id AS id, categories_name AS name FROM categories"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy sách theo category + phân trang
    public function getBooksByCategory($categoryId, $limit, $offset)
    {
        $sql = "SELECT b.book_id,
                   b.book_title,
                   b.author,
                   b.stock_quantity,
                   b.image_url,
                   c.categories_name
            FROM books b
            INNER JOIN categories c 
                ON b.categories_id = c.categories_id
            WHERE b.categories_id = :categoryId
            LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':categoryId', (int)$categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sách theo category
    public function getTotalBooksByCategory($categoryId)
    {
        $sql = "SELECT COUNT(*) 
                FROM books 
                WHERE categories_id = :categoryId";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':categoryId', (int)$categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
