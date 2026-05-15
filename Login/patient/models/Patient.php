<?php
require_once 'config/database.php';
class Patient {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function create($user_id, $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history) {
        $stmt = $this->conn->prepare("INSERT INTO patients (user_id, date_of_birth, blood_group, gender, address, emergency_contact_name, emergency_contact_phone, medical_history_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $user_id, $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history);
        return $stmt->execute();
    }
    public function getByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM patients WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($user_id, $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history) {
        $stmt = $this->conn->prepare("UPDATE patients SET date_of_birth=?, blood_group=?, gender=?, address=?, emergency_contact_name=?, emergency_contact_phone=?, medical_history_notes=? WHERE user_id=?");
        $stmt->bind_param("sssssssi", $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history, $user_id);
        return $stmt->execute();
    }
}
?>