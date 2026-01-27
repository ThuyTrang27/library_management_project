<?php require dirname(__DIR__, 2) . '/app/views/layouts/headerAdmin.php'; ?>
<div class="container mt-4">
    <div class="card p-4 shadow-sm border-0" style="border-radius: 15px;">
        <h3 class="text-primary mb-4">Request Information</h3>
        <div class="row">
            <div class="col-md-4"><strong>Full Name:</strong> <?= htmlspecialchars($request['full_name']) ?></div>
            <div class="col-md-4"><strong>Phone:</strong> <?= htmlspecialchars($request['phone']) ?></div>
            <div class="col-md-4"><strong>Status:</strong>
                <span class="badge bg-warning"><?= $request['status'] ?></span>
            </div>
        </div>
    </div>

    <h4 class="mt-4 mb-3">Books in this request</h4>

    <table class="table table-hover shadow-sm">
        <thead class="table-primary">
            <tr>
                <th>Barcode (Mã vạch)</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Quantity</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i): ?>
                <tr>
                    <td>
                        <code class="fw-bold text-dark" style="font-size: 1.1rem;">
                            <?= $i['barcode'] ?? 'N/A' ?>
                        </code>
                    </td>
                    <td><?= htmlspecialchars($i['book_title']) ?></td>
                    <td><?= htmlspecialchars($i['author']) ?></td>
                    <td><span class="badge bg-secondary"><?= $i['quantity'] ?></span></td>
                    <td><?= htmlspecialchars($i['category']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($request['status'] === 'Pending'): ?>
        <div class="d-flex justify-content-center gap-3 mt-5">
            <a href="index.php?action=admin_update_status&id=<?= $request['id'] ?>&status=Accepted"
                class="btn btn-success btn-lg px-5 shadow" onclick="return confirm('Xác nhận cho mượn và trừ kho?')">
                Accept
            </a>
            <a href="index.php?action=admin_update_status&id=<?= $request['id'] ?>&status=Refused"
                class="btn btn-danger btn-lg px-5 shadow">
                Refuse
            </a>
        </div>
    <?php endif; ?>
</div>