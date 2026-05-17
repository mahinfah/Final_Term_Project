<?php
require_once __DIR__ . '/../config/database.php';
class Appointment {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getTodaySchedule($doctor_id) {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT a.*, u.name as patient_name, p.medical_history_notes 
                                      FROM appointments a 
                                      JOIN patients p ON a.patient_id = p.id 
                                      JOIN users u ON p.user_id = u.id 
                                      WHERE a.doctor_id = ? AND a.appointment_date = ? 
                                      ORDER BY a.appointment_time");
        $stmt->bind_param("is", $doctor_id, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $apps = [];
        while($row = $result->fetch_assoc()) $apps[] = $row;
        return $apps;
    }
    public function getWeeklySchedule($doctor_id) {
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime('+7 days'));
        $stmt = $this->conn->prepare("SELECT a.*, u.name as patient_name 
                                      FROM appointments a 
                                      JOIN patients p ON a.patient_id = p.id 
                                      JOIN users u ON p.user_id = u.id 
                                      WHERE a.doctor_id = ? AND a.appointment_date BETWEEN ? AND ? 
                                      ORDER BY a.appointment_date, a.appointment_time");
        $stmt->bind_param("iss", $doctor_id, $start, $end);
        $stmt->execute();
        $result = $stmt->get_result();
        $apps = [];
        while($row = $result->fetch_assoc()) $apps[] = $row;
        return $apps;
    }
    public function getPendingRequests($doctor_id) {
        $stmt = $this->conn->prepare("SELECT a.*, u.name as patient_name 
                                      FROM appointments a 
                                      JOIN patients p ON a.patient_id = p.id 
                                      JOIN users u ON p.user_id = u.id 
                                      WHERE a.doctor_id = ? AND a.status = 'pending' 
                                      ORDER BY a.appointment_date, a.appointment_time");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $apps = [];
        while($row = $result->fetch_assoc()) $apps[] = $row;
        return $apps;
    }
    public function updateStatus($appointment_id, $status, $doctor_id) {
        $stmt = $this->conn->prepare("UPDATE appointments SET status = ? WHERE id = ? AND doctor_id = ?");
        $stmt->bind_param("sii", $status, $appointment_id, $doctor_id);
        return $stmt->execute();
    }
    public function getUpcomingFollowUps($doctor_id) {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT cn.*, u.name as patient_name, a.appointment_date 
                                      FROM consultation_notes cn 
                                      JOIN appointments a ON cn.appointment_id = a.id 
                                      JOIN patients p ON cn.patient_id = p.id 
                                      JOIN users u ON p.user_id = u.id 
                                      WHERE cn.doctor_id = ? AND cn.follow_up_date >= ? 
                                      ORDER BY cn.follow_up_date");
        $stmt->bind_param("is", $doctor_id, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $followups = [];
        while($row = $result->fetch_assoc()) $followups[] = $row;
        return $followups;
    }
}
?>