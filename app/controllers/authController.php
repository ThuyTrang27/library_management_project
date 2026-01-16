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
        if ($user && password_verify($password, $user['password']) && $user['role'] == $roleValue) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php?action=home");
            exit();
        }
        return "Thông tin đăng nhập không chính xác.";
    }

    public function handleForgetPassword($email)
    {
        $user = $this->model->getUserByEmail($email);
        if (!$user) return "Email không tồn tại.";
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 300;
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
            $mail->Subject = 'OTP Reset Password';
            $mail->Body = "Mã xác thực của bạn là: <b>$otp</b>";
            $mail->send();
            return "Hệ thống đã gửi mã OTP về email của bạn";
        } catch (Exception $e) {
            return "Lỗi: " . $mail->ErrorInfo;
        }
    }

    public function handleVerifyOTP($input)
    {
        if (time() > $_SESSION['otp_expire']) return "OTP hết hạn.";
        if ($input == $_SESSION['reset_otp']) {
            $_SESSION['otp_verified'] = true;
            header("Location: index.php?action=reset_password");
            exit();
        }
        return "OTP không đúng.";
    }

    public function handleResetPassword($pass, $confirm)
    {
        if ($pass !== $confirm) return "Mật khẩu không khớp.";
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        if ($this->model->updatePassword($_SESSION['otp_email'], $hash)) {
            unset($_SESSION['reset_otp'], $_SESSION['otp_verified']);
            return "Đổi mật khẩu thành công!";
        }
        return "Lỗi cập nhật.";
    }
}
