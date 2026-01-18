<?php
class Database {
    private $host = "localhost";
    private $dbname = "LIBRARY_MANAGEMENT";
    private $username = "root";
    private $password = "";
    public $conn;

    // Phương thức để lấy kết nối
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8",
                $this->username,
                $this->password
            );
            // Thiết lập chế độ báo lỗi
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Thiết lập fetch mode mặc định là mảng kết hợp (tùy chọn)
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Lỗi kết nối Database: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>