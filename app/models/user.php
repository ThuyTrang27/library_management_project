<?php
class User {
    private $conn;

    public function __construct($conn) {
        if (!$conn) {
            die('❌ conn NULL in model');
        }
        $this->conn = $conn;
    }

    public function checkUserExist($username, $email) {
        $sql = "SELECT user_id FROM users 
                WHERE username = :username OR email = :email 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
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

            $stmt = $this->conn->prepare($sql);
            
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
                return ['status' => true, 'message' => 'Đăng ký thành công!'];
            }
            
            return ['status' => false, 'message' => 'Không thể thêm dữ liệu.'];

        } catch (PDOException $e) {
            return [
                'status' => false, 
                'message' => 'Lỗi Database: ' . $e->getMessage()
            ];
        }
    }
}