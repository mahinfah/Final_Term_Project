<?php
require_once _DIR_ . '/../config/database.php';
class Doctor {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function updateProfile($doctor_id, $bio, $consultation_fee, $photo_path, $license_number, $experience_years, $specialization_id) {
        $stmt = $this->conn->prepare("UPDATE doctors SET bio = ?, consultation_fee = ?, photo_path = ?, license_number = ?, experience_years = ?, specialization_id = ? WHERE id = ?");
        $stmt->bind_param("sdssiii", $bio, $consultation_fee, $photo_path, $license_number, $experience_years, $specialization_id, $doctor_id);
        return $stmt->execute();
    }
    public function getSpecializations() {
        $result = $this->conn->query("SELECT * FROM specializations ORDER BY name");
        $specs = [];
        while($row = $result->fetch_assoc()) $specs[] = $row;
        return $specs;
    }
    public function getAvailability($doctor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM doctor_availability WHERE doctor_id = ? ORDER BY FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $availability = [];
        while($row = $result->fetch_assoc()) $availability[] = $row;
        return $availability;
    }
    public function updateAvailability($doctor_id, $day_of_week, $start_time, $end_time, $slot_duration, $is_available) {
        $stmt = $this->conn->prepare("UPDATE doctor_availability SET start_time = ?, end_time = ?, slot_duration_minutes = ?, is_available = ? WHERE doctor_id = ? AND day_of_week = ?");
        $stmt->bind_param("ssiiis", $start_time, $end_time, $slot_duration, $is_available, $doctor_id, $day_of_week);
        return $stmt->execute();
    }
    public function getLeaveDates($doctor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM leave_dates WHERE doctor_id = ? ORDER BY leave_date");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $leaves = [];
        while($row = $result->fetch_assoc()) $leaves[] = $row;
        return $leaves;
    }
    public function addLeaveDate($doctor_id, $leave_date, $reason) {
        $stmt = $this->conn->prepare("INSERT INTO leave_dates (doctor_id, leave_date, reason) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $doctor_id, $leave_date, $reason);
        return $stmt->execute();
    }
    public function removeLeaveDate($id, $doctor_id) {
        $stmt = $this->conn->prepare("DELETE FROM leave_dates WHERE id = ? AND doctor_id = ?");
        $stmt->bind_param("ii", $id, $doctor_id);
        return $stmt->execute();
    }
}
?>