<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../models/Patient.php';
require_once '../models/Doctor.php';
require_once '../models/Appointment.php';
require_once '../models/Dependent.php';
require_once '../models/Review.php';
require_once '../models/Billing.php';
require_once '../models/Announcement.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header('Location: ../index.php');
    exit;
}

$user = new User();
$patientModel = new Patient();
$doctorModel = new Doctor();
$appointmentModel = new Appointment();
$dependentModel = new Dependent();
$reviewModel = new Review();
$billingModel = new Billing();
$announcementModel = new Announcement();

$user_data = $user->getUserById($_SESSION['user_id']);
$patient_data = $patientModel->getByUserId($_SESSION['user_id']);

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="nav">
        <a href="?page=dashboard">Dashboard</a>
        <a href="?page=profile">Profile</a>
        <a href="?page=doctors">Find Doctors</a>
        <a href="?page=appointments">Appointments</a>
        <a href="?page=dependents">Family</a>
        <a href="?page=medical_history">Medical History</a>
        <a href="?page=billing">Billing</a>
        <a href="?page=reviews">My Reviews</a>
        <a href="?page=announcements">Announcements</a>
        <a href="../logout.php">Logout</a>
    </div>
    <div class="content">
        <?php
        switch($page) {
            case 'dashboard': include '../views/patient/dashboard.php'; break;
            case 'profile': include '../views/patient/profile.php'; break;
            case 'doctors': include '../views/patient/doctors.php'; break;
            case 'doctor_detail': include '../views/patient/doctor_detail.php'; break;
            case 'book_appointment': include '../views/patient/book_appointment.php'; break;
            case 'appointments': include '../views/patient/appointments.php'; break;
            case 'dependents': include '../views/patient/dependents.php'; break;
            case 'medical_history': include '../views/patient/medical_history.php'; break;
            case 'billing': include '../views/patient/billing.php'; break;
            case 'reviews': include '../views/patient/reviews.php'; break;
            case 'announcements': include '../views/patient/announcements.php'; break;
            default: include '../views/patient/dashboard.php';
        }
        ?>
    </div>
</div>
</body>
</html>