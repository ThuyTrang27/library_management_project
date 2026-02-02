<<<<<<< HEAD
    <?php
    // Tái sử dụng header
    require_once __DIR__ . '/../layouts/header.php';

    ?>
    <link rel="stylesheet" href="/public/css/admin.css">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management</title>
        <link rel="stylesheet" href="/public/css/admin.css">
    </head>

    <body>
        <?php
        // Tái sử dụng header
        require_once __DIR__ . '/../layouts/headerAdmin.php';

        ?>
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
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center">No user data available.</td>
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
    </body>

    </html>