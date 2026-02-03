<?php

/**
 * app/models/category.php
 * Model quản lý danh mục
 */

class Category
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Lấy tất cả danh mục
     */
    public function getAllCategories()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM categories ORDER BY categories_name");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return [];
        }
    }



    /**
     * Lấy danh mục theo ID
     */
    public function getCategoryById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE categories_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting category: " . $e->getMessage());
            return null;
        }
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
}