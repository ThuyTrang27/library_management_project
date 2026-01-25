<?php

/**
 * app/models/category.php
 * Model quản lý danh mục
 */

class Category
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lấy tất cả danh mục
     */
    public function getAllCategories()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY categories_name");
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
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE categories_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting category: " . $e->getMessage());
            return null;
        }
    }
}
