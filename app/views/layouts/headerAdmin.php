<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- TOP BAR -->
    <nav class="navbar navbar-dark" style="background:#4f8fb8">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold">TVAN LIBRARY – ADMIN</span>

            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> Admin
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item text-danger" href="index.php?action=logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ADMIN MENU -->
    <div class="bg-light border-bottom">
        <div class="container py-2">
            <a class="btn btn-outline-primary me-2"
                href="index.php?action=admin_borrow_list">
                Borrowing Management
            </a>

            <a class="btn btn-outline-secondary me-2" href="#">
                Book Management
            </a>

            <a class="btn btn-outline-secondary me-2" href="#">
                User Management
            </a>

            <a class="btn btn-outline-secondary" href="#">
                Statistics
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>