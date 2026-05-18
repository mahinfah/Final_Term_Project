<?php
require_once __DIR__ . '/../config/database.php';
class Review {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getByDoctor($doctor_id) {
        $stmt = $this->conn->prepare("SELECT r.*, u.name as patient_name 
                                      FROM doctor_reviews r 
                                      JOIN patients p ON r.patient_id = p.id 
                                      JOIN users u ON p.user_id = u.id 
                                      WHERE r.doctor_id = ? 
                                      ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while($row = $result->fetch_assoc()) $reviews[] = $row;
        return $reviews;
    }
    public function addReply($review_id, $reply) {
        $stmt = $this->conn->prepare("UPDATE doctor_reviews SET reply = ? WHERE id = ?");
        $stmt->bind_param("si", $reply, $review_id);
        return $stmt->execute();
    }
}
?>