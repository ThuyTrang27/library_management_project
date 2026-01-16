<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Kiểm tra email tồn tại (Yêu cầu 5)
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật mã OTP khi quên mật khẩu (Yêu cầu 3)
    public function updateOTP($email, $otp)
    {
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        $stmt = $this->db->prepare("UPDATE users SET otp_code = ?, otp_expiry = ? WHERE email = ?");
        return $stmt->execute([$otp, $expiry, $email]);
    }

    // Cập nhật mật khẩu mới
    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ?, otp_code = NULL, otp_expiry = NULL WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }
}
