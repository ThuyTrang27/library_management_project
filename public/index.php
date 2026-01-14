<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/book.php';

$booksPerPage = 20; // 4 dòng x 5 sách
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$bookModel = new Book($pdo);
$books = $bookModel->getBooksByPage($page, $booksPerPage);
$totalBooks = $bookModel->getTotalBooks();
$totalPages = ceil($totalBooks / $booksPerPage);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>TVAN Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex align-items-center">
            <img src="image/logo.jpg" alt="Logo" style="height:48px;width:auto;margin-right:12px;object-fit:contain;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);background:#fff;">
            <a class="navbar-brand fw-bold mb-0" href="#">TVAN LIBRARY</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Homepage</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">My Books</a></li>
                </ul>

                <form class="d-flex">
                    <input id="searchInput" class="form-control me-2" placeholder="Nhập tên sách...">
                    <button class="btn btn-warning" type="button" onclick="app.searchBook()">Search</button>
                </form>
            </div>
        </div>
    </nav>


    <!-- SLIDER (Bootstrap card khung đẹp) -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow border-0 p-3" style="background:#f8f9fa;">
                    <div class="slideshow-container position-relative d-flex justify-content-center align-items-center bg-white p-3 rounded shadow" style="min-height:240px;max-width:420px;margin:auto;overflow:hidden;">
                        <img class="slide active" src="image/hoangtu.jpg" alt="Hoàng Tử Bé" style="width:100%;max-width:340px;height:210px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.10);display:block;transition:opacity 0.5s;">
                        <img class="slide" src="image/harrypotter.jpg" alt="Harry Potter" style="width:100%;max-width:340px;height:210px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.10);display:none;transition:opacity 0.5s;">
                        <img class="slide" src="image/dacnhantam.jpg" alt="Đắc Nhân Tâm" style="width:100%;max-width:340px;height:210px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.10);display:none;transition:opacity 0.5s;">
                        <img class="slide" src="image/toituhoc.jpg" alt="Tôi Tự Học" style="width:100%;max-width:340px;height:210px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.10);display:none;transition:opacity 0.5s;">
                        <img class="slide" src="image/nhagiakim.jpg" alt="Nhà Giả Kim" style="width:100%;max-width:340px;height:210px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.10);display:none;transition:opacity 0.5s;">
                        <a class="prev position-absolute top-50 start-0 translate-middle-y" style="z-index:2;font-size:2rem;color:#333;background:#fff3;padding:8px 16px;border-radius:0 8px 8px 0;" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next position-absolute top-50 end-0 translate-middle-y" style="z-index:2;font-size:2rem;color:#333;background:#fff3;padding:8px 16px;border-radius:8px 0 0 8px;" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BOOK LIST -->
    <div class="container mt-4">
        <div id="bookList" class="row g-3">
            <?php
            // Đảm bảo luôn có 20 slot/card (4 dòng x 5 sách)
            $displayBooks = $books;
            $missing = 20 - count($displayBooks);
            for ($i = 0; $i < $missing; $i++) {
                $displayBooks[] = null;
            }
            for ($row = 0; $row < 4; $row++): ?>
                <div class="row mb-3 justify-content-center">
                    <?php for ($col = 0; $col < 5; $col++):
                        $idx = $row * 5 + $col;
                        $book = $displayBooks[$idx];
                    ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 d-flex align-items-stretch" style="flex:0 0 20%;max-width:20%;">
                            <?php if ($book): ?>
                                <div class="card h-100 text-center p-2 w-100">
                                    <img src="<?= htmlspecialchars($book['image_ulr']) ?>" class="card-img-top mx-auto" alt="<?= htmlspecialchars($book['book_title']) ?>" style="height:180px;object-fit:cover;width:auto;max-width:100%;">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 fw-bold" style="font-size:1.1rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?= htmlspecialchars($book['book_title']) ?>">
                                            <?= htmlspecialchars($book['book_title']) ?>
                                        </h6>
                                        <div style="font-size:0.98em;">Author: <?= htmlspecialchars($book['author']) ?></div>
                                        <div style="font-size:0.98em;">Genre: <?= htmlspecialchars($book['genre']) ?></div>
                                        <div style="font-size:0.98em;">Stock: <?= htmlspecialchars($book['stock_quantity']) ?></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="card h-100 text-center p-2 w-100 bg-transparent border-0"></div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-3">
                <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">&laquo; Trước</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Sau &raquo;</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- FOOTER -->
    <footer class="bg-primary text-light mt-4 p-4">
        <div class="container row">
            <div class="col-md-6">
                <h5>TVAN LIBRARY</h5>
                <p>Address: 99 To Hien Thanh, Son Tra, Da Nang</p>
                <p>Email: tvanlibrary@gmail.com</p>
            </div>
            <div class="col-md-6">
                <p>
                    Established in 2026, with a vast collection of books in various genres.
                    Knowledge is a treasure.
                </p>
            </div>
        </div>
    </footer>

    <script src="js/model.js"></script>
    <script src="js/app.js"></script>
    <script src="js/slide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Slide auto chuyển động, hover thì dừng, rời chuột thì chạy tiếp
        window.onload = function() {
            slides = document.getElementsByClassName("slide");
            showSlides(slideIndex);
            if (autoSlideInterval) clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 1800);
            var slideBox = document.querySelector('.slideshow-container');
            if (slideBox) {
                slideBox.addEventListener('mouseenter', function() {
                    clearInterval(autoSlideInterval);
                });
                slideBox.addEventListener('mouseleave', function() {
                    autoSlideInterval = setInterval(nextSlide, 1800);
                });
            }
        };
    </script>
</body>

</html>