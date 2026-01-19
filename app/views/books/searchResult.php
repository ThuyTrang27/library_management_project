<?php require_once __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="main-container mt-4 mb-5">
    <!-- Tiêu đề kết quả -->
    <div class="d-flex align-items-center mb-4">
        <h4 class="text-primary m-0">
            <i class="bi bi-search me-2"></i>Kết quả tìm kiếm cho: "<?= htmlspecialchars($keyword) ?>"
        </h4>
        <span class="badge bg-secondary ms-3"><?= count($books) ?> kết quả</span>
    </div>

    <?php if (empty($books)): ?>
        <!-- Thông báo nếu không tìm thấy -->
        <div class="alert alert-warning text-center py-5 shadow-sm" role="alert">
            <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
            <h5>Rất tiếc, không tìm thấy cuốn sách nào phù hợp!</h5>
            <p>Vui lòng thử lại với từ khóa khác hoặc kiểm tra lại chính tả.</p>
            <a href="index.php?action=home" class="btn btn-outline-primary mt-2">
                <i class="bi bi-arrow-left me-2"></i>Quay lại trang chủ
            </a>
        </div>
    <?php else: ?>
        <!-- Lưới hiển thị sách -->
        <div class="book-grid">
            <?php foreach ($books as $book): ?>
                <div class="book-item book-card">
                    <div class="book-image-wrapper">
                        <img src="images/<?= htmlspecialchars($book['image_url']) ?>" 
                             alt="<?= htmlspecialchars($book['book_title']) ?>" 
                             class="book-image">
                    </div>
                    
                    <div class="card-body p-2">
                        <h3 class="book-title" title="<?= htmlspecialchars($book['book_title']) ?>">
                            <?= htmlspecialchars($book['book_title']) ?>
                        </h3>
                        
                        <p class="book-info mb-1">
                            <i class="bi bi-person-fill me-1"></i><?= htmlspecialchars($book['author']) ?>
                        </p>
                        
                        <p class="book-info">
                            <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($book['categories_name']) ?>
                        </p>
                        
                        <a href="index.php?action=detail&id=<?= $book['book_id'] ?>" 
                           class="btn btn-primary btn-sm w-100 view-detail-btn mt-2">
                           Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>