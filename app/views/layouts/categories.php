<?php
/**
 * app/views/layouts/categories.php
 * 
 * File này hiển thị danh mục sách - NHỎ GỌN, 1 HÀNG
 * 
 * GIẢI THÍCH CHO NGƯỜI MỚI HỌC:
 * - Hiển thị tất cả danh mục trong 1 hàng ngang
 * - Mỗi danh mục là một badge (nhãn) có thể click
 * - Sử dụng Bootstrap classes để tạo layout đẹp
 * 
 * CÁCH HOẠT ĐỘNG:
 * 1. Lấy danh sách danh mục từ Controller (biến $categories)
 * 2. Dùng vòng lặp foreach để hiển thị từng danh mục
 * 3. Mỗi danh mục là một link đến trang sách theo danh mục đó
 */

// Đảm bảo BASE_URL đã được định nghĩa
if (!defined('BASE_URL')) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config/config.php';
}

// Lấy danh sách danh mục từ Controller (biến $categories)
// Nếu không có, dùng mảng rỗng
$categories = $categories ?? [];
?>

<!-- PHẦN DANH MỤC SÁCH - NHỎ GỌN, 1 HÀNG -->
<div class="container mt-4 mb-3" id="categories">
    <!-- Tiêu đề -->
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mb-3 text-primary fw-bold">
                <i class="bi bi-bookmarks"></i> Categories
            </h5>
        </div>
    </div>

    <!-- 
        Hiển thị tất cả danh mục trong 1 hàng
        - flex-nowrap: Không xuống dòng, giữ tất cả trong 1 hàng
        - overflow-auto: Cho phép scroll ngang nếu quá nhiều danh mục
        - justify-content-center: Căn giữa các danh mục
    -->
    <div class="row g-2 justify-content-center flex-nowrap overflow-auto">
        <?php if (!empty($categories)): // Nếu có danh mục ?>
            <?php foreach ($categories as $category): // Vòng lặp qua từng danh mục ?>
                <?php
                // Lấy thông tin danh mục
                $categoryId = $category['categories_id'] ?? 0;
                $categoryName = htmlspecialchars($category['categories_name'] ?? 'Unknown');
                ?>
                
                <!-- 
                    col-auto: Cột tự động điều chỉnh theo nội dung
                    Mỗi danh mục là một badge có thể click
                -->
                <div class="col-auto">
                    <a href="<?php echo BASE_URL; ?>/index.php?action=category&id=<?php echo $categoryId; ?>"
                        class="category-badge text-decoration-none">
                        <span class="category-name"><?php echo $categoryName; ?></span>
                    </a>
                </div>
            <?php endforeach; // Kết thúc vòng lặp ?>
        <?php else: // Nếu không có danh mục ?>
            <div class="col-12">
                <p class="text-center text-muted small">Chưa có danh mục nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
