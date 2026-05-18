<?php
session_start();
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Doctor.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/ConsultationNote.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Earning.php';
require_once __DIR__ . '/../models/Message.php';


$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = dirname(dirname($script_name));  
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $base_dir;


if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header('Location: ' . $base_url . '/index.php');
    exit;
}


$user = new User();
$doctorModel = new Doctor();
$appointmentModel = new Appointment();
$consultNoteModel = new ConsultationNote();
$reviewModel = new Review();
$earningModel = new Earning();
$messageModel = new Message();

$user_data = $user->getUserById($_SESSION['user_id']);
$doctor_data = $doctorModel->getByUserId($_SESSION['user_id']);
$specializations = $doctorModel->getSpecializations();

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Panel</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="nav">
        <a href="?page=dashboard">Dashboard</a>
        <a href="?page=profile">Profile</a>
        <a href="?page=availability">Availability</a>
        <a href="?page=leave_dates">Leave Dates</a>
        <a href="?page=today_schedule">Today's Schedule</a>
        <a href="?page=weekly_calendar">Weekly Calendar</a>
        <a href="?page=pending_requests">Pending Requests</a>
        <a href="?page=consultation_notes">Consultation Notes</a>
        <a href="?page=patient_notes">Patient Notes History</a>
        <a href="?page=reviews">Reviews</a>
        <a href="?page=earnings">Earnings</a>
        <a href="?page=statistics">Statistics</a>
        <a href="?page=messages">Messages</a>
        <a href="<?php echo $base_url; ?>/logout.php">Logout</a>
    </div>
    <div class="content">
        <?php
        switch($page) {
            case 'dashboard': include __DIR__ . '/../views/doctor/dashboard.php'; break;
            case 'profile': include __DIR__ . '/../views/doctor/profile.php'; break;
            case 'availability': include __DIR__ . '/../views/doctor/availability.php'; break;
            case 'leave_dates': include __DIR__ . '/../views/doctor/leave_dates.php'; break;
            case 'today_schedule': include __DIR__ . '/../views/doctor/today_schedule.php'; break;
            case 'weekly_calendar': include __DIR__ . '/../views/doctor/weekly_calendar.php'; break;
            case 'pending_requests': include __DIR__ . '/../views/doctor/pending_requests.php'; break;
            case 'consultation_notes': include __DIR__ . '/../views/doctor/consultation_note.php'; break;
            case 'patient_notes': include __DIR__ . '/../views/doctor/patient_notes.php'; break;
            case 'reviews': include __DIR__ . '/../views/doctor/reviews.php'; break;
            case 'earnings': include __DIR__ . '/../views/doctor/earnings.php'; break;
            case 'statistics': include __DIR__ . '/../views/doctor/statistics.php'; break;
            case 'messages': include __DIR__ . '/../views/doctor/messages.php'; break;
            default: include __DIR__ . '/../views/doctor/dashboard.php';
        }
        ?>
    </div>
</div>
</body>
</html>
