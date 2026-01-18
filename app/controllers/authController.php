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

    /* ================= LOGIN ================= */
    public function login()
    {
        $message = null;

        if (isset($_POST['login'])) {
            $message = $this->handleLogin(
                $_POST['email'],
                $_POST['password'],
                $_POST['role']
            );
        }

        require dirname(__DIR__) . '/views/auth/login.php';
    }

    private function handleLogin($email, $password, $role)
    {
        $user = $this->model->getUserByEmail($email);
        $roleValue = (int)$role; // FIX CHUẨN VỚI VIEW

        if (!$user) return "You did not register yet!";

        if (password_verify($password, $user['password']) && $user['role'] == $roleValue) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php?action=home");
            exit();
        }
        return "You have entered the wrong password/email";
    }

    /* ================= FORGOT PASSWORD ================= */
    public function forgotPassword()
    {
        $message = null;

        if (isset($_POST['send_otp'])) {
            $message = $this->handleForgetPassword($_POST['email']);
        }

        require dirname(__DIR__) . '/views/auth/forgot_password.php';
    }

    private function handleForgetPassword($email)
    {
        $user = $this->model->getUserByEmail($email);
        if (!$user) return "Your email is not registered!";

        $otp = random_int(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 300;

        $result = $this->sendEmail($email, $user['full_name'], $otp);

        //  ĐIỀU HƯỚNG SANG VERIFY OTP
        if ($result === "OTP has been sent to your email.") {
            header("Location: index.php?action=verify_otp");
            exit();
        }

        return $result;
    }

    /* ================= VERIFY OTP ================= */
    public function verifyOtp()
    {
        $message = null;

        if (isset($_POST['verify'])) {
            $message = $this->handleVerifyOTP($_POST['otp_input']);
        }

        require dirname(__DIR__) . '/views/auth/verify_otp.php';
    }

    private function handleVerifyOTP($inputOtp)
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

    /* ================= RESET PASSWORD ================= */
    public function resetPassword()
    {
        $message = null;

        if (isset($_POST['reset'])) {
            $message = $this->handleResetPassword(
                $_POST['new_password'],
                $_POST['confirm_password']
            );
        }

        require dirname(__DIR__) . '/views/auth/reset_password.php';
    }

    private function handleResetPassword($newPassword, $confirmPassword)
    {
        if (!isset($_SESSION['otp_verified'])) {
            return "You are not authorized to reset the password.";
        }

        if ($newPassword !== $confirmPassword) {
            return "Passwords do not match!";
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->model->updatePassword($_SESSION['otp_email'], $hashedPassword);

        // Xóa session OTP
        unset(
            $_SESSION['reset_otp'],
            $_SESSION['otp_email'],
            $_SESSION['otp_expire'],
            $_SESSION['otp_verified']
        );

        //  ĐIỀU HƯỚNG VỀ LOGIN
        header("Location: index.php?action=login&reset=success");
        exit();
    }


    /* ================= LOGOUT ================= */
    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=listbook");
        exit();
    }

    /* ================= SEND EMAIL ================= */
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
            $mail->Body = "Hello $name, your OTP code is <b>$otp</b>. Valid for 5 minutes.";

            $mail->send();
            return "OTP has been sent to your email.";
        } catch (Exception $e) {
            return "Mail error!";
        }
    }
}
