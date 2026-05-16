<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/DoctorController.php';

$db = new Database();
$db->getConnection();

$controller = new DoctorController($db);

$action = $_GET['action'] ?? 'dashboard';

if ($action == 'login') {
    $controller->login();
    exit;
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: index.php?action=login");
    exit;
}

switch ($action) {
    case 'dashboard': $controller->dashboard(); break;
    case 'profile': $controller->profile(); break;
    case 'availability': $controller->availability(); break;
    case 'leave_dates': $controller->leaveDates(); break;
    case 'today_schedule': $controller->todaySchedule(); break;
    case 'weekly_calendar': $controller->weeklyCalendar(); break;
    case 'confirm_appointment': $controller->confirmAppointment(); break;
    case 'reject_appointment': $controller->rejectAppointment(); break;
    case 'no_show_appointment': $controller->noShowAppointment(); break;
    case 'checkin_ajax': $controller->checkinAjax(); break;
    case 'add_consultation': $controller->addConsultation(); break;
    case 'patient_notes': $controller->patientNotes(); break;
    case 'reviews': $controller->reviews(); break;
    case 'reply_review': $controller->replyReview(); break;
    case 'earnings': $controller->earnings(); break;
    case 'statistics': $controller->statistics(); break;
    case 'followups': $controller->followups(); break;
    case 'messages': $controller->messages(); break;
    case 'send_message': $controller->sendMessage(); break;
    default: $controller->dashboard();
}
?>