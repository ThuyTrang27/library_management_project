<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - TVAN Library</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="brand-header">
        <img src="images/logo.png" alt="Logo">
        <span>TVAN LIBRARY</span>
    </div>

    <div class="login-container">
        <div class="left">
            <h1>Welcome back !</h1>

            <?php if ($message): ?>
                <div class="msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="input-field" placeholder="email@example.com" required>
                </div>

                <div class="form-group" style="position: relative;">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="input-field" placeholder="••••••••" required>
                    <span id="togglePassword" style="position: absolute; right: 15px; top: 38px; cursor: pointer;">👁️</span>
                </div>

                <div class="role-group" style="margin-bottom: 20px;">
                    <label><input type="radio" name="role" value="User" checked> User</label>
                    <label style="margin-left: 20px;"><input type="radio" name="role" value="Admin"> Admin</label>
                </div>

                <div class="button-group" style="display: flex; flex-direction: column; gap: 10px;">
                    <button type="submit" name="login" class="btn-primary">Sign In</button>
                    <button type="button" class="btn-secondary" style="padding: 12px; border: 1px solid #519aba; background: #fff; color: #519aba; border-radius: 5px; cursor: pointer;">Register</button>
                </div>

                <a href="index.php?action=forgot_password_view" class="forget-link">Forget your password?</a>
            </form>
        </div>
        <div class="right" style="background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66') center/cover;"></div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>