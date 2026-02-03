<?php
<<<<<<< HEAD
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
=======
class User {
    private $conn;

    public function __construct($conn) {
        if (!$conn) {
            die('❌ conn NULL in model');
        }
        $this->conn = $conn;
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
    }

    public function checkUserExist($username, $email) {
        $sql = "SELECT user_id FROM users 
                WHERE username = :username OR email = :email 
                LIMIT 1";

<<<<<<< HEAD
        $stmt = $this->db->prepare($sql);
=======
        $stmt = $this->conn->prepare($sql);
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
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

<<<<<<< HEAD
            $stmt = $this->db->prepare($sql);
=======
            $stmt = $this->conn->prepare($sql);
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
            
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
<<<<<<< HEAD
                return ['status' => true];
            }
            
            return ['status' => false];
=======
                return ['status' => true, 'message' => 'Đăng ký thành công!'];
            }
            
            return ['status' => false, 'message' => 'Không thể thêm dữ liệu.'];
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663

        } catch (PDOException $e) {
            return [
                'status' => false, 
                'message' => 'Lỗi Database: ' . $e->getMessage()
            ];
        }
    }
<<<<<<< HEAD

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lockUser($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET is_locked = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    public function unlockUser($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET is_locked = 0 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }


=======
>>>>>>> 3f7e7f9ac9d8183744203643594bbb23085f7663
}