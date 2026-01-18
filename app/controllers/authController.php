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

        if (!$user) return "You did not register yet!";

        // Sử dụng password_verify để so khớp mật khẩu đã băm
        if (password_verify($password, $user['password']) && $user['role'] == $roleValue) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php?action=home");
            exit();
        }
        return "You have entered the wrong password/email";
    }

    public function handleForgetPassword($email)
    {
        $user = $this->model->getUserByEmail($email);
        if (!$user) return "Your email is not registered!";

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
            $mail->Subject = 'OTP Reset Password from TVAN Library';
            $mail->Body = "hello $name, your OTP code is: <b>$otp</b>. available in5 minutes.";
            $mail->send();
            return "Our OTP code has been sent to your email address.";
        } catch (Exception $e) {
            return "Error sending email: " . $mail->ErrorInfo;
        }
    }

    public function handleVerifyOTP($inputOtp)
    {
        if (!isset($_SESSION['otp_expire']) || time() > $_SESSION['otp_expire']) {
            return "OTP has expired!";
        }
        if ($inputOtp == $_SESSION['reset_otp']) {
            $_SESSION['otp_verified'] = true;
            header("Location: index.php?action=reset_password");
            exit();
        }
        return "OTP is incorrect!";
    }

    public function handleResetPassword($newPassword, $confirmPassword)
    {
        if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
            return "Yuou are not authorized to reset the password.";
        }
        if ($newPassword !== $confirmPassword) {
            return "Passwords do not match!";
        }

        $email = $_SESSION['otp_email'];
        // Băm mật khẩu mới bằng thuật toán chuẩn
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $this->model->updatePassword($email, $hashedPassword);

        if ($result) {
            // Xóa dữ liệu OTP sau khi thành công
            unset($_SESSION['reset_otp'], $_SESSION['otp_email'], $_SESSION['otp_expire'], $_SESSION['otp_verified']);
            return "update password successfull!";
        }
        return "There was an error, please try again.";
    }
}

//     public function logout() {
//         session_destroy();
//         header("Location: index.php");
//     }
// }