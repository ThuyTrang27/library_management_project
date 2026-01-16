<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - TVAN Library</title>
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
            <h1>Forgot Password?</h1>
            <p style="margin-bottom: 20px; color: #666;">Nhập email để nhận mã OTP xác thực.</p>

            <?php if (isset($message)): ?>
                <div class="msg" style="color: #d9534f;"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=forgot_password">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="input-field" placeholder="example@gmail.com" required>
                </div>
                <div class="button-group">
                    <button type="submit" name="send_otp" class="btn-primary">Send OTP</button>
                    <a href="index.php?action=login" class="forget-link">Quay lại Đăng nhập</a>
                </div>
            </form>
        </div>
        <div class="right" style="background: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8') center/cover;"></div>
    </div>
</body>

</html>