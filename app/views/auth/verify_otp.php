<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Verify OTP - TVAN Library</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
            <h1>Verify OTP</h1>
            <p style="margin-bottom: 20px; color: #666;">
                Vui lòng nhập mã 6 số đã được gửi tới email của bạn.
            </p>

            <?php if ($message): ?>
                <div class="msg" style="color: #d9534f; margin-bottom: 15px;"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=verify_otp">
                <div class="form-group">
                    <label>OTP Code</label>
                    <input type="text" name="otp_input" placeholder="******"
                        maxlength="6" required
                        style="letter-spacing: 10px; text-align: center; font-size: 20px;">
                </div>

                <button type="submit" name="verify" class="btn-in">Verify OTP</button>
                <a href="index.php?action=forgot_password" class="link">Gửi lại mã khác?</a>
            </form>
        </div>
        <div class="right-img" style="background-image: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da');"></div>
    </div>
</body>

</html>