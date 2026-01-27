<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/css/bookListView.css">
</head>

<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="container">

        <h2 class="mt-4 mb-3">
            Result for category:
            <span><?= htmlspecialchars($selectedCategory['name']) ?></span>
        </h2>

        <div class="book-grid">

            <?php foreach ($books as $book): ?>
                <div class="book-item">

                    <div class="book-img-container">
                        <?php
                        $imageName = !empty($book['image_url'])
                            ? trim($book['image_url'])
                            : 'default-book.png';
                        $displayPath = "images/" . $imageName;
                        ?>
                        <img src="<?= $displayPath ?>"
                            onerror="this.onerror=null; this.src='images/default-book.png';"
                            alt="<?= htmlspecialchars($book['book_title']) ?>">
                    </div>

                    <h3><?= htmlspecialchars($book['book_title']) ?></h3>

                    <p>
                        <strong>Genre:</strong>
                        <?= htmlspecialchars($book['categories_name']) ?>
                    </p>

                    <p>
                        <strong>Author:</strong>
                        <?= htmlspecialchars($book['author']) ?>
                    </p>

                    <p>
                        <strong>Stock:</strong>
                        <?= (int)$book['stock_quantity'] ?>
                    </p>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="<?= ($i == $currentPage) ? 'active' : '' ?>"
                        href="index.php?action=category&id=<?= $selectedCategory['id'] ?>&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>

</html>