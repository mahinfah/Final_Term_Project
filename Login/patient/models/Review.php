<?php
require_once 'config/database.php';
class Review {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function add($appointment_id, $patient_id, $doctor_id, $rating, $text) {
        $stmt = $this->conn->prepare("INSERT INTO doctor_reviews (appointment_id, patient_id, doctor_id, rating, review_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiis", $appointment_id, $patient_id, $doctor_id, $rating, $text);
        return $stmt->execute();
    }
    public function getByAppointment($appointment_id, $patient_id) {
        $stmt = $this->conn->prepare("SELECT * FROM doctor_reviews WHERE appointment_id = ? AND patient_id = ?");
        $stmt->bind_param("ii", $appointment_id, $patient_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $rating, $text) {
        $stmt = $this->conn->prepare("UPDATE doctor_reviews SET rating = ?, review_text = ? WHERE id = ?");
        $stmt->bind_param("isi", $rating, $text, $id);
        return $stmt->execute();
    }
    public function delete($id, $patient_id) {
        $stmt = $this->conn->prepare("DELETE FROM doctor_reviews WHERE id = ? AND patient_id = ?");
        $stmt->bind_param("ii", $id, $patient_id);
        return $stmt->execute();
    }
}
?>