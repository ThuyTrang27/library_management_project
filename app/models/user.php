<?php
class User
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

    public function checkUserExist($username, $email) {
        $sql = "SELECT user_id FROM users 
                WHERE username = :username OR email = :email 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email'    => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($data) {
        // 1. Kiểm tra tồn tại
        if ($this->checkUserExist($data['username'], $data['email'])) {
            return [
                'status' => false,
                'message' => 'The username or email already exists in the system!'
            ];
        }

        try {
            $sql = "INSERT INTO users 
                    (full_name, username, email, phone, password, address, gender, date_of_birth) 
                    VALUES 
                    (:fullname, :username, :email, :phone, :password, :address, :gender, :date_of_birth)";

            $stmt = $this->db->prepare($sql);
            
            // Thực thi với mảng dữ liệu
            $result = $stmt->execute([
                ':fullname'      => $data['fullname'],
                ':username'      => $data['username'],
                ':email'         => $data['email'],
                ':phone'         => $data['phone'],
                ':password'      => password_hash($data['password'], PASSWORD_BCRYPT),
                ':address'       => $data['address'],
                ':gender'        => $data['gender'],
                ':date_of_birth' => $data['date_of_birth']
            ]);

            if ($result) {
                return ['status' => true];
            }
            
            return ['status' => false];

        } catch (PDOException $e) {
            return [
                'status' => false, 
                'message' => 'Lỗi Database: ' . $e->getMessage()
            ];
        }
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}