<?php
class Book
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy danh sách sách phân trang
    public function getBooksByPage($page = 1, $booksPerPage = 20)
    {
        $offset = ($page - 1) * $booksPerPage;
        $sql = "SELECT b.*, c.categories_name as genre FROM books b LEFT JOIN categories c ON b.categories_id = c.categories_id LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $booksPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalBooks()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM books");
        return $stmt->fetchColumn();
    }
}
