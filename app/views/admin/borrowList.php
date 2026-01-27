<?php require __DIR__ . '/../layouts/headerAdmin.php'; ?>

<div class="container mt-4">
    <h3>Borrow Requests</h3>

    <?php foreach ($requests as $r): ?>
        <div class="border p-2 mb-2">
            <b><?= $r['email'] ?></b> |
            <?= $r['title'] ?> |
            <span class="text-primary"><?= $r['status'] ?></span>

            <?php if ($r['status'] == 'pending'): ?>
                <a class="btn btn-success btn-sm"
                    href="index.php?action=approve&id=<?= $r['id'] ?>">
                    Approve
                </a>

                <a class="btn btn-danger btn-sm"
                    href="index.php?action=reject&id=<?= $r['id'] ?>">
                    Reject
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>

</html>