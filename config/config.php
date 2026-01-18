<?php
class Database
{
    private $host = "localhost";
    private $db_name = "LIBRARY_MANAGEMENT";
    private $username = "root";
    private $password = "";
    public $conn;

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

/**
 * config/config.php
 * Cấu hình chung cho ứng dụng
 */

// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== DEFINE PATHS =====
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('MODELS_PATH', APP_PATH . '/models');
define('CONTROLLERS_PATH', APP_PATH . '/controllers');
define('VIEWS_PATH', APP_PATH . '/views');
define('CSS_PATH', PUBLIC_PATH . '/css');
define('JS_PATH', PUBLIC_PATH . '/js');
define('IMAGES_PATH', PUBLIC_PATH . '/images');

// ===== DEFINE BASE_URL =====
// Điều chỉnh theo cấu trúc thư mục của bạn
define('BASE_URL', '/public');


// ===== DATABASE CONFIGURATION =====
define('DB_HOST', 'localhost');
define('DB_NAME', 'LIBRARY_MANAGEMENT');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
