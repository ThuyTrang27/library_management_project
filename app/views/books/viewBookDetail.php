<?php  require_once __DIR__ . '/../layouts/header.php';?>
<link rel="stylesheet" href="css/viewBookDetail.css">

<div class="book-detail-container">
    <div class="book-detail-wrapper">
        <!-- Image & basic info section -->
        <div class="book-image-section">
            <img src="<?php echo htmlspecialchars($book['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($book['book_title']); ?>" 
                 class="book-cover">
            
            <div class="book-price">
                <?php echo number_format($book['price'], 0, ',', '.'); ?> đ
            </div>
            
            <div class="book-actions">
               <a href="index.php?action=add_to_mybook&id=<?php echo $book['book_id']; ?>&title=<?php echo urlencode($book['book_title']); ?>&author=<?php echo urlencode($book['author']); ?>&img=<?php echo urlencode($book['image_url']); ?>" 
                style="text-decoration: none;">
                    <button class="btn-add-to-cart">Add to My Book</button>
                </a>
            </div>
            
            <div class="book-meta">
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($book['categories_name']); ?></p>
                <p><strong>Quantity:</strong> <?php echo $book['stock_quantity']; ?></p>
                <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>
                <p><strong>Publication Year:</strong> <?php echo $book['publisher_year']; ?></p>
            </div>
        </div>
        
        <!-- Detail content section -->
        <div class="book-content-section">
            <h1 class="book-title"><?php echo htmlspecialchars($book['book_title']); ?></h1>
            
            <div class="book-introduction">
                <h2>Introduction</h2>
                <div class="book-description">
                    <?php echo nl2br(htmlspecialchars($book['content'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  require_once __DIR__ . '/../layouts/footer.php';?>

<script>
    // Handle Borrow button
    document.querySelector('.btn-borrow').addEventListener('click', function() {
        <?php if ($book['stock_quantity'] > 0): ?>
            window.location.href = 'index.php?controller=borrow&action=request&book_id=<?php echo $book['book_id']; ?>';
        <?php else: ?>
            alert('This book is currently out of stock. Please come back later.');
        <?php endif; ?>
    });
</script>
