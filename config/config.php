<?php
class Database {
    private $host = "localhost";
    private $db_name = "LIBRARY_MANAGEMENT";
    private $username = "root";
    private $password = "";
    public $conn;

    // Phương thức để lấy kết nối
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",$this->username,$this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Lỗi kết nối Database: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>