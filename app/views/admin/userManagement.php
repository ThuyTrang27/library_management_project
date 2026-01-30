<?php
// Tái sử dụng header
require_once __DIR__ . '/../layouts/header.php';

?>

<link rel="stylesheet" href="/public/css/admin.css">

<div class="container">
    <h1 class="text-center mt-4 mb-4">User Management</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($users) && !empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['user_id']) ?></td>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars($user['date_of_birth']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <?php if (isset($user['is_locked']) && $user['is_locked']) : ?>
                                    <span class="badge bg-danger">Blocked</span>
                                <?php else : ?>
                                    <span class="badge bg-success">Active</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($user['is_locked']) && $user['is_locked']) : ?>
                                    <a href="index.php?action=unlock_user&id=<?= $user['user_id'] ?>" class="btn btn-success btn-sm">Unblock</a>
                                <?php else : ?>
                                    <a href="index.php?action=lock_user&id=<?= $user['user_id'] ?>" class="btn btn-danger btn-sm">Block</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="text-center">No user data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Tái sử dụng footer
require_once __DIR__ . '/../layouts/footer.php';
?>