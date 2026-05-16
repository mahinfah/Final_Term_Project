<?php
class AppointmentModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getTodayAppointments($doctor_id) {
        $sql = "SELECT a.*, u.name as patient_name, p.user_id as patient_user_id 
                FROM appointments a 
                JOIN patients p ON a.patient_id = p.id 
                JOIN users u ON p.user_id = u.id 
                WHERE a.doctor_id = ? AND a.appointment_date = CURDATE() 
                ORDER BY a.appointment_time";
        $result = $this->db->select($sql, [$doctor_id], "i");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getWeeklyAppointments($doctor_id, $start_date, $end_date) {
        $sql = "SELECT a.*, u.name as patient_name 
                FROM appointments a 
                JOIN patients p ON a.patient_id = p.id 
                JOIN users u ON p.user_id = u.id 
                WHERE a.doctor_id = ? AND a.appointment_date BETWEEN ? AND ? 
                ORDER BY a.appointment_date, a.appointment_time";
        $result = $this->db->select($sql, [$doctor_id, $start_date, $end_date], "iss");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($appointment_id, $status) {
        $sql = "UPDATE appointments SET status=? WHERE id=?";
        return $this->db->execute($sql, [$status, $appointment_id], "si");
    }

    public function getAppointmentById($id, $doctor_id) {
        $sql = "SELECT a.*, p.user_id as patient_user_id, u.name as patient_name 
                FROM appointments a 
                JOIN patients p ON a.patient_id = p.id 
                JOIN users u ON p.user_id = u.id 
                WHERE a.id = ? AND a.doctor_id = ?";
        $result = $this->db->select($sql, [$id, $doctor_id], "ii");
        return $result->fetch_assoc();
    }
}
?>