<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn = conn_open();

$totalPatients       = countPatients($conn);
$totalActiveDoctors  = countActiveDoctors($conn);
$totalPendingBilling = countPendingBilling($conn);
$totalAppointments   = countAppointments($conn);

conn_close($conn);