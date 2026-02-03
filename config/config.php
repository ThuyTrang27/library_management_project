<?php
<<<<<<< HEAD
class Database
{
    private $host = "localhost";
    private $db_name = "LIBRARY_MANAGEMENT";
=======
class Database {
    private $host = "localhost";
    private $dbname = "LIBRARY_MANAGEMENT";
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
    private $username = "root";
    private $password = "";
    public $conn;

<<<<<<< HEAD
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Lỗi kết nối: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

=======
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
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
?>