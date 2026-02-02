<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Borrow List</title>
</head>

<body>
    <?php
    require __DIR__ . '/../layouts/headerAdmin.php'; ?>
    <table class="table table-bordered table-hover">
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
                <tr style="cursor:pointer"
                    onclick="window.location='index.php?action=admin_borrow_detail&id=<?= $r['id'] ?>'">
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['full_name']) ?></td>
                    <td><?= htmlspecialchars($r['address']) ?></td>
                    <td><?= htmlspecialchars($r['phone']) ?></td>
                    <td><?= $r['request_date'] ?></td>
                    <td><?= $r['schedule_return_date'] ?></td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            <?= $r['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>