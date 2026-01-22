<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../public/css/bookRequest.css" class="">
</head>
<body>
    <div class="borrow-container">
    <h2 class="title-blue">My borrowing book list</h2>
    <hr>
    
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
                    <button class="btn-qty">+</button>
                    <span>1</span>
                    <button class="btn-qty">-</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="button-group">
        <a href="index.php?action=show_borrow_form">
            <button class="btn-submit">Borrow book</button>
        </a>
        <button class="btn-cancel">Cancel</button>
    </div>
</div>
</body>
</html>