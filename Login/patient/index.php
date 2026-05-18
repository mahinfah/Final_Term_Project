<?php
session_start();
require_once __DIR__ . '/models/User.php';

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$loginRoot = preg_replace('#/patient$#i', '', $scriptDir);
$doctorLoginPath = $loginRoot . '/Doctor/index.php';
$receptionistDashboardPath = $loginRoot . '/RECEPTIONIST/VIEW/receptionist_dashboard.php';
$error = '';

if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'patient':
            header('Location: controllers/PatientController.php');
            exit;
        case 'doctor':
            header('Location: ' . $doctorLoginPath);
            exit;
        case 'receptionist':
            header('Location: ' . $receptionistDashboardPath);
            exit;
        case 'admin':
            session_destroy();
            $error = 'Admin dashboard is not available in this project.';
            break;
        default:
            session_destroy();
            header('Location: index.php');
            exit;
    }
}


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
            switch ($role) {
                case 'patient':
                    $_SESSION['user_id'] = $loggedInUser['id'];
                    $_SESSION['role'] = $userRole;
                    $_SESSION['username'] = $loggedInUser['name'];
                    header('Location: controllers/PatientController.php');
                    exit;
                case 'doctor':
                    $_SESSION['user_id'] = $loggedInUser['id'];
                    $_SESSION['role'] = $userRole;
                    $_SESSION['email'] = $loggedInUser['email'];
                    $_SESSION['username'] = $loggedInUser['name'];
                    header('Location: ' . $doctorLoginPath);
                    exit;
                case 'receptionist':
                    $_SESSION['user_id'] = $loggedInUser['id'];
                    $_SESSION['role'] = $userRole;
                    $_SESSION['email'] = $loggedInUser['email'];
                    $_SESSION['name'] = $loggedInUser['name'];
                    $_SESSION['username'] = $loggedInUser['name'];
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
