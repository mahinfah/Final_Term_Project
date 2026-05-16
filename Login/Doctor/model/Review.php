<?php
class ReviewModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getForDoctor($doctor_id) {
        $sql = "SELECT r.*, u.name as patient_name, a.appointment_date 
                FROM doctor_reviews r 
                JOIN patients p ON r.patient_id = p.id 
                JOIN users u ON p.user_id = u.id 
                JOIN appointments a ON r.appointment_id = a.id 
                WHERE r.doctor_id = ? 
                ORDER BY r.created_at DESC";
        $result = $this->db->select($sql, [$doctor_id], "i");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addReply($review_id, $reply) {
        $sql = "UPDATE doctor_reviews SET reply=? WHERE id=?";
        return $this->db->execute($sql, [$reply, $review_id], "si");
    }
}
?>