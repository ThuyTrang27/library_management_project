<?php

/**
 * app/views/home.php
 * 
 * File này hiển thị trang chủ của website
 * 
 * GIẢI THÍCH CHO NGƯỜI MỚI HỌC:
 * - Đây là VIEW trong mô hình MVC
 * - Controller sẽ truyền dữ liệu vào đây qua các biến: $books, $categories, $page, $totalPages
 * - File này chỉ hiển thị dữ liệu, không xử lý logic phức tạp
 * 
 * CÁCH HOẠT ĐỘNG:
 * 1. Load các file cần thiết (App, helpers)
 * 2. Include header (phần đầu trang)
 * 3. Include slider (carousel)
 * 4. Include categories (danh mục)
 * 5. Hiển thị danh sách sách
 * 6. Include footer (phần cuối trang)
 */

// Bước 1: Load App core và helper functions
require_once dirname(__DIR__) . '/core/App.php';
App::init();
require_once dirname(__DIR__) . '/helpers/imageHelper.php';

// Bước 2: Include header (phần đầu trang)
$action = $_GET['action'] ?? 'home';
require_once __DIR__ . '/layouts/header.php';

// Bước 3: Include slider (phần carousel)
require_once __DIR__ . '/layouts/slider.php';

// Bước 4: Include danh mục sách (ngay dưới slider)
require_once __DIR__ . '/layouts/categories.php';
// require_once __DIR__ . '/css/styles.php';
?>
<link rel="stylesheet" href="/css/style.css">
<!-- PHẦN HIỂN THỊ DANH SÁCH SÁCH -->
<div class="container mt-4 mb-5">
    <!-- Tiêu đề phần sách -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center mb-3 text-primary fw-bold">
                <i class="bi bi-book"></i> All Books
            </h2>
            <p class="text-center text-muted">Discover our amazing collection of books</p>
        </div>
    </div>

    <!-- Danh sách sách -->
    <div id="bookList" class="row g-4">
        <?php
        // Bước 1: Lấy danh sách sách từ Controller
        // Nếu không có, dùng mảng rỗng
        $displayBooks = $books ?? [];

        // Bước 2: Đảm bảo luôn có đủ 20 slot (4 dòng x 5 sách) để giữ layout đẹp
        $missing = 20 - count($displayBooks);
        for ($i = 0; $i < $missing; $i++) {
            $displayBooks[] = null;
        }

        // Bước 3: Hiển thị sách theo dạng lưới 4 dòng x 5 cột
        // Vòng lặp for: tạo 4 dòng
        for ($row = 0; $row < 4; $row++):
        ?>
            <div class="row g-4 justify-content-center">
                <?php
                // Vòng lặp for: tạo 5 cột trong mỗi dòng
                for ($col = 0; $col < 5; $col++):
                    // Tính chỉ số của sách trong mảng (dòng * 5 + cột)
                    $idx = $row * 5 + $col;
                    // Lấy thông tin sách
                    $book = $displayBooks[$idx] ?? null;
                ?>
                    <!-- 
                        Bootstrap Grid System:
                        - col-lg-2: Trên màn hình lớn, mỗi cột chiếm 2/12 = ~16.67%
                        - col-md-3: Trên màn hình trung, mỗi cột chiếm 3/12 = 25%
                        - col-sm-4: Trên màn hình nhỏ, mỗi cột chiếm 4/12 = 33.33%
                        - col-6: Trên màn hình rất nhỏ, mỗi cột chiếm 6/12 = 50%
                        - d-flex align-items-stretch: Căn chỉnh các card bằng nhau
                    -->
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 d-flex align-items-stretch">

                        <?php if ($book): // Nếu có sách, hiển thị thông tin 
                        ?>
                            <?php
                            // Xử lý dữ liệu sách
                            // Hàm getBookImagePath() tự động xử lý cả image_ulr và image_url
                            $imagePath = getBookImagePath($book);

                            // Hàm safeValue() đảm bảo không có giá trị null (tránh lỗi)
                            $bookTitle = safeValue($book['book_title'] ?? '', 'No Title');
                            $bookAuthor = safeValue($book['author'] ?? '', 'Unknown');
                            $bookGenre = safeValue($book['genre'] ?? '', 'N/A');
                            $bookStock = safeValue($book['stock_quantity'] ?? 0, '0');
                            $bookId = safeValue($book['book_id'] ?? 0, '0');
                            ?>

                            <!-- Card hiển thị thông tin sách -->
                            <!-- 
                                Bootstrap Card Component:
                                - card: Class cơ bản của card
                                - h-100: Chiều cao 100% (các card bằng nhau)
                                - text-center: Căn giữa nội dung
                                - w-100: Chiều rộng 100%
                            -->
                            <div class="book-card card h-100 w-100 border-0 shadow-sm">
                                <!-- Hình ảnh bìa sách -->
                                <!-- 
                                    Bootstrap Image Classes:
                                    - card-img-top: Ảnh ở trên cùng của card
                                    - w-100: Chiều rộng 100%
                                    - rounded-top: Bo tròn góc trên
                                -->
                                <div class="book-image-wrapper">
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>"
                                        class="card-img-top w-100 book-image"
                                        alt="<?php echo htmlspecialchars($bookTitle); ?>"
                                        onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>/images/no-image.png';">
                                </div>

                                <!-- Thông tin sách -->
                                <div class="card-body d-flex flex-column p-3">
                                    <!-- Tên sách -->
                                    <h6 class="card-title mb-2 fw-bold text-primary book-title"
                                        title="<?php echo htmlspecialchars($bookTitle); ?>">
                                        <?php echo htmlspecialchars($bookTitle); ?>
                                    </h6>

                                    <!-- Tác giả -->
                                    <div class="book-info small mb-1">
                                        <i class="bi bi-person-fill text-muted"></i>
                                        <span class="text-muted"><?php echo htmlspecialchars($bookAuthor); ?></span>
                                    </div>

                                    <!-- Thể loại -->
                                    <div class="book-info small mb-2">
                                        <i class="bi bi-bookmark-fill text-muted"></i>
                                        <span class="text-muted"><?php echo htmlspecialchars($bookGenre); ?></span>
                                    </div>

                                    <!-- Số lượng còn lại -->
                                    <div class="book-info stock-badge mb-3">
                                        <i class="bi bi-box-seam-fill"></i>
                                        <strong>Stock:</strong> <?php echo htmlspecialchars($bookStock); ?>
                                    </div>

                                    <!-- Nút View Detail -->
                                    <a href="<?php echo BASE_URL; ?>/index.php?action=book&id=<?php echo htmlspecialchars($bookId); ?>"
                                        class="btn btn-primary btn-sm mt-auto view-detail-btn">
                                        <i class="bi bi-eye"></i> View Detail
                                    </a>
                                </div>
                            </div>

                        <?php else: // Nếu không có sách, hiển thị card trống để giữ layout 
                        ?>
                            <div class="card h-100 w-100 bg-transparent border-0"></div>
                        <?php endif; ?>

                    </div>
                <?php endfor; // Kết thúc vòng lặp 5 cột 
                ?>
            </div>
        <?php endfor; // Kết thúc vòng lặp 4 dòng 
        ?>
    </div>

    <!-- PHÂN TRANG (PAGINATION) -->
    <!-- 
        Bootstrap Pagination Component
        - Chỉ hiển thị nếu có nhiều hơn 1 trang
        - justify-content-center: Căn giữa các nút phân trang
    -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
                <!-- Nút "Trước" -->
                <li class="page-item <?php echo ($page ?? 1) <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?action=home&page=<?php echo ($page ?? 1) - 1; ?>" tabindex="-1">
                        <i class="bi bi-chevron-left"></i> Previous
                    </a>
                </li>

                <!-- Các số trang -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == ($page ?? 1)) ? 'active' : ''; ?>">
                        <a class="page-link" href="?action=home&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Nút "Sau" -->
                <li class="page-item <?php echo ($page ?? 1) >= $totalPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?action=home&page=<?php echo ($page ?? 1) + 1; ?>">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php
// Bước 5: Include footer (phần cuối trang)
require_once __DIR__ . '/layouts/footer.php';
?>