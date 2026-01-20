<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book borrow information</title>
</head>
<body>
    <form action="index.php?action=submit_borrow" method="POST">
    <h3>Thông tin người nhận</h3>
    <input type="text" name="name" placeholder="Họ tên" required>
    <input type="text" name="phone" placeholder="Số điện thoại" required>
    <textarea name="address" placeholder="Địa chỉ"></textarea>

    <h3>Danh sách sách mượn</h3>
    <table>
        <?php foreach ($_SESSION['cart'] as $book): ?>
        <tr>
            <td><?php echo $book['title']; ?></td>
            <td>ID: <?php echo $book['id']; ?></td>
            <td>Số lượng: 1</td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <button type="submit">Gửi yêu cầu mượn</button>
</form>
</body>
</html>