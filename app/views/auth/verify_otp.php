<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP - TVAN Library</title>
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
            <h1>Verify OTP</h1>
            <p style="margin-bottom: 20px; color: #666;">
                Mã đã gửi tới: <b><?php echo $_SESSION['otp_email'] ?? ''; ?></b>
            </p>

            <?php if (isset($message)): ?>
                <div class="msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=verify_otp">
                <div class="form-group">
                    <label>Mã OTP (6 số)</label>
                    <input type="text" name="otp_input" class="input-field" maxlength="6"
                        style="letter-spacing: 8px; text-align: center; font-size: 22px;" required>
                </div>
                <button type="submit" name="verify" class="btn-primary">Xác nhận mã</button>
            </form>
        </div>
        <div class="right" style="background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') center/cover;"></div>
    </div>
</body>

</html>