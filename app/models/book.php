<?php
/**
 * app/models/book.php
 * Model quản lý sách
 */

class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lấy danh sách sách phân trang
     */
    public function getBooksByPage($page = 1, $booksPerPage = 20)
    {
        try {
            $offset = ($page - 1) * $booksPerPage;
            $sql = "SELECT b.*, c.categories_name as genre 
                    FROM books b 
                    LEFT JOIN categories c ON b.categories_id = c.categories_id 
                    ORDER BY b.book_id 
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $booksPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting books: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy tổng số sách
     */
    public function getTotalBooks()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM books");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting total books: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Lấy sách theo ID
     */
    public function getBookById($id)
    {
        try {
            $sql = "SELECT b.*, c.categories_name as genre 
                    FROM books b 
                    LEFT JOIN categories c ON b.categories_id = c.categories_id 
                    WHERE b.book_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting book: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy sách theo danh mục
     */
    public function getBooksByCategory($categoryId, $page = 1, $booksPerPage = 20)
    {
        try {
            $offset = ($page - 1) * $booksPerPage;
            $sql = "SELECT b.*, c.categories_name as genre 
                    FROM books b 
                    LEFT JOIN categories c ON b.categories_id = c.categories_id 
                    WHERE b.categories_id = :category_id 
                    ORDER BY b.book_id 
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $booksPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting books by category: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy tổng số sách theo danh mục
     */
    public function getTotalBooksByCategory($categoryId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM books WHERE categories_id = :category_id");
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting total books by category: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Tìm kiếm sách
     */
    public function searchBooks($keyword)
    {
        try {
            $search = "%{$keyword}%";
            $sql = "SELECT b.*, c.categories_name as genre 
                    FROM books b 
                    LEFT JOIN categories c ON b.categories_id = c.categories_id 
                    WHERE b.book_title LIKE :keyword 
                    OR b.author LIKE :keyword 
                    OR c.categories_name LIKE :keyword
                    ORDER BY b.book_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':keyword', $search, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error searching books: " . $e->getMessage());
            return [];
        }
    }
}
