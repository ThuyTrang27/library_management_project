<?php require 'app/views/layouts/headerAdmin.php'; ?>
<link rel="stylesheet" href="public/css/admin.css">

<h3>Request Information</h3>
<p>Full name: <?= $request['full_name'] ?></p>
<p>Phone: <?= $request['phone'] ?></p>
<p>Address: <?= $request['address'] ?></p>
<p>Status: <?= $request['status'] ?></p>

<h3>Book in this request</h3>
<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Quantity</th>
    </tr>

    <?php foreach ($items as $i): ?>
        <tr>
            <td><?= $i['book_title'] ?></td>
            <td><?= $i['author'] ?></td>
            <td><?= $i['category'] ?></td>
            <td><?= $i['quantity'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="actions">
    <a class="accept" href="index.php?action=admin_borrow_accept&id=<?= $request['id'] ?>">Accept</a>
    <a class="refuse" href="index.php?action=admin_borrow_refuse&id=<?= $request['id'] ?>">Refuse</a>
</div>

</body>

</html>