<?php require dirname(__DIR__, 2) . '/app/views/layouts/headerAdmin.php'; ?>
<div class="container mt-4">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Request ID</th>
                <th>Full name</th>
                <th>Address</th>
                <th>Phone number</th>
                <th>Request date</th>
                <th>Schedule return date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $r): ?>
                <tr onclick="location.href='index.php?action=admin_borrow_detail&id=<?= $r['id'] ?>'" style="cursor:pointer">
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['full_name']) ?></td>
                    <td><?= htmlspecialchars($r['address']) ?></td>
                    <td><?= htmlspecialchars($r['phone']) ?></td>
                    <td><?= $r['request_date'] ?></td>
                    <td><?= $r['return_date'] ?></td>
                    <td><?= $r['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>