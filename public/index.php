<?php

/**
 * public/index.php
 * Entry Point - Điểm bắt đầu của ứng dụng
 */

// Load config
require_once dirname(__DIR__) . '/config/config.php';
// Load models
require_once MODELS_PATH . '/book.php';
require_once MODELS_PATH . '/category.php';

// Load controllers
require_once CONTROLLERS_PATH . '/bookController.php';

// ===== ROUTING =====
$action = $_GET['action'] ?? 'home';
$id = $_GET['id'] ?? null;

try {
    $bookController = new BookController($pdo);

    switch ($action) {
        case 'home':
            $bookController->index();
            break;

        case 'book':
            if ($id) {
                $bookController->show($id);
            } else {
                $bookController->index();
            }
            break;

        case 'category':
            if ($id) {
                $bookController->showByCategory($id);
            } else {
                $bookController->index();
            }
            break;

        case 'search':
            $bookController->search();
            break;

        default:
            $bookController->index();
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . htmlspecialchars($e->getMessage());
}
