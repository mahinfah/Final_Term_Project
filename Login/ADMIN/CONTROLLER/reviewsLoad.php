<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn    = conn_open();
$reviews = getDoctorReviews($conn);
conn_close($conn);