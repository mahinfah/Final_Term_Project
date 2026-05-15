<?php
require_once 'config/database.php';
class Doctor {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getAllApproved($search = '', $spec = '', $min_fee = '', $max_fee = '') {
        $sql = "SELECT d.*, u.name, u.email, u.phone, u.profile_pic, s.name as specialization_name 
                FROM doctors d JOIN users u ON d.user_id = u.id 
                LEFT JOIN specializations s ON d.specialization_id = s.id 
                WHERE d.is_approved = 1 AND u.is_active = 1";
        if($search) $sql .= " AND (u.name LIKE '%$search%' OR s.name LIKE '%$search%')";
        if($spec) $sql .= " AND d.specialization_id = $spec";
        if($min_fee) $sql .= " AND d.consultation_fee >= $min_fee";
        if($max_fee) $sql .= " AND d.consultation_fee <= $max_fee";
        $result = $this->conn->query($sql);
        $doctors = [];
        while($row = $result->fetch_assoc()) $doctors[] = $row;
        return $doctors;
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT d.*, u.name, u.email, u.phone, u.profile_pic, s.name as specialization_name FROM doctors d JOIN users u ON d.user_id = u.id LEFT JOIN specializations s ON d.specialization_id = s.id WHERE d.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getSpecializations() {
        $result = $this->conn->query("SELECT * FROM specializations ORDER BY name");
        $specs = [];
        while($row = $result->fetch_assoc()) $specs[] = $row;
        return $specs;
    }
    public function getAverageRating($doctor_id) {
        $stmt = $this->conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM doctor_reviews WHERE doctor_id = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getReviews($doctor_id) {
        $stmt = $this->conn->prepare("SELECT r.*, u.name as patient_name FROM doctor_reviews r JOIN patients p ON r.patient_id = p.id JOIN users u ON p.user_id = u.id WHERE r.doctor_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while($row = $result->fetch_assoc()) $reviews[] = $row;
        return $reviews;
    }
}
?>