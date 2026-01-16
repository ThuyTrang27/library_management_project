<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - TVAN Library</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="brand-header">
        <img src="images/logo.png" alt="Logo">
        <span>TVAN LIBRARY</span>
    </div>

    <div class="login-container">
        <div class="left-form">
            <p class="brand-sub">TVAN LIBRARY</p>
            <h1>New Password</h1>
            <p style="margin-bottom: 20px; color: #666;">Thiết lập mật khẩu mới cho tài khoản của bạn.</p>

            <?php if ($message): ?>
                <div class="msg" style="color: #28a745; margin-bottom: 15px;"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=reset_password">
                <div class="form-group" style="position: relative;">
                    <label>New Password</label>
                    <input type="password" name="new_password" id="n_pass" placeholder="••••••••" required>
                    <span class="toggle" onclick="toggle('n_pass')" style="position: absolute; right: 12px; top: 38px; cursor: pointer;">👁️</span>
                </div>

                <div class="form-group" style="position: relative;">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="c_pass" placeholder="••••••••" required>
                    <span class="toggle" onclick="toggle('c_pass')" style="position: absolute; right: 12px; top: 38px; cursor: pointer;">👁️</span>
                </div>

                <button type="submit" name="reset" class="btn-in">Update Password</button>
            </form>
        </div>
        <div class="right-img" style="background-image: url('https://images.unsplash.com/photo-1512820790803-83ca734da794');"></div>
    </div>

    <script>
        function toggle(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>