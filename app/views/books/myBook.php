<?php  require_once __DIR__ . '/../layouts/header.php';?>
<link rel="stylesheet" href="css/bookRequest.css">

<div class="borrow-container">
    <h2 class="title-blue">My Borrowed Books</h2>
    <hr>

    <?php if (empty($listBooks)): ?>
        <p>Your borrowing list is empty. <a href="index.php">Go back to choose books</a></p>
    <?php else: ?>
    <?php endif; ?>

    <div class="book-list">
        <?php foreach ($listBooks as $book): ?>
        <div class="book-card">
            <img src="<?php echo $book['image']; ?>" alt="Book cover">
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
            <button class="btn-submit">Borrow Books</button>
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

    // If new quantity > 0 → update normally
    if (newQty > 0) {
        qtyElement.innerText = newQty;
        fetch(`index.php?action=update_cart_qty&id=${bookId}&qty=${newQty}`);
    } 
    // If new quantity = 0 → remove book
    else {
        if (confirm("Do you want to remove this book from your list?")) {
            fetch(`index.php?action=remove_from_cart&id=${bookId}`)
                .then(() => {
                    let bookCard = qtyElement.closest('.book-card');
                    bookCard.remove();
                    location.reload();
                });
        }
    }
}
</script>
