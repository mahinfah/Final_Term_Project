<?php
require_once _DIR_ . '/../config/database.php';
class ConsultationNote {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function add($appointment_id, $doctor_id, $patient_id, $symptoms, $diagnosis, $prescription, $follow_up_date) {
        $stmt = $this->conn->prepare("INSERT INTO consultation_notes (appointment_id, doctor_id, patient_id, symptoms, diagnosis, prescription, follow_up_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissss", $appointment_id, $doctor_id, $patient_id, $symptoms, $diagnosis, $prescription, $follow_up_date);
        return $stmt->execute();
    }
    public function getByPatient($doctor_id, $patient_id) {
        $stmt = $this->conn->prepare("SELECT cn.*, a.appointment_date 
                                      FROM consultation_notes cn 
                                      JOIN appointments a ON cn.appointment_id = a.id 
                                      WHERE cn.doctor_id = ? AND cn.patient_id = ? 
                                      ORDER BY a.appointment_date DESC");
        $stmt->bind_param("ii", $doctor_id, $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notes = [];
        while($row = $result->fetch_assoc()) $notes[] = $row;
        return $notes;
    }
}
?>