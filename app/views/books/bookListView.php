<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/css/bookListView.css" class="">
    <link rel="stylesheet" href="../../../public/js/slide.js" class="">
</head>

<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
    <div class="container">
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="../../../public/images/slide1.jpg" alt="Banner 1"></div>
                <div class="slide"><img src="../../../public/images/slide2.jpeg" alt="Banner 2"></div>
                <div class="slide"><img src="../../../public/images/slide3.jpg" alt="Banner 3"></div>
                <div class="slide"><img src="../../../public/images/slide4.jpg" alt="Banner 4"></div>
            </div>

            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>


        <script>
            // move slide 
            let index = 0;

            function moveSlide(step) {
                const slides = document.querySelectorAll(".slide");
                const slider = document.querySelector(".slider");
                index += step;

                if (index >= slides.length) index = 0;
                if (index < 0) index = slides.length - 1;

                slider.style.transform = `translateX(${-index * 100}%)`;
            }
            // Tự động chuyển slide sau 5 giây
            setInterval(() => moveSlide(1), 5000);
        </script>

        <div class="book-grid">
            <?php foreach ($books as $book): ?>
                <div class="book-item">
                    <div class="book-img-container">
                        <?php
                        $imageName = !empty($book['image_url']) ? trim($book['image_url']) : 'default-book.png';
                        $displayPath = "images/" . $imageName;
                        ?>
                        <img src="<?php echo $displayPath; ?>" onerror="this.onerror=null; this.src='images/default-book.png';" alt="<?php echo htmlspecialchars($book['book_title']); ?>">
                    </div>
                    <h3><?php echo htmlspecialchars($book['book_title']); ?></h3>
                    <p><strong>Genre:</strong> <?php echo htmlspecialchars($book['categories_name'] ?? 'N/A'); ?></p>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                    <p><strong>Stock:</strong> <?php echo (int)$book['stock_quantity']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php
                // Nếu đang lọc theo category thì link phải giữ ID category đó
                $url = isset($_GET['id'])
                    ? "index.php?action=category&id=" . (int)$_GET['id'] . "&page=$i"
                    : "index.php?action=listbook&page=$i";
                ?>
                <a href="<?php echo $url; ?>"
                    class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>