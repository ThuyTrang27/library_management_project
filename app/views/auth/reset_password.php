<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu - TVAN Library</title>
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
            <h1>New Password</h1>

            <form method="POST" action="index.php?action=reset_password">
                <div class="form-group" style="position: relative;">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="new_password" id="pass1" class="input-field" required>
                    <span class="toggle-eye" onclick="toggle('pass1')" style="position: absolute; right: 10px; top: 38px; cursor: pointer;">👁️</span>
                </div>

                <div class="form-group" style="position: relative;">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" id="pass2" class="input-field" required>
                    <span class="toggle-eye" onclick="toggle('pass2')" style="position: absolute; right: 10px; top: 38px; cursor: pointer;">👁️</span>
                </div>

                <button type="submit" name="reset" class="btn-primary">Cập nhật mật khẩu</button>
            </form>
        </div>
        <div class="right" style="background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794') center/cover;"></div>
    </div>

    <script>
        function toggle(id) {
            const x = document.getElementById(id);
            x.type = x.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>