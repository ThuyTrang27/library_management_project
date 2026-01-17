<?php

/**
 * app/views/layouts/header.php
 * 
 * Header chung cho tất cả trang
 * 
 * GIẢI THÍCH CHO NGƯỜI MỚI HỌC:
 * - Đây là phần đầu trang (navigation bar)
 * - Sử dụng Bootstrap Navbar component
 * - Chứa logo, menu điều hướng, thanh tìm kiếm, và phần đăng nhập/đăng ký
 * 
 * CÁCH HOẠT ĐỘNG:
 * 1. Kiểm tra BASE_URL đã được định nghĩa chưa
 * 2. Load Bootstrap CSS và Icons
 * 3. Hiển thị navbar với các menu và chức năng
 */

// Đảm bảo BASE_URL đã được định nghĩa
if (!defined('BASE_URL')) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config/config.php';
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVAN Library</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>

<body>
    <!-- 
        Bootstrap Navbar Component
        - navbar: Class cơ bản của navbar
        - navbar-expand-lg: Mở rộng trên màn hình lớn, thu gọn trên màn hình nhỏ
        - navbar-dark: Màu chữ sáng (cho nền tối)
        - bg-primary: Nền màu xanh primary của Bootstrap
    -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex align-items-center">

            <!-- Logo và tên thư viện -->
            <img src="/images/logo/logo.jpg "
                alt="Logo"
                class="logo-img me-2"
                onerror="this.src='<?php echo BASE_URL; ?>/images/slider/logo.jpg'">

            <a class="navbar-brand fw-bold mb-0" href="<?php echo BASE_URL; ?>/index.php?action=home">
                TVAN LIBRARY
            </a>

            <!-- 
                collapse navbar-collapse: 
                - Thu gọn menu trên màn hình nhỏ
                - Hiển thị đầy đủ trên màn hình lớn
            -->
            <div class="collapse navbar-collapse">

                <!-- Menu điều hướng -->
                <!-- 
                    Bootstrap Nav Component:
                    - navbar-nav: Menu điều hướng
                    - me-auto: Margin end auto (đẩy phần bên phải ra xa)
                -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action ?? '') == 'home' ? 'active' : ''; ?>"
                            href="<?php echo BASE_URL; ?>/index.php?action=home">
                            <i class="bi bi-house-door"></i> Homepage
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">
                            <i class="bi bi-bookmarks"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            <i class="bi bi-info-circle"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            <i class="bi bi-telephone"></i> Contact
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): // Nếu đã đăng nhập 
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?action=myBorrows">
                                <i class="bi bi-book"></i> My Books
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Thanh tìm kiếm -->
                <!-- 
                    Bootstrap Form Component:
                    - d-flex: Flexbox layout
                    - me-3: Margin end (bên phải) 3 units
                -->
                <form class="d-flex me-3" action="<?php echo BASE_URL; ?>/index.php" method="GET">
                    <input type="hidden" name="action" value="search">
                    <input id="searchInput"
                        name="keyword"
                        class="form-control me-2"
                        type="search"
                        placeholder="Nhập tên sách..."
                        value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                    <button class="btn btn-warning" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </form>

                <!-- Phần đăng nhập/đăng ký hoặc thông tin user -->
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): // Nếu đã đăng nhập 
                    ?>
                        <!-- 
                            Bootstrap Dropdown Component:
                            - dropdown: Class cơ bản của dropdown
                            - data-bs-toggle="dropdown": Kích hoạt dropdown khi click
                        -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle"
                                type="button"
                                id="userDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'User'); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?action=myBorrows">
                                        <i class="bi bi-book"></i> My Books
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/index.php?action=logout">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: // Nếu chưa đăng nhập 
                    ?>
                        <!-- Nút đăng nhập -->
                        <a href="<?php echo BASE_URL; ?>/index.php?action=login"
                            class="btn btn-outline-light me-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <!-- Nút đăng ký -->
                        <a href="<?php echo BASE_URL; ?>/index.php?action=register"
                            class="btn btn-light">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>