<?php
require_once __DIR__ . '/../config/database.php';
class User {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password_hash'])) return $row;
        }
        return false;
    }
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function updateProfile($id, $name, $phone, $profile_pic = null) {
        if ($profile_pic) {
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, phone = ?, profile_pic = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $phone, $profile_pic, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $phone, $id);
        }
        return $stmt->execute();
    }
    public function changePassword($id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $id);
        return $stmt->execute();
    }
}
?>