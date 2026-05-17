<?php
session_start();
require_once _DIR_ . '/../models/Appointment.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$appointmentModel = new Appointment();

if($action == 'check_in') {
    $appointment_id = (int)$_GET['id'];
    $doctor_id = $_SESSION['user_id']; // but we need doctor's db id, not user_id. Fetch.
    // In a real system, you'd get doctor_id from session via Doctor model. Simplified:
    $db = new Database();
    $conn = $db->getConnection();
    $doc = $conn->query("SELECT id FROM doctors WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();
    $doctor_db_id = $doc['id'];
    $result = $appointmentModel->updateStatus($appointment_id, 'checked_in', $doctor_db_id);
    echo json_encode(['success' => $result]);
}
?>