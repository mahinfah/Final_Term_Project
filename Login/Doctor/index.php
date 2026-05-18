<?php
session_start();
require_once __DIR__ . '/models/User.php';


$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = dirname($script_name);  // e.g., /Final_Term_Project/Login/Doctor
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $base_dir;
$loginRoot = preg_replace('#/Doctor$#i', '', str_replace('\\', '/', $base_dir));
$patientLoginPath = $loginRoot . '/patient/index.php';
$receptionistDashboardPath = $loginRoot . '/RECEPTIONIST/VIEW/receptionist_dashboard.php';


if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'doctor':
            header('Location: ' . $base_url . '/controllers/DoctorController.php');
            exit;
        case 'patient':
            header('Location: ' . $patientLoginPath);
            exit;
        case 'receptionist':
            header('Location: ' . $receptionistDashboardPath);
            exit;
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $role = strtolower(trim($_POST['role'] ?? ''));
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($role) || empty($email) || empty($password)) {
        $error = 'Please fill all fields.';
    } else {
        $user = new User();
        $loggedInUser = $user->login($email, $password);
        $userRole = strtolower(trim($loggedInUser['role'] ?? ''));

        if ($loggedInUser && $userRole === $role && $loggedInUser['is_active'] == 1) {
            $_SESSION['user_id'] = $loggedInUser['id'];
            $_SESSION['role'] = $userRole;
            $_SESSION['email'] = $loggedInUser['email'];
            $_SESSION['name'] = $loggedInUser['name'];
            $_SESSION['username'] = $loggedInUser['name'];

            switch ($role) {
                case 'doctor':
                    header('Location: ' . $base_url . '/controllers/DoctorController.php');
                    exit;
                case 'patient':
                    header('Location: ' . $patientLoginPath);
                    exit;
                case 'receptionist':
                    header('Location: ' . $receptionistDashboardPath);
                    exit;
                case 'admin':
                    $error = 'Admin dashboard is not available in this project.';
                    break;
                default:
                    $error = 'Invalid role selected.';
            }
        } else {
            $error = 'Invalid email, password, or role mismatch.';
        }
    }
}

include __DIR__ . '/views/login.php';
?>
