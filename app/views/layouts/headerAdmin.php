<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

    <div class="admin-header">
        <div class="logo">
            <img src="images/logo.png" alt="">
            <span>TVAN LIBRARY</span>
        </div>

        <div class="admin-user dropdown">
            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i> Admin
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item text-danger" href="index.php?action=logout">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="admin-menu">
        <a href="#">Book Management</a>
        <a href="#">User Management</a>
        <a class="active" href="index.php?action=admin_borrow">Borrowing Management</a>
        <a href="#">Statistics</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>