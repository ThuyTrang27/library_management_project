<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - TVAN Library</title>

    <link rel="stylesheet" href="/library_management_project/public/css/admin.css">
    <link rel="stylesheet" href="/library_management_project/public/css/statistics.css">
</head>

<body>

<div class="statistics-wrapper">

    <div class="page-header">
        <h1 class="page-title">📊 Library Statistics</h1>
    </div>

    <div class="stats-main-grid">

        <div class="summary-section">
            <h2 class="section-heading">Overview</h2>

            <div class="stat-card card-red">
                <div class="card-icon">📚</div>
                <div class="card-content">
                    <div class="stat-number"><?= $data['total_books'] ?? 0 ?></div>
                    <div class="stat-label">Total Books</div>
                </div>
            </div>

            <div class="stat-card card-orange">
                <div class="card-icon">📖</div>
                <div class="card-content">
                    <div class="stat-number"><?= $data['borrowed_books'] ?? 0 ?></div>
                    <div class="stat-label">Borrowed Books</div>
                </div>
            </div>

            <div class="stat-card card-blue">
                <div class="card-icon">⏳</div>
                <div class="card-content">
                    <div class="stat-number"><?= $data['pending_requests'] ?? 0 ?></div>
                    <div class="stat-label">Pending Requests</div>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="card-icon">👥</div>
                <div class="card-content">
                    <div class="stat-number"><?= $data['total_users'] ?? 0 ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
        </div>

        <div class="category-section">
            <h2 class="section-heading">Books by Category</h2>

            <div class="category-grid">
                <?php if (!empty($data['books_by_category'])): ?>
                    <?php foreach ($data['books_by_category'] as $c): ?>
                        <div class="category-card">
                            <div class="category-number"><?= $c['total_books'] ?></div>
                            <div class="category-name"><?= htmlspecialchars($c['category_name']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No category data available</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="status-section">
        <h2 class="section-heading">Borrowing Status</h2>

        <div class="status-grid">
            <div class="status-card">
                ⏳ Pending: <?= $data['borrowing_by_status']['pending'] ?? 0 ?>
</div>
            <div class="status-card">
                ✅ Approved: <?= $data['borrowing_by_status']['approved'] ?? 0 ?>
            </div>
            <div class="status-card">
                ✔️ Returned: <?= $data['borrowing_by_status']['returned'] ?? 0 ?>
            </div>
            <div class="status-card">
                ❌ Rejected: <?= $data['borrowing_by_status']['rejected'] ?? 0 ?>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/./library_management_project/app/views/layouts/footer.php'; ?>

</body> 
</html>