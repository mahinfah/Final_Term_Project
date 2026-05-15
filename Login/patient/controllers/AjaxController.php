<?php
session_start();
require_once '../config/database.php';

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
    $day = date('l', strtotime($date));
    

    $avail = $conn->query("SELECT start_time, end_time, slot_duration_minutes FROM doctor_availability WHERE doctor_id = $doctor_id AND day_of_week = '$day' AND is_available = 1")->fetch_assoc();
    
    if(!$avail) {
        echo json_encode(['slots' => []]);
        exit;
    }

    $leave = $conn->query("SELECT * FROM leave_dates WHERE doctor_id = $doctor_id AND leave_date = '$date'");
    if($leave->num_rows > 0) {
        echo json_encode(['slots' => []]);
        exit;
    }
    

    $booked = [];
    $res = $conn->query("SELECT appointment_time FROM appointments WHERE doctor_id = $doctor_id AND appointment_date = '$date' AND status NOT IN ('cancelled','no_show')");
    while($row = $res->fetch_assoc()) {
        $booked[] = $row['appointment_time'];
    }
    

    $start = new DateTime($avail['start_time']);
    $end = new DateTime($avail['end_time']);
    $interval = new DateInterval('PT' . $avail['slot_duration_minutes'] . 'M');
    $slots = [];
    $current = clone $start;
    
    while($current < $end) {
        $t24 = $current->format('H:i:s');
        if(!in_array($t24, $booked)) {
            $slots[] = $current->format('h:i A');
        }
        $current->add($interval);
    }
    
    echo json_encode(['slots' => $slots]);
}
?>