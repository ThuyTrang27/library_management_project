<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password - TVAN Library</title>
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
            <h1>Forgot Password?</h1>
            <p style="margin-bottom: 25px; color: #666; line-height: 1.5;">
                Đừng lo lắng! Hãy nhập email của bạn dưới đây, chúng tôi sẽ gửi mã OTP để bạn thiết lập lại mật khẩu.
            </p>

            <?php if ($message): ?>
                <div class="msg" style="color: #d9534f; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=forgot_password">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                </div>

                <div class="button-group" style="margin-top: 30px;">
                    <button type="submit" name="send_otp" class="btn-in">Send OTP Code</button>
                    <a href="index.php?action=login" class="link">Quay lại Đăng nhập</a>
                </div>
            </form>
        </div>

        <div class="right-img" style="background-image: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8');"></div>
    </div>
</body>

</html>