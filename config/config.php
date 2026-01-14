<?php
// Kết nối PDO đến database LIBRARY_MANAGEMENT
$host = 'localhost';
$db   = 'LIBRARY_MANAGEMENT';
$user = 'root'; // Thay đổi nếu user khác
$pass = '';     // Thay đổi nếu có mật khẩu
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
