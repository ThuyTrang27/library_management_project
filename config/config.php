<?php
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
define('IMAGE_PATH', PUBLIC_PATH . '/image');
define('IMAGES_PATH', PUBLIC_PATH . '/images');

// ===== DEFINE BASE_URL =====
// Điều chỉnh theo cấu trúc thư mục của bạn
define('BASE_URL', '/library_management_project/public');

// ===== DATABASE CONFIGURATION =====
define('DB_HOST', 'localhost');
define('DB_NAME', 'LIBRARY_MANAGEMENT');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ===== DATABASE CONNECTION =====
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Kết nối cơ sở dữ liệu thất bại. Vui lòng thử lại sau.");
}
