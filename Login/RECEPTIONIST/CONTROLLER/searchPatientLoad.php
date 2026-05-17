<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn = conn_open();

$patients         = [];
$selectedPatient  = null;
$upcomingAppts    = [];
$bills            = [];
$search           = '';

// ✅ Handle search
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search   = $_GET['search'];
    $patients = searchPatients($conn, $search);
}

// ✅ Handle view profile
if (isset($_GET['patient_id']) && !empty($_GET['patient_id'])) {
    $patient_id      = $_GET['patient_id'];
    $selectedPatient = getPatientProfile($conn, $patient_id);
    $upcomingAppts   = getPatientUpcomingAppointments($conn, $patient_id);
    $bills           = getPatientBilling($conn, $patient_id);
}

conn_close($conn);