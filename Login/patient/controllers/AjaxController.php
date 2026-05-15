<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$database = new Database();
$conn = $database->getConnection();
$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'get_available_slots') {
    $doctor_id = (int)$_GET['doctor_id'];
    $date = $_GET['date'];
    $day_of_week = date('l', strtotime($date)); 
    
    
    $avail_stmt = $conn->prepare("SELECT start_time, end_time, slot_duration_minutes FROM doctor_availability WHERE doctor_id = ? AND day_of_week = ? AND is_available = 1");
    $avail_stmt->bind_param("is", $doctor_id, $day_of_week);
    $avail_stmt->execute();
    $avail = $avail_stmt->get_result()->fetch_assoc();
    
    if(!$avail) {
        echo json_encode(['slots' => []]);
        exit;
    }
    
    
    $leave_stmt = $conn->prepare("SELECT * FROM leave_dates WHERE doctor_id = ? AND leave_date = ?");
    $leave_stmt->bind_param("is", $doctor_id, $date);
    $leave_stmt->execute();
    $leave = $leave_stmt->get_result();
    if($leave->num_rows > 0) {
        echo json_encode(['slots' => []]);
        exit;
    }
    
    
    $booked_stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND status NOT IN ('cancelled','no_show')");
    $booked_stmt->bind_param("is", $doctor_id, $date);
    $booked_stmt->execute();
    $booked_result = $booked_stmt->get_result();
    
    $booked_times = [];
    while($row = $booked_result->fetch_assoc()) {
        $booked_times[] = $row['appointment_time'];
    }
    
   
    $start = new DateTime($avail['start_time']);
    $end = new DateTime($avail['end_time']);
    $interval_minutes = (int)$avail['slot_duration_minutes'];
    $interval = new DateInterval('PT' . $interval_minutes . 'M');
    
    $slots = [];
    $current = clone $start;
    while($current < $end) {
        $time_slot_24 = $current->format('H:i:s');
        if(!in_array($time_slot_24, $booked_times)) {
            $slots[] = $current->format('h:i A');
        }
        $current->add($interval);
    }
    
    echo json_encode(['slots' => $slots]);
}
?>