<?php
require_once 'config/database.php';
class Appointment {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getAvailableSlots($doctor_id, $date) {
        $day = date('l', strtotime($date));
        $stmt = $this->conn->prepare("SELECT start_time, end_time, slot_duration_minutes FROM doctor_availability WHERE doctor_id = ? AND day_of_week = ? AND is_available = 1");
        $stmt->bind_param("is", $doctor_id, $day);
        $stmt->execute();
        $avail = $stmt->get_result()->fetch_assoc();
        if(!$avail) return [];
        $leave = $this->conn->prepare("SELECT * FROM leave_dates WHERE doctor_id = ? AND leave_date = ?");
        $leave->bind_param("is", $doctor_id, $date);
        $leave->execute();
        if($leave->get_result()->num_rows > 0) return [];
        $booked = $this->conn->prepare("SELECT appointment_time FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND status NOT IN ('cancelled','no_show')");
        $booked->bind_param("is", $doctor_id, $date);
        $booked->execute();
        $bookedTimes = [];
        $res = $booked->get_result();
        while($row = $res->fetch_assoc()) $bookedTimes[] = $row['appointment_time'];
        $start = new DateTime($avail['start_time']);
        $end = new DateTime($avail['end_time']);
        $interval = new DateInterval('PT' . $avail['slot_duration_minutes'] . 'M');
        $slots = [];
        $current = clone $start;
        while($current < $end) {
            $t24 = $current->format('H:i:s');
            if(!in_array($t24, $bookedTimes)) $slots[] = $current->format('h:i A');
            $current->add($interval);
        }
        return $slots;
    }
    public function book($patient_id, $doctor_id, $date, $time, $reason, $dependent_id = null) {
        $time24 = date('H:i:s', strtotime($time));
        $stmt = $this->conn->prepare("INSERT INTO appointments (patient_id, doctor_id, dependent_id, appointment_date, appointment_time, reason, status, booked_by) VALUES (?, ?, ?, ?, ?, ?, 'pending', 'patient')");
        $stmt->bind_param("iiisss", $patient_id, $doctor_id, $dependent_id, $date, $time24, $reason);
        if($stmt->execute()) {
            $app_id = $this->conn->insert_id;
            $fee = $this->conn->query("SELECT consultation_fee FROM doctors WHERE id = $doctor_id")->fetch_assoc()['consultation_fee'];
            $bill = $this->conn->prepare("INSERT INTO billing (appointment_id, patient_id, amount, payment_status) VALUES (?, ?, ?, 'pending')");
            $bill->bind_param("iid", $app_id, $patient_id, $fee);
            $bill->execute();
            return $app_id;
        }
        return false;
    }
    public function getUpcoming($patient_id) {
        $stmt = $this->conn->prepare("SELECT a.*, u.name as doctor_name FROM appointments a JOIN doctors d ON a.doctor_id = d.id JOIN users u ON d.user_id = u.id WHERE a.patient_id = ? AND a.appointment_date >= CURDATE() AND a.status NOT IN ('completed','cancelled') ORDER BY a.appointment_date, a.appointment_time");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function getPast($patient_id) {
        $stmt = $this->conn->prepare("SELECT a.*, u.name as doctor_name, (SELECT COUNT(*) FROM consultation_notes WHERE appointment_id = a.id) as has_notes FROM appointments a JOIN doctors d ON a.doctor_id = d.id JOIN users u ON d.user_id = u.id WHERE a.patient_id = ? AND (a.appointment_date < CURDATE() OR a.status = 'completed') ORDER BY a.appointment_date DESC");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_assoc()) $data[] = $row;
        return $data;
    }
    public function cancel($id, $patient_id) {
        $stmt = $this->conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND patient_id = ? AND appointment_date > CURDATE()");
        $stmt->bind_param("ii", $id, $patient_id);
        return $stmt->execute();
    }
    public function reschedule($id, $patient_id, $new_date, $new_time) {
        $time24 = date('H:i:s', strtotime($new_time));
        $stmt = $this->conn->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, status = 'pending' WHERE id = ? AND patient_id = ? AND appointment_date > CURDATE()");
        $stmt->bind_param("ssii", $new_date, $time24, $id, $patient_id);
        return $stmt->execute();
    }
    public function getConsultationNotes($appointment_id, $patient_id) {
        $stmt = $this->conn->prepare("SELECT n.*, u.name as doctor_name FROM consultation_notes n JOIN doctors d ON n.doctor_id = d.id JOIN users u ON d.user_id = u.id WHERE n.appointment_id = ? AND n.patient_id = ?");
        $stmt->bind_param("ii", $appointment_id, $patient_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>