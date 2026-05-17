<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn = conn_open();
$message = '';

// ✅ Load doctors for dropdown
$doctors = getDoctors($conn);

// ✅ Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id  = $_POST['doctor_id'];
    $date       = $_POST['date'];
    $time       = $_POST['time'];
    $reason     = $_POST['reason'];

    // ✅ Check empty fields
    if (empty($patient_id) || empty($doctor_id) || empty($date) || empty($time) || empty($reason)) {
        $message = "error:All fields are required";
    } else {
        $result = bookAppointment($conn, $patient_id, $doctor_id, $date, $time, $reason);
        if ($result) {
            $message = "success:Appointment booked successfully";
        } else {
            $message = "error:Something went wrong";
        }
    }
}

conn_close($conn);