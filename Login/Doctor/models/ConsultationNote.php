<?php
class ConsultationNoteModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function addNote($appointment_id, $doctor_id, $patient_id, $symptoms, $diagnosis, $prescription, $follow_up_date) {
        $sql = "INSERT INTO consultation_notes (appointment_id, doctor_id, patient_id, symptoms, diagnosis, prescription, follow_up_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [$appointment_id, $doctor_id, $patient_id, $symptoms, $diagnosis, $prescription, $follow_up_date], "iiissss");
    }

    public function getPatientNotes($doctor_id, $patient_user_id) {
        $sql = "SELECT cn.*, a.appointment_date, a.appointment_time 
                FROM consultation_notes cn 
                JOIN appointments a ON cn.appointment_id = a.id 
                JOIN patients p ON cn.patient_id = p.id 
                WHERE cn.doctor_id = ? AND p.user_id = ? 
                ORDER BY a.appointment_date DESC";
        $result = $this->db->select($sql, [$doctor_id, $patient_user_id], "ii");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFollowUps($doctor_id) {
        $sql = "SELECT cn.*, u.name as patient_name, a.appointment_date as last_visit 
                FROM consultation_notes cn 
                JOIN appointments a ON cn.appointment_id = a.id 
                JOIN patients p ON cn.patient_id = p.id 
                JOIN users u ON p.user_id = u.id 
                WHERE cn.doctor_id = ? AND cn.follow_up_date >= CURDATE() 
                ORDER BY cn.follow_up_date";
        $result = $this->db->select($sql, [$doctor_id], "i");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>