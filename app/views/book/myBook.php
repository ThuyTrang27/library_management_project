<h2>Sách đã chọn (My Book)</h2>

<?php if (!empty($listBooks)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listBooks as $book): ?>
            <tr>
                <td><img src="<?php echo $book['image']; ?>" width="50"></td>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['quantity']; ?></td>
                <td><a href="index.php?action=remove&id=<?php echo $book['id']; ?>">Xóa</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?action=show_borrow_form" style="padding: 10px; background: blue; color: white; text-decoration: none;">Tiến hành mượn sách</a>

<?php else: ?>
    <p>Danh sách trống. Hãy quay lại chọn sách nhé!</p>
    <a href="index.php">Quay lại danh sách sách</a>
<?php endif; ?>