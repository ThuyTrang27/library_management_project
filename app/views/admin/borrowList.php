<?php require 'app/views/layouts/headerAdmin.php'; ?>
<link rel="stylesheet" href="public/css/admin.css">

<table>
    <tr>
        <th>ID</th>
        <th>Full name</th>
        <th>Phone</th>
        <th>Request date</th>
        <th>Status</th>
    </tr>

    <?php foreach ($requests as $r): ?>
        <tr onclick="location.href='index.php?action=admin_borrow_detail&id=<?= $r['id'] ?>'">
            <td><?= $r['id'] ?></td>
            <td><?= $r['full_name'] ?></td>
            <td><?= $r['phone'] ?></td>
            <td><?= $r['request_date'] ?></td>
            <td><?= $r['status'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>

</html>