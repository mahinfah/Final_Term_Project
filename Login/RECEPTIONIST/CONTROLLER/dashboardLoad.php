<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$conn = conn_open();

$profile = getReceptionistProfile($conn, $_SESSION['email']);
conn_close($conn);