<?php
class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($email, $hashedPassword)
    {
        // Chỉ cập nhật cột password, vì OTP đã lưu trong Session
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }
}
