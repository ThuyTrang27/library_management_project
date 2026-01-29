    <?php  require_once __DIR__ . '/../layouts/header.php';?>
    <link rel="stylesheet" href="css/bookRequest.css">
    <div class="borrow-container">
    <h2 class="title-blue">My borrowing book list</h2>
    <hr>
    <?php if (empty($listBooks)): ?>
    <p>Danh sách mượn của bạn đang trống. <a href="index.php">Quay lại chọn sách</a></p>
    <?php else: ?>
    <?php endif; ?>
    <div class="book-list">
        <?php foreach ($listBooks as $book): ?>
        <div class="book-card">
            <img src="<?php echo $book['image']; ?>" alt="Sách">
            <div class="book-info">
                <h4><?php echo $book['title']; ?></h4>
                <p><strong>ID:</strong> <?php echo $book['id']; ?></p>
                <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                <div class="quantity-control">
                    <strong>Quantity:</strong>
                    <button class="btn-qty" onclick="updateQty('<?php echo $book['id']; ?>', 1)">+</button>
                    <span id="qty-<?php echo $book['id']; ?>"><?php echo $book['quantity']; ?></span>
                    <button class="btn-qty" onclick="updateQty('<?php echo $book['id']; ?>', -1)">-</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="button-group">
        <a href="index.php?action=show_borrow_form">
            <button class="btn-submit">Borrow book</button>
        </a>

         <a href="index.php?action=home">
            <button class="btn-cancel">Cancel</button>
        </a>        
    </div>
</div>
 <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
 <script>
   function updateQty(bookId, change) {
    let qtyElement = document.getElementById('qty-' + bookId);
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;

    // Nếu số lượng mới > 0, cập nhật như bình thường
    if (newQty > 0) {
        qtyElement.innerText = newQty;
        fetch(`index.php?action=update_cart_qty&id=${bookId}&qty=${newQty}`);
    } 
    // Nếu số lượng mới bằng 0, thực hiện xóa
    else {
        if (confirm("Bạn có muốn xóa sách này khỏi danh sách không?")) {
            fetch(`index.php?action=remove_from_cart&id=${bookId}`)
                .then(() => {
                    // Tìm phần tử cha (book-card) và xóa nó khỏi giao diện
                    let bookCard = qtyElement.closest('.book-card');
                    bookCard.remove();
                    
                    // Nếu sau khi xóa mà không còn sách nào, có thể reload để hiện thông báo trống
                    location.reload(); 
                });
        }
    }
}
 </script> 
