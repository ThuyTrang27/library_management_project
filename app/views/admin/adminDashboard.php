<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/headerAdmin.php'; ?>
    <div class="container">
        <div class="select-add-book">
            <a href="index.php?action=import_book_by_excel">
                <button class="btn-add-book">Import books</button>
            </a>

            <a href="index.php?action=show_form_add_book">
                <button class="btn-add-book">Add new book</button>
            </a>
        </div>

        <div class="book_dashboard">           
            <table class="table">
                <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Images</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Genre</th>
                    <th>Pulisher</th>
                    <th>Pulish year</th>
                    <th>Stock quantity</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books)): // Sửa từ $book thành $books ?>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $book['book_id']; ?></td>
                                <td><?php echo htmlspecialchars($book['book_title']); ?></td>
                                <td>
                                    <img src="public/images/<?php echo $book['image_url']; ?>" width="50" alt="" class="Cover">
                                </td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                
                                <td><?php echo number_format($book['price'] ?? 0); ?>đ</td> 
                                <td><?php echo htmlspecialchars($book['categories_name'] ?? "N/A"); ?></td>
                                <td><?php echo htmlspecialchars($book['publisher'] ?? "N/A"); ?></td>
                                <td><?php echo htmlspecialchars($book['publish_year'] ?? "N/A"); ?></td>
                                
                                <td><?php echo $book['stock_quantity']; ?></td>
                                <td>
                                    <a href="index.php?action=edit_book&id=<?php echo $book['book_id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="index.php?action=delete_book&id=<?php echo $book['book_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">No books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
            </div>            
    </div>
    <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>">
            <a href="index.php?action=admin_dashboard&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>
</ul>
</body>
</html>