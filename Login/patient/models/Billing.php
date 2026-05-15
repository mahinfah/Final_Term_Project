<?php
require_once __DIR__ . '/../config/database.php';
class Billing {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getByPatient($patient_id) {
        $stmt = $this->conn->prepare("SELECT b.*, a.appointment_date, u.name as doctor_name FROM billing b JOIN appointments a ON b.appointment_id = a.id JOIN doctors d ON a.doctor_id = d.id JOIN users u ON d.user_id = u.id WHERE b.patient_id = ? ORDER BY a.appointment_date DESC");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bills = [];
        while($row = $result->fetch_assoc()) $bills[] = $row;
        return $bills;
    }
    public function submitPaymentIntent($bill_id, $patient_id, $method) {
        $stmt = $this->conn->prepare("UPDATE billing SET payment_method = ?, payment_status = 'paid', paid_at = NOW() WHERE id = ? AND patient_id = ? AND payment_status = 'pending'");
        $stmt->bind_param("sii", $method, $bill_id, $patient_id);
        return $stmt->execute();
    }
}
?>