<?php
$host = 'localhost';
$db   = 'LIBRARY_MANAGEMENT';
$user = 'root';
$pass = ''; // Mật khẩu database của bạn
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}
