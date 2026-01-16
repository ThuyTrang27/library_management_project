<?php
require_once __DIR__ . '/../core/lib/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../core/lib/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../core/lib/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handleLogin($email, $password, $role)
    {
        $user = $this->model->getUserByEmail($email);
        $roleValue = ($role == "Admin") ? 1 : 0;

        if (!$user) return "Bạn chưa có tài khoản";

        // Sử dụng password_verify để so khớp mật khẩu đã băm
        if (password_verify($password, $user['password']) && $user['role'] == $roleValue) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php?action=home");
            exit();
        }
        return "Bạn đã nhập sai mật khẩu/email";
    }

    public function handleForgetPassword($email)
    {
        $user = $this->model->getUserByEmail($email);
        if (!$user) return "Email chưa được đăng ký";

        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp; // Lưu OTP vào Session
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 300; // Hiệu lực 5 phút

        return $this->sendEmail($email, $user['full_name'], $otp);
    }

    private function sendEmail($email, $name, $otp)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ngocanhqb123end@gmail.com';
            $mail->Password = 'bcox uaxi ntpv txri';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('ngocanhqb123end@gmail.com', 'TVAN Library');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Mã OTP xác thực mật khẩu';
            $mail->Body = "Chào $name, mã OTP của bạn là: <b>$otp</b>. Hiệu lực 5 phút.";
            $mail->send();
            return "Hệ thống đã gửi mã OTP về email của bạn";
        } catch (Exception $e) {
            return "Lỗi gửi mail: " . $mail->ErrorInfo;
        }
    }

    public function handleVerifyOTP($inputOtp)
    {
        if (!isset($_SESSION['otp_expire']) || time() > $_SESSION['otp_expire']) {
            return "Mã OTP đã hết hạn!";
        }
        if ($inputOtp == $_SESSION['reset_otp']) {
            $_SESSION['otp_verified'] = true;
            header("Location: index.php?action=reset_password");
            exit();
        }
        return "Mã OTP không chính xác!";
    }

    public function handleResetPassword($newPassword, $confirmPassword)
    {
        if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
            return "Bạn không có quyền thực hiện hành động này!";
        }
        if ($newPassword !== $confirmPassword) {
            return "Mật khẩu xác nhận không khớp!";
        }

        $email = $_SESSION['otp_email'];
        // Băm mật khẩu mới bằng thuật toán chuẩn
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $this->model->updatePassword($email, $hashedPassword);

        if ($result) {
            // Xóa dữ liệu OTP sau khi thành công
            unset($_SESSION['reset_otp'], $_SESSION['otp_email'], $_SESSION['otp_expire'], $_SESSION['otp_verified']);
            return "Đổi mật khẩu thành công!";
        }
        return "Có lỗi xảy ra, vui lòng thử lại.";
    }
}
