<?php
/**
 * app/views/layouts/footer.php
 * 
 * Footer chung cho tất cả trang - Nội dung đầy đủ
 * 
 * GIẢI THÍCH CHO NGƯỜI MỚI HỌC:
 * - Đây là phần cuối trang (footer)
 * - Sử dụng Bootstrap Grid System để chia thành 3 cột
 * - Chứa thông tin liên hệ, giới thiệu, và liên kết nhanh
 * 
 * CÁCH HOẠT ĐỘNG:
 * 1. Kiểm tra BASE_URL đã được định nghĩa chưa
 * 2. Hiển thị footer với 3 cột thông tin
 * 3. Load Bootstrap JavaScript và các script khác
 */

// Đảm bảo BASE_URL đã được định nghĩa
if (!defined('BASE_URL')) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config/config.php';
}
?>
<!-- FOOTER -->
<!-- 
    Bootstrap Footer Component:
    - bg-primary: Nền màu xanh primary
    - text-light: Chữ màu sáng (cho nền tối)
    - mt-5: Margin top 5 units
    - pt-4 pb-3: Padding top 4, padding bottom 3
-->
<footer class="bg-primary text-light mt-5 pt-4 pb-3">
    <div class="container">
        <!-- 
            Bootstrap Grid System:
            - row: Hàng chứa các cột
            - col-lg-4: Trên màn hình lớn, mỗi cột chiếm 4/12 = 33.33%
            - col-md-6: Trên màn hình trung, mỗi cột chiếm 6/12 = 50%
            - mb-4: Margin bottom 4 units
        -->
        <div class="row">
            <!-- Cột 1: Thông tin liên hệ -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-building"></i> TVAN LIBRARY
                </h5>
                <p class="mb-2">
                    <i class="bi bi-geo-alt-fill"></i>
                    <strong>Address:</strong> 99 To Hien Thanh, Son Tra, Da Nang
                </p>
                <p class="mb-2">
                    <i class="bi bi-envelope-fill"></i>
                    <strong>Email:</strong>
                    <a href="mailto:tvanlibrary@gmail.com" class="text-light text-decoration-none">
                        tvanlibrary@gmail.com
                    </a>
                </p>
                <p class="mb-2">
                    <i class="bi bi-telephone-fill"></i>
                    <strong>Phone:</strong> 0347 395 104
                </p>
                <p class="mb-0">
                    <i class="bi bi-clock-fill"></i>
                    <strong>Open time:</strong> 8:00 - 20:00 (All days)
                </p>
            </div>

            <!-- Cột 2: Về thư viện -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-info-circle"></i> About Us
                </h5>
                <p class="text-justify">
                    TVAN Library was established in 2026 with a rich collection of books
                    across various genres. We are committed to providing readers with the best
                    experience in searching for and borrowing books.
                </p>
                <p class="mb-0">
                    <strong>Philosophy:</strong> "Knowledge is an invaluable treasure"
                </p>
            </div>

            <!-- Cột 3: Liên kết nhanh -->
            <div class="col-lg-4 col-md-12 mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-link-45deg"></i> Quick Links
                </h5>
                <!-- 
                    Bootstrap List Component:
                    - list-unstyled: Bỏ dấu chấm đầu dòng
                -->
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?php echo BASE_URL; ?>/index.php?action=home" 
                           class="text-light text-decoration-none">
                            <i class="bi bi-house-door"></i> Homepage
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#categories" class="text-light text-decoration-none">
                            <i class="bi bi-bookmarks"></i> Categories
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#about" class="text-light text-decoration-none">
                            <i class="bi bi-info-circle"></i> About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#contact" class="text-light text-decoration-none">
                            <i class="bi bi-telephone"></i> Contact
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): // Nếu đã đăng nhập ?>
                        <li class="mb-2">
                            <a href="<?php echo BASE_URL; ?>/index.php?action=myBorrows" 
                               class="text-light text-decoration-none">
                                <i class="bi bi-book"></i> My Books
                            </a>
                        </li>
                    <?php else: // Nếu chưa đăng nhập ?>
                        <li class="mb-2">
                            <a href="<?php echo BASE_URL; ?>/index.php?action=login" 
                               class="text-light text-decoration-none">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Dòng phân cách -->
        <!-- 
            Bootstrap HR Component:
            - my-4: Margin top và bottom 4 units
            - border-light: Màu border sáng (cho nền tối)
            - opacity-50: Độ trong suốt 50%
        -->
        <hr class="my-4 border-light opacity-50">

        <!-- Phần bản quyền -->
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-2">
                    <i class="bi bi-c-circle"></i>
                    <strong>2026 TVAN Library.</strong> All rights reserved.
                </p>
                <p class="mb-0 small">
                    Developed with <i class="bi bi-heart-fill text-danger"></i> by the TVAN team
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- 
    LƯU Ý: Bootstrap Icons đã được load trong header.php
    Không cần load lại ở đây, nhưng để lại để đảm bảo tương thích
-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<!-- JavaScript Files -->
<!-- 
    Thứ tự load JavaScript:
    1. Custom scripts (model.js, app.js, slide.js)
    2. Bootstrap JavaScript (cần load cuối để khởi tạo các component)
-->
<script src="<?php echo BASE_URL; ?>/js/model.js"></script>
<script src="<?php echo BASE_URL; ?>/js/app.js"></script>
<script src="<?php echo BASE_URL; ?>/js/slide.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
